const pid       = $("#comment-pid").val();
const rid       = $("#reply-id").val();
const inputBar  = document.querySelector("#comment-input"); 
const inputName = document.querySelector("#comment-name"); 
const rootDiv   = document.querySelector("#comments"); 
const btn       = document.querySelector("#submit"); 
const editBtn   = document.querySelector("#comment-edit"); 
const mainCommentCount = document.querySelector('#count'); 


function showComment(currentVal, nameVal, pid) {

       var dataObj          = new Object();
       dataObj['pid']       = pid;
       dataObj['name']      = nameVal;
       dataObj['content']   = currentVal;
       dataObj              = JSON.stringify(dataObj);

        
    $.ajax({
        url      : "/index.php/reply/save",
        data		    : { dataObj : dataObj },
        method          : "post",
        cache           : false,
        
        success : function(data) { 

        if(data == '200') { 
            alert("등록되었습니다.");
                location.replace('/index.php/content?id='+pid);

                return true;

            } else {
                alert("오류발생.");
            
                return false;
            }
        },
        error : function( jqxhr , status , error ){
            console.log( jqxhr , status , error );
        }
  
    }); //ajax end

    
}
    
    //저장버튼
    function pressBtn()
    { 

        const currentVal = inputBar.value; 
        const nameVal  = inputName.value;

        if(!nameVal.length)
        {
            alert("이름을 입력해주세요!!");
        }
        else if(!currentVal.length)
        { 
            alert("댓글을 입력해주세요!!");

         }else{ 
             showComment(currentVal, nameVal, pid); 
             mainCommentCount.innerHTML++; 
             inputBar.value =''; 
        } 
    } 
 

    //수정버튼
	
    $(".comment-edit").each(function(i) {
		
		$(this).click(function(e) {

        if($('#editSubmit').css("display") == "none")
        {
            $('#submit').css("display", "none");
            $("#editSubmit").show();
        } 
        

        //const replyId       = document.querySelector("#reply-id"); 
        const replyId       = $(this).attr('id'); 
        
        const name      = document.getElementById('reply-name-'+replyId).innerText;
        const content   =  document.getElementById('reply-content-'+replyId).innerHTML;


        $("input[name=comment-name]").attr('value', name);
        $("input[name=comment-input]").attr('value', content);
	

            $("#editSubmit").on("click", function() {

                const name_form     = $("input[name=comment-name]").val();
                const comment_form  = $("input[name=comment-input]").val();

                        if(name_form == "")
                        {
                            alert("이름을 입력해주세요");
                        }

                        else if(comment_form == "")
                        {
                            alert("댓글을 입력해주세요");
                        }

                        else {

                            $.ajax({
                                url             : "/index.php/reply/modify",
                                data		    : {
                                                    replyId     : replyId,
                                                    name        : name_form,
                                                    content     : comment_form
                                                },
                                method          : "GET",
                                success : function(r) { 
                                        const obj = $.parseJSON(r);

                                        if(obj.is_valid == '1'){
                                            alert("수정되었습니다.");
                                            $("#editSubmit").hide();
                                            $("#submit").show();
                                            location.replace('/index.php/content?id='+ pid);

                                        } else {
                                            alert("오류발생.");
                                            $("#editSubmit").hide();
                                            $("#submit").show();
                                        }

                                }
                                , error : function( jqxhr , status , error ){
                                        console.log( jqxhr , status , error );
                                }
                    
                            }); //ajax end

                        } //else end

                });
		});
           
    });


    //삭제버튼
    $(".comment-delete").each(function(i) {
		
		$(this).click(function(e) {

			e.preventDefault();

//			const replyId   = document.querySelector("#reply-id");    
			const replyId   = $(this).attr('id');
			
			$.ajax({
				url             : "/index.php/reply/delete",
				data		    : {replyId : replyId},
				method          : "GET",
				success : function(r) { 
					const obj = $.parseJSON(r);
					console.log('obj : ' + obj.is_valid);

					if(obj.is_valid == "1") { 
						alert("삭제되었습니다.");
						location.replace('/index.php/content?id='+ pid);
						
					} else {
						alert("오류발생.");
						
					}
				}, error : function( jqxhr , status , error ){
					console.log( jqxhr , status , error );
				}
	  
			}); //ajax end
		});
        
    });


    btn.onclick = pressBtn;
