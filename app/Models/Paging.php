<?php
namespace App\Models;

use CodeIgniter\Model;

class Paging extends Model {

    private static $db;

	function __construct($arr = 0) {


    }


    //총 페이지 개수
    function totalPage($num, $rowPage){
        return intval(($num-1)/$rowPage)+1;
    }

    //페이징
    function pageView($arr = array())
    {
        $url        = $arr['url'];
        $totalcnt   = $arr['total'];
        $rowsPage   = $arr['rowsPage'];
        $curPage    = $arr['curPage'];
        $link_url   = $arr['link_url'];
        //$qryChk     = $arr['qry'];

		$isAjax		= $arr['isAjax'];

        
        //페이지 파라미터 중복제거
        if($link_url != '')
        {
            $link_url = preg_replace('/[\&]?p=[0-9]+[\&]?/', '', $link_url);
            
        }

        $Info = $this->_pageList($totalcnt, $rowsPage, $curPage, 5);
        
		if($isAjax != 1) 
		{
			$result = array();
			if ($Info['current_block'] > 2) {
				array_push($result, "<li><a href='" . $url . "?p=1&" .  $link_url . "'>◀</a></li> ");
			}
			if ($Info['current_block'] > 1) {
				array_push($result, "<li><a href='" . $url . "?p=" . $Info['prev'] . "&" . $link_url . "'>◁</a></li> ");
			}
			foreach ($Info['current'] as $w) {
				
				if ($curPage == $w) {
					
					array_push($result, "<li class='act'><a href='" . $url . "?p=" . $w . "&" . $link_url  . "'><span style='color:red;'>" . $w . "</span></a></li> ");
					
				} else {
					array_push($result, "<li><a href='" . $url . "?p=" . $w . "&" . $link_url . "'>" . $w . "</a></li> ");
				}
			}
			if ($Info['current_block'] < ($Info['total_block'])) {
				array_push($result, "<li><a href='" . $url . "?p=" . $Info['next'] . "&" . $link_url . "'>▷</a></li> ");
			}
			if ($Info['current_block'] < ($Info['total_block'] - 1)) {
				array_push($result, "<li><a href='" . $url . "?p=" . $Info['totalPage'] . "&" . $link_url . "'>▶</a></li> ");
			}

			return $result;
	   } else {

			return $Info;
	   }

	}




    private function _pageList($totalcnt,$rowsPage,$curPage,$block_limit) {


        //현재 페이지
        $curPage = $curPage ? $curPage : 1;

        //페이지 당 게시글 개수
        $block_limit = $block_limit ? $block_limit : 10;

        //현재 블럭
        $current_block=ceil($curPage/$block_limit);

        //총 페이지
        $totalPage = ceil($totalcnt/$rowsPage);
        if($totalPage == 0) {
            ++$totalPage;
        }

        //전체 블록 개수
        $total_block = ceil($totalPage / $block_limit);

        //현재 블럭의 시작 페이지
        $fstPage            = (((ceil($curPage/$block_limit)-1)*$block_limit)+1);

        //현재 블럭의 마지막 페이지
        $endPage            = $fstPage + $block_limit -1;

        if($totalPage < $endPage) {
            $endPage        = $totalPage;
        }
        
        // 시작 바로 전 페이지
        $prev_page = $fstPage - 1;

        // 마지막 다음 페이지
        $next_page = $endPage + 1;

        

        foreach(range($fstPage, $endPage) as $val) {
            $row[] = $val;
        }

        return array(
            'total_block'   => $total_block,
            'current_block' => $current_block,
            'totalPage'     => $totalPage,
            'fstPage'       => $fstPage,
            'endPage'       => $endPage,
            'prev'          => $prev_page,
            'next'          => $next_page,
            'current'       => $row
        );

    } 















}
