<?php

namespace App\Controllers\Board\Main;
use App\Models\Board_model;
use App\Models\Paging;
use App\Models\Reply_model;

class MainController extends \CodeIgniter\Controller
{
	
	public function index()
	{

		//검색
		$searchText 		= isset($_GET['filter_name']) ? trim($_GET['filter_name']) : '';

		//페이지 시작 변수
		$page 				= isset($_GET['page']) ? trim($_GET['page']) : 1;

		//현재 페이지
		$curPage			= isset($_GET['p']) ? $_GET['p'] : 1;

		$url 				= preg_replace('/(\/index\.php)/i', '', $_SERVER['PHP_SELF']);
		$link_url			= $_SERVER['QUERY_STRING'];


		//표시되는 페이지 수
		$rowsPage 			= 10;

		$board 			= new Board_model();
		$notice 		= $board->get_noticeView();
		$list 			= $board->get_view($curPage, $rowsPage, $searchText);
		$total			= $board->getTotal($searchText);

		$paging			= new Paging();
		$totalPage 		= $paging->totalPage($total, $rowsPage);
		

		$arr = array(
			'url' 		=> $url,
			'total'		=> $total,
			'rowsPage'	=> $rowsPage,
			'curPage'	=> $curPage,
			'link_url'	=> $link_url,
			'isAjax'    => 0

		);

		return view('home', [
							  'noticeList' 	=> $notice,
							  'boardList'	=> $list,
							  'curPage'		=> $curPage,
							  'total'		=> $total,
							  'rowsPage'	=> $rowsPage,
							  'link_url'	=> $link_url,
							  'searchText'	=> $searchText,
							  'pagingArr'	=> $paging->pageView($arr)
					]);
	} //index end

	//글쓰기 및 수정
	public function write() {

		$mode = isset($_GET['idx']) ? 'edit' : 'write';

		$board 		= new Board_model();

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
		
		if( $_POST["idx"] ) { //수정

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

    //업로드
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
	
					//$savedPath 					= $file->store(); 
					$savedPath 					= $file->store(); 
	
					$fileInfo['boardId']		= $boardId;
					$fileInfo['filePath'] 		= $savedPath;
					$fileInfo['fileName'] 		= $file->getClientName(); 
					$fileInfo['fileSize']	 	= $file->getSizeByUnit('kb'); //mb
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

	//업로드 파일 삭제
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


	//상세보기
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

		return view('content', [
								'pid'		=> $id,
								'reply'		=> $reply->get_view($id),
								'total'		=> $reply->getTotal($id),
								'content'	=> $content,
								'file_name' => $file_name,
								'filePath'	=> $filePath,
								'file_idx'	=> $file_idx
					]);
	}

	//삭제
	function remove() {
		$idx 		= $_GET['idx'];

		$board = new Board_model();
		$board->remove($idx);
	}


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
