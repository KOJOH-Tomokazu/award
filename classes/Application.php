<?php
include_once	'QSL.php';
include_once	'Prise.php';

/**
 * 申請書クラス
 * @author JJ4KME
 */
class Application {

	/** 賞別 */
	private $prise;
	/** 発行番号 */
	private $pubNumber;
	/** 申請年月日 */
	private $appDate;
	/** 発行年月日 */
	private $pubDate;
	/** コールサイン */
	private $opCallsign;
	/** 氏名(漢字) */
	private $opNamek;
	/** 氏名(ふりがな) */
	private $opNamer;
	/** メールアドレス */
	private $opMail;
	/** 郵便番号 */
	private $opZipCode;
	/** 都道府県コード */
	private $opPrefCode;
	/** 市区町村コード */
	private $opJisCode;
	/** 都道府県市区町村名 */
	private $opTownName;
	/** 住所 */
	private $opAddress;
	/** 特記事項 */
	private $remarks;
	/** ＱＳＬカードのリスト */
	private $qslList;

	/**
	 * コンストラクター
	 * @param array $source 元データ
	 */
	function __construct(array $source = null) {
		$this->qslList = array();
		if ($source !== null) {
			$this->prise		= Prise::get($source['prise']);
			$this->pubNumber	= $source['pubnumber'];
			$this->appDate		= new DateTime($source['appdate']);
			$this->pubDate		= (empty($source['pubdate'])	? NULL : new DateTime($source['pubdate']));
			$this->opCallsign	= $source['opcallsign'];
			$this->opNamek		= $source['opnamek'];
			$this->opNamer		= $source['opnamer'];
			$this->opMail		= (empty($source['opmail'])		? NULL : $source['opmail']);
			$this->opZipCode	= $source['opzipcode'];
			$this->opPrefCode	= $source['opprefcode'];
			$this->opJisCode	= $source['opjiscode'];
			$this->opTownName	= $source['optownname'];
			$this->opAddress	= (empty($source['opaddress'])	? NULL : $source['opaddress']);
			$this->remarks		= (empty($source['remarks'])	? NULL : $source['remarks']);
		}
	}

	/**
	 * ゲッター
	 * @param unknown $name プロパティ名
	 * @return unknown 値
	 */
	function __get($name) {

		return $this->{$name};
	}

	/**
	 * セッター
	 * @param unknown $name プロパティ名
	 * @param unknown $value 値
	 */
	function __set($name, $value) {
		if ($name == 'appDate') {
			$this->{$name}	= new DateTime($value);

		} else if ($name == 'pubDate') {
			$this->{$name}	= new DateTime($value);

		} else {
			$this->{$name} = $value;
		}
	}

	/**
	 * 値がセットされているか調べる
	 * @param unknown $name プロパティ名
	 * @return unknown セットされていたらtrue、されていなかったらfalse
	 */
	function __isset($name) {

		return isset($this->{$name});
	}

	/**
	 * アワード申請書の内容を配列で返す
	 * @return string[]|array[]|NULL[] アワード申請書のデータ
	 */
	public function toArray() {

		$result = array(
			'prise'			=> $this->prise->id,
			'priseMark'		=> $this->prise->prefix,
			'priseName'		=> $this->prise->name,
			'pubNumber'		=> $this->pubNumber,
			'appDate'		=> $this->appDate->format('Y-m-d'),
			'pubDate'		=> (empty($this->pubDate)	? NULL : $this->pubDate->format('Y-m-d')),
			'opCallsign'	=> $this->opCallsign,
			'opNamek'		=> $this->opNamek,
			'opNamer'		=> $this->opNamer,
			'opMail'		=> (empty($this->opMail)	? NULL : $this->opMail),
			'opZipCode'		=> substr($this->opZipCode, 0, 3). '-'. substr($this->opZipCode, 3),
			'opPrefCode'	=> $this->opPrefCode,
			'opJisCode'		=> $this->opJisCode,
			'opTownName'	=> $this->opTownName,
			'opAddress'		=> $this->opAddress,
			'remarks'		=> $this->remarks,
			'qslList'		=> array());
		foreach ($this->qslList as $qsl) {
			$result['qslList'][] = $qsl->toArray();
		}

		return $result;
	}

	/**
	 * アワード申請書を登録
	 * @param PDO $db ＤＢ接続
	 */
	public function register(PDO $db) {

		if ($this->update($db) == 0) {
			$this->insert($db);
		}
	}

	/**
	 * アワード申請書を更新
	 * @param PDO $db ＤＢ接続
	 * @return number 更新したレコード数
	 */
	public function update(PDO $db) {

		$SQL = <<<EOF
UPDATE application
SET	appdate		= :appdate,
	pubdate		= :pubdate,
	opcallsign	= :opcallsign,
	opnamek		= :opnamek,
	opnamer		= :opnamer,
	opmail		= :opmail,
	opzipcode	= :opzipcode,
	opprefcode	= :opprefcode,
	opjiscode	= :opjiscode,
	opaddress	= :opaddress,
	remarks		= :remarks
WHERE
	prise		= :prise
AND	pubnumber	= :pubnumber
EOF;
		$stmt = $db->prepare($SQL);
		$stmt->execute(array(
			':prise'		=> $this->prise->id,
			':pubnumber'	=> $this->pubNumber,
			':appdate'		=> $this->appDate->format('Y-m-d'),
			':pubdate'		=> (empty($this->pubDate)	? NULL : $this->pubDate->format('Y-m-d')),
			':opcallsign'	=> $this->opCallsign,
			':opnamek'		=> $this->opNamek,
			':opnamer'		=> $this->opNamer,
			':opmail'		=> (empty($this->opMail)	? NULL : $this->opMail),
			':opzipcode'	=> $this->opZipCode,
			':opprefcode'	=> $this->opPrefCode,
			':opjiscode'	=> $this->opJisCode,
			':opaddress'	=> $this->opAddress,
			':remarks'		=> (empty($this->remarks)	? NULL : $this->remarks)));

		return $stmt->rowCount();
	}

	/**
	 * アワード申請書を追加
	 * @param PDO $db ＤＢ接続
	 */
	public function insert(PDO $db) {

		$SQL = <<<EOF
INSERT INTO application (prise,  pubnumber,  appdate,  pubdate,  opcallsign,  opnamek,  opnamer,  opmail,  opzipcode,  opprefcode,  opjiscode,  opaddress,  remarks)
                VALUES (:prise, :pubnumber, :appdate, :pubdate, :opcallsign, :opnamek, :opnamer, :opmail, :opzipcode, :opprefcode, :opjiscode, :opaddress, :remarks)
EOF;
		$stmt = $db->prepare($SQL);
		$stmt->execute(array(
			':prise'		=> $this->prise->id,
			':pubnumber'	=> $this->pubNumber,
			':appdate'		=> $this->appDate->format('Y-m-d'),
			':pubdate'		=> (empty($this->pubDate)	? NULL : $this->pubDate->format('Y-m-d')),
			':opcallsign'	=> $this->opCallsign,
			':opnamek'		=> $this->opNamek,
			':opnamer'		=> $this->opNamer,
			':opmail'		=> (empty($this->opMail)	? NULL : $this->opMail),
			':opzipcode'	=> $this->opZipCode,
			':opprefcode'	=> $this->opPrefCode,
			':opjiscode'	=> $this->opJisCode,
			':opaddress'	=> $this->opAddress,
			':remarks'		=> (empty($this->remarks)	? NULL : $this->remarks)));
	}

	/**
	 * 指定した番号のアワード申請書を取得
	 * @param PDO $db ＤＢ接続
	 * @param unknown $prise 賞別
	 * @param unknown $pubNumber 発行番号
	 * @return Application|Application[] アワード申請書データ
	 */
	public static function get(PDO $db, $prise = null, $pubNumber = null) {

		$params = array();
		$SQL = <<<EOF
SELECT
	APP.appdate,
	APP.pubdate,
	APP.prise,
	APP.pubnumber,
	APP.opcallsign,
	APP.opnamek,
	APP.opnamer,
	APP.opmail,
	APP.opzipcode,
	APP.opprefcode,
	APP.opjiscode,
	COALESCE(JIS1.name, '') || CASE WHEN JIS2.name LIKE '%部' OR JIS2.name LIKE '%支庁' OR JIS2.name LIKE '%振興局' THEN '' ELSE JIS2.name END || JIS3.name AS optownname,
	APP.opaddress,
	APP.remarks
FROM
	application APP
LEFT JOIN common.jiscode JIS3
	ON	JIS3.jiscode	= APP.opprefcode || APP.opjiscode
LEFT JOIN common.jiscode JIS2
	ON	JIS2.enddate	IS NULL
	AND	JIS2.jiscode	= JIS3.parent
LEFT JOIN common.jiscode JIS1
	ON	JIS1.enddate	IS NULL
	AND	JIS1.jiscode	= JIS2.parent
EOF;
		if ($prise !== null && $pubNumber !== null) {
			$SQL .= ' WHERE APP.prise = :prise AND APP.pubnumber = :pubnumber';
			$params = array(
				':prise'		=> $prise,
				':pubnumber'	=> $pubNumber);
		}
		$SQL .= <<<EOF

ORDER BY
	APP.pubdate,
	APP.prise,
	APP.pubnumber
EOF;
		$stmt = $db->prepare($SQL);
		$stmt->execute($params);

		if ($prise !== null && $pubNumber !== null) {
			$record = $stmt->fetch();
			$result = new Application($record);
			$result->qslList = QSL::get($db, $record['prise'], $record['pubnumber']);

		} else {
			$result = array();
			while ($record = $stmt->fetch()) {
				$temp = new Application($record);
				$temp->qslList = QSL::get($db, $record['prise'], $record['pubnumber']);
				$result[] = $temp;
			}
		}
		$stmt->closeCursor();

		return $result;
	}

	/**
	 * 発行番号を取得
	 * @param PDO $db ＤＢ接続
	 * @param unknown $prise 賞別
	 * @return number 発行番号
	 */
	public static function getPublishNumber(PDO $db, $prise) {

		$result = 1;
		$SQL = <<<EOF
SELECT
	MAX(pubnumber)	AS maxnumber
FROM
	application
WHERE
	prise	= :prise
EOF;
		$stmt = $db->prepare($SQL);
		$stmt->execute(array(
			':prise'	=> $prise));

		while ($record = $stmt->fetch()) {
			$result = $record['maxnumber'] + 1;
		}
		$stmt->closeCursor();

		return	$result;
	}
}
