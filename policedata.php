<?php
//police table에 넣을 경찰 정보(사이버기초프로젝트 팀원들)
	
   $con = mysqli_connect("localhost", "root", "", "conandb") or die("MySQL 접속 실패 !!");
   
   //salt 만들기
   $rand_1=random_int(1,1000);$rand_5=random_int(1,1000);
   $rand_2=random_int(1,1000);$rand_6=random_int(1,1000);
   $rand_3=random_int(1,1000);$rand_7=random_int(1,1000);
   $rand_4=random_int(1,1000);$rand_8=random_int(1,1000);
   
   //기관, 부서
   //소속부서, 소속기관 데이터
	$hvar = '울산 중앙 경찰'; $hvar2 = '청소년 과';
	$svar = '대구 중앙 경찰'; $svar2 = '사이버 보안 과';
	$jvar = '창원 중앙 경찰'; $jvar2 = '사이버 수사 대';
	$kvar = '서울 중앙 경찰'; $kvar2 = '범죄 심리 과';

/*블룸필터 */
	//블룸필터 인덱스 구하는 함수
	//sha256을 통해 변수를 해쉬하면 16진수 문자열이 나옴
	//16진수를 10진수로 전환하여
	//그 숫자를 하나하나를 원소로 갖는 배열을 만듬
	//숫자들을 모두 더해
	//512로 나누어 인덱스를 구함
	function IndexFunction($val){
		$Hval = base_convert(hash("sha256", $val),16,10);
		$array = str_split($Hval);
		$sum = 0;
		foreach($array as $x){
			$sum += $x;
		}
		$index = $sum % 512;
		return $index;
	}
	
	//블룸필터 함수
	function BloomFunction($string){
		$bloomfilter = array();
		$bloomfilter = array_fill(0,512, 0);
		$array = explode(' ', $string);
		foreach($array as $val){
			$index = IndexFunction($val);
			$bloomfilter[$index] = 1;
		}
		return implode($bloomfilter); //db에 넣으려고 배열에서 문자열로 전환
	}
	
	//소속 기관, 소속 부서 블룸필터 암호화 적용
	$bloomfilterH_A = BloomFunction($hvar); $bloomfilterH_D = BloomFunction($hvar2);
	$bloomfilterS_A = BloomFunction($svar); $bloomfilterS_D = BloomFunction($svar2);
	$bloomfilterJ_A = BloomFunction($jvar); $bloomfilterJ_D = BloomFunction($jvar2);
	$bloomfilterK_A = BloomFunction($kvar); $bloomfilterK_D = BloomFunction($kvar2);
	
		/*암호화
			아이디
			비밀번호 - 해쉬 + salt
			이름    - 대칭키
			나이    - 대칭키 + salt
			성별    - 대칭키 + salt
			소속 기관 - 블룸필터
			소속 부서 - 블룸필터
			salt1
			salt2
		*/
   $sql = "
		INSERT INTO policeinfo VALUES
		('HYN',SHA2('HYN$rand_1', 512),HEX(AES_ENCRYPT('황유나','HSJK')),HEX(AES_ENCRYPT(22$rand_5,'HSJK')),SHA2('여$rand_5',256),'$bloomfilterH_A','$bloomfilterH_D', $rand_1, $rand_5),
		('SJW',SHA2('SJW$rand_2', 512),HEX(AES_ENCRYPT('석지원','HSJK')),HEX(AES_ENCRYPT(21$rand_6,'HSJK')),SHA2('여$rand_6',256),'$bloomfilterS_A','$bloomfilterS_D', $rand_2, $rand_6),
		('JBM',SHA2('JBM$rand_3', 512),HEX(AES_ENCRYPT('장보민','HSJK')),HEX(AES_ENCRYPT(21$rand_7,'HSJK')),SHA2('여$rand_7',256),'$bloomfilterJ_A','$bloomfilterJ_D', $rand_3, $rand_7),
		('KSY',SHA2('KSY$rand_4', 512),HEX(AES_ENCRYPT('김서영','HSJK')),HEX(AES_ENCRYPT(21$rand_8,'HSJK')),SHA2('여$rand_8',256),'$bloomfilterK_A','$bloomfilterK_D', $rand_4, $rand_8)
   ";
 
   $ret = mysqli_query($con, $sql);
 
   if($ret) {
	   echo "데이터 입력 성공";
   }
   else {
	   echo "데이터 입력 실패"."<br>";
	   echo "실패 원인 :".mysqli_error($con);
	   echo $bloomfilterH_A;
   }
 
   mysqli_close($con);
?>
