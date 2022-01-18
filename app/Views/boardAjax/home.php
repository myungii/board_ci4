<head>
    
<link rel="stylesheet" type="text/css" href="/asset/popup/css/popup.css">
<script src="/asset/popup/js/popup.js"></script>

    <style>
        #noticeList {
            font-weight : bold;
        }
        #new {
            color : red;
        }


		.ui-datepicker-trigger{cursor: pointer;}
		.datepicker{cursor: pointer;} 
    </style>
</head>

<!-- //subTitle -->
<div id="title-area">HTML </div>
<!-- Contents -->
<div id="Contents" style="width:1400px; padding-left:20em;">
    <!-- filter -->
    <form id="FrmAttendanceSearch" >
    <input type="hidden" name="p" value="">
    <table class="table table-bordered table-form pad">
        <colgroup>
            <col>
			<col style="width:400px">
        </colgroup>
		
        <tbody>
            <tr>
                <th>재목</th>
                <td>
                    <input type="text" name="search_title" class="form-control input-xsm"   value="" autocomplete="off">
                </td>

                <th>이름</th>
                <td>
                    <input type="text" name="search_name" class="form-control input-xsm"  value="" autocomplete="off">
                </td>
            </tr>

            <tr>
                <th>등록일</th>
                <td>
					<div style="float:left; width:180px">
						 <input type="text" name="search_reg_start" class="datepicker" id="datepicker_start" style="width:100%"  value="" autocomplete="off" readonly>
					</div>	
					<div style="float:left;">
						<span style="margin:0 5px; line-height:30ox;">
							~
						</span>
					</div>
					<div style="float:left;width:180px;">
						 <input type="text" name="search_reg_end" class="datepicker" id="datepicker_end" style="width:100%"  value="" autocomplete="off" readonly>
					</div>	

                </td>

                <th>공지여부</th>
                <td style="text-align:start;">
                  <input type="radio" name="notice" id="all" value="all" class="hmis validate" checked>
                  <span class="lbl">전체</span>
                  <input type="radio" name="notice" id="yes" value="Y" class="hmis validate" >
                  <span class="lbl">공지</span>
                  <input type="radio" name="notice" id="no" value="N" class="hmis validate">
                  <span class="lbl">일반</span>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="area-button">
        <button type="button" id="searchBtn" class="btn btn-lg btn-theme" onclick="">검색</button>
    </div>
    </form>
    
        <!-- btn, total -->
        <h3 class="area-title">
        Total :
        <span class="f-bold"><strong><span id="recordsTotal"></span></strong>건</span>
        <div class="button-box">
            <button class="btn btn-flat-blue" onclick='dialog.dialog( "open" );'  style="float: left;">게시물 등록</button>
        </div>
    </h3>
    
    <!-- list -->
    
        <table class="table table-bordered table-list table-striped table-hover table-adjehyu" id="adjehyuList">
            <colgroup>
                <col width="80px">
                <col>
                <col width="100px">
                <col width="100px">
                <col width="100px">
            </colgroup>
            <thead>
            <tr>
                <th>No</th>
                <th>제목</th>
                <th>이름</th>
                <th>등록일</th>
                <th>조회수</th>
            </tr>
            </thead>
            <tbody id="notice_list">
  
            </tbody>
            
            <tbody id="board_list">
            </tbody>
            
        </table>
            
        <div id="paging" class="area-button">
        <ul class="pagination">
        </ul>
        
        </div>

</div>


<!-- 글쓰기 팝업 -->
<div id="dialog-form" title="글쓰기">

	<form>
		<div class="form-group">
			<label for="wname" style="display:inline-block">이름</label>
			 <div class="col-sm-10">
				<input type="text" class="form-control" id="wname" name="wname"  aria-describedby="emailHelp" placeholder="이름을 입력하세요.">
			 </div>
			 <div class="valid_notice" style="color:red"> </div>
		</div>
		<div class="form-group">
			<label for="wtitle" style="display:inline-block">제목</label>
			<input type="text" class="form-control" id="wtitle" name="wtitle" placeholder="제목을 입력하세요.">
		</div>
		<div class="form-check">
			<label style="display:block">공지여부</label>
			<input class="form-check-input" type="radio" name="wnotice" id="wnotice_N" value="N" checked>
			<label class="form-check-label" style="display:inline-block" for="wnotice_N">
				미사용
			</label>
			<input class="form-check-input" type="radio" name="wnotice" id="wnotice_Y" value="Y" >
			<label class="form-check-label" style="display:inline-block" for="wnotice_Y">
				사용
			</label>
		</div>
		<br>
		<div class="form-group">
			<label for="wupload_file" style="display:inline-block">파일첨부</label>
			<input type="file" class="form-control-file" name="wupload_file"  id="wupload_file">
		</div>
		<div class="form-group">
			<textarea class="form-control" id="summernote" name="editoerdata" rows="3"></textarea>
		</div>
	</form>

</div>



<!-- Contents -->

<script type="text/javascript">

$(function() {

    //모든 datepicker에 대한 공통 옵션 설정
    $.datepicker.setDefaults({
        dateFormat: 'yy-mm-dd' //Input Display Format 변경
        ,showOtherMonths: true //빈 공간에 현재월의 앞뒤월의 날짜를 표시
        ,showMonthAfterYear:true //년도 먼저 나오고, 뒤에 월 표시
        ,changeYear: true //콤보박스에서 년 선택 가능
        ,changeMonth: true //콤보박스에서 월 선택 가능                
        ,yearSuffix: "년" //달력의 년도 부분 뒤에 붙는 텍스트
        ,monthNamesShort: ['1','2','3','4','5','6','7','8','9','10','11','12'] //달력의 월 부분 텍스트
        ,monthNames: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'] //달력의 월 부분 Tooltip 텍스트
        ,dayNamesMin: ['일','월','화','수','목','금','토'] //달력의 요일 부분 텍스트
        ,dayNames: ['일요일','월요일','화요일','수요일','목요일','금요일','토요일'] //달력의 요일 부분 Tooltip 텍스트
        ,minDate: "-1M" //최소 선택일자(-1D:하루전, -1M:한달전, -1Y:일년전)
        ,maxDate: "+1M" //최대 선택일자(+1D:하루후, -1M:한달후, -1Y:일년후)                    
    });

    //input을 datepicker로 선언
    $("#datepicker_start").datepicker();                    
    $("#datepicker_end").datepicker();
    //To의 초기값을 내일로 설정
    $('#datepicker_end').datepicker('setDate', 'today'); //(-1D:하루전, -1M:한달전, -1Y:일년전), (+1D:하루후, -1M:한달후, -1Y:일년후)


	//wirte form editor
	$('#summernote').summernote({
			height: 390,
			width: 960,              
			minHeight: 200,            
			maxHeight: 500, 
			focus: true,                  
			lang: "ko-KR",					
			placeholder: '내용을 입력해주세요.',	
			toolbar: [
				['fontname', ['fontname']],
				['fontsize', ['fontsize']],
				['style', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
				['color', ['forecolor', 'color']],
				['table', ['table']],
				['para', ['ul', 'ol', 'paragraph']],
				['height', ['height']],
				['insert', ['picture', 'link', 'video']],
				['view', ['fullscreen', 'help']]
			],
			fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', '맑은 고딕', '궁서', '굴림체',
				'굴림', '돋음체', '바탕체'],
			fontSizes: ['8', '9', '10', '11', '12', '14', '16', '18', '20', '22', '24', '28', '30', '36',
				'50', '72']
	 }); //summernote end

});


var dialog, form;

dialog = $( "#dialog-form" ).dialog({
        autoOpen: false,
        height: 800,
        width: 1000,
        modal: true,
        buttons: {
            
			Submit: function() {

							var name			= $("input[name=wname]").val();
							var title			= $("input[name=wtitle]").val();
							var upload_file		= $("input[name=wupload_file]")[0].files[0];
							var content			= $("#summernote").val();

						$("input[name=wnotice]:checked").each(function() {
							var notice = $(this).val();

							add_write(name, title, content, notice, upload_file)

						});
			},

            Cancel: function() {
            dialog.dialog( "close" );
            }
        },
        close: function() {
            //form[ 0 ].reset();
            //allFields.removeClass( "ui-state-error" );
        }
});//dialog end





function writePopup(formData) {
	
console.log("writePopup : " + formData);

        $.ajax({
            url : "/index.php/boardAjax/write/ajaxPopup",
            method : "POST",
			data : formData,
			dataType : "text",
			//contentType : 'application/x-www-form-urlencoded; charset=euc-kr json',
			contentType : false,
			processData: false,
            success :function(data) {

                console.log('성공 : ' + data);

					if(data == "200") 
					{
						alert("저장되었습니다.");
						location.replace("/index.php/ajax")
					} 
					else {
						alert("오류발생");
					}
			
                        
            }
            , error : function (request, status, error) {
                    console.log('error 발생 : ' + request + '   ' + status + '   ' + error);

            }

        }); //ajax end


} //writePopup end



//공백체크 및 데이터 넘기기 
function add_write(name, title, content, notice, upload_file) {

		var arr		= [name, title, content];
		var arr2	= ['이름', '제목', '내용'];

		for(i=0; i<=arr.length; i++)
		{
			if(arr[i] == '')
			{
				alert(arr2[i] + '을(를) 입력해주세요.');
				return false;
			}
		}

		let formData = new FormData();
		
		formData.append("name",         name);
		formData.append("title",        title);
		formData.append("content",      content);
		formData.append("notice",       notice);

		if(upload_file) {
			formData.append("upload_file",  upload_file);
		}

		writePopup(formData);


}



$(document).ready(function() {

	load_data();

    
});

	function load_data(search, page)
	{
			page = page? page : 0;

		$.ajax({
			url : "/index.php/boardAjax/home/ajaxList",
			type : "POST",
			data : { search : search, page : page},
			dataType : 'text',
	  		contentType : 'application/x-www-form-urlencoded; charset=euc-kr json',
			success :function(data) {
				var json = JSON.parse(data);
                                
				$("input[name=p]").attr("value", json.p);
				$("span#recordsTotal").text(json.total);
                //noticeData(json.notce_list);
				htmlData(json.list, json.page, json.total, json.rowsPage, json.notce_list);
			
				paging(json.current_block, json.current, json.total_block, json.prev, json.next, json.totalPage, json.page);
			}
			, error : function (request, status, error) {
					console.log('error 발생 : ' + request + '   ' + status + '   ' + error);

			}

		});

	}


	function htmlData(json, page, total, rowsPage, notice) {
		var index = total - (page - 1) * rowsPage;
		var row = '';


        for(var n in notice)
        {

             row = $("<tr/>").append(

                $("<td/>").html("<b>공지</b>"),
                $("<td/>").html("<a href ='/index.php/ajax/content/"+ notice[n].idx +"'>" + notice[n].title + notice[n].new + "</a>"),
                $("<td/>").text(notice[n].name),
                $("<td/>").text(notice[n].regdate),
                $("<td/>").text(notice[n].cnt)
            );
            $("#board_list").append(row);
        }


		for(var i in json)
		{

			 row = $("<tr/>").append(

				$("<td/>").text(index-i),
				$("<td/>").html("<a href ='/index.php/ajax/content/"+ json[i].idx +"'>" + json[i].title + json[i].new + "</a>"),
				$("<td/>").text(json[i].name),
				$("<td/>").text(json[i].regdate),
				$("<td/>").text(json[i].cnt)

			);

			$("#board_list").append(row);
		}


	}



	function paging(current_block, current, total_block, prev, next, totalPage, page) {


		 $("ul.pagination").html('');

           if (current_block > 2) {
				 $("ul.pagination").append("<li><a id='page-1' href='#'>◀</a></li>");
            }
            if (current_block > 1) {
				$("ul.pagination").append("<li><a id='" + prev + "' href='#'>◁</a></li>");
			}
            for(var i=1; i<=current.length; i++) {

                if (page == i) {
					$("ul.pagination").append("<li class='act'><a id='" + i + "' href='#'><span style='color:red;'>" + i + "</span></a></li>");
                } else {

					 $("ul.pagination").append("<li><a id='" + i + "' href='#'>" + i + "</a></li>");
                }
            }
            if (current_block < (total_block)) {
				$("ul.pagination").append("<li><a id='" + next + "' href='#'>▷</a></li>");
            }
            if (current_block < (total_block - 1)) {
				 $("ul.pagination").append("<li><a id='" + totalPage + "' href='#'>▶</a></li>");
            }


	}


	$(document).on('click', 'ul.pagination li > a', function() {
		var page = $(this).attr("id");
		test = $("input[name=p]").attr("value", page);

		 $('#searchBtn').click();
	});

	
	$('#searchBtn').click(function(e) {
		$("#board_list").html('');

	   let title 		= $("input[name=search_title]").val();	
	   let name 		= $("input[name=search_name]").val();	
	   let reg_start 	= $("input[name=search_reg_start]").val();	
	   let reg_end 		= $("input[name=search_reg_end]").val();	
	   let notice 		= $("input[type=radio]:checked").val();	
	   
	   let page			= $("input[name=p]").val();

		let search     		= new Object();

		search.title   		= title;
		search.name   		= name;
		search.reg_start   	= reg_start;
		search.reg_end   	= reg_end;
		search.notice   	= notice;

		load_data(search, page);

	});




</script>
