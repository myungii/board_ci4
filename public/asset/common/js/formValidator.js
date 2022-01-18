/**
 * Created by kej.
 * Date: 2020-08-05
 * Time: 오후 12:03
 */

var FormValidator = function () {
    this.onlyNumAndEnRegex = /[^\._A-Za-z0-9]{1,}/g;
    this.onlyNumAndKrRegex = /[^0-9가-힣ㄱ-ㅎㅏ-ㅣ\x20]{1,}/g;
    this.onlyKrRegex = /([^가-힣ㄱ-ㅎㅏ-ㅣ\x20])/ig;
    this.onlyNotKrRegex = /([가-힣ㄱ-ㅎㅏ-ㅣ])/ig;
    this.onlyNumRegex = /[^\d]/g;
    this.onlyTextRegex = /[\d]/g;

    this.nullCheck = function (el,msg) {
        var msg = msg || null;
        if( el.val() == "" ){
            if(msg!==null) alert(msg);
            el.focus();
            return false;
        }
        return true;
    }

    this.isChecked = function(el, msg){
        var msg = msg || null;
        if( !el.is(":checked") ){
            if(msg!==null) alert(msg);
            el.focus();
            return false;
        }
        return true;
    }

    this.lenCheck = function(el,len,msg) {
        var msg = msg || null;
        if( el.val().length <= len ){
            if(msg!==null) alert(msg);
            el.focus();
            return false;
        }
        return true;
    }

    this.lenCheckByValue = function(val,len,msg) {
        var msg = msg || null;
        if( val.length <= len ){
            if(msg!==null) alert(msg);
            return false;
        }
        return true;
    }

    this.isEmail = function (value,msg) {
        var msg = msg || null;
        var format = /^[A-Za-z0-9_\.\-]+@[-_A-Za-z0-9\-]+\.[A-Za-z0-9\-]+/;
        if (value.search(format) != -1) {
            return true;
        }
        if(msg!==null) alert(msg);
        return false;
    }

    this.isPhoneNumber = function (value,msg) {
        var msg = msg || null;
        var format = /^(01[016789]{1}|02|0[3-9]{1}[0-9]{1})-?[0-9]{3,4}-?[0-9]{4}$/;
        if (value.search(format) != -1) {
            return true;
        }
        if(msg!==null) alert(msg);
        return false;
    }

    this.isMobileNumber = function (value,msg) {
        var msg = msg || null;
        var format = /^01[016789]-\d{3,4}-\d{4}$/g;
        if (value.search(format) != -1) {
            return true;
        }
        if(msg!==null) alert(msg);
        return false;
    }

    /**
     * 임의의 정규식으로 유효성 검사
     * @param el
     * @param regExp : 체크할 정규식
     * @param msg
     * @returns {boolean}
     */
    this.regExpTest = function (el,regExp,msg) {
        var msg = msg || null;
        if( !regExp.test( el.val() ) ){
            if(msg!==null) alert(msg);
            el.focus();
            return false;
        }
        return true;
    }

    /**
     * ajaxSubmit beforeSubmit 에서 파일 체크
     * @param data
     * @returns {boolean}
     */
     this.checkFile = function ( data ) {
        // ;, %00, %zz -> .txt.asp, .asp%00.jpg

        var _data = data;
        var regExp = /\.(xls|xlsx|docx|pptx|txt|png|zip|jpeg|jpg|pdf)$/i;
        var fileNum = 0; //폼데이터에 있는 파일 확장자 input의 개수.
        var validFileNum = 0; //유효성 검사 통과한 파일의 개수

        _data.forEach(function (el) {
            if( el.type == "file" && el.value != '' ){
                fileNum++;
                if( regExp.test(el.value.name) ) validFileNum++;
            }
        });

         return fileNum === 0 || fileNum === validFileNum;
    }

    /**
     * 문자열에 한글문자가 하나라도 있는지 검사
     * @param value
     * @param msg
     * @returns {boolean}
     */
    this.isInKr = function ( value,msg ) {
        var msg = msg || null;
        for ( var nindex = 0; nindex < value.length; nindex++) {
            var str2 = value.charAt(nindex);
            if (( str2 >= 'ㄱ' && str2 <= '힣' )){
                return true;
            }
        }
        if(msg!==null) alert(msg);
        return false;
    }

    /**
     * 정규식으로 문자열이 영문 대소 문자와 숫자로만 구성되었는지 패턴검사
     * @param value
     * @param msg
     * @returns {boolean} : 영문, 숫자만 있는 경우 true
     */
    this.isOnlyNumAndEn = function (value,msg) {
        var msg = msg || null;
        var kor_check = this.onlyNumAndEnRegex;
        if (kor_check.test(value)) {
            if(msg!==null) alert(msg);
            return false;
        }
        return true;
    }

    /**
     * 정규식으로 문자열이 한글과 숫자로만 구성되었는지 패턴검사
     * @param value
     * @param msg
     * @returns {boolean} : 한글, 숫자만 있는 경우 true
     */
    this.isOnlyNumAndKr = function (value,msg) {
        var msg = msg || null;
        var kor_check = this.onlyNumAndKrRegex;
        if (kor_check.test(value)) {
            if(msg!==null) alert(msg);
            return false;
        }
        return true;
    }

    /**
     * 정규식으로 문자열이 한글로만 구성되었는지 패턴검사
     * @param value
     * @param msg
     * @returns {boolean} : 한글, 공백만 있는 경우 true
     */
    this.isOnlyKr = function (value,msg) {
        var msg = msg || null;
        var _this = this;
        var kor_check = _this.onlyKrRegex;
        if (kor_check.test(value)) {
            if(msg!==null) alert(msg);
            return false;
        }
        return true;
    }

    /**
     * 정규식으로 문자열이 한글을 제외한 글자로만 구성되었는지 패턴검사
     * @param value
     * @param msg
     * @returns {boolean} : 한글, 공백만 있는 경우 false
     */
    this.isOnlyNotKr = function (value,msg) {
        var msg = msg || null;
        var kor_check = this.onlyNotKrRegex;
        if (kor_check.test(value)) {
            if(msg!==null) alert(msg);
            return false;
        }
        return true;
    }

    /**
     * 정규식으로 문자열이 숫자로만 구성되었는지 패턴검사
     * @param value
     * @param msg
     * @returns {boolean} : 숫자만 존재할 경우 true
     */
    this.isOnlyNum = function (value,msg) {
        var msg = msg || null;
        var num_check = this.onlyNumRegex;
        if (num_check.test(value)) {
            if(msg!==null) alert(msg);
            return false;
        }
        return true;
    }

    /**
     * 정규식으로 문자로만 구성되었는지 패턴검사
     * @param value
     * @param msg
     * @returns {boolean} : 문자만 존재할 경우 true
     */
    this.isOnlyText = function (value,msg) {
        var msg = msg || null;
        var text_check = this.onlyTextRegex;
        if (text_check.test(value)) {
            if(msg!==null) alert(msg);
            return false;
        }
        return true;
    }

}