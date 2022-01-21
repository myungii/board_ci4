<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="user-scalable=yes, maximum-scale=1.0, minimum-scale=0.2, width=1400"> 
    <title></title>
    <!--link rel="icon" href="/favicon.ico" sizes="72x72"-->
        <!--css-->
        <script src="/asset/adminsin/js/jquery-1.11.1.min.js"></script>
    <script src="/asset/adminsin/js/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>

    <link rel="stylesheet" type="text/css" href="/asset/adminsin/css/main.css">
    <link href="/asset/adminsin/css/style.min.css" rel="stylesheet" media="screen">
    <link href="/asset/adminsin/css/layout2.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" href="/asset/adminsin/js/jquery-ui-1.12.1.custom/jquery-ui.min.css">
    <link rel="stylesheet" type="text/css" href="/asset/adminsin/css/validationEngine.jquery.css" />
    <link rel="stylesheet" type="text/css" href="/asset/adminsin/css/default.css" />
    <link rel="stylesheet" type="text/css" href="/asset/adminsin/css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="/asset/popup/css/popup.css" />
    <link href="/asset/adminsin/css/dataTables.bootstrap.min.css" rel="stylesheet" media="screen">
    <script src="/asset/adminsin/js/jquery.validationEngine-kr.js"></script>
    <script src="/asset/adminsin/js/jquery.validationEngine.js"></script>

    <script src="/asset/adminsin/js/jquery.form.js"></script>
    <script src="/asset/adminsin/js/common.js"></script>
    
    <!-- write editor -->
    <script src="/asset/summernote/summernote-lite.js"></script>
    <link rel="stylesheet" href="/asset/summernote/summernote-lite.css">

	<!-- reply -->
    <link rel="stylesheet" type="text/css" media="screen" href="/asset/reply/css/reply.css">
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

   <style>
       #form-commentInfo {
                          padding-left : 20em;
   				         }
       #comments {
     	                  padding-left : 20em;
      }



   </style>


</head>
<body>
    <div class="wrap" id="wrap">
        <header>
            <div class="inner">
<!--                <h1 class="logo"><a href="#"><img src="/assetsin/adminsin/images/logo_white.png" alt=""></a></h1>-->
                <nav class="gnb">
                    <ul>
                        <li class="selected"><a href="/">공지사항
                        </a></li>
                    </ul>
                </nav>
                <ul class="user">
                    <li class="team">&nbsp; 님 환영합니다.</li>
					<li class="logout"><a href="/admin/login/logout" style="display: inline-block; width: 100%; height: 100%;"><i class="fa fa-power-off" aria-hidden="true"></i></a></li>
                </ul>
            </div>
            
        </header>
		
    <?= $this->renderSection('content') ?>

        <section class="sideBar">

     <?= $this->include('layouts/left3') ?>

			<div class="btnmain">
          
                <button class="f" onclick="window.open('')" >공지사항1</button>
                <button class="f" onclick="window.open('')" >공지사항1</button>    
                <button class="f" onclick="window.open('')" >공지사항1</button>
            

			</div>
        </section>
    </div>

</body>
</html>

<script type="text/javascript">
//<!--
go_url2 = function ( url) {			
		var url ;			
		location.href= url ;
}	
//-->
</script>



<script>
//사이드바 높이
$(function() { 

  var wrap = $('.layout-east');
  var sideBar = $('.sideBar');
 
  var wrap_height = $('.layout-east').outerHeight(true);
  var sideBar_height = $('.sideBar').outerHeight(true);

  if(wrap_height > sideBar_height) { 
	  $('.sideBar').css({'height':wrap_height + 'px'}); 
	 }



});	
</script>
