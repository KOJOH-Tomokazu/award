<?php
/**
 * 賞別クラス
 * @author JJ4KME
 */
class Prise {

	/** 元データ */
	private static $source = array(
			'A'	=> array(
					'id'		=> 'A',
					'prefix'	=> 'お',
					'name'		=> '尾道'),
			'B'	=> array(
					'id'		=> 'B',
					'prefix'	=> 'さ',
					'name'		=> '桜'),
			'C'	=> array(
					'id'		=> 'C',
					'prefix'	=> 'き',
					'name'		=> '奇祭'));
	/** 区分 */
	private $id;
	/** 記号 */
	private $prefix;
	/** 名称 */
	private $name;

	/**
	 * コンストラクター
	 * @param array $source 元データ
	 */
	public function __construct(array $source = null) {
		if ($source !== null) {
			$this->id		= $source['id'];
			$this->prefix	= $source['prefix'];
			$this->name		= $source['name'];
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

		$this->{$name} = $value;
	}

	public function toArray() {

		return array(
				'id'		=> $this->id,
				'prefix'	=> $this->prefix,
				'name'		=> $this->name);
	}

	public static function get($id = null) {

		if ($id === null) {
			$result = array();
			foreach (self::$source as $key => $value) {
				$result[$key] = new Prise($value);
			}

		} else {
			$result = new Prise(self::$source[$id]);
		}

		return $result;
	}
}
