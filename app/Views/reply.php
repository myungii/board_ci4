<div class="comment-contents" style="width:1400px;">    
         <div id="comment-form">
               <input type="hidden" id="comment-pid" value="<?= $pid ?>">
              <div id="comment-count">댓글 <span id="count"><?= $total ?></span></div> 
              <input type="text" name="name" id="comment-name" placeholder="이름">
              <input id="comment-input" placeholder="댓글을 입력해 주세요."> 
              <button id="submit"  class="btn btn-lg btn-theme">등록</button> 
        </div> 
        
        <div id="comments-area"> <!--dap_lo -->
        <div id="comment-list">댓글목록</div>
		<?php foreach($reply as $list) { ?>
			<div class="comment-name"><b><?= $list->name ?></b></div>
			<span class="eachComment"><?= $list->content ?> </span> <!-- dap_to_comt_edit -->
			<div class="time"><?= $list->regdate ?></div> <!-- rep_me_dap_to -->
                  <div class="comment-menu"> <!-- rep_me rep_menu -->
                        <a class="comment-edit" href="#">수정</a> <!-- dat_edit_bt -->
                        <a class="comment-delete" href="#">삭제</a> <!-- dat_delete_bt -->
                  </div>
		<?php }	?>
	  </div>
  </div>


         <script src="/asset/reply/js/reply.js"></script> 
