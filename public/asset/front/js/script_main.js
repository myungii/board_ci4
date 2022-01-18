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


// 스크롤 애니메이션
$(function() {
	$('.animate').scrolla({
		mobile: true, 
		once: false 
	});    
}); 

// 픽스 버튼

$(window).on('scroll resize', function() {
    var scrollTop = 0;
    scrollTop = $(document).scrollTop();
    btn();
    function btn() {
        if (scrollTop > 180) { 
            $('.fix').addClass('on');
        }
		else {
            $('.fix').removeClass('on');
        }
    }
});