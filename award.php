<?php
include_once	'libs/MyPDO.php';
include_once	'classes/Application.php';
include_once	'classes/QSL.php';
include_once	'classes/Prise.php';
error_log(print_r($_REQUEST, true));
define('SEEDS',	'123456789ABCDEFGHIJKLMNPQRSTUVWXYZ');

if (isset($_REQUEST['CALL_AJAX'])) {
	$result = array('success' => TRUE);

	try {
		$db	= new MyPDO('tomtom');
		$db->exec("SET search_path TO 'award'");
		$db->beginTransaction();
		if ($_REQUEST['CALL_AJAX'] == 'create') {
			// 認証番号の生成
			$result['MD5KEY']	= md5($_SERVER['REMOTE_ADDR']. $_REQUEST['PHPSESSID']);
			$result['NUMBER']	= generateNumber();

			if (updateMD5Key($db, $result['MD5KEY'], $result['NUMBER']) == 0) {
				registerMD5Key($db, $result['MD5KEY'], $result['NUMBER']);
			}

		} else if ($_REQUEST['CALL_AJAX'] == 'verify') {
			// 認証番号の照合
			$result['success']	= verifyNumber($db, $_REQUEST['MD5KEY'], $_REQUEST['NUMBER']);

		} else if ($_REQUEST['CALL_AJAX'] == 'register') {
			// 申請書の登録
			$pubNumber = Application::getPublishNumber($db, $_REQUEST['prise']);
			$application = new Application(array(
					'prise'			=> $_REQUEST['prise'],
					'pubnumber'		=> $pubNumber,
					'appdate'		=> date('Y-m-d'),
					'opcallsign'	=> $_REQUEST['opCallsign'],
					'opnamek'		=> $_REQUEST['opNameK'],
					'opnamer'		=> $_REQUEST['opNameR'],
					'opmail'		=> $_REQUEST['opMail'],
					'opzipcode'		=> $_REQUEST['opZipCode'],
					'opprefcode'	=> $_REQUEST['opPrefCode'],
					'opjiscode'		=> $_REQUEST['opJisCode'],
					'opaddress'		=> $_REQUEST['opAddress'],
					'remarks'		=> $_REQUEST['remarks']));
			$application->register($db);
			// ＱＳＬリストの登録
			$qsls = array();
			for ($i = 0; $i < 19; $i++) {
				$qsls[] = new QSL(array(
						'prise'		=> $_REQUEST['prise'],
						'pubnumber'	=> $pubNumber,
						'qslnumber'	=> $i + 1,
						'callsign'	=> $_REQUEST['wkCallsign'][$i],
						'datetime'	=> $_REQUEST['wkDateTime'][$i],
						'frequency'	=> $_REQUEST['wkFrequency'][$i],
						'mode'		=> $_REQUEST['wkMode'][$i],
						'qth'		=> $_REQUEST['wkQth'][$i]));
			}
			QSL::insert($db, $qsls);
			$result['message'] = 'アワードの申請を受け付けました、マネージャーからの連絡をお待ちください';

		} else if ($_REQUEST['CALL_AJAX'] == 'publish') {
			// 発行処理・編集
			$application = Application::get($db, $_REQUEST['prise'], $_REQUEST['pubNumber']);
			$application->pubDate	= $_REQUEST['pubDate'];
			$application->opAddress	= $_REQUEST['opAddress'];
			$application->register($db);

		} else if ($_REQUEST['CALL_AJAX'] == 'getName') {
			// ＱＴＨ取得
			$result['NAME']	= getQTH($db, $_REQUEST['CODE']);

		} else if ($_REQUEST['CALL_AJAX'] == 'listApplications') {
			// 申請書のリストを取得
			$source = Application::get($db);
			$result['LIST'] = array();
			foreach ($source as $application) {
				$result['LIST'][]	= $application->toArray();
			}

		} else if ($_REQUEST['CALL_AJAX'] == 'getPriseList') {
			// 賞別のリストを取得
			$source = Prise::get();
			$result['LIST'] = array();
			foreach ($source as $key => $prise) {
				$result['LIST'][$key] = $prise->toArray();
			}

		} else if ($_REQUEST['CALL_AJAX'] == 'getPrefList') {
			// 都道府県のリストを取得
			$result['LIST'] = getPrefList($db);

		} else if ($_REQUEST['CALL_AJAX'] == 'getCityList') {
			// 市区町村のリストを取得
			$result['LIST'] = getCityList($db, $_REQUEST['prefCode']);

		} else if ($_REQUEST['CALL_AJAX'] == 'getFreqList') {
			// 周波数帯のリストを取得
			$result['LIST'] = getFreqList($db);
		}

		$db->commit();

	} catch (PDOException $pe) {
		$db->rollBack();
		$result = array(
				'success'	=> FALSE,
				'code'		=> $pe->getCode(),
				'message'	=> $pe->getMessage());

	} finally {
		$db = NULL;

	}

	echo	json_encode($result);
}

/**
 * 認証番号を生成する
 * @return string 認証番号
 */
function generateNumber() {

	$result = '';
	for ($i = 1; $i <= 5; $i++) {
		$result .= substr(SEEDS, rand(0, strlen(SEEDS) - 1), 1);
	}

	return $result;
}

/**
 * 認証番号を更新する
 * @param PDO $db ＤＢ接続
 * @param unknown $md5key ＭＤ５キー
 * @param unknown $value 認証番号
 * @return number 更新したレコード数
 */
function updateMD5Key(PDO $db, $md5key, $value) {

	$SQL = <<<EOF
UPDATE verify
SET	value	= :value
WHERE
	md5key	= :md5key
EOF;
	$stmt = $db->prepare($SQL);
	$stmt->execute(array(
		':value'	=> $value,
		':md5key'	=> $md5key));

	return $stmt->rowCount();
}

/**
 * 認証番号を登録する
 * @param PDO $db ＤＢ接続
 * @param unknown $md5key ＭＤ５キー
 * @param unknown $value 認証番号
 */
function registerMD5Key(PDO $db, $md5key, $value) {

	$SQL = <<<EOF
INSERT INTO verify (md5key,  value)
VALUES            (:md5key, :value)
EOF;
	$stmt = $db->prepare($SQL);
	$stmt->execute(array(
		':value'	=> $value,
		':md5key'	=> $md5key));
}

/**
 * 認証番号を照合する
 * @param PDO $db ＤＢ接続
 * @param unknown $md5key ＭＤ５キー
 * @param unknown $value 認証番号
 * @return number 照合できたら０、出来なかったら－１
 */
function verifyNumber(PDO $db, $md5key, $value) {

	$SQL = <<<EOF
SELECT
	COUNT(*)
FROM
	verify
WHERE
	md5key = :md5key
AND	value	= :value
EOF;
	$stmt = $db->prepare($SQL);
	$stmt->execute(array(
		':value'	=> $value,
		':md5key'	=> $md5key));

	$record = $stmt->fetch(PDO::FETCH_NUM);
	$result = boolval($record[0] == 1);
	$stmt->closeCursor();

	return $result;
}

/**
 * ＱＴＨを取得
 * @param PDO $db ＤＢ接続
 * @param unknown $code JCC/JCGコード
 * @return string|mixed ＱＴＨ
 */
function getQTH(PDO $db, $code) {

	$result = '';
	$SQL = <<<EOF
SELECT
	name
FROM
	common.jccg
WHERE
	code	= :code
EOF;
	$stmt = $db->prepare($SQL);
	$stmt->execute(array(
		':code'	=> $code));

	while ($record = $stmt->fetch()) {
		$result = $record['name'];
		break;
	}
	$stmt->closeCursor();

	return $result;
}

/**
 * 都道府県の一覧を取得
 * @param PDO $db ＤＢ接続
 * @return array 都道府県の一覧
 */
function getPrefList(PDO $db) {

	$SQL = <<<EOF
SELECT
	jiscode	AS code,
	name	AS name
FROM
	common.jiscode
WHERE
	startdate	<= NOW()
AND	(enddate	>= NOW()
OR	enddate		IS NULL)
AND	jiscode		LIKE '%000'
ORDER BY
	code
EOF;
	$stmt = $db->prepare($SQL);
	$stmt->execute();

	$result = $stmt->fetchAll();
	$stmt->closeCursor();

	return $result;
}

/**
 * 市郡以下の一覧を取得
 * @param PDO $db ＤＢ接続
 * @param unknown $jisCode ＪＩＳコード
 * @return array 市郡以下の一覧
 */
function getCityList(PDO $db, $jisCode) {

	$SQL = <<<EOF
SELECT
	COALESCE(JIS3.jiscode, JIS2.jiscode) AS code,
	CASE WHEN JIS2.name LIKE '%部' OR JIS2.name LIKE '%支庁' OR JIS2.name LIKE '%振興局' THEN '' ELSE JIS2.name END || COALESCE(JIS3.name, '') AS name
FROM
    common.jiscode JIS2
	LEFT JOIN common.jiscode JIS3
		ON	JIS3.startdate	<= NOW()
		AND	(JIS3.enddate	>= NOW()
		OR	JIS3.enddate	IS NULL)
		AND	JIS3.parent		= JIS2.jiscode
WHERE
    JIS2.startdate   <= NOW()
AND (JIS2.enddate    >= NOW()
OR  JIS2.enddate     IS NULL)
AND JIS2.parent		= :jiscode
ORDER BY
    JIS2.jiscode
EOF;
	$stmt = $db->prepare($SQL);
	$stmt->execute(array(
		':jiscode'	=> $jisCode));

	$result = $stmt->fetchAll();
	$stmt->closeCursor();

	return $result;
}

/**
 * 周波数帯の一覧を取得
 * @param PDO $db ＤＢ接続
 * @return mixed[] 周波数帯の一覧
 */
function getFreqList(PDO $db) {

	$result = array();
	$SQL = <<<EOF
SELECT
	id,
	name
FROM
	freqs
ORDER BY
	id
EOF;
	$stmt = $db->prepare($SQL);
	$stmt->execute();

	while ($record = $stmt->fetch()) {
		$result[$record['id']] = $record['name'];
	}
	$stmt->closeCursor();

	return $result;
}
