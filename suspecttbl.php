<?php
//용의자 table
	
   $con = mysqli_connect("localhost", "root", "", "conandb") or die("MySQL 접속 실패 !!");

//번호(primary key)
//이름, 나이, 키, 성별, 혈액형, 알리바이(블룸필터), 알리바이(대칭키), 특징(블룸필터), 특징(대칭키), salt
   $sql = "
	   CREATE TABLE suspectinfo 
		( NUM  			INT(128) PRIMARY KEY NOT NULL,
		  NAME			VARCHAR(128) NOT NULL,
		  AGE			VARCHAR(128) NOT NULL,
		  HEIGHT		INT(128) NOT NULL,
		  SEX			VARCHAR(128) NOT NULL,
		  BLOOD_TYPE	VARCHAR(256) NOT NULL,
		  ALIBI			VARCHAR(512) NOT NULL,
		  PR_ALIBI		VARCHAR(128) NOT NULL,
		  FEATURE		VARCHAR(512) NOT NULL,
		  PR_FEATURE	VARCHAR(128) NOT NULL,
		  SALT			VARCHAR(20) NOT NULL
		)
   ";
 
   $ret = mysqli_query($con, $sql);
 
   if($ret) {
	   echo "suspect 생성 성공";
   }
   else {
	   echo "suspect 생성 실패"."<br>";
	   echo "실패 원인 :".mysqli_error($con);
   }
 
   mysqli_close($con);
?>
