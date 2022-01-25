<?php

namespace App\Controllers\Quiz\Main;

use stdClass;

class QuizController extends \CodeIgniter\Controller
{
	
	public function index()
	{

		return view('Quiz/home');
	} //index end
	
	public function quiz() {
		
		$index 		= !empty( $_GET['index'] ) 		? intval( $_GET['index'] ) 		: 0;	//현재 몇 번째 문제
		$chk_answer = !empty( $_GET['chk_answer'] ) ? $_GET['chk_answer'] 	: '0';	//이용자 체크 답안

		$q1 		= array(
							'question'		=> '브론테 자매가 집필한 작품이 아닌것은 다음 중 무엇일까요?',
							'selection'		=> [
													"제인 에어", "오만과 편견", "폭풍의 언덕"
												],
							'answer'		=> 0	
						);
		
		$q2 		= array(
							'question'		=> '신앙과 이성의 조화를 주장한 스콜라 철학자는 누구 일까요?',
							'selection'		=> [
													"헤라도토스", "토마스 아퀴나스", "베이컨"
												],
							'answer'		=> 1	
							);
	
		$q3 		= array(
							'question'		=> '작품 \'민중을 이끄는 자유의 여신\'을 그린 화가는 누구일까요?',
							'selection'		=> [
													"외젠 들라크루아", "존 콘스터블", "카스파르 프리드리히"
												],
							'answer'		=> 0	
							);

		
		$qlist 	= array();
		$finish = FALSE;
		array_push($qlist, $q1, $q2, $q3);

		//선택지 번호
		$number = ["①", "②", "③"];

	/*	
		foreach($qlist as $key =>$val) {
			$qnum = $key+1;
			echo "Q" . $qnum . ". " . $val['question'] . "<br>";

			for($i=0; $i<count($val['selection']); $i++) {
				
				echo $number[$i] . $val['selection'][$i] . "<br>"; 
			}
		}
		echo "<br>";
		print_r($qlist[1]);
		echo "<br><br>";

		echo "Q1. " . $qlist[$index]['question'] . "<br>";
		for($i=0; $i<count($qlist[$index]['selection']); $i++) {
			echo $number[$i] . $qlist[$index]['selection'][$i] . "<br>";
		}
		
	*/	
		
		if( $chk_answer == '0' ) { //처음 문제

			$msg = '';

		} 
		else { //선택지 답 눌렀을 때

			if( intval( $chk_answer ) !== $qlist[$index]['answer'] + 1 ) { //오답
				$msg = '틀렸습니다! 다시 입력해주세요!';

			} else { //정답
				if( $index < count($qlist) - 1 ) {
					
					$index++;
				} 
				else { //퀴즈 종료

					$index 	= count($qlist) - 1;
					$finish = TRUE;
				}
				
				$msg = '정답입니다!';
			}			
		}


		$data =  [ 'qlist' => $qlist[$index], 'finish' => $finish, 'number' => $number, 'index' => $index, 'msg' => $msg ];

		echo json_encode($data);
		exit;
		
	} //quiz end


	function quiz2() {

		//국가선택
		$country = [
						"UK" 		=> ["영국"		, "pound"],
						"USA" 		=> ["미국"		, "dollar"],
						"EUROPE" 	=> ["유럽연합"	, "eur"],
						"CHINA" 	=> ["중국"		, "yuan"]
					];

		$chk_country 	= !empty( $_GET['chk_country'] )	? $_GET['chk_country']		: '';
		$chk_answer 	= !empty( $_GET['chk_answer'] ) 	? $_GET['chk_answer'] 		: '0';	//이용자 체크 답안

		$data['country']  = $country;
		
		if($chk_country !== '') { //국가 선택
			$answer 		  = $country[$chk_country][1];
			$data['answer']	  = $answer;
		}

		$data['is_valid'] = "0"; 

		if($chk_answer !== '0') { //처음 뜰 때 제외
			if( $chk_answer == $answer ) { //정답일 때
				$data['is_valid'] = "1";
			} else { //오답일 때
				$data['is_valid'] = "2";
			}
		}
		

		echo json_encode($data);
		exit;
		
	}




}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
