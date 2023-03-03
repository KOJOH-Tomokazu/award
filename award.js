
const METHOD_TYPE		= 'POST';
const DATA_TYPE			= 'json';
const URL_AJAX			= 'award.php';
const regCallsignChar	= /^[0-9a-zA-Z\-\/]$/;
const regCallsign		= /^[0-9a-zA-Z\-\/]+$/;
const regDateChar		= /^[\d\/\-]$/;
const regDateFormat1	= /^(\d{4})(\/|\-)(\d{1,2})(\/|\-)(\d{1,2})$/;
const regDateFormat2	= /^(\d{4})(\d{2})(\d{2})$/;
const regTimeChar		= /^[\d:]$/;
const regTimeFormat1	= /^(\d{1,2}):(\d{1,2})$/;
const regTimeFormat2	= /^(\d{2})(\d{2})$/;

const CALLSIGN_VALID			= 0;
const CALLSIGN_EMPTY			= 1;
const CALLSIGN_INVALID_FORMAT	= 2;
const DATE_VALID				= 0;
const DATE_EMPTY				= 1;
const DATE_INVALID_VALUE		= 2;
const DATE_INVALID_FORMAT		= 3;
const TIME_VALID				= 0;
const TIME_EMPTY				= 1;
const TIME_INVALID_VALUE		= 2;
const TIME_INVALID_FORMAT		= 3;

let md5Key;

/**
 * 周波数の一括設定ウィンドウを表示する
 */
function showFreqWindow() {

	$('div#freqWindow').show();
	$('select#allFreq').val('');

	hideModeWindow();
}

/**
 * 周波数を一括設定する
 */
function setAllFreq() {

	let value = $('select#allFreq').val();
	if (value != '') {
		$('select[id^=wkFreq]').val(value);
	}

	hideFreqWindow();
}

/**
 * 周波数の一括設定ウィンドウを隠す
 */
function hideFreqWindow() {

	$('div#freqWindow').hide();
}

/**
 * 電波形式の一括設定ウィンドウを表示する
 */
function showModeWindow() {

	$('div#modeWindow').show();
	$('input#allMode').val('');

	hideFreqWindow();
}

/**
 * 電波形式を一括設定する
 */
function setAllMode() {

	let value = $('input#allMode').val();
	if (value != '') {
		$('input[id^=wkMode]').val(value);
	}

	hideModeWindow();
}

/**
 * 電波形式の一括設定ウィンドウを隠す
 */
function hideModeWindow() {

	$('div#modeWindow').hide();
}

/**
 * 種別からフォーカスが外れた
 * @param target 対象要素
 */
function onBlur_Prise(target) {

	$(target).removeClass('is-valid is-invalid');

	if ($(target).prop('selectedIndex') == -1) {
		$(target).addClass('is-invalid');
		$(target).parent().find('div.invalid-feedback').html('アワードの種別を選択してください');

	} else {
		$(target).addClass('is-valid');
	}
}

/**
 * 特記事項からフォーカスが外れた
 * @param target 対象要素
 */
function onBlur_Remarks(target) {

	$(target).addClass('is-valid').removeClass('is-invalid');
}

/**
 * コールサイン欄でキーが押された
 * @param e イベント
 * @return ＯＫならtrue、ＮＧならfalse
 */
function onKeyPress_Callsign(e) {

	return	regCallsignChar.test(e.key);
}

/**
 * 申請者コールサイン欄からフォーカスが外れた
 * @param target 対象要素
 */
function onBlur_OpCallsign(target) {

	let check = checkCallsign(target.value);
	$(target).removeClass('is-valid is-invalid').prop('title', '');

	if (check == CALLSIGN_EMPTY) {
		$(target).addClass('is-invalid');
		$(target).parent().find('div.invalid-feedback').html('コールサイン(またはＳＷＬナンバー)を入力してください');

	} else if (check == CALLSIGN_INVALID_FORMAT) {
		$(target).addClass('is-invalid');
		$(target).parent().find('div.invalid-feedback').html('コールサイン(またはＳＷＬナンバー)が不正です');

	} else {
		$(target).addClass('is-valid').val(formatCallsign(target.value));
	}
}

/**
 * コールサイン欄からフォーカスが外れた
 * @param target 対象要素
 */
function onBlur_Callsign(target) {

	let check = checkCallsign(target.value);
	$(target).removeClass('is-valid is-invalid').prop('title', '');

	if (check == CALLSIGN_EMPTY) {
		$(target).addClass('is-invalid');
		$(target).parent().find('div.invalid-feedback').html('コールサインを入力してください');

	} else if (check == CALLSIGN_INVALID_FORMAT) {
		$(target).addClass('is-invalid');
		$(target).parent().find('div.invalid-feedback').html('コールサインを正しく入力してください');

	} else {
		$(target).addClass('is-valid').val(formatCallsign(target.value));
	}
}

function onBlur_Name(target) {

	$(target).removeClass('is-valid is-invalid').prop('title', '');

	if (target.value == '') {
		$(target).addClass('is-invalid');
		$(target).parent().find('div.invalid-feedback').html('お名前を入力してください');

	} else {
		$(target).addClass('is-valid');
	}
}

/**
 * 郵便番号欄でキーが押された
 * @param e イベント
 * @return 入力ＯＫならtrue、ＮＧならfalse
 */
function onKeyPress_ZipCode(e) {

	return (e.key.match(/^[0-9]$/) !== null);
}

/**
 * 郵便番号からフォーカスが外れた
 * @param target フォーカスが外れた要素
 */
function onBlur_ZipCode(target) {

	if (target.value == '') {
		$(target).addClass('is-invalid').removeClass('is-valid');
		$(target).parent().find('div.invalid-feedback').html('郵便番号を入力してください');

	} else if (checkZipCode(target.value)) {
		$(target).addClass('is-valid').removeClass('is-invalid').prop('title', '');

	} else {
		$(target).addClass('is-invalid').removeClass('is-valid');
		$(target).parent().find('div.invalid-feedback').html('郵便番号を正しく入力してください');
	}
}

/**
 * 住所欄からフォーカスが外れた
 */
function onBlur_Address() {

	if ($('select#opPrefCode').prop('selectedIndex') == -1 || $('select#opJisCode').prop('selectedIndex') == -1 || $('input#opAddress').val() == '') {
		$('select#opPrefCode').addClass('is-invalid').removeClass('is-valid');
		$('select#opJisCode' ).addClass('is-invalid').removeClass('is-valid');
		$('input#opAddress'  ).addClass('is-invalid').removeClass('is-valid');
		$('input#opAddress ~ div.invalid-feedback').html('都道府県・市区町村を選択してください。ご住所を入力してください');

	} else {
		$('select#opPrefCode').addClass('is-valid').removeClass('is-invalid');
		$('select#opJisCode' ).addClass('is-valid').removeClass('is-invalid');
		$('input#opAddress'  ).addClass('is-valid').removeClass('is-invalid');
	}
}

/**
 * Ｅメール欄からフォーカスが外れた
 * @param target 対象要素
 */
function onBlur_Email(target) {

	if (target.value != '' && !checkEMail(target.value)) {
		$(target).addClass('is-invalid').removeClass('is-valid');
		$(target).parent().find('div.invalid-tooltip').html('Ｅメールアドレスを正しく入力してください');

	} else {
		$(target).addClass('is-valid').removeClass('is-invalid').prop('title', '');
	}
}

/**
 * 日付欄でキーが押された
 * @param e イベント
 * @return ＯＫならtrue、ＮＧならfalse
 */
function onKeyPress_Date(e) {

	return	regDateChar.test(e.key);
}

/**
 * 日付欄からフォーカスが外れた
 * @param target 対象要素
 */
function onBlur_Date(target) {

	let check = checkDate(target.value);
	$(target).removeClass('is-valid is-invalid').prop('title', '');

	if (check == DATE_EMPTY) {
		// 日付が指定されていなかったら
		$(target).addClass('is-invalid');
		$(target).parent().find('div.invalid-feedback').html('日付を入力してください');

	} else if (check == DATE_INVALID_VALUE) {
		// 日付の値が間違っていたら
		$(target).addClass('is-invalid');
		$(target).parent().find('div.invalid-feedback').html('日付を正しく入力してください(２００１年以降が有効です)');

	} else if (check == DATE_INVALID_FORMAT) {
		// 日付のフォーマットが間違っていたら
		$(target).addClass('is-invalid');
		$(target).parent().find('div.invalid-feedback').html('日付のフォーマットが不正です');

	} else {
		$(target).addClass('is-valid').val(formatDate(target.value));
	}
}

/**
 * 時刻欄でキーが押された
 * @param e イベント
 * @return ＯＫならtrue、ＮＧならfalse
 */
function onKeyPress_Time(e) {

	return	regTimeChar.test(e.key);
}

/**
 * 時刻欄からフォーカスが外れた
 * @param target 対象要素
 */
function onBlur_Time(target) {

	let check = checkTime(target.value);
	$(target).removeClass('is-valid is-invalid').prop('title', '');

	if (check == TIME_EMPTY) {
		// 時刻が指定されていなかったら
		$(target).addClass('is-invalid');
		$(target).parent().find('div.invalid-feedback').html('時刻を入力してください');

	} else if (check == DATE_INVALID_VALUE) {
		// 時刻の値が間違っていたら
		$(target).addClass('is-invalid');
		$(target).parent().find('div.invalid-feedback').html('時刻が不正です');

	} else if (check == DATE_INVALID_FORMAT) {
		// 時刻のフォーマットが間違っていたら
		$(target).addClass('is-invalid');
		$(target).parent().find('div.invalid-feedback').html('時刻のフォーマットが不正です');

	} else {
		$(target).addClass('is-valid').val(formatTime(target.value));
	}
}

/**
 * 電波の型式欄でキーが押された
 * @param e イベント
 * @return ＯＫならtrue、ＮＧならfalse
 */
function onKeyPress_Mode(e) {

	return (e.key.match(/^[0-9A-Za-z]$/) !== null);
}

/**
 * 電波の型式欄からフォーカスが外れた
 * @param target 対象要素
 */
function onBlur_Mode(target) {

	target.value = target.value.toUpperCase();
}

/**
 * コード欄でキーが押された
 * @param e イベント
 * @return ＯＫならtrue、ＮＧならfalse
 */
function onKeyPress_Code(e) {

	return (e.key.match(/^[0-9A-Za-z]$/) !== null);
}

/**
 * コード欄からフォーカスが外れた
 * @param target フォーカスが外れた要素
 */
function onBlur_Code(target) {

	let row = $(target).parent().parent();
	target.value = target.value.toUpperCase();
	getName(target.value).done(function(data, textStatus) {
		$(row).find('input[id^=wkQth]').val(data.NAME);
	});
}

/**
 * 送信時の入力チェックを行う
 * @returns エラーがあればfalse、エラーがなければtrue
 */
function checkSubmit() {

	let result = true;
	let usedCallsigns = [];

	// 申請情報のチェック
	if ($('select#prise').prop('selectedIndex') == -1) {
		$('select#prise').addClass('is-invalid').removeClass('is-valid');
		$('select#prise ~ div.invalid-feedback').html('種別を選択してください');
		result = false;

	} else {
		$('select#prise').addClass('is-valid').removeClass('is-invalid');
	}

	$('input#remarks').addClass('is-valid').removeClass('is-invalid');

	// 申請者情報のチェック
	if ($('input#opZipCode').val() == '') {
		$('input#opZipCode').addClass('is-invalid').removeClass('is-valid');
		$('input#opZipCode ~ div.invalid-feedback').html('郵便番号を入力してください');

	} else if (checkZipCode($('input#opZipCode').val())) {
		$('input#opZipCode').addClass('is-valid').removeClass('is-invalid');

	} else {
		$('input#opZipCode').addClass('is-invalid').removeClass('is-valid');
		$('input#opZipCode ~ div.invalid-feedback').html('郵便番号を正しく入力してください');
		result = false;
	}

	if ($('select#opPrefCode').prop('selectedIndex') == -1 || $('select#opJisCode').prop('selectedIndex') == -1 || $('input#opAddress').val() == '')  {
		$('select#opPrefCode').addClass('is-invalid').removeClass('is-valid');
		$('select#opJisCode' ).addClass('is-invalid').removeClass('is-valid');
		$('input#opAddress'  ).addClass('is-invalid').removeClass('is-valid');
		$('input#opAddress ~ div.invalid-feedback').html('都道府県・市区町村を選択してください。ご住所を入力してください');
		result = false;

	} else {
		$('select#opPrefCode').addClass('is-valid').removeClass('is-invalid');
		$('select#opJisCode' ).addClass('is-valid').removeClass('is-invalid');
		$('input#opAddress'  ).addClass('is-valid').removeClass('is-invalid');
	}

	if ($('input#opKanji').val() == '' || $('input#opRoman').val() == '') {
		$('input#opKanji').addClass('is-invalid').removeClass('is-valid');
		$('input#opRoman').addClass('is-invalid').removeClass('is-valid');
		$('input#opRoman ~ div.invalid-feedback').html('お名前を漢字とひらがなで入力してください');
		result = false;

	} else {
		$('input#opKanji').addClass('is-valid').removeClass('is-invalid');
		$('input#opRoman').addClass('is-valid').removeClass('is-invalid');
	}

	if ($('input#opCallsign').val() == '') {
		$('input#opCallsign').addClass('is-invalid').removeClass('is-valid');
		$('input#opCallsign ~ div.invalid-feedback').html('コールサイン(またはＳＷＬナンバー)を入力してください');
		result = false;

	} else {
		$('input#opCallsign').addClass('is-valid').removeClass('is-invalid');
	}

	if ($('input#opEmail').val() == '') {
		$('input#opEmail').removeClass('is-valid');

	} else {
		$('input#opEmail').addClass('is-valid');
	}

	// ＱＳＬカードリストのチェック
	for (let i = 0; i < 19; i++) {

		let check = checkCallsign($('input#wkCallsign' + i).val());
		$('input#wkCallsign' + i).removeClass('is-valid is-invalid').prop('title', '');
		if (check == CALLSIGN_EMPTY) {
			$('input#wkCallsign' + i).addClass('is-invalid');
			$('input#wkCallsign' + i + ' ~ div.invalid-feedback').html('コールサインを入力してください');
			result = false;

		} else if (check == CALLSIGN_INVALID_FORMAT) {
			$('input#wkCallsign' + i).addClass('is-invalid');
			$('input#wkCallsign' + i + ' ~ div.invalid-feedback').html('コールサインを正しく入力してください');
			result = false;

		} else if (usedCallsigns.indexOf($('input#wkCallsign' + i).val()) >= 0) {
			$('input#wkCallsign' + i).addClass('is-invalid');
			$('input#wkCallsign' + i + ' ~ div.invalid-feedback').html('同じ局は一度しか使えません');
			result = false;

		} else {
			$('input#wkCallsign' + i).addClass('is-valid');
			usedCallsigns.push($('input#wkCallsign' + i).val());
		}

		$('input#wkDate' + i).removeClass('is-valid is-invalid').prop('title', '');
		check = checkDate($('input#wkDate' + i).val());
		if (check == DATE_EMPTY) {
			// 日付が指定されていなかったら
			$('input#wkDate' + i).addClass('is-invalid');
			$('input#wkDate' + i + ' ~ div.invalid-feedback').html('日付を入力してください');
			result = false;

		} else if (check == DATE_INVALID_VALUE) {
			// 日付の値が間違っていたら
			$('input#wkDate' + i).addClass('is-invalid');
			$('input#wkDate' + i + ' ~ div.invalid-feedback').html('日付を正しく入力してください(２００１年以降が有効です)');
			result = false;

		} else if (check == DATE_INVALID_FORMAT) {
			// 日付のフォーマットが間違っていたら
			$('input#wkDate' + i).addClass('is-invalid');
			$('input#wkDate' + i + ' ~ div.invalid-feedback').html('日付のフォーマットが不正です');
			result = false;

		} else {
			$('input#wkDate' + i).addClass('is-valid');
		}

		$('input#wkTime' + i).removeClass('is-valid is-invalid').prop('title', '');
		check = checkTime($('input#wkTime' + i).val());
		if (check == TIME_EMPTY) {
			// 時刻が指定されていなかったら
			$('input#wkTime' + i).addClass('is-invalid');
			$('input#wkTime' + i + ' ~ div.invalid-feedback').html('時刻を入力してください');
			result = false;

		} else if (check == DATE_INVALID_VALUE) {
			// 時刻の値が間違っていたら
			$('input#wkTime' + i).addClass('is-invalid');
			$('input#wkTime' + i + ' ~ div.invalid-feedback').html('時刻が不正です');
			result = false;

		} else if (check == DATE_INVALID_FORMAT) {
			// 時刻のフォーマットが間違っていたら
			$('input#wkTime' + i).addClass('is-invalid');
			$('input#wkTime' + i + ' ~ div.invalid-feedback').html('時刻のフォーマットが不正です');
			result = false;

		} else {
			$('input#wkTime' + i).addClass('is-valid');
		}
	}

	// 認証番号のチェック
	verifyNumber($('input#vNumber').val()).done(function(data, textStatus, jqXHR) {
		if ($('input#vNumber').val() == "" || data.RESULTCD != 0) {
			$('input#vNumber').addClass('error').prop('title', '認証番号を左記の通り入力してください。');
			getNumber();
			result = false;

		} else {
			$('input#vNumber').removeClass('error').prop('title', '');
		}

	}).fail(function (jqXHR, textStatus, errorThrown) {

	}).always(function () {

	});

	return result;
}

/**
 * 郵便番号をチェックする
 * @param source 元データ
 * @returns 正しければtrue、間違っていたらfalse
 */
function checkZipCode(source) {

	if (!source.match(/^[0-9]{7}$/)) {
		return false;
	}

	return true;
}

/**
 * コールサインをチェックする
 * @param source 元データ
 * @returns エラーコード
 */
function checkCallsign(source) {

	let result = CALLSIGN_VALID;

	if (source == '') {
		// コールサインが入力されていなかったら
		result = CALLSIGN_EMPTY;

	} else if (!regCallsign.test(source)) {
		// フォーマットが不正だったら
		result = CALLSIGN_INVALID_FORMAT;
	}

	return result;
}

/**
 * コールサインをフォーマット(大文字化)する
 * @param source 元データ
 * @returns 大文字化したコールサイン
 */
function formatCallsign(source) {

	return source.toUpperCase();
}

/**
 * 日付をチェックする
 * @param source 元データ
 * @returns エラーコード
 */
function checkDate(source) {

	let result = DATE_VALID;

	if (source == '') {
		// 日付が入力されていなかったら
		result = DATE_EMPTY;

	} else if (regDateFormat1.test(source)) {
		// '/''-'付きフォーマットだったら
		let temp = source.match(regDateFormat1);
		temp[1] = parseInt(temp[1]);
		temp[3] = parseInt(temp[3]);
		temp[5] = parseInt(temp[5]);

		if (isNaN(Date.parse(temp[1] + '/' + temp[3] + '/' + temp[5])) || (new Date(temp[1] + '/' + temp[3] + '/' + temp[5])).getMonth() + 1 != temp[3] || Date.parse(temp[1] + '/' + temp[3] + '/' + temp[5]) < Date.parse('2001/01/01')) {
			// 日付の値が間違っていたら
			result = DATE_INVALID_VALUE;
		}

	} else if (regDateFormat2.test(source)) {
		// '/'無しフォーマットだったら
		let temp = source.match(regDateFormat2);
		temp[1] = parseInt(temp[1]);
		temp[2] = parseInt(temp[2]);
		temp[3] = parseInt(temp[3]);

		if (isNaN(Date.parse(temp[1] + '/' + temp[2] + '/' + temp[3])) || (new Date(temp[1] + '/' + temp[2] + '/' + temp[3])).getMonth() + 1 != temp[2] || Date.parse(temp[1] + '/' + temp[3] + '/' + temp[5]) < Date.parse('2001/01/01')) {
			// 日付の値が間違っていたら
			result = DATE_INVALID_VALUE;
		}

	} else {
		result = DATE_INVALID_FORMAT;
	}

	return result;
}

/**
 * 日付をフォーマットする
 * @param source 元データ
 * @returns YYYY/MM/DD形式またはYYYY-MM-DD形式
 */
function formatDate(source) {

	if (regDateFormat1.test(source)) {
		// '/''-'付きフォーマットだったら
		let temp = source.match(regDateFormat1);
		temp[1] = parseInt(temp[1]);
		temp[3] = parseInt(temp[3]);
		temp[5] = parseInt(temp[5]);

		source = temp[1] + temp[2] + ('0' + temp[3]).slice(-2) + temp[4] + ('0' + temp[5]).slice(-2);

	} else if (regDateFormat2.test(source)) {
		// '/'無しフォーマットだったら
		let temp = source.match(regDateFormat2);
		temp[1] = parseInt(temp[1]);
		temp[2] = parseInt(temp[2]);
		temp[3] = parseInt(temp[3]);

		source = temp[1] + '/' + ('0' + temp[2]).slice(-2) + '/' + ('0' + temp[3]).slice(-2);
	}

	return source;
}

/**
 * 時刻をチェックする
 * @param source 元データ
 * @returns 正しければtrue、間違っていたらfalse
 */
function checkTime(source) {

	let result = TIME_VALID;

	if (source == '') {
		result = TIME_EMPTY;

	} else if (regTimeFormat1.test(source)) {
		// ':'付きフォーマットだったら
		let temp = source.match(regTimeFormat1);
		temp[1] = parseInt(temp[1]);
		temp[2] = parseInt(temp[2]);

		if (temp[1] < 0 || temp[1] > 23 || temp[2] < 0 || temp[2] > 59) {
			result = DATE_INVALID_VALUE;
		}

	} else if (regTimeFormat2.test(source)) {
		// '/'無しフォーマットだったら
		let temp = source.match(regTimeFormat2);
		temp[1] = parseInt(temp[1]);
		temp[2] = parseInt(temp[2]);

		if (temp[1] < 0 || temp[1] > 23 || temp[2] < 0 || temp[2] > 59) {
			result = DATE_INVALID_VALUE;
		}
	}

	return result;
}

/**
 * 時刻をフォーマットする
 * @param source 元データ
 * @returns HH:MM形式
 */
function formatTime(source) {

	if (regTimeFormat1.test(source)) {
		// ':'付きフォーマットだったら
		let temp = source.match(regTimeFormat1);
		temp[1] = parseInt(temp[1]);
		temp[2] = parseInt(temp[2]);

		source = ('0' + temp[1]).slice(-2) + ':' + ('0' + temp[2]).slice(-2);

	} else if (regTimeFormat2.test(source)) {
		// '/'無しフォーマットだったら
		let temp = source.match(regTimeFormat2);
		temp[1] = parseInt(temp[1]);
		temp[2] = parseInt(temp[2]);

		source = ('0' + temp[1]).slice(-2) + ':' + ('0' + temp[2]).slice(-2);
	}

	return result;
}

/**
 * Ｅメールをチェックする
 * @param source 元データ
 * @returns 正しければtrue、間違っていたらfalse
 */
function checkEMail(source) {

	return source.match(/^[0-9a-zA-Z\-\+\_]+@([0-9a-zA-Z\-]+\.)+[0-9a-zA-Z]+$/);
}

/**
 * 時刻をフォーマットする
 * @param source 元データ
 * @returns HH:MM形式
 */
function formatTime(source) {

	if (source.match(/^[0-9]{1,2}:[0-9]{1,2}$/)) {
		let temp = source.split(":");
		temp[0] = parseInt(temp[0]);
		temp[1] = parseInt(temp[1]);

		return (temp[0] < 10 ? "0" : "") + temp[0] + ":" + (temp[1] < 10 ? "0" : "") + temp[1];

	} else if (source.match(/^[0-9]{4}$/)) {
		let hour = parseInt(source.substr(0, 2));
		let minute = parseInt(source.substr(2, 4));

		return (hour < 10 ? "0" : "") + hour + ":" + (minute < 10 ? "0" : "") + minute;
	}

	return source;
}

/**
 * 指定したキーの申請書を表示する
 * @param prise 種別
 * @param pubNumber 発行番号
 */
function showApplication(target) {

	let key = $(target).parent().parent().data('key');
	location.href = "awardView.php?ACTION=view&prise=" + key.prise + "&pubNumber=" + key.number;
}

function getPriseList() {

	$.ajax({
		type:		METHOD_TYPE,
		url:		URL_AJAX,
		dataType:	DATA_TYPE,
		data:	{
			CALL_AJAX:	'getPriseList'},
		beforeSend:	function (jqXHR) {

		}
	}).done(function(data, textStatus, jqXHR) {
		if (data.RESULTCD == 0) {
			for (let prise in data.LIST) {
				$('select#prise').append(
					$('<option />').val(prise).html(data.LIST[prise].name));
			}
			$('select#prise').prop('selectedIndex', -1);

		} else {
			showAlertDialog('尾道２１世紀アワード', data.MESSAGE);
		}

	}).fail(function (jqXHR, textStatus, errorThrown) {

	}).always(function () {
		$('div#wait').hide();
	});
}

/**
 * 都道府県のリストを取得
 */
function getPrefList() {

	$.ajax({
		type:		METHOD_TYPE,
		url:		URL_AJAX,
		dataType:	DATA_TYPE,
		data:	{
			CALL_AJAX:	'getPrefList'},
		beforeSend:	function (jqXHR) {
			$('div#wait').show();
			$('select#opPrefCode').prop('disabled', true);
		}
	}).done(function(data, textStatus, jqXHR) {
		if (data.RESULTCD == 0) {
			for (let i = 0; i < data.LIST.length; i++) {
				$('select#opPrefCode').append(
					$('<option />').val(data.LIST[i].code).html(data.LIST[i].name));
			}
			$('select#opPrefCode').prop('selectedIndex', -1);

		} else {
			showAlertDialog('尾道２１世紀アワード', data.MESSAGE);
		}

	}).fail(function (jqXHR, textStatus, errorThrown) {

	}).always(function () {
		$('select#opPrefCode').prop('disabled', false);
		$('div#wait').hide();
	});
}

/**
 * 市区町村のリストを取得
 */
function getCityList(target) {

	$.ajax({
		type:		METHOD_TYPE,
		url:		URL_AJAX,
		dataType:	DATA_TYPE,
		data:	{
			CALL_AJAX:	'getCityList',
			prefCode:	target.value},
		beforeSend:	function (jqXHR) {
			$('div#wait').show();
			$('select#opJisCode').prop('disabled', true);
		}
	}).done(function(data, textStatus, jqXHR) {
		if (data.RESULTCD == 0) {
			$('select#opJisCode').empty();
			for (let i = 0; i < data.LIST.length; i++) {
				$('select#opJisCode').append(
					$('<option />').val(data.LIST[i].code).html(data.LIST[i].name));
			}
			$('select#opJisCode').prop('selectedIndex', -1);

		} else {
			showAlertDialog('尾道２１世紀アワード', data.MESSAGE);
		}

	}).fail(function (jqXHR, textStatus, errorThrown) {

	}).always(function () {
		$('select#opJisCode').prop('disabled', false).focus();
		$('div#wait').hide();
	});
}

/**
 * 周波数帯のリストを取得
 */
function getFreqList() {

	$.ajax({
		type:		METHOD_TYPE,
		url:		URL_AJAX,
		dataType:	DATA_TYPE,
		data:	{
			CALL_AJAX:	'getFreqList'},
		beforeSend:	function (jqXHR) {

		}
	}).done(function(data, textStatus, jqXHR) {
		if (data.RESULTCD == 0) {
			for (let id in data.LIST) {
				$('select.wkFreq').append(
					$('<option />').val(id).html(data.LIST[id]));
			}
			$('select.wkFreq').prop('selectedIndex', -1);

		} else {
			showAlertDialog('尾道２１世紀アワード', data.MESSAGE);
		}

	}).fail(function (jqXHR, textStatus, errorThrown) {

	}).always(function () {
		$('div#wait').hide();
	});
}

/**
 * 申請書の一覧を取得
 */
function listApplications() {

	$.ajax({
		type:		METHOD_TYPE,
		url:		URL_AJAX,
		dataType:	DATA_TYPE,
		data:	{
			CALL_AJAX:	'listApplications'},
		beforeSend:	function (jqXHR) {
			$('div#wait').show();
			$('table#admin tbody').empty();
		}
	}).done(function(data, textStatus, jqXHR) {
		if (data.RESULTCD == 0) {
			for (let i = 0; i < data.LIST.length; i++) {
				let record = data.LIST[i];

				let row1 = $('<tr />').data('key', {prise: record.prise, number: record.pubNumber});
				if (record.pubDate == null) {
					$(row1).append(
						$('<td />').addClass('appdate').attr({rowspan: 2}).append([
							record.appDate,
							$('<br />'),
							$('<input />').addClass('form-control').attr({type: 'date', name: 'pubDate', maxlength: 10})]));
				} else {
					$(row1).append(
						$('<td />').addClass('appdate').attr({rowspan: 2}).append([
							record.appDate,
							$('<br />'),
							record.pubDate,
							$('<input />').attr({type: 'hidden', name: 'pubDate'}).val(record.pubDate)]));
				}

				$(row1).addClass(record.pubDate == null ? 'notPublished' : '').append([
					$('<td />').addClass('prise').html(record.priseName + '賞'),
					$('<td />').addClass('callsign').attr({rowspan: 2}).html(record.opCallsign),
					$('<td />').addClass('opname').attr({rowspan: 2}).append([
						$('<span />').addClass('ruby').html(record.opNamer),
						record.opNamek]),
					$('<td />').addClass('opmail').html(record.opMail),
					$('<td />').addClass('opaddress').attr({rowspan: 2}).append([
						'〒' + record.opZipCode,
						'&nbsp;',
						record.opTownName,
						$('<br />'),
						$('<input />').addClass('form-control').attr({type: 'text', name: 'opAddress'}).val(record.opAddress)]),
					$('<td />').addClass('buttons').attr({rowspan: 2}).append([
						$('<button />').addClass('btn').attr({onclick: "showApplication(this);"}).html('表示'),
						$('<button />').addClass('btn').attr({onclick: "publish(this);"}).html(record.pubDate == null ? '発行' : '修正')])]);

				let row2 = $('<tr />').addClass(record.pubDate == null ? 'notPublished' : '').append([
					$('<td />').addClass('prise').html(record.priseMark + '-' + record.pubNumber),
					$('<td />').addClass('remarks').html(record.remarks)]);

				$('table#admin tbody').append([row1, row2]);
			}

		} else {
			showAlertDialog('尾道２１世紀アワード', data.MESSAGE);
		}

	}).fail(function (jqXHR, textStatus, errorThrown) {

	}).always(function () {
		$('div#wait').hide();
	});
}

/**
 * 発行処理
 * @param target 対象要素
 */
function publish(target) {

	let row = $(target).parent().parent();
	let key = $(row).data('key');

	$.ajax({
		type:		METHOD_TYPE,
		url:		URL_AJAX,
		dataType:	DATA_TYPE,
		data:	{
			CALL_AJAX:	'publish',
			prise:		key.prise,
			pubNumber:	key.number,
			opAddress:	$(row).find('input[name=opAddress]').val(),
			pubDate:	$(row).find('input[name=pubDate]').val().replace(/\-/g, "/")},
		beforeSend:		function (jqXHR) {

		}
	}).done(function(data, textStatus, jqXHR) {
		if (data.RESULTCD == 0) {
			listApplications();

		} else {
			showAlertDialog('尾道２１世紀アワード', data.MESSAGE);
		}

	}).fail(function (jqXHR, textStatus, errorThrown) {

	}).always(function () {

	});
}

function register() {

	let params = {
		CALL_AJAX:		'register',
		prise:			$('select#prise').val(),
		remarks:		$('input#remarks').val(),
		opCallsign:		$('input#opCallsign').val(),
		opNameK:		$('input#opKanji').val(),
		opNameR:		$('input#opRoman').val(),
		opMail:			$('input#opEmail').val(),
		opZipCode:		$('input#opZipCode').val(),
		opPrefCode:		$('select#opJisCode').val().substr(0, 2),
		opJisCode:		$('select#opJisCode').val().substr(2, 3),
		opAddress:		$('input#opAddress').val(),
		wkCallsign:		[],
		wkDateTime:		[],
		wkFrequency:	[],
		wkMode:			[],
		wkQth:			[]};

	for (let i = 0; i < 19; i++) {
		params.wkCallsign.push( $('input#wkCallsign' + i).val());
		params.wkDateTime.push( $('input#wkDate'     + i).val() + ' ' + $('input#wkTime' + i).val());
		params.wkFrequency.push($('select#wkFreq'    + i).val());
		params.wkMode.push(     $('input#wkMode'     + i).val());
		params.wkQth.push(      $('input#wkQth'      + i).val());
	}

	$.ajax({
		type:		METHOD_TYPE,
		url:		URL_AJAX,
		dataType:	DATA_TYPE,
		data:		params,
		beforeSend:	function (jqXHR) {

		}
	}).done(function(data, textStatus, jqXHR) {
		if (data.RESULTCD == 0) {
			showAlertDialog('アワードの申請ありがとうございます', data.MESSAGE);
			$('button#clear').click();

		} else {
			showAlertDialog('尾道２１世紀アワード', data.MESSAGE);
		}

	}).fail(function (jqXHR, textStatus, errorThrown) {

	}).always(function () {

	});
}

/**
 * 認証番号を取得
 * @returns 認証番号
 */
function getNumber() {

	$.ajax({
		type:		METHOD_TYPE,
		url:		URL_AJAX,
		dataType:	DATA_TYPE,
		data:	{
			CALL_AJAX:	'create',
			PHPSESSID:	sessionId},
		beforeSend:	function (jqXHR) {

		}
	}).done(function(data, textStatus, jqXHR) {
		md5Key = data.MD5KEY;
		$('div#number').html(data.NUMBER);
		$('input#vNumber').val('');

	}).fail(function (jqXHR, textStatus, errorThrown) {

	}).always(function () {

	});
}

/**
 * 認証番号を照合する
 * @param vNumber 認証番号
 */
function verifyNumber(vNumber) {

	return $.ajax({
		type:		METHOD_TYPE,
		url:		URL_AJAX,
		dataType:	DATA_TYPE,
		async:		false,
		data:	{
			CALL_AJAX:	'verify',
			MD5KEY:		md5Key,
			NUMBER:		vNumber},
		beforeSend:		function (jqXHR) {}});
}

/**
 * ＱＴＨを取得
 * @param code コード
 */
function getName(code) {

	return $.ajax({
		type:		METHOD_TYPE,
		url:		URL_AJAX,
		dataType:	DATA_TYPE,
		async:		false,
		data:	{
			CALL_AJAX:	'getName',
			CODE:		code},
		beforeSend:	function (jqXHR) {}});
}
