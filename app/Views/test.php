<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="/asset/popup/css/popup.css" />
    <!--script-->
    <script type="text/javascript" src="/asset/front/js/jquery-3.3.1.min.js"></script>
    

    <title>test</title>
</head>
<body>
    <h3>This is a Test page.</h3>


</body>

<script>


    

// 클립보드 
function copy(val) {
	var dummy = document.createElement("textarea");
	document.body.appendChild(dummy);
	dummy.value = val;
	dummy.select();
	document.execCommand("copy");
	document.body.removeChild(dummy);
	alert('복사 완료되었습니다.');
}

// 팝업
function openLayerPopup(selector) {
	$(selector).before('<div id="layer-mask"></div>').fadeIn(150);
    $(selector).find('.close').one('click', function() {
		$('#layer-mask').remove();
		$(selector).css({'display': 'none'});
    });
}

</script>

</html>