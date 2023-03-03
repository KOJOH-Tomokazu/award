<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Cache-Control" content="no-cache" />
<meta http-equiv="Expires" content="0" />
<link rel="stylesheet" href="libs/bootstrap/css/bootstrap.css" />
<link rel="stylesheet" href="libs/jQuery/jquery-ui.css" />
<!--
<link rel="stylesheet" href="libs/common.css" />
-->
<link rel="stylesheet" href="award.css" />
<script src="libs/bootstrap/js/bootstrap.js"></script>
<script src="libs/jQuery/jquery.js"></script>
<script src="libs/jQuery/jquery-ui.js"></script>
<script src="libs/common.js"></script>
<script src="award.js"></script>
<title>尾道２１世紀アワード申請書作成</title>
<?php
$CHARACTERS	= 'ONOMICHI21STCENTURY';
session_start();
?>
<script type="text/javascript">
let sessionId;

/**
 * 読み込み完了時の処理
 * @param event イベント
 */
$(window).on('load', function(e) {

	sessionId = '<?= session_id() ?>';

	$('button#regist').click(function(e) {
		if (checkSubmit()) {
			regist();
		}
	});

	$('button#clear').click(function(e) {
		$('select#prise'     ).removeClass('is-valid is-invalid').prop('title', '').prop('selectedIndex', -1);
		$('input#remarks'    ).removeClass('is-valid is-invalid').prop('title', '').val('');
		$('input#opCallsign' ).removeClass('is-valid is-invalid').prop('title', '').val('');
		$('input#opKanji'    ).removeClass('is-valid is-invalid').prop('title', '').val('');
		$('input#opRoman'    ).removeClass('is-valid is-invalid').prop('title', '').val('');
		$('input#opEmail'    ).removeClass('is-valid is-invalid').prop('title', '').val('');
		$('input#opZipCode'  ).removeClass('is-valid is-invalid').prop('title', '').val('');
		$('select#opPrefCode').removeClass('is-valid is-invalid').prop('title', '').prop('selectedIndex', -1);
		$('select#opJisCode' ).removeClass('is-valid is-invalid').prop('title', '').prop('selectedIndex', -1);
		$('input#opAddress'  ).removeClass('is-valid is-invalid').prop('title', '').val('');
		$('input.wkCallsign' ).removeClass('is-valid is-invalid').prop('title', '').val('');
		$('input.wkDate'     ).removeClass('is-valid is-invalid').prop('title', '').val('');
		$('input.wkTime'     ).removeClass('is-valid is-invalid').prop('title', '').val('');
		$('select.wkFreq'    ).removeClass('is-valid is-invalid').prop('title', '').prop('selectedIndex', -1);
		$('input.wkMode'     ).removeClass('is-valid is-invalid').prop('title', '').val('');
		$('input.wkCode'     ).removeClass('is-valid is-invalid').prop('title', '').val('');
		$('input.wkQth'      ).removeClass('is-valid is-invalid').prop('title', '').val('');
	});

	$('button#generate').click(function(e) {
		getNumber();
		$('input#vNumber').focus();
	});

	getNumber()
	getPriseList();
	getPrefList();
	getFreqList();
});
</script>
</head>
<body>
<div class="container">
	<div class="card">
		<div class="card-header fs-4">申請情報</div>
		<div class="card-body"><div class="row">
			<div class="col-2">
				<label for="prise">種別</label>
				<div class="input-group position-relative">
					<select id="prise" class="form-select" onblur="onBlur_Prise(this);" required></select>
					<span class="input-group-text">賞</span>
					<div class="invalid-feedback"></div>
				</div>
			</div>
			<div class="col-10">
				<label for="remarks">特記事項</label>
				<input type="text" id="remarks" class="form-control" onblur="onBlur_Remarks(this);" />
			</div>
		</div></div>
	</div>
	<div class="card">
		<div class="card-header fs-4">申請者</div>
		<div class="card-body">
			<div class="row">
				<div class="col-3 position-relative">
					<label for="opCallsign">コールサイン(ＳＷＬナンバー)</label>
					<input type="text" id="opCallsign" class="form-control" onkeypress="onKeyPress_Callsign(event);" onblur="onBlur_OpCallsign(this);" required />
					<div class="invalid-feedback"></div>
				</div>
				<div class="col-5">
					<label for="opKanji">お名前</label>
					<div class="input-group position-relative">
						<input type="text" id="opKanji" class="form-control" onblur="onBlur_Name(this);" placeholder="お名前(漢字)"     required />
						<input type="text" id="opRoman" class="form-control" onblur="onBlur_Name(this);" placeholder="お名前(ひらがな)" required />
						<div class="invalid-feedback"></div>
					</div>
				</div>
				<div class="col-4 position-relative">
					<label for="opEmail">Ｅメールアドレス</label>
					<input type="text" id="opEmail" class="form-control" placeholder="例)callsign@jarl.com" onblur="onBlur_Email(this);" />
					<div class="invalid-tooltip"></div>
					<span class="form-text text-muted">受信拒否設定等をされている場合、jj4kme@gmail.com からのメールが受信できるよう設定をお願いします。特に携帯メールの方！</span>
				</div>
			</div>
			<div class="row">
				<div class="col-2 position-relative">
					<label for="opZipCode">郵便番号</label>
					<input type="text" id="opZipCode" class="form-control" placeholder="'-'無し７桁" maxlength="7" onkeypress="return onKeyPress_ZipCode(event);" onblur="onBlur_ZipCode(this);" required />
					<div class="invalid-feedback"></div>
				</div>
				<div class="col-10 position-relative">
					<label for="opPrefCode">ご住所</label>
					<div class="input-group position-relative">
						<select id="opPrefCode" class="form-select" onchange="getCityList(this);" onblur="onBlur_Address();" required></select>
						<select id="opJisCode"  class="form-select"                               onblur="onBlur_Address();" required></select>
						<input type="text" id="opAddress" class="form-control"                    onblur="onBlur_Address();" required />
						<div class="invalid-feedback"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="card">
		<div class="card-header fs-4">ＱＳＬのリスト</div>
		<div class="card-body">
			<ul style="list-style-type:none;">
				<li>コールサイン、交信(受信)日時は必ず入力ください</li>
				<li>周波数帯、電波の型式、相手局のＱＴＨは、それぞれ関係する特記事項を希望する場合のみ入力・選択してください</li>
				<li>「一括設定」ボタンで、周波数帯・電波の型式が一括で設定できます。一括で設定後、個別に変更もできます</li>
			</ul>
			<div class="row">
				<div class="col-2">コールサイン</div>
				<div class="col-3">交信(受信)日時</div>
				<div class="col-2">周波数帯<button class="btn btn-sm ms-1" onclick="showFreqWindow();">一括設定</button><br />
					<div id="freqWindow">
						<div class="input-group">
							<select id="allFreq" class="form-select wkFreq"></select>
							<span class="input-group-text">帯</span>
						</div>
						<button class="btn btn-sm" onclick="setAllFreq();"    >ＯＫ</button>
						<button class="btn btn-sm" onclick="hideFreqWindow();">キャンセル</button>
					</div>
				</div>
				<div class="col-2">電波の型式<button class="btn btn-sm ms-1" onclick="showModeWindow();">一括設定</button><br />
					<div id="modeWindow">
						<div class="input-group">
							<input type="text" id="allMode" class="form-control wkMode" onblur="onBlur_Mode(this);" />
						</div>
						<button class="btn btn-sm" onclick="setAllMode();"    >ＯＫ</button>
						<button class="btn btn-sm" onclick="hideModeWindow();">キャンセル</button>
					</div>
				</div>
				<div class="col-3">相手局ＱＴＨ</div>
			</div>
			<div class="row mb-1">
				<div class="col-2 g-0"><div class="input-group">
					<span class="input-group-text">例</span>
					<input type="text" class="form-control" readonly="readonly" value="JJ4KME" />
				</div></div>
				<div class="col-3 g-0"><div class="input-group">
					<input type="text" class="form-control" readonly="readonly" value="2012/12/01" />
					<input type="text" class="form-control" readonly="readonly" value="12:34" />
				</div></div>
				<div class="col-2 g-0"><div class="input-group">
					<select class="form-select" readonly="readonly"><option>10MHz</option></select>
					<span class="input-group-text">帯</span>
				</div></div>
				<div class="col-2 g-0"><input type="text" class="form-control" readonly="readonly" value="A1A" /></div>
				<div class="col-3 g-0"><div class="input-group">
					<input type="text" class="form-control wkCode" readonly="readonly" value="3504" />
					<input type="text" class="form-control wkQth"  readonly="readonly" value="広島県三原市" />
				</div></div>
			</div>
<?php for ($i = 0; $i < strlen($CHARACTERS); $i++) { ?>
			<div class="row mb-1">
				<div class="col-2 g-0"><div class="input-group position-relative">
					<span class="input-group-text"><?= mb_convert_kana($CHARACTERS[$i], 'A') ?></span>
					<input type="text" class="form-control wkCallsign" id="wkCallsign<?= $i ?>" maxlength="10" onkeypress="return onKeyPress_Callsign(event);" onblur="onBlur_Callsign(this);" />
					<div class="invalid-feedback"></div>
				</div></div>
				<div class="col-3 g-0"><div class="input-group position-relative">
					<input type="text" class="form-control wkDate" id="wkDate<?= $i ?>" maxlength="10" onkeypress="return onKeyPress_Date(event);" onblur="onBlur_Date(this);" />
					<input type="text" class="form-control wkTime" id="wkTime<?= $i ?>" maxlength="5"  onkeypress="return onKeyPress_Time(event);" onblur="onBlur_Time(this);" />
					<div class="invalid-feedback"></div>
				</div></div>
				<div class="col-2 g-0"><div class="input-group">
					<select id="wkFreq<?= $i ?>" class="form-select wkFreq"></select>
					<span class="input-group-text">帯</span>
				</div></div>
				<div class="col-2 g-0"><input type="text" class="form-control wkMode" id="wkMode<?= $i ?>" onkeypress="onKeyPress_Mode(event);" onblur="onBlur_Mode(this);" ;/></div>
				<div class="col-3 g-0"><div class="input-group">
					<input type="text" class="form-control wkCode" id="wkCode<?= $i ?>" maxlength="6" onkeypress="onKeyPress_Code(event);" onblur="onBlur_Code(this);" />
					<input type="text" class="form-control wkQth"  id="wkQth<?=  $i ?>" />
				</div></div>
			</div>
<?php } ?>
		</div>
	</div>
	<div class="card">
		<div class="card-header fs-4">認証番号</div>
		<div class="card-body">
			<div class="row">
				<div id="number" class="col-2 fs-1 text-center align-middle"></div>
				<div class="col-10">左の英数字を入力してから「送信」ボタンを押してください<br />
					<input type="text" id="vNumber" class="form-control-lg fs-3" size="5" maxlength="5" /><span class="form-text text-muted">(大文字と小文字は区別します)</span><br />
					<button id="generate" class="btn btn-sm">読みにくい時はこちらを押してください</button></div>
			</div>
		</div>
	</div>
	<button id="regist" class="btn btn-lg" title="入力された内容をチェック後、エラーがなければ送信します">送信</button>
	<button id="clear"  class="btn btn-lg" title="入力された内容を消去します">クリア</button>
	<p>申請手数料は下記ゆうちょ銀行口座へ送金をお願いします。<br />ゆうちょ銀行：記号１５１４０、番号２８９４３９４１、名義７２２ハムクラブ<br />他行からは、ゆうちょ銀行 五一八(ごいちはち)店 普通２８９４３９４</p>
<?php
session_write_close();
?>
</div>
</body>
</html>
