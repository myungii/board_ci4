<!-- //subTitle -->
<div id="title-area">HTML </div>
<!-- Contents -->
<div id="Contents" style="width:1400px; padding-left:20em;">

    <!-- list -->
    <form id="frmAdjehyuList" onsubmit="return false">
        <table class="table table-bordered table-list table-striped">
            <colgroup>
                <col width="120px">
                <col>
                <col width="120px">
                <col>
                <col width="120px">
            </colgroup>
            <tbody>
            <tr>
                <th>제목</th>
                <td class="textAlign" id="dtitle" colspan="3"><?= $content->title ?></td>
            </tr>
            <tr>
                <th>이름</th>
                <td class="textAlign" id="dname"><?= $content->name ?></td>
                <th>등록일</th>
                <td class="textAlign" ><?= Board_model::setRegdate($content->regdate) ?></td>
            </tr>
            <tr>
                <th>조회수</th>
                <td class="textAlign" colspan="3"><?= $content->cnt ?></td>
            </tr>
            
            <tr>
                <th>파일</th>
                <td class="textAlign" colspan="3">
                    <a id="dfile" href="/uploads/<?= $file_name ?>" download>
                        <?= $file_name ?>
                    </a> 
                </td>
            </tr>
      
            <tr>
                <td class="textAlign" colspan="4" style="vertical-align: text-top;height:150px;line-height:15px;padding:10 10 10 10;word-wrap:break-word;word-break:break-all">
                    <?= $content->content ?>
                </td>
            </tr>

            </tbody>

        </table>
        
        <div class="area-button">
            <button type="button" class="btn btn-gray btn-lg modal-close" onclick="location.href='/ajax';">목록</button>
            <button type="button" class="btn btn-lg btn-theme" onclick="dialog.dialog( 'open' );">수정</button>
            <button type="button" class="btn btn-lg" onclick="location.replace('/index.php/boardAjax/delete?id=<?=$content->idx?>')">삭제</button>
        </div>

    </form>


    <!-- 댓글 -->
    <div class="comment-contents" style="width:1400px;">    
         <div id="comment-form">
               <input type="hidden" id="comment-pid" value="<?= $pid ?>">
              <div id="comment-count">댓글 <span id="count"><?= $total ?></span></div> 
              <input type="text" name="comment-name" id="comment-name" placeholder="이름">
              <input  name="comment-input"id="comment-input" placeholder="댓글을 입력해 주세요."> 
              <button id="submit"  class="btn btn-lg btn-theme">등록</button> 
              <button id="editSubmit"  class="btn btn-lg btn-theme" style="display:none;">수정</button> 
        </div> 
        
        <div id="comments-area"> <!--dap_lo -->
        <div id="comment-list">댓글목록</div>
		<?php foreach($reply as $list) { ?>
            <input type="hidden" id="reply-id" value="<?= $list->idx ?>">
			<div class="comment-name" id="reply-name-<?= $list->idx ?>"><b><?= $list->name ?></b></div>
			<span class="eachComment" id="reply-content-<?= $list->idx ?>"><?= $list->content ?> </span> <!-- dap_to_comt_edit -->
			<div class="time" id="reply-date"><?= $list->regdate ?></div> <!-- rep_me_dap_to -->
                  <div class="comment-menu"> <!-- rep_me rep_menu -->
                        <a class="comment-edit" id="<?= $list->idx ?>" href="#">수정 </a> <!-- dat_edit_bt -->
                        <a class="comment-delete" id="<?= $list->idx ?>" href="#">삭제</a> <!-- dat_delete_bt -->
                  </div>
		<?php }	?>
	  </div>
  </div>

         <script src="/asset/reply/js/reply.js"></script> 

</div>

<!-- 수정 팝업 -->
<div id="dialog-form" title="글쓰기">

	<form>
		<input type="hidden" name="widx" value="<?= $content->idx ?>">
		<div class="form-group">
			<label for="wname" style="display:inline-block">이름</label>
			 <div class="col-sm-10">
				<input type="text" class="form-control" id="wname" name="wname" value="<?= $content->title ?>"  aria-describedby="emailHelp" placeholder="이름을 입력하세요.">
			 </div>
			 <div class="valid_notice" style="color:red"> </div>
		</div>
		<div class="form-group">
			<label for="wtitle" style="display:inline-block">제목</label>
			<input type="text" class="form-control" id="wtitle" name="wtitle" value="<?= $content->name ?>" placeholder="제목을 입력하세요.">
		</div>
		<div class="form-check">
			<label style="display:block">공지여부</label>
			<input class="form-check-input" type="radio" name="wnotice" id="wnotice_N" value="N"  <?php if($content->notice == 0) echo "checked" ?> >
			<label class="form-check-label" style="display:inline-block" for="wnotice_N">
				미사용
			</label>
			<input class="form-check-input" type="radio" name="wnotice" id="wnotice_Y" value="Y"  <?php if($content->notice == 1) echo "checked" ?> >
			<label class="form-check-label" style="display:inline-block" for="wnotice_Y">
				사용
			</label>
		</div>
		<br>
		<div class="form-group">
			<label for="wupload_file" style="display:inline-block">파일첨부</label>
			<input type="file" class="form-control-file" name="wupload_file" value="<?= $file_name ?>"  id="wupload_file">
			<input type="hidden" name="wfile_idx" value="<?= $file_idx ?>"  id="wfile_idx">
		</div>
		<div class="form-group">
			<textarea class="form-control" id="summernote" name="editoerdata" rows="3"><?= $content->content ?></textarea>
		</div>
	</form>

</div>


<!-- Contents -->

<script type="text/javascript">

$(function() {
	$(".textAlign").css("text-align", "left");



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

							var idx			    = $("input[name=widx]").val();
							var name			= $("input[name=wname]").val();
							var title			= $("input[name=wtitle]").val();
							var upload_file		= $("input[name=wupload_file]")[0].files[0];
							var content			= $("#summernote").val();
							var old_file		= $("input[name=wfile_idx]").val();

						$("input[name=wnotice]:checked").each(function() {
							var notice = $(this).val();

							edit_write(idx, name, title, content, notice, upload_file, old_file)

						});
			},

            Cancel: function() {
            dialog.dialog( "close" );
            }
        },
        close: function() {

        }
});//dialog end




function editPopup(formData, idx) {
	
console.log("writePopup : " + formData);

        $.ajax({
            url : "/index.php/boardAjax/write/editPopup",
            method : "POST",
			data : formData,
			dataType : "text",
			//contentType : 'application/x-www-form-urlencoded; charset=euc-kr json',
			contentType :false,
			processData: false,
            success :function(data) {

                console.log('성공 : ' + data);

					if(data != '') 
					{
						alert("저장되었습니다.");
						location.replace("/index.php/ajax/content/" + idx)
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
function edit_write(idx, name, title, content, notice, upload_file, old_file) {

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
		
		formData.append("idx",          idx);
		formData.append("name",         name);
		formData.append("title",        title);
		formData.append("content",      content);
		formData.append("notice",       notice);
		formData.append("old_file",     old_file);

		if(upload_file) {
			formData.append("upload_file",  upload_file);
		}

		editPopup(formData, idx);


}


</script>
