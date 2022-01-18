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
                <td class="textAlign" colspan="3"><?= $content->title ?></td>
            </tr>
            <tr>
                <th>이름</th>
                <td class="textAlign"><?= $content->name ?></td>
                <th>등록일</th>
                <td class="textAlign"><?= Board_model::setRegdate($content->regdate) ?></td>
            </tr>
            <tr>
                <th>조회수</th>
                <td class="textAlign" colspan="3"><?= $content->cnt ?></td>
            </tr>
            
            <tr>
                <th>파일</th>
                <td class="textAlign" colspan="3">
                    <a href="/uploads/<?= $file_name ?>" download>
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
            <button type="button" class="btn btn-gray btn-lg modal-close" onclick="location.href='/';">목록</button>
            <button type="button" class="btn btn-lg btn-theme" onclick="location.replace('/index.php/edit/?id=<?=$content->idx?>')">수정</button>
            <button type="button" class="btn btn-lg" onclick="location.replace('/index.php/delete?id=<?=$content->idx?>')">삭제</button>
        </div>

    </form>

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

<!-- Contents -->

<script type="text/javascript">
	$(function() {
		$(".textAlign").css("text-align", "left");

	});

</script>
