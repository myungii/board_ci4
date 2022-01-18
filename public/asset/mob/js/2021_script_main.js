'use strict';

// url 이동
/*
go_url = function ( url) {
	var url ;
	window.open(url) ;
}
*/


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
/*$(function() {
	$('.animate').scrolla({
		mobile: true,
		once: false
	});
});*/

// 픽스 버튼
$(window).on('scroll resize', function() { // 스크롤시 , 윈도우 창크기 변경시
    var scrollTop = 0;
    scrollTop = $(document).scrollTop();
    btn();
    function btn() {
        if (scrollTop > 80) {
            $('.fix').addClass('on');
        }
		else {
            $('.fix').removeClass('on');
        }
    }
});


// 롤링배너
$(function() {
    $(".slide").slick({
        arrows: true,
		autoplay: true,
        autoplaySpeed: 800,
		slidesToShow: 3,
		slidesToScroll:1
    });
	$(".slide2").slick({
        arrows: true,
		autoplay: true,
        autoplaySpeed: 800,
		slidesToShow: 3,
		slidesToScroll:1
    });
});
