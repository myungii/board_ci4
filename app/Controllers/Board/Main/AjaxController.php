<?php

namespace App\Controllers\Board\Main;
use App\Models\Board_model;
use App\Models\Paging;
use App\Models\Reply_model;

class AjaxController extends \CodeIgniter\Controller
{
	
	public function index()
	{

		return view('boardAjax/home');
	} //index end

	public function list() {

		//검색
		$query = isset( $_POST['search'] ) ? $_POST['search'] : '';

		//현재 페이지
		$curPage = ( $_POST['page'] > 0 ) ? trim( $_POST['page'] ) : 1;

		$url		= $_SERVER['PHP_SELF'];
		$link_url	= $_SERVER['QUERY_STRING'];

		//표시되는 페이지 수
		$rowsPage	= 10;

		//리스트 출력
		$board = new Board_model();
		$data = $board->getViewForAjax($curPage, $rowsPage, $query);

		//공지글
		$noticeView = $board->get_noticeView();

		$list = array();

		foreach($data as $li)
		{

			if($li['fileid'] == null)
			{
				$li['filed'] = "";
			}

			if($li['notice'] == null)
			{	
				$li['notice'] = "";
			}

			if($li['modidate'] == null)
			{
				$li['modidate'] = "";
			}

			$row = array (
				"idx"			=> $li['idx'],
				"title"			=> $li['title'],
				"name"			=> $li['name'],
				"content"		=> $li['content'],
				"cnt"			=> $li['cnt'],
				"regdate"		=> Board_model::setRegdate( $li['regdate'] ),
				"fileid"		=> $li['fileid'],
				"notice"		=> $li['notice'],
				"modidate"		=> $li['modidate'],
				"new"			=> Board_model::displayNew( $li['regdate'] )
			);

			$list[] = $row;

		}

		foreach($noticeView as $li)
		{
			if($li['fileid'] == null)
			{
				$li['filed'] = "";
			}

			if($li['notice'] == null)
			{	
				$li['notice'] = "";
			}

			if($li['modidate'] == null)
			{
				$li['modidate'] = "";
			}

			$row = array (
				"idx"			=> $li['idx'],
				"title"			=> $li['title'],
				"name"			=> $li['name'],
				"content"		=> $li['content'],
				"cnt"			=> $li['cnt'],
				"regdate"		=> Board_model::setRegdate($li['regdate']),
				"fileid"		=> $li['fileid'],
				"notice"		=> $li['notice'],
				"modidate"		=> $li['modidate'],
				"new"			=> Board_model::displayNew($li['regdate'])
			);

			$notce_list[] = $row;

		}

		//레코드 갯수 출력
		$total 	   = $board->getTotalForAjax($query);

		//페이징
		$pagingArr = array(
					"url"		=> $url,
					"total"		=> $total,
					"rowsPage"	=> $rowsPage,
					"curPage"	=> $curPage,
					"link_url"	=> $link_url,
					"isAjax"    => 1

		);

		$page 	   = new Paging();
		$paging    = $page->pageView($pagingArr);

		$result = array( "list"			=> $list, 
						 "notce_list"   => $notce_list,
						 "total"		=> $total,
						 "current_block"=> $paging['current_block'],
						 "current"		=> $paging['current'],
						 "total_block"  => $paging['total_block'],
						 "prev"  		=> $paging['prev'],
						 "next"  		=> $paging['next'],
						 "totalPage"  	=> $paging['totalPage'],
						 "pagingArr"	=> $pagingArr,
						 "rowsPage"		=> $rowsPage,
						 "page"			=> $curPage);

		$this->display($result);


	} //list end


	public function write() {

		$mode = isset($_GET['idx']) ? 'edit' : 'write';

		$board 		= new Board_model();
		$content 	= $board->load( $_GET['idx'], $mode );

		if($mode === 'edit') {
			$content 	= $board->load( $_GET['idx'], $mode );
	
			return view('write', [ 'content' => $content ,
								   'file'	 => isset( $content['fileid'] ) ? $board->fileLoad( $content['fileid'] ) : ''
								] );
		}

		return view('write');
	} //write end


	//저장 및 수정
	public function save() {

		$param_arr = array(
			'name' 		=> $_POST["name"],
			'title'		=> $_POST["title"],
			'content'	=> $_POST["content"],
			'notice'	=> ($_POST["notice"] === 'Y') ? 1 : 0
		);
				
		$board 			= new Board_model();
		
		if( isset( $_POST["idx"] ) ) { //수정

				$param_arr['idx'] = $_POST["idx"];
				$board->modify($param_arr);

				if( $_POST["file_idx"] ){
					$fileIdx 	= $this->_removeFile($_POST["file_idx"]); //서버 삭제
					$board->fileDelete($_POST["file_idx"]); //DB 삭제
				
				}

				$fileUpload = $this->_upload($_POST["idx"]);

				if(!empty($fileUpload)) {
					$file_arr = [
						'boardId' 		=> $_POST["idx"],
						'fileName' 		=> $fileUpload['fileName'],
						'fileSize'		=> intval($fileUpload['fileSize']),
						'filePath'		=> $fileUpload['filePath'],
						'fileType'		=> $fileUpload['fileType'],
						'regdate'		=> date("Y-m-d H:i:s"),
						'fullFilePath'	=> $fileUpload['fullFilePath']
					];
	
					$board->fileUpload($file_arr);
				} else { //파일등록 없이 수정할 때 success 사인
					$json 			  = null;
					$json['is_valid'] = '1';
	
					echo json_encode($json);
				}
				
		} else { //저장

			$insertId = $board->add($param_arr);
			
			$fileUpload = $this->_upload($insertId);

			if(!empty($fileUpload)) {
				$file_arr = [
								'boardId' 		=> $fileUpload['boardId'],
								'fileName' 		=> $fileUpload['fileName'],
								'fileSize'		=> intval($fileUpload['fileSize']),
								'filePath'		=> $fileUpload['filePath'],
								'fileType'		=> $fileUpload['fileType'],
								'regdate'		=> date("Y-m-d H:i:s"),
								'fullFilePath'	=> $fileUpload['fullFilePath']
							];
			
				$board->fileUpload($file_arr);

			} else { //파일등록 없이 저장할 때 success 사인

				$json 			  = null;
				$json['is_valid'] = '1';

				echo json_encode($json);
			}
		    
		}


	} //save end

	public function _upload($boardId) {

		$file = $this->request->getFile("upload_file");

		$fileInfo = [];

		if($file !=null) {
			if( !$file->isValid() ) {
				$errorString  = $file->getErrorString();
				$errorCode	  = $file->getError();

				$fileInfo['hasError'] 			= true;
				$fileInfo['errorString'] 		= $errorString;
				$fileInfo['errorCode'] 			= $errorCode;
			} else {
				$fileInfo['hasError'] 			= false;
				if ($file->hasMoved() === false) {               
					$fileInfo['fileType'] 		= $file->getMimeType(); 
	
					$savedPath 					= $file->store(); 
					//$savedPath 					= $file->move(); 
	
					$fileInfo['boardId']		= $boardId;
					$fileInfo['filePath'] 		= $savedPath;
					$fileInfo['fileName'] 		= $file->getClientName(); 
					$fileInfo['fileSize']	 	= $file->getSizeByUnit('kb'); //kb
					$fileInfo['fullFilePath'] 	= $fileInfo['filePath'];
					//$fileInfo['fileName'] = $file->getName(); 
					//$fileInfo['clientMimeType'] = $file->getClientMimeType(); 
					//$fileInfo['fileType'] = $file->getClientExtension();  웹브라우저가 보낸 확장자
					//$fileInfo['fileType'] = $file->guessExtension(); //실제 확장자
				}
			}
		}

		return $fileInfo;
	}

	public function _removeFile($id) {

		$board 			= new Board_model();

		if($id) {

			$fileInfo 	= $board->fileLoad($id);
			$filePath 	= $fileInfo['filePath'];
			
			if(file_exists(WRITEPATH . 'uploads/' . $filePath) == TRUE) {
				unlink(WRITEPATH . 'uploads/' . $filePath);	
			}

		}
		return $fileInfo['idx'];

	}


	function content($num) {
		$id = $num;

		$board 					= new Board_model();
        $content 				= $board->load($id, '');

		if( $content['fileid'] == null ) {
			$file_name = '';
			$file_idx  = '';
			$filePath  = '';
			
		} else {
			
			$fileInfo 	= $board->fileLoad($content['fileid']);
			$file_name	= $fileInfo['fileName'];
			$file_idx	= $fileInfo['idx'];
			$filePath	= $fileInfo['filePath'];

		}
		
		$reply 		= new Reply_model();

		return view('boardAjax/content', [
								'pid'		=> $id,
								'reply'		=> $reply->get_view($id),
								'total'		=> $reply->getTotal($id),
								'content'	=> $content,
								'file_name' => $file_name,
								'filePath'	=> $filePath,
								'file_idx'	=> $file_idx
					]);
	}

	function remove() {
		$idx 		= $_GET['idx'];

		$board = new Board_model();
		$board->remove($idx);
	}


	/*********************
	* @title 공용 출력
	* @param $data json
	* @return json
	**********************/
	public function display($data)/*{{{*/
	{
		echo json_encode($data, JSON_UNESCAPED_UNICODE);
		exit;
	}/*}}}*/


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
