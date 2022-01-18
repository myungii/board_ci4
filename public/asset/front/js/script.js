
$(document).on('click', 'a[href="#"]', function(e){
    e.preventDefault();
});

// visual & UI 모션
$(function() {
    $(".con.a .imgBox ul").slick({
        slidesToShow: 2,
		slidesToScroll: 1,
        arrows: false,
        dots: false,
        autoplay: true,
        autoplaySpeed: 1900,
        pauseOnHover:false,
		pauseOnFocus:false,
        vertical: true
    });    
    $(".con.b .imgBox > div").slick({
        arrows: false,
        dots: false,
        autoplay: true,
        fade:true,
        autoplaySpeed: 2000,
        pauseOnHover:false,
		pauseOnFocus:false
    }); 
    $(".con.c .imgBox > div").slick({
        arrows: false,
        dots: false,
        autoplay: true,
        fade:true,
        autoplaySpeed: 2000,
        pauseOnHover:false,
		pauseOnFocus:false
    }); 
});


// UI 모션
$(function() {
    var numSlide = $('.con.b .imgBox ul li').length;
    var slideNow = 0;
    var slidePrev = 0;
    var slideNext = 0;
    var timerId = null;
    var isTimerOn = true;
    var timerSpeed = 2500;

    showSlide(1);

    function showSlide(n) {
        clearTimeout(timerId);
        $('.con.b .imgBox ul li').removeClass('on');
        $('.con.b .imgBox ul li:eq(' + (n - 1) + ')').addClass('on');
        slideNow = n;
        slidePrev = (n - 1) < 1 ? numSlide : n - 1;
        slideNext = (n + 1) > numSlide ? 1 : n + 1;
        if (isTimerOn === true) {
            timerId = setTimeout(function() {showSlide(slideNext);}, timerSpeed);
        }
    }

});

$(function() {
    var numSlide = $('.con.c .imgBox ul li').length;
    var slideNow = 0;
    var slidePrev = 0;
    var slideNext = 0;
    var timerId = null;
    var isTimerOn = true;
    var timerSpeed = 2500;

    showSlide2(1);

    function showSlide2(n) {
        clearTimeout(timerId);
        $('.con.c .imgBox ul li').removeClass('on');
        $('.con.c .imgBox ul li:eq(' + (n - 1) + ')').addClass('on');
        slideNow = n;
        slidePrev = (n - 1) < 1 ? numSlide : n - 1;
        slideNext = (n + 1) > numSlide ? 1 : n + 1;
        if (isTimerOn === true) {
            timerId = setTimeout(function() {showSlide2(slideNext);}, timerSpeed);
        }
    }

});

//  이벤트부분
$(function() {            
    $('.con.e .open').on('click', function() {
        $('.con.e p').slideToggle(250);
    });
    $('.con.f .open').on('click', function() {
        $(this).toggleClass('on');
        $('.con.f p').slideToggle(200);
    });

});
// fix
$(window).on('scroll resize', function() { 
    var scrollTop = 0;
    scrollTop = $(document).scrollTop();
    btn();
    function btn() {
        if (scrollTop > 650) { $('.fix').addClass('on');}
		else { $('.fix').removeClass('on');}
    }
});


//scroll
$(function() {
    $('.quikMenu li:eq(0), .gnb li:eq(0)').on('click', function() {
        var event2 = $('.con.a').offset().top;
        $('html, body').animate( { scrollTop : (event2) }, 400 );
    });
    $('.quikMenu li:eq(1), .gnb li:eq(1)').on('click', function() {
        var event1 = $('.con.e').offset().top;
        $('html, body').animate( { scrollTop : (event1) }, 400 );
    });
	$('.quikMenu li:eq(2), .gnb li:eq(2)').on('click', function() {
        var event1 = $('.con.g').offset().top;
        $('html, body').animate( { scrollTop : (event1) }, 400 );
    });
	$('.fix').on('click', function() {
        $('html, body').animate( { scrollTop : (0) }, 300 );
    });
});

	//faq
$(function() {   
	$(".faq_area .faq_q").click(function(){
		if($(this).closest("li").hasClass("on")){
			$(".faq_list > li").removeClass("on");
			$(".faq_a").hide();
		}else{
			$(".faq_a").hide();
			$(this).closest("li").addClass("on").siblings("li").removeClass("on");
			$(this).closest("li").find(".faq_a").show();
			$("html,body").animate({scrollTop: $(this).closest(".faq_q").offset().top - 200},300);
		}
	});

}); 