<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1" />
<link rel="stylesheet" href="libs/bootstrap/css/bootstrap.css" />
<link rel="stylesheet" href="award.css" />
<script src="libs/bootstrap/js/bootstrap.js"></script>
<title>尾道２１世紀アワード - 受賞者リスト</title>
</head>

<body>

<p class="l1n">尾道２１世紀アワード - 受賞者リスト</p>

<p>　以下の方々にアワードを発行しました。</p>
<?php
include_once	'libs/MyPDO.php';

try {
	$db		= new MyPDO('tomtom');												# ＤＢ接続

	$stmt	= $db->query("SELECT TO_CHAR(MAX(pubdate), 'YYYY.MM.DD') AS pubdate FROM award.application");
	$record	= $stmt->fetch();
	print	"<p>{$record['pubdate']}現在</p>";
?>
<table class="table table-bordered">
	<tr>
		<th rowspan="2">コールサイン</th>
		<th class="lh-1" rowspan="2">お名前<br /><span class="small">(敬称略)</span></th>
		<th colspan="3">賞別取得年月日</th>
	</tr>
	<tr>
		<th>尾道賞</th>
		<th>桜賞</th>
		<th>奇祭賞</th>
	</tr>
	<tr>
		<td>JE0VFV</td>
		<td>小泉 順一</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>2001.06.16</td>
	</tr>
	<tr>
		<td>JI4UMT</td>
		<td>和田 隆一郎</td>
		<td>&nbsp;</td>
		<td>2001.06.27</td>
		<td>2001.07.04</td>
	</tr>
	<tr>
		<td>JF3DOK</td>
		<td>森田 久夫</td>
		<td>2001.07.26<br />2005.06.01</td>
		<td>2001.07.04</td>
		<td>2001.07.04</td>
	</tr>
	<tr>
		<td>JH1REP</td>
		<td>大塚 光雄</td>
		<td>&nbsp;</td>
		<td>2001.08.29</td>
		<td>2001.07.13</td>
	</tr>
	<tr>
		<td>JH7GKD</td>
		<td>鏡 雄一</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>2001.07.28</td>
	</tr>
	<tr>
		<td>JH1VQP</td>
		<td>良峰 政男</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>2001.08.27</td>
	</tr>
	<tr>
		<td>JL4FLJ</td>
		<td>吉田 基樹</td>
		<td>&nbsp;</td>
		<td>2001.09.19</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>JA1FXE</td>
		<td>荻原 三郎</td>
		<td>2005.12.17</td>
		<td>&nbsp;</td>
		<td>2001.09.21</td>
	</tr>
	<tr>
		<td>JQ1OKU</td>
		<td>沼田 健一</td>
		<td>2001.09.26<br />2005.10.28</td>
		<td>2003.02.24</td>
		<td>2005.10.28</td>
	</tr>
	<tr>
		<td>JK4GJX</td>
		<td>手島 伸</td>
		<td>&nbsp;</td>
		<td>2002.03.10</td>
		<td>2001.10.10</td>
	</tr>
	<tr>
		<td>JA0JY</td>
		<td>塚原 修</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>2001.10.30</td>
	</tr>
	<tr>
		<td>JL4GEL</td>
		<td>池田 寛幹</td>
		<td>2001.11.10</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>JA4TI</td>
		<td>福井 重雄</td>
		<td>2001.11.10</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>JM4AHF</td>
		<td>窪田 理正</td>
		<td>2001.11.21</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>JA1DXU</td>
		<td>本間 祐弘</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>2001.11.30</td>
	</tr>
	<tr>
		<td>JE5PHO</td>
		<td>守屋 一夫</td>
		<td>&nbsp;</td>
		<td>2001.12.05</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>JF2OZW</td>
		<td>松尾 賢一</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>2001.12.08</td>
	</tr>
	<tr>
		<td>JR1DHD</td>
		<td>佐藤 圭一</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>2001.12.12</td>
	</tr>
	<tr>
		<td>JA1OI</td>
		<td>佐藤 誠</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>2001.12.18</td>
	</tr>
	<tr>
		<td>JE4WUW</td>
		<td>檜山 多見登</td>
		<td>2001.12.29</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>JH1RYN</td>
		<td>下條 博</td>
		<td>2008.12.12</td>
		<td>2008.12.12</td>
		<td>2001.12.30</td>
	</tr>
	<tr>
		<td>JR3OET</td>
		<td>横須賀 良夫</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>2002.01.26</td>
	</tr>
	<tr>
		<td>JG1JRZ</td>
		<td>鈴木 一男</td>
		<td>&nbsp;</td>
		<td>2003.01.10</td>
		<td>2002.01.26</td>
	</tr>
	<tr>
		<td>JR4OKW</td>
		<td>小畑 忠昌</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>2002.02.01</td>
	</tr>
	<tr>
		<td>JL4SXA</td>
		<td>服部 俊明</td>
		<td>2002.02.01</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>JH8EAQ</td>
		<td>武田 洋一</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>2002.02.16</td>
	</tr>
	<tr>
		<td>JE0SQP</td>
		<td>古山 峻</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>2002.02.16</td>
	</tr>
	<tr>
		<td>JG5KYM</td>
		<td>戸田 廣</td>
		<td>2002.02.24</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>JJ4KME</td>
		<td>古城 朋和</td>
		<td>2002.03.01</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>JA3KRN</td>
		<td>鈴木 敏夫</td>
		<td>2002.10.18</td>
		<td>&nbsp;</td>
		<td>2002.03.03</td>
	</tr>
	<tr>
		<td>JR1HMX</td>
		<td>星野 二六</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>2002.04.29</td>
	</tr>
	<tr>
		<td>JE2BSJ</td>
		<td>内藤 好司</td>
		<td>2002.05.17</td>
		<td>2002.05.17</td>
		<td>2002.05.17</td>
	</tr>
	<tr>
		<td>JN1TZU</td>
		<td>島田 征一</td>
		<td>&nbsp;</td>
		<td>2002.07.01</td>
		<td>2002.05.19</td>
	</tr>
	<tr>
		<td>JH4WHE</td>
		<td>永峰 彰</td>
		<td>2002.06.06</td>
		<td>2002.06.06</td>
		<td>2002.06.06</td>
	</tr>
	<tr>
		<td>JA8QW</td>
		<td>神保 功</td>
		<td>2008.07.15</td>
		<td>2008.07.15</td>
		<td>2002.07.03<br />2008.07.15</td>
	</tr>
	<tr>
		<td>JA1ECU</td>
		<td>井上 昭朗</td>
		<td>2002.07.13</td>
		<td>2002.07.13</td>
		<td>2002.07.13</td>
	</tr>
	<tr>
		<td>JN6SKN</td>
		<td>&#26583;元 重昭</td>
		<td>&nbsp;</td>
		<td>2002.07.15</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>JH8QIO</td>
		<td>宮 雄三子</td>
		<td>&nbsp;</td>
		<td>2005.11.21</td>
		<td>2002.08.01<br />2005.11.21</td>
	</tr>
	<tr>
		<td>JK4JYA</td>
		<td>浅雄 邦博</td>
		<td>2002.08.03</td>
		<td>2002.08.03</td>
		<td>2002.08.03</td>
	</tr>
	<tr>
		<td>JO6CAV</td>
		<td>米永 勝一</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>2002.08.26</td>
	</tr>
	<tr>
		<td>JI5KKU</td>
		<td>一色 さつえ</td>
		<td>&nbsp;</td>
		<td>2002.09.14</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>JE3OQG</td>
		<td>山本 弘</td>
		<td>2002.09.19</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>JH4QMU</td>
		<td>森末 智久</td>
		<td>2002.11.25</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>JH4DGN</td>
		<td>松本 成一</td>
		<td>&nbsp;</td>
		<td>2002.12.03</td>
		<td>2002.12.03</td>
	</tr>
	<tr>
		<td>JN1AEI</td>
		<td>坂本 憲彦</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>2002.12.05</td>
	</tr>
	<tr>
		<td>JA2PFZ</td>
		<td>冨永 厚平</td>
		<td>2005.05.13</td>
		<td>2002.12.10</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>JM1ATF</td>
		<td>伊南 栄治</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>2003.01.08</td>
	</tr>
	<tr>
		<td>JA6AAF</td>
		<td>中村 満</td>
		<td>&nbsp;</td>
		<td>2003.02.17</td>
		<td>2005.10.27</td>
	</tr>
	<tr>
		<td>JI0JFA</td>
		<td>田中 雄一</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>2003.03.27</td>
	</tr>
	<tr>
		<td>JH1QPJ</td>
		<td>金子 勝美</td>
		<td>2003.04.26</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>JA6CLJ</td>
		<td>池田 一雄</td>
		<td>2003.05.13</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>JS3COV</td>
		<td>合田 勝紀</td>
		<td>2003.05.15</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>JJ4VQU</td>
		<td>品川 馨</td>
		<td>2003.06.21</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>JE3CSO</td>
		<td>中田 勝明</td>
		<td>2003.09.13</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>JK4TRI</td>
		<td>西本 富士夫</td>
		<td>&nbsp;</td>
		<td>2003.11.17</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>JA1BUQ</td>
		<td>力石 富司</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>2004.08.13</td>
	</tr>
	<tr>
		<td>JE2RZS</td>
		<td>進藤 昭和</td>
		<td>2010.02.28</td>
		<td>2004.11.15</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>JF1LFW</td>
		<td>竹村 博喜</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>2005.01.13</td>
	</tr>
	<tr>
		<td>JE4NKF</td>
		<td>紀本 勲</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>2005.03.27</td>
	</tr>
	<tr>
		<td>JS2JWD</td>
		<td>山田 佳重</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>2005.04.27</td>
	</tr>
	<tr>
		<td>JF8MJF</td>
		<td>千葉 健治</td>
		<td>2005.04.30</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>JF2CSS</td>
		<td>甲村 順一</td>
		<td>2005.05.12</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>JS2ADM</td>
		<td>山口 浩史</td>
		<td>2005.05.13</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>JH4EZE</td>
		<td>黒崎 隆</td>
		<td>2005.05.14</td>
		<td>2005.05.14</td>
		<td>2005.05.14</td>
	</tr>
	<tr>
		<td>JH3WNV</td>
		<td>道平 勇</td>
		<td>2005.05.25</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>JR8CEM</td>
		<td>浅山 宏</td>
		<td>2005.06.02</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>JG3NBD</td>
		<td>北村 治良</td>
		<td>&nbsp;</td>
		<td>2005.06.02</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>JR6XXI</td>
		<td>仲原 良男</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>2005.06.03</td>
	</tr>
	<tr>
		<td>JL4WOO</td>
		<td>中野 浩</td>
		<td>2005.06.08</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>JR8JRM</td>
		<td>三浦 照幸</td>
		<td>&nbsp;</td>
		<td>2005.06.15</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>JH2DLJ</td>
		<td>川上 正直</td>
		<td>&nbsp;</td>
		<td>2005.07.02</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>JE3IAC</td>
		<td>松谷 倫男</td>
		<td>2005.07.08</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>JE8JSX</td>
		<td>坂森 勉</td>
		<td>&nbsp;</td>
		<td>2005.07.25</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>JF6OID</td>
		<td>庄司 政行</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>2005.07.29</td>
	</tr>
	<tr>
		<td>JG1VJR</td>
		<td>津田 立男</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>2005.09.17</td>
	</tr>
	<tr>
		<td>JA1CKE</td>
		<td>星野 幸男</td>
		<td>2005.09.28</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>JI6QJX</td>
		<td>三浦 俊夫</td>
		<td>2005.10.01</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>JR5PPN</td>
		<td>鈴木 重香</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>2005.10.03</td>
	</tr>
	<tr>
		<td>JG8DZS</td>
		<td>小坂 順一</td>
		<td>&nbsp;</td>
		<td>2005.10.13</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>JM1SMM</td>
		<td>栗原 豊</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>2005.10.19</td>
	</tr>
	<tr>
		<td>JG8UCB</td>
		<td>濱本 功</td>
		<td>2005.10.22</td>
		<td>2005.10.22</td>
		<td>2005.10.22</td>
	</tr>
	<tr>
		<td>JO1WZM</td>
		<td>野本 建夫</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>2005.10.24</td>
	</tr>
	<tr>
		<td>JA2EPW</td>
		<td>小林 仁</td>
		<td>&nbsp;</td>
		<td>2005.11.10</td>
		<td>2005.10.25</td>
	</tr>
	<tr>
		<td>JH4WAZ</td>
		<td>松浦 和成</td>
		<td>&nbsp;</td>
		<td>2005.10.25</td>
		<td>2005.10.25</td>
	</tr>
	<tr>
		<td>JF5FWZ</td>
		<td>近藤 征一</td>
		<td>2005.10.25</td>
		<td>2005.10.25</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>JH5GEN</td>
		<td>越智 省二</td>
		<td>2005.10.31</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>JG2UZS</td>
		<td>山口 惣一郎</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>2005.11.05</td>
	</tr>
	<tr>
		<td>JA4KCG</td>
		<td>吉岡 昌彦</td>
		<td>2005.11.08</td>
		<td>2005.11.08</td>
		<td>2005.11.08</td>
	</tr>
	<tr>
		<td>JE6JVH</td>
		<td>平塚 幹夫</td>
		<td>&nbsp;</td>
		<td>2005.12.03</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>JH7OWZ</td>
		<td>井澤 尚志</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>2005.12.12</td>
	</tr>
	<tr>
		<td>JL4TTY</td>
		<td>光成 清志</td>
		<td>2005.12.23</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>JN6GZB/1</td>
		<td>有路 美紀夫</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>2006.01.31</td>
	</tr>
	<tr>
		<td>JI7RBP</td>
		<td>黄川田 圭一</td>
		<td>&nbsp;</td>
		<td>2006.02.07</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>JA1GLE</td>
		<td>滝 修一</td>
		<td>2006.03.15</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>JA6FKZ</td>
		<td>桝井 隆</td>
		<td>&nbsp;</td>
		<td>2006.03.15</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>JI7EHD</td>
		<td>石田 敏夫</td>
		<td>&nbsp;</td>
		<td>2006.03.20</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>7M4KHY</td>
		<td>尾野本 剛</td>
		<td>&nbsp;</td>
		<td>2006.03.22</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>JG2GSY</td>
		<td>山崎 鶴夫</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>2006.04.03</td>
	</tr>
	<tr>
		<td>JH1EDZ</td>
		<td>高桑 修</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>2006.05.10</td>
	</tr>
	<tr>
		<td>JM4OSI</td>
		<td>今坂 建生</td>
		<td>&nbsp;</td>
		<td>2006.06.01</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>JR2NRP</td>
		<td>本田 清</td>
		<td>&nbsp;</td>
		<td>2006.07.19</td>
		<td>2007.11.20</td>
	</tr>
	<tr>
		<td>JA9WKK</td>
		<td>西畑 玉江</td>
		<td>&nbsp;</td>
		<td>2006.07.25</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>JN4UUS</td>
		<td>大畑 等</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>2006.07.29</td>
	</tr>
	<tr>
		<td>JK1EMH</td>
		<td>臼井 利一</td>
		<td>2006.09.16</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>7L3IUE</td>
		<td>多田 良平</td>
		<td>&nbsp;</td>
		<td>2006.09.26</td>
		<td>2006.09.26</td>
	</tr>
	<tr>
		<td>JA6JTZ</td>
		<td>松永 健次</td>
		<td>2006.10.17</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>7L4RAY</td>
		<td>宝木原 正剛</td>
		<td>&nbsp;</td>
		<td>2006.10.19</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>JA6GAO</td>
		<td>金城 政道</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>2006.11.02</td>
	</tr>
	<tr>
		<td>JF1CLU</td>
		<td>伏屋 英典</td>
		<td>2006.11.08</td>
		<td>2006.11.18</td>
		<td>2006.11.18</td>
	</tr>
	<tr>
		<td>JL3RTA</td>
		<td>宮下 俊夫</td>
		<td>&nbsp;</td>
		<td>2006.12.21</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>JN1BPI</td>
		<td>町居 清</td>
		<td>2007.01.23</td>
		<td>2007.01.23</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>JG7ASP</td>
		<td>葛西 正行</td>
		<td>2007.02.08</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>JJ6QPW</td>
		<td>印南 俊夫</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>2007.02.22</td>
	</tr>
	<tr>
		<td>JN7SIV</td>
		<td>池田 優</td>
		<td>&nbsp;</td>
		<td>2007.03.24</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>JL3WXS</td>
		<td>前田 充彦</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>2007.04.10</td>
	</tr>
	<tr>
		<td>JP2UWS</td>
		<td>小野原 浩</td>
		<td>&nbsp;</td>
		<td>2007.07.30</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>JA6TNT</td>
		<td>仲野 正基</td>
		<td>&nbsp;</td>
		<td>2007.08.15</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>JE8LIM</td>
		<td>清水 裕久</td>
		<td>&nbsp;</td>
		<td>2007.10.15</td>
		<td>2007.10.15</td>
	</tr>
	<tr>
		<td>JA3RK</td>
		<td>的場 績</td>
		<td>2007.10.23</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
<?php
	$SQL	= <<<EOF
SELECT
	RTRIM(p.opcallsign) AS callsign,
	RTRIM(p.opnamek) AS name,
	TO_CHAR(a.pubdate, 'YYYY.MM.DD') AS pubdate_a,
	TO_CHAR(b.pubdate, 'YYYY.MM.DD') AS pubdate_b,
	TO_CHAR(c.pubdate, 'YYYY.MM.DD') AS pubdate_c,
	CASE WHEN a.pubdate IS NULL THEN CASE WHEN b.pubdate IS NULL THEN c.pubdate ELSE b.pubdate END ELSE a.pubdate END AS sortkey
FROM
	(
		SELECT
			opcallsign,
			opnamek,
			MIN(pubdate)
		FROM
			award.application
		GROUP BY
			opcallsign,
			opnamek
		ORDER BY
			MIN(pubdate)
	) p
	LEFT JOIN award.application a
		ON	a.prise			= 'A'
		AND	a.opcallsign	= p.opcallsign
	LEFT JOIN award.application b
		ON	b.prise			= 'B'
		AND	b.opcallsign	= p.opcallsign
	LEFT JOIN award.application c
		ON	c.prise			= 'C'
		AND	c.opcallsign	= p.opcallsign
ORDER BY
	sortkey
EOF;
	$stmt	= $db->query($SQL);
	while ($record = $stmt->fetch()) {
?>
		<tr>
			<td><?= $record['callsign'] ?></td>
			<td><?= $record['name']     ?></td>
			<td><?= $record['pubdate_a']?></td>
			<td><?= $record['pubdate_b']?></td>
			<td><?= $record['pubdate_c']?></td>
		</tr>
<?php
	}

} catch (PDOException $pe) {
?>
	<p><?= $pe->getMessage() ?></p>
	<pre><?= $pe->getTraceAsString() ?></pre>
<?php
}
?>
</table>
<hr />
<a href="javascript:history.back()">戻る</a>
</body>
</html>
