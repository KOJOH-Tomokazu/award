<?php
include_once	'Prise.php';

/**
 * ＱＳＬカードクラス
 * @author JJ4KME
 */
class QSL {

	/** 賞別 */
	private $prise;
	/** 発行番号 */
	private $pubNumber;
	/** ＱＳＬ番号 */
	private $qslNumber;
	/** コールサイン */
	private $callsign;
	/** 交信日時 */
	private $datetime;
	/** 周波数帯 */
	private $frequency;
	/** 電波の型式 */
	private $mode;
	/** ＱＴＨ */
	private $qth;

	/**
	 * コンストラクター
	 * @param array $source 元データ
	 */
	function __construct(array $source = null) {
		if ($source !== null) {
			$this->prise		= Prise::get($source['prise']);
			$this->pubNumber	= $source['pubnumber'];
			$this->qslNumber	= $source['qslnumber'];
			$this->callsign		= $source['callsign'];
			$this->datetime		= new DateTime($source['datetime']);
			$this->frequency	= (empty($source['frequency'])	? NULL : $source['frequency']);
			$this->mode			= (empty($source['mode'])		? NULL : $source['mode']);
			$this->qth			= (empty($source['qth'])		? NULL : $source['qth']);
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
		if ($name == 'datetime') {
			$this->{$name}	= new DateTime($value);

		} else {
			$this->{$name} = $value;
		}
	}

	function __isset($name) {

		return isset($this->{$name});
	}

	public function toArray() {

		return array(
			'prise'			=> $this->prise->id,
			'pubNumber'		=> $this->pubNumber,
			'qslNumber'		=> $this->qslNumber,
			'callsign'		=> $this->callsign,
			'datetime'		=> (empty($this->datetime)	? NULL : $this->datetime->format('Y-m-d H:i')),
			'frequency'		=> (empty($this->frequency)	? NULL : $this->frequency),
			'mode'			=> (empty($this->mode)		? NULL : $this->mode),
			'qth'			=> (empty($this->qth)		? NULL : $this->qth));
	}

	public static function get(PDO $db, $prise, $pubNumber) {

		$result = array();
		$params = array(
			':prise'		=> $prise,
			':pubnumber'	=> $pubNumber);
		$SQL = <<<EOF
SELECT
	prise,
	pubnumber,
	qslnumber,
	callsign,
	datetime,
	frequency,
	mode,
	qth
FROM
	qsllist
WHERE
	prise		= :prise
AND	pubnumber	= :pubnumber
ORDER BY
	qslnumber
EOF;
		$stmt = $db->prepare($SQL);
		$stmt->execute($params);

		while ($record = $stmt->fetch()) {
			$result[] = new QSL($record);
		}
		$stmt->closeCursor();

		return $result;
	}

	public static function delete(PDO $db, $prise, $pubNumber) {

		$params = array(
			':prise'		=> $prise,
			':pubnumber'	=> $pubNumber);
		$SQL = <<<EOF
DELETE FROM qsllist
WHERE
	prise		= :prise
AND	pubnumber	= :pubnumber
EOF;
		$stmt = $db->prepare($SQL);
		$stmt->execute($params);
	}

	public static function insert(PDO $db, array $source) {

		$SQL = <<<EOF
INSERT INTO qsllist (prise,  pubnumber,  qslnumber,  callsign,  datetime,  frequency,  mode,  qth)
             VALUES(:prise, :pubnumber, :qslnumber, :callsign, :datetime, :frequency, :mode, :qth)
EOF;
		$stmt = $db->prepare($SQL);
		foreach ($source as $record) {
			$stmt->execute(array(
				':prise'		=> $record->prise->id,
				':pubnumber'	=> $record->pubNumber,
				':qslnumber'	=> $record->qslNumber,
				':callsign'		=> $record->callsign,
				':datetime'		=> (empty($record->datetime)	? NULL : $record->datetime->format('Y-m-d H:i')),
				':frequency'	=> (empty($record->frequency)	? NULL : $record->frequency),
				':mode'			=> (empty($record->mode)		? NULL : $record->mode),
				':qth'			=> (empty($record->qth)		? NULL : $record->qth)));
		}
	}
}
