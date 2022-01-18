'use strict';

$(document).on('click', 'a[href="#"]', function(e){
    e.preventDefault();
});

// 클립보드 
function copy(val) {
	var dummy = document.createElement("textarea");
	document.body.appendChild(dummy);
	dummy.value = val;
	dummy.select();
	document.execCommand("copy");
	document.body.removeChild(dummy);
	alert('복사 완료되었습니다.');
}

// 팝업
function openLayerPopup(selector) {
	$(selector).before('<div id="layer-mask"></div>').fadeIn(150);
    $(selector).find('.close').one('click', function() {
		$('#layer-mask').remove();
		$(selector).css({'display': 'none'});
    });
}

//스크롤 
$(function() {            
    $('.scroll').on('click', function() {
       // var index = $('.visual .list li a:eq(4)').index($(this)); 
        var top = $('section:eq(5)').offset().top;
        $('html, body').animate( { scrollTop : (top) }, 400 );  
    });
});  

//상단이동
$(function() { 
	$( '.goTop' ).click( function() {
		$( 'html, body' ).animate( { scrollTop : 0 }, 300 );
		return false;
	});
});

var scrollTop = 0;
scrollTop = $(document).scrollTop();

$(window).on('scroll resize', function() {
    scrollTop = $(document).scrollTop();
    fixHeader();
});

function fixHeader() {
    if (scrollTop > 180) {   $('.goTop').addClass('on');  } 
	else {  $('.goTop').removeClass('on'); }
}