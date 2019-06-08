<?php
   $con = mysqli_connect("localhost", "root", "", "conandb") or die("MySQL 접속 실패 !!");
   
   //salt 생성
   	$rand_1=random_int(1,1000);
	$rand_2=random_int(1,1000);
	$rand_3=random_int(1,1000);
	$rand_4=random_int(1,1000);
	$rand_5=random_int(1,1000);
   
/* 블룸필터 */
   	//블룸필터 인덱스 구하는 함수
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
		return implode($bloomfilter);
	}

/* 버켓기반 암호화 */
	function bucket($height){
		if($height<160) $value=4;
		else if($height>=160 and $height<170) $value=3;
		else if($height>=170 and $height<175) $value=7;
		else if($height>=175 and $height<180) $value=9;
		else if($height>=180 and $height<185) $value=1;
		else if($height>=185 and $height<190) $value=8;
		else return $value=5;
		
		return $value;
	}
	
	//신장에 버켓기반 암호화 적용
	$value_1=bucket(182);
	$value_2=bucket(172);
	$value_3=bucket(178);
	$value_4=bucket(173);
	$value_5=bucket(176);
	
	//알리바이와 특징
	$sim_al = '잃어버린 보석을 찾고 있었음.'; $sim_f = '미술관 사장';
	$jeon_al = '의뢰인의 저녁식사를 준비했음'; $jeon_f = '의뢰인의 비서';
	$kim_al = '의뢰인에 의해 방에 갇혀있었음'; $kim_f = '유명한과 면식이 있는 탐정';
	$jeong_al = '자살했는데 시신이 발견되지 않음'; $jeong_f = '파 이스트 오피스 비서실장';
	$chae_al = '하반신 마비로 인해 병실에 있음'; $chae_f = '파 이스트 오피스 사장';
	
	//알리바이와 특징에 블룸필터 암호화 적용
	$sim_al_bloom = BloomFunction($sim_al); $sim_f_bloom = BloomFunction($sim_f);
	$jeon_al_bloom = BloomFunction($jeon_al); $jeon_f_bloom = BloomFunction($jeon_f);
	$kim_al_bloom = BloomFunction($kim_al); $kim_f_bloom = BloomFunction($kim_f);
	$jeong_al_bloom = BloomFunction($jeong_al); $jeong_f_bloom = BloomFunction($jeong_f);
	$chae_al_bloom = BloomFunction($chae_al); $chae_f_bloom = BloomFunction($chae_f);
	
	/*
		번호
		이름     - 대칭키
		나이	    - 대칭키 + salt
		키(신장)  - 버켓기반 암호화
		성별     - 대칭키 + salt
		혈액형    - 대칭키 + salt
		알리바이   - 블룸필터
		알리바이   - 대칭키
		특징		- 블룸필터
		특징		- 대칭키
		salt
	*/

   $sql = "
		INSERT INTO suspectinfo VALUES
		(1, HEX(AES_ENCRYPT('심정태','suspectisme')),HEX(AES_ENCRYPT(45+$rand_1,'suspectisme')),$value_1,HEX(AES_ENCRYPT('남','suspectisme')), SHA2('A$rand_1',256), '$sim_al_bloom', HEX(AES_ENCRYPT('$sim_al','suspectisme')), '$sim_f_bloom', HEX(AES_ENCRYPT('$sim_f','suspectisme')),$rand_1),
		(2, HEX(AES_ENCRYPT('전기수','suspectisme')),HEX(AES_ENCRYPT(36+$rand_2,'suspectisme')),$value_2,HEX(AES_ENCRYPT('남','suspectisme')), SHA2('A$rand_2',256), '$jeon_al_bloom', HEX(AES_ENCRYPT('$jeon_al','suspectisme')), '$jeon_f_bloom', HEX(AES_ENCRYPT('$jeon_f','suspectisme')),$rand_2),
		(3, HEX(AES_ENCRYPT('김용성','suspectisme')),HEX(AES_ENCRYPT(39+$rand_3,'suspectisme')),$value_3,HEX(AES_ENCRYPT('남','suspectisme')), SHA2('B$rand_3',256), '$kim_al_bloom', HEX(AES_ENCRYPT('$kim_al','suspectisme')), '$kim_f_bloom', HEX(AES_ENCRYPT('$kim_f','suspectisme')),$rand_3),
		(4, HEX(AES_ENCRYPT('정나미','suspectisme')),HEX(AES_ENCRYPT(27+$rand_4,'suspectisme')),$value_4,HEX(AES_ENCRYPT('여','suspectisme')), SHA2('O$rand_4',256), '$jeong_al_bloom', HEX(AES_ENCRYPT('$jeong_al','suspectisme')), '$jeong_f_bloom', HEX(AES_ENCRYPT('$jeong_f','suspectisme')),$rand_4),
		(5, HEX(AES_ENCRYPT('채동민','suspectisme')),HEX(AES_ENCRYPT(27+$rand_5,'suspectisme')),$value_5,HEX(AES_ENCRYPT('남','suspectisme')), SHA2('B$rand_5',256), '$chae_al_bloom', HEX(AES_ENCRYPT('$chae_al','suspectisme')), '$chae_f_bloom', HEX(AES_ENCRYPT('$chae_f','suspectisme')),$rand_5)
		";
 
   $ret = mysqli_query($con, $sql);
 
   if($ret) {
	   echo "데이터가 성공적으로 입력됨";
   }
   else {
	   echo "데이터 입력 실패"."<br>";
	   echo "실패 원인 :".mysqli_error($con);
   }
 
   mysqli_close($con);
?>
