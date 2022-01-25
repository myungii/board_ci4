<?= $this->extend('layouts/default') ?>

<?= $this->section('content') ?>

<head>
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
    <style>
		div.quiz_title {
			font-size: 14px;
			font-weight: bold;
			padding : 0.3em;
		}

		li.chk_answer_li {
			padding: 0.3em;
		}

		#msg {
			color: red;
		}

		div.finish {
			color:darkblue;
		}
		
		#chk_frm label {
			display: inline;
			position: relative;
			top: -8px;
		}

    </style>
</head>

<!-- //subTitle -->
<div id="title-area">Quiz </div>
<!-- Contents -->
<div id="Contents" style="width:1400px; padding-left:20em;">
	<br>
    <h2>Quiz</h2>
	<br>

	<button type="button" class="btn" id="quiz_start">퀴즈 시작1</button>
	<button type="button" class="btn" id="quiz_second">퀴즈 시작2</button>


  <!-- Modal -->
  <div id="dialog" title="QUIZ" style="display: none;">
		
	</div>

</div>

<!-- Contents -->

<script type="text/javascript">

let index = 0;

$(function() {

	 $("#quiz_start").on("click", function() {
		load_data_1();
	}); //quiz_start click end

	$("#quiz_second").on("click", function() {
		load_data_2();
	}); //quiz_start click end

});

//퀴즈 시작1
function load_data_1(index, answer) {

	$.ajax({
				type: 'GET',
				url: '/Quiz/Main/QuizController/quiz',
				data: { index  		: index,
						chk_answer  : answer
					  },
				success: function(data) {
					var obj = $.parseJSON(data);

					quiz1_html(obj);	
							
					$("#dialog").dialog({
						width: 500,
						modal: true,
						colseText: "hide",
						buttons: [
									{		
										text:"닫기",
										//icon: "ui-icon-heart",
										click: function() {
											$(this).dialog("close");
										}
									}
								 ]
					}); //dialog end
				}

			}); //ajax end

} //load_data_1 end

//퀴즈 시작1
function quiz1_html(obj) {

	if(obj.finish == 1) {  //문제가 끝나면 종료
		$("#dialog").html(`<div class="quiz_title finish"> 정답입니다! 모든 문제를 다 푸셨습니다! </div>`);
		$("#dialog").append(`<button class="btn result"> 응모하기 </button>`);
	} else {
		let num = parseInt(obj.index) + 1;
		$("#dialog").html(`<div class='quiz_title'>Q${num}.${obj.qlist.question} `);
		
		for(let i=0; i<obj.qlist.selection.length; i++) {
			let chk = i + 1;
			$("#dialog").append(`<li class='chk_answer_li'><a href='javascript:chk_answer(${obj.index}, ${chk});'> ${obj.number[i]} ${obj.qlist.selection[i]} </a></li>`);					
		}
		$("#dialog").append(`<small id='msg'>${obj.msg}</small>`);
	}

} //quiz1_html end


//퀴즈 시작1 버튼 클릭 시
function chk_answer(index, answer) {

	load_data(index, answer);
}




//퀴즈 시작2
function load_data_2(answer, country, country_name) {

$.ajax({
			type: 'GET',
			url: '/Quiz/Main/QuizController/quiz2',
			data: { 
					chk_country : country,
					chk_answer  : answer
				  },
			success: function(data) {
				var obj = $.parseJSON(data);

				quiz_selection(obj.country);

				if(obj.is_valid == '2') {
					quiz2_html('틀렸습니다! 다시 선택해주세요. 정답을 맞추셔야 이벤트 응모가 가능합니다.', country_name, country);	
				} 

				if(obj.is_valid == '1') 
				{
					$("#dialog").html(`<div class="quiz_title finish"> 정답입니다! 이벤트 응모하시겠습니까? </div>`);
					$("#dialog").append(`<button class="btn result"> 응모하기 </button>`);
				}
				
						
				$("#dialog").dialog({
					width: 500,
					modal: true,
					colseText: "hide",
					buttons: [
								{		
									text:"닫기",
									//icon: "ui-icon-heart",
									click: function() {
										$(this).dialog("close");
									}
								}
							 ]
				}); //dialog end
			}

		}); //ajax end

} //load_data_2 end


//퀴즈 시작2 : 시작 전 국가 선택
function quiz_selection(country) {

	$("#dialog").html(`<div class="quiz_title"> 국가를 선택하고 확인버튼 눌러주세요! </div>`);
	$("#dialog").append(`<form id="chk_frm"> 
							<input type="checkbox" id="UK" data-id="${country.UK[0]}" name="country[]" value="${country.UK[1]}"> 
							<label for="UK"> ${country.UK[0]} </label><br>
							<input type="checkbox" id="USA" data-id="${country.USA[0]}" name="country[]" value="${country.USA[1]}"> 
							<label for="USA"> ${country.USA[0]} </label><br>
							<input type="checkbox" id="EUROPE" data-id="${country.EUROPE[0]}" name="country[]" value="${country.EUROPE[1]}"> 
							<label for="EUROPE"> ${country.EUROPE[0]} </label><br>
							<input type="checkbox" id="CHINA" data-id="${country.CHINA[0]}" name="country[]" value="${country.CHINA[1]}"> 
							<label for="CHINA"> ${country.CHINA[0]} </label><br>
						 </form>`);
	$("#dialog").append(`<button class="btn" onclick="result('country[]');"> 확인 </button>`);

	_checkbox('country[]');

	//quiz2_html();
	
}

//퀴즈 시작2
function quiz2_html(msg, country, en_country) {

	if(msg) {
		alert(`${msg}`);
	}
	$("#dialog").html(`<div class="quiz_title">Q. ${country}이 쓰는 화폐 단위는?</div>`);
	$("#dialog").append(`<form id="chk_frm"> 
							<input type="checkbox" id="USA" name="currency[]" value="dollar"> 
							<label for="currency1"> $ 달러 </label><br>
							<input type="checkbox" id="CHINA" name="currency[]" value="yuan">
							<label for="currency1"> ¥ 위안 </label><br>
							<input type="checkbox" id="UK" name="currency[]" value="pound"> 
							<label for="currency1"> £ 파운드 </label><br>
							<input type="checkbox" id="EUROPE" name="currency[]" value="eur"> 
							<label for="currency1"> € 유로 </label><br>
						</form>`);
	$("#dialog").append(`<button class="btn" onclick="result('currency[]', '${en_country}', '${country}');"> 정답버튼 누르고 응모하기 </button>`);

	_checkbox('currency[]');

} //quiz2_html end


//퀴즈 시작2 버튼 클릭 시
function result(name, en_country, country_name) {
	
	$(`#chk_frm :input[name='${name}']:checked`).each(function() {
	
		let checked = '';

		if(name == 'currency[]') {
			checked = $(this).val();
			load_data_2(checked, en_country, country_name);
			return;
		}
		else if(name == 'country[]') {
			checked = $(this).attr("data-id");
			en_country = $(this).attr('id');
	
			quiz2_html('', checked, en_country, country_name);
		}

		
	});
	
}

//공통
function _checkbox(name) {
	//체크박스 한 개만 선택하기
	$(`input[type='checkbox'][name='${name}']`).click(function() {
		if($(this).prop("checked")) {
			$(`input[type='checkbox'][name='${name}']`).prop("checked", false);
			$(this).prop("checked", true);
		}
	});
}


</script>

<?= $this->endSection() ?>