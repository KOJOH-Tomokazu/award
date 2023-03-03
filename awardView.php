<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Cache-Control" content="no-cache" />
<meta http-equiv="Expires" content="0" />
<link rel="stylesheet" href="libs/bootstrap/css/bootstrap.css" />
<!--
<link rel="stylesheet" href="libs/common.css" />
-->
<link rel="stylesheet" href="award.css" />
<script src="libs/bootstrap/js/bootstrap.js"></script>
<title>尾道２１世紀アワード申請書</title>
</head>
<body>
<?php
include_once	'libs/MyPDO.php';
include_once	'classes/Application.php';
include_once	'classes/Prise.php';

$CHARACTERS	= 'ONOMICHI21STCENTURY';

$db	= new MyPDO('tomtom');
$db->exec("SET search_path TO 'award'");
$application = Application::get($db, $_REQUEST['prise'], $_REQUEST['pubNumber']);

$stmtBand = $db->prepare('SELECT name FROM freqs WHERE id = :id');
?>
	<table id="dates" class="table table-bordered w-auto">
		<tr>
			<th class="date   pt-1 pb-1">申請日</th>
			<td class="date   pt-1 pb-1"><?= $application->appDate->format('Y/m/d') ?></td>
			<th class="date   pt-1 pb-1">発行日</th>
			<td class="date   pt-1 pb-1"><?= (empty($application->pubDate) ? '' : $application->pubDate->format('Y/m/d')) ?></td>
			<th class="number pt-1 pb-1">発行番号</th>
			<td class="number pt-1 pb-1"><?= $application->prise->prefix ?>-<?= $application->pubNumber ?></td>
		</tr>
	</table>
	<table id="info_view" class="table table-bordered w-auto">
		<thead>
			<tr>
				<th colspan="4" class="pt-1 pb-1">申請情報</th>
			</tr>
			<tr>
				<th id="prise"   class="pt-1 pb-1">種別</th>
				<th id="remarks" class="pt-1 pb-1">特記事項</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="prise   pt-1 pb-1"><?= $application->prise->name ?>賞</td>
				<td class="remarks pt-1 pb-1"><?= $application->remarks ?></td>
			</tr>
		</tbody>
	</table>
	<table id="owner_view" class="table table-bordered w-auto">
		<colgroup>
			<col id="col1" />
			<col id="col2" />
			<col id="col3" />
		</colgroup>
		<thead>
			<tr>
				<th colspan="3" class="pt-1 pb-1">申請者</th>
			</tr>
		</thead>
		<tr>
			<th colspan="2" class="pt-1 pb-1">コールサイン<br /><span class="small">(ＳＷＬナンバー)</span></th>
			<td class="pt-1 pb-1"><?= mb_convert_kana($application->opCallsign, 'A') ?></td>
		</tr>
		<tr>
			<th rowspan="2" class="align-middle">お<br />名<br />前</th>
			<th class="pt-1 pb-1 align-middle">ふりがな</th>
			<td class="pt-1 pb-1"><?= $application->opNamer ?></td>
		</tr>
		<tr>
			<th class="pt-1 pb-1 align-middle">漢字</th>
			<td class="pt-1 pb-1"><?= $application->opNamek ?></td>
		</tr>
		<tr>
			<th colspan="2" class="pt-1 pb-1 align-middle">住所</th>
			<td class="pt-1 pb-1">〒<?= substr($application->opZipCode, 0, 3) ?>-<?= substr($application->opZipCode, 3, 4) ?>&nbsp;<?= $application->opTownName ?>&nbsp;<?= $application->opAddress ?></td>
		</tr>
		<tr>
			<th colspan="2" class="pt-1 pb-1">E-Mail</th>
			<td class="pt-1 pb-1"><?= $application->opMail ?></td>
		</tr>
	</table>
	<table id="list_view" class="table table-bordered w-auto">
		<thead>
			<tr>
				<th colspan="6" class="pt-1 pb-1">ＱＳＬのリスト</th>
			</tr>
			<tr>
				<th id="character">文<br />字</th>
				<th id="callsign" >コールサイン</th>
				<th id="datetime" >交信(受信)日時</th>
				<th id="frequency">周波数帯</th>
				<th id="mode"     >電波の<br />型式</th>
				<th id="qth"      >相手局ＱＴＨ</th>
			</tr>
		</thead>
		<tbody>
<?php
foreach ($application->qslList as $qsl) {
	if (empty($qsl->frequency)) {
		$band = '';

	} else {
		$stmtBand->bindValue(':id', $qsl->frequency);
		$stmtBand->execute();
		$record = $stmtBand->fetch();
		$band = $record['name'];
		$stmtBand->closeCursor();
	}
?>
			<tr>
				<th class="character pt-1 pb-0 align-middle"><?= mb_convert_kana($CHARACTERS[$qsl->qslNumber - 1], 'A') ?></th>
				<td class="callsign  pt-1 pb-0"><?= $qsl->callsign ?></td>
				<td class="datetime  pt-1 pb-0"><?= $qsl->datetime->format('Y/m/d H:i') ?></td>
				<td class="frequency pt-1 pb-0"><?= $band ?></td>
				<td class="mode      pt-1 pb-0"><?= $qsl->mode ?></td>
				<td class="qth       pt-1 pb-0"><?= $qsl->qth ?></td>
			</tr>
<?php } ?>
		</tbody>
	</table>
</body>
</html>

