<?= $this->extend('layouts/default') ?>

<?= $this->section('content') ?>

<head>
    <style>
        #noticeList {
            font-weight : bold;
        }
        #new {
            color : red;
        }
 
    </style>
</head>

<!-- //subTitle -->
<div id="title-area">HTML </div>
<!-- Contents -->
<div id="Contents" style="width:1400px; padding-left:20em;">
    <!-- filter -->
    <form id="FrmAttendanceSearch" method="get" action="/board" >
    <input type="hidden" name="p" value="<?= $curPage ?>">
    <table class="table table-bordered table-form pad">
        <colgroup>
            <col width="120px">
            <col>
    
        </colgroup>
        <tbody>
            <tr>
                <th>제목</th>
                <td>
                    <input type="text" name="filter_name" class="form-control input-xsm"  style="width:1022px;"  value="<?= $searchText ?>" autocomplete="off">
                </td>
            </tr>

        </tbody>
    </table>

    <div class="area-button">
        <button type="submit" class="btn btn-lg btn-theme" onclick="">검색</button>
    </div>
    </form>
    
        <!-- btn, total -->
        <h3 class="area-title">
        Total :
        <span class="f-bold"><strong><span id="recordsTotal"><?= $total ?></span></strong>건</span>
        <div class="button-box">
            <button class="btn btn-flat-blue" onclick="location.replace('<?= route_to('write'); ?>');" style="float: left;">게시물 등록</button>
        </div>
    </h3>
    
    <!-- list -->
    
        <table class="table table-bordered table-list table-striped table-hover table-adjehyu" id="adjehyuList">
            <colgroup>
                <col width="80px">
                <col>
                <col width="100px">
                <col width="100px">
                <col width="100px">
            </colgroup>
            <thead>
            <tr>
                <th>No</th>
                <th>제목</th>
                <th>이름</th>
                <th>등록일</th>
                <th>조회수</th>
            </tr>
            </thead>
            <tbody>
                <?php

                use App\Models\Board_model;

                if($noticeList)
                {
                    foreach($noticeList as $notice) { 
                       echo '
                        <tr>
                            <td id="noticeList">공지</td>
                            <td>
                                <a href="board/content/'.$notice['idx'].'">' . $notice['title'] . Board_model::displayNew($notice['regdate']) . '</a></td>
                            <td>' . $notice['name'] . '</td>
                            <td>' . Board_model::setRegdate($notice['regdate']) . '</td>
                            <td>' . $notice['cnt'] . '</td>
                        </tr>';
                    }
                } 
                if ($boardList)
                {
                    $index = 0;
                    foreach($boardList as $list) { 
                        $index++;
                        $indexNum = ($total - ($curPage-1)*$rowsPage - $index) + 1;

                        echo '
                        <tr>
                            <td>' . $indexNum . '</td>
                            <td>
                                <a href="board/content/'.$list['idx'].'">' . $list['title'] . Board_model::displayNew($list['regdate']) . '</a></td>
                            <td>' . $list['name'] . '</td>
                            <td>' . Board_model::setRegdate($list['regdate']) . '</td>
                            <td>' . $list['cnt'] . '</td>
                        </tr>';
                        }
                } 

                ?>
                
            </tbody>
            
        </table>
            
        <div id="paging" class="area-button">
        <ul class="pagination">
            <?php 
                
                for($i=0; $row= (isset($pagingArr[$i])) ? $pagingArr[$i] : 0; $i++) {
                    echo $pagingArr[$i];
                }
                     ?>
        </ul>
        
        </div>
    

</div>

<!-- Contents -->

<script type="text/javascript">

$(function() {
    
   
});

</script>

<?= $this->endSection() ?>