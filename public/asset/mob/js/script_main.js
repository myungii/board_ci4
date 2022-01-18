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
$(function() {
	$('.animate').scrolla({
		mobile: true, 
		once: false 
	});    
}); 

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


//패럴렉스

function castParallax() {
	
	window.addEventListener("scroll", function(event){

		var top = this.pageYOffset;

		var layers = document.getElementsByClassName("parallax");
		var layer, speed, yPos;
		for (var i = 0; i < layers.length; i++) {
			layer = layers[i];
			speed = layer.getAttribute('data-speed');
			var yPos = -(top * speed / 100);
			layer.setAttribute('style', 'transform: translate3d(0px, ' + yPos + 'px, 0px)');

		}
	});
}

castParallax();