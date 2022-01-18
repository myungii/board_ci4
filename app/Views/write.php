<!-- //subTitle -->
<div id="title-area">글쓰기 </div>
    <!-- Contents -->
    <div id="Contents" style="width:1400px; padding-left:20em;">

    <form id="write_form" enctype='multipart/form-data' method="post" action="/index.php/write/save">
    
        <table class="table table-bordered table-list">
            <colgroup>
                <col width="120px">
                <col width="1000px">
                <col width="120px">
                <col width="1000px">
            </colgroup>

            <tbody>
             
            <tr>
                <th>이름</th>
                <td>
                  <input type="text" name="name" id="name" style="width:980px;" value="" >
                </td>
            </tr>
            <tr>
                <th>제목</th>
                <td><input type="text" name="title" value="" id="title"  style="width:980px;"></td>
            </tr> 
            <tr>
                <th>공지여부</th>
                <td style="text-align:start;">
                  <label class="hmis">
                  <input type="radio" name="notice" value="Y" class="hmis validate" >
                  <span class="lbl">사용</span>
                  </label>
                  <label class="hmis">
                  <input type="radio" name="notice" value="N" class="hmis validate" checked>
                  <span class="lbl">미사용</span>
                  </label>
                </td>
            </tr> 
            <tr>
                <th>파일</th>
                <td><input type="file" name="upload_file" value="" id="upload_file"  style="width:980px;"></td>
            </tr> 

            </tbody>

        </table>  <br>

         <textarea id="summernote" name="editordata"></textarea>
               
         <div class="area-button">
            <button type="submit" name="save" class="btn btn-lg btn-theme" onclick="">저장</button>
            <button type="button" class="btn btn-gray btn-lg modal-close" onclick="location.href='/';">목록</button>
        </div>

    </form>
    </div>

</div>

<script type="text/javascript">

$(document).ready(function () {
    $('#summernote').summernote({
      height: 500,
      width: 1120,              
      minHeight: 500,            
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
    });
$("#write_form").on("submit" , function(e) { 
	//$(document).on("click", "button[name='save']" , function(e) { 
		
		e.preventDefault();	

        let name			    = $('input[name=name]').val();
        let title			    = $('input[name=title]').val();
        let upload_file		= $('input[name=upload_file]')[0].files[0];
        let content			  = $('#summernote').val();

        let arr				    = [name, title, content];
        let arr2			    = ['이름', '제목', '내용'];

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
		formData.append("content",      $('#summernote').val());
		formData.append("upload_file",  upload_file);
//formData.append("notice",       notice);
    
    $("input[name=notice]:checked").each(function() {
        formData.append("notice",    $(this).val());
    });

		$.ajax({
          url      : "/index.php/write/save",
    
		  data		        : formData,
      method          : "POST",
		  contentType     : false,
		  cache           : false,
		  processData     : false , 
      success : function(r) { 

        if(r == '200') { 
          alert("저장되었습니다.");
              location.replace('/');
              return true;
            } else {
              alert("오류발생.");
              return false;
            }
        }
        , complete : function()
        {
            
        }
      }); //ajax end


    }); //click end

  });



</script>
