'use strict';


// 클립보드 복사
function copy(val) {
	var dummy = document.createElement("textarea");
	document.body.appendChild(dummy);
	dummy.value = val;
	dummy.select();
	document.execCommand("copy");
	document.body.removeChild(dummy);
	alert('복사 완료되었습니다.');
}

// 픽스 버튼
$(window).on('scroll resize', function() { // 스크롤시 , 윈도우 창크기 변경시 
    var scrollTop = 0;
    scrollTop = $(document).scrollTop();
    btn();
    function btn() {
        if (scrollTop > 650) { $('.fix').addClass('on');}
		else { $('.fix').removeClass('on');}
    }
});

// 스크롤 이동
$(function() {            
    $('.visualList .inner li').on('click', function() {
        var index = $('.visualList .inner li').index($(this)); 
        var top = $('section.b:eq(' + (index) + ')').offset().top;
        $('html, body').animate( { scrollTop : (top) }, 400 );  
    });
});  
