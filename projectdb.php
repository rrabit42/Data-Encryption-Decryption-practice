<?php
//사이버기초프로젝트 database 생성
//Database : conandb
   $con = mysqli_connect("localhost", "root", "", "") or die("MySQL 접속 실패 !!");
         
   $sql = "CREATE DATABASE conandb DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";
   $ret = mysqli_query($con, $sql);
   
   if($ret) {
	   echo "policedb 생성 성공";
   }
   else {
	   echo "policedb 생성 실패"."<br>";
	   echo "실패 원인 :".mysqli_error($con);
   }
   
   mysqli_close($con);
?>
