var eventObj = {
    validator : null
    ,pageForm : null
    ,popupForm : null
    ,inputName : null
    ,inputPhone : null
    ,etc_code1 : null
    ,etc_code2 : null
    ,etc_code3 : null
    ,etc_code4 : null
    ,agreebtn : null

    ,init : function () {
        this.validator = new FormValidator();
        this.popupForm = $('#applyPopupForm'); // popup form
        this.inputName = this.popupForm.find("input[name=name]");
        this.inputPhone = this.popupForm.find("input[name=phone]");
        this.agreebtn = this.popupForm.find("input[name=agmtYn]"); //취급방침

        this.pageForm = $('#applyForm'); // page form
        this.etc_code1 = $('[name=etc_code1]');
        this.etc_code2 = $('[name=etc_code2]');
        this.etc_code3 = $('[name=etc_code3]');
        this.etc_code4 = $('[name=etc_code4]');

        this.registEvent();
    }

    ,registEvent : function(){
        var _this = this;
        _this.keyUpEvent();

        $('#noData').on('change', function(e){
            if($(e.target).prop('checked')){
                _this.etc_code4.val('');
                _this.etc_code4.attr('readonly',true);
            } else {
                _this.etc_code4.attr('readonly',false);
            }
        })
    }

    ,openLayerPopup : function(target){
        var _this = this;

        if(_this.validCheckEtc()){
            _this.showPopup(target);
        } else {
            // alert('모든 계획을 입력해주세요.');
        }
    }

    ,keyUpEvent : function () {
        var _this = this;
        var delay = 100;
        var t = null;

        //이름 keyup
        /*$(_this.inputName).on('keyup', function (e) {
            clearTimeout(t);
            t = setTimeout(function () {
                if(!_this.validator.isOnlyKr($(e.target).val())){
                    alert("한글로 입력해주세요.");
                    $(e.target).val('');
                }
            }, delay)
        })*/

        $(_this.inputName).on('keyup', function (e) {
            if(!_this.validator.isOnlyText($(e.target).val())){
                $(e.target).val('');
            }
        })

        //연락처 keyup
        $(_this.inputPhone).on('keyup', function (e) {
            if(!_this.validator.isOnlyNum($(e.target).val())){
                $(e.target).val('');
            }
        })
    }

    ,reset : function () {
        var _this = this;
        $(_this.popupForm)[0].reset();
        $(_this.pageForm)[0].reset();
        _this.etc_code4.attr('readonly',false);
    }

    // ----------------------- 팝업 관련 -----------------------
    ,showPopup : function(selector){
        $(selector).before('<div id="layer-mask"></div>').fadeIn(150);
        $('body').addClass('on');
    }

    ,hidePopup : function (selector) {
        var _this = this;
        $('#layer-mask').remove();
        $(selector).css({'display': 'none'});
        $('body').removeClass('on');
        if(selector==='#pop_2') _this.reset();

    }

    // ----------------------- 폼 관련 -----------------------
    ,onSubmit : function () {
        var _this = this;

        gtag('event', 'popCard_campaign', {
            'event_category' : 'marketing_event',
            'event_label' : 'Privacy_complete'
        });

        if(_this.validCheck()){
            var _data = _this.popupForm.serialize()+'&'+_this.pageForm.serialize();

            $.ajax({
                type: 'POST',
                url: '/front/dreamok/applyPopCard',
                data: _data,
                success: function(data) {
                    var obj = $.parseJSON(data);
                    if (obj.is_valid == "1") {
                        alert("이미 응모하셨습니다");
                        _this.hidePopup('#pop_1');
                        // _this.reset();
                    } else {
                        // openLayerPopup('#pop_2');
                        gtag('event', 'popCard_campaign', {
                            'event_category' : 'marketing_event',
                            'event_label' : 'application_complete'
                        });
                        _this.hidePopup('#pop_1');
                        _this.reset();
                        _this.showPopup('#pop_2');
                    }
                }
            });
        }
    }

    // ----------------------- sns 공유 관련 -----------------------
    ,shareResult : function ( type ) {
		alert(type);
        var snsTitle = '사람인 직장 문화 개선 프로젝트';
        var snsUrl = "http://saramin-event.co.kr/happyWorkLife_event";
        var snsImageKakao = snsUrl;

        if(type === "f"){
            gtag('event', 'popCard_campaign', {
                'event_category' : 'marketing_event',
                'event_label' : 'facebook_share'
            });
            this.shareFaceBook(snsTitle, snsUrl);
        }else if(type === "k"){
            gtag('event', 'popCard_campaign', {
                'event_category' : 'marketing_event',
                'event_label' : 'kakao_share'
            });
            this.shareKakaoTalk(snsTitle, '', snsUrl);
        }else if(type === "u"){
            gtag('event', 'popCard_campaign', {
                'event_category' : 'marketing_event',
                'event_label' : 'link_share'
            });
            this.shareUrl(snsUrl);
        }

    }

    ,shareFaceBook : function (title, shareUrl) {
        var url = encodeURIComponent(shareUrl+"?utm_source=facebook&utm_medium=share&utm_campaign=event&utm_term=popcard_campaign");
        var href = "http://www.facebook.com/sharer.php?u="+ url;
        var a = window.open(href, "facebook", "width=800, height=500");
        if( a ) {
            a.focus();
        }
    }

    ,shareKakaoTalk : function (title, imgUrl, shareUrl) {
        var shareUrl = shareUrl+"?utm_source=kakao&utm_medium=share&utm_campaign=event&utm_term=popcard_campaign";
        Kakao.Link.sendDefault({
            objectType: 'feed',
            content: {
                title: title,
                description : "사람인 '즐겁다Card라'로  즐거운 순간을 기록하세요.",
                imageUrl: 'http://saramin-event.co.kr/assetsin/front/img/october/sns_thumb_kakao.png',
                link: {
                    mobileWebUrl: shareUrl,
                    webUrl: shareUrl,
                },
            },
            buttonTitle : '자세히보기'
        });
    }

    ,shareUrl : function (shareUrl) {
        var agent = navigator.userAgent.toLocaleLowerCase();
        var isIOS = /iphone|ipad/.test(agent);
        var copyEl = document.getElementById("snsCopy");
        var shareUrl = shareUrl+"?utm_source=link&utm_medium=share&utm_campaign=event&utm_term=popcard_campaign";
        $(copyEl).val(shareUrl);

        // 링크복사 시 화면 크기 고정
        $('html').find('meta[name=viewport]').attr('content', 'width=device-width,initial-scale=1.0,minimum-scale=0,maximum-scale=1.0');

        if(isIOS){
            var editable = copyEl.contentEditable;
            var readOnly = copyEl.readOnly;
            copyEl.contentEditable = true;
            copyEl.readOnly = false;
            var range = document.createRange();
            range.selectNodeContents(copyEl);
            var selection = window.getSelection();
            selection.removeAllRanges();
            selection.addRange(range);
            copyEl.setSelectionRange(0, 999999);
            copyEl.contentEditable = editable;
            copyEl.readOnly = readOnly;
        } else {
            copyEl.select();
        }

        try {
            var successful = document.execCommand('copy');
            copyEl.blur();
            if (successful) {
                alert("URL이 복사 되었습니다.");
                $('html').find('meta[name=viewport]').attr('content', 'width=device-width,initial-scale=1.0,minimum-scale=0,maximum-scale=1.0');
            } else {
                alert('이 브라우저는 지원하지 않습니다.');
            }
        } catch (err) {
            alert('이 브라우저는 지원하지 않습니다.');
        }

    }
}

$(function () {
    eventObj.init();
})