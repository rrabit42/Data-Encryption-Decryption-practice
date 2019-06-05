<?php
//경찰 table
//아이디, 비밀번호, 이름, 나이, 성별, 소속기관, 소속부서, 암호화를위한 salt1, salt2
   $con = mysqli_connect("localhost", "root", "", "conandb") or die("MySQL 접속 실패 !!");

   $sql = "
	   CREATE TABLE policeinfo 
		( ID  		VARCHAR(20) PRIMARY KEY NOT NULL,
		  PASSWORD    	VARCHAR(512) NOT NULL,
		  NAME			VARCHAR(128) NOT NULL,
		  AGE			VARCHAR(128) NOT NULL,
		  SEX			VARCHAR(256) NOT NULL,
		  AGENCY		VARCHAR(600) NOT NULL,
		  DEP			VARCHAR(600) NOT NULL,
		  SALT1			VARCHAR(20) NOT NULL,
		  SALT2         VARCHAR(20) NOT NULL
		)
   ";
 
   $ret = mysqli_query($con, $sql);
 
   if($ret) {
	   echo "policeinfo 생성 성공";
   }
   else {
	   echo "policeinfo 생성 실패"."<br>";
	   echo "실패 원인 :".mysqli_error($con);
   }
 
   mysqli_close($con);
?>
