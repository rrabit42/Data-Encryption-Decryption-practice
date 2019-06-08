<html>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	
	<head>
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
			<a class="navbar-brand" href="main.php">이화사이버경찰청</a>
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		  </button>

		  <div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto">
			  <li class="nav-item">
				<a class="nav-link" href="main.php">Home<a>
			  </li>
			  <?php
				session_start();
				if(isset($_SESSION['id'])){
				  echo
				  '<li class="nav-item">
					<a class="nav-link" href="logout.php">Logout</a>
				  </li>
				  <li class="nav-item">
					<a class="nav-link" href="search.php">Search</a>
				  </li>
				  <li class="nav-item">
					<a class="nav-link" href="suspectinsert.php">Suspect Insert<a>
				  </li>	';
				}
			  else{
				  echo '
			  <li class="nav-item">
				<a class="nav-link" href="form.php">Login</a>
			  </li>';
			  }
			  ?>
			</ul>
		  </div>
		</nav>
	</head>
  <div class="form-group">
	<h1>용의자 추가</h1>
 <!--<form name="suspect_form" method="post"  action="insertresult.php">
   <table width="940" style="padding:5px 0 5px 0; ">
      <tr height="2" bgcolor="#006633"><td colspan="2"></td></tr>
       <tr>
         <th> 이름</th>
         <td><input type="text" name="suspectName"></td>
      </tr>
      <tr>
         <th> 나이</th>
         <td><input type="text" name="susepctAge"></td>
       </tr>
       <tr>
         <th> 신장</th>
         <td><input type="text" name="suspectHeight"></td>
       </tr>
       <tr>
         <th>성별</th>
           <td class="s">
               <input type="radio" name="suspectSex" value='4'> 여  
               <input type="radio" name="suspectSex" value='5'> 남
            </td>
         </tr>
         <tr>
           <th> 혈액형 </th>
		    <td class="s">
               <input type="radio" name="suspectBloodtype" value='17'> A 
               <input type="radio" name="suspectBloodtype" value='18'> B 
			   <input type="radio" name="suspectBloodtype" value='19'> O 
			   <input type="radio" name="suspectBloodtype" value='20'> AB 
            </td>
         </tr>
       <tr>
         <th> 알리바이</th>
         <td><input type="text" name="suspectAlibi"></td>
       </tr>
       <tr>
         <th> 특징</th>
         <td><input type="text" name="suspectFeature"></td>
       </tr>	   
           <tr height="2" bgcolor="#006633"><td colspan="2"></td></tr>
           <tr>
             <td colspan="2" align="center">
               <input type="submit" value="용의자 추가">
               <input type="reset" value="취소">
            </td>
           </tr>
           </table>
          </td>
          </tr>
          </form>-->
</div>
<?php
	$con = mysqli_connect("localhost", "root", "", "conandb") or die("MySQL 접속 실패 !!");
	
	$query = "SELECT * FROM suspectinfo";
	$data = mysqli_query($con, $query);
	
	   	//블룸필터 인덱스 구하는 함수
	function IndexFunction($val){
		$Hval = base_convert(hash("sha256", $val),2,16);
		$array = str_split($Hval);
		$sum = 0;
		foreach($array as $x){
			$sum += bin2hex($x);
		}
		$index = $sum % 512;
		return $index;
	}
	
	//블룸필터 함수
	function BloomFunction($string){
		$array = explode(' ', $string);
		$bloomfilter = array();
		$bloomfilter = array_fill(0,512, 0);
		foreach($array as $val){
			$index = IndexFunction($val);
			$bloomfilter[$index] = 1;
		}
		return implode($bloomfilter);
	}
	
	//버켓기반 암호화
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
	$name=$_POST["suspectName"];
	$age=$_POST["suspectAge"];
	$height=$_POST["suspectHeight"];
	$sex=$_POST["suspectSex"];
	$bloodtype=$_POST["suspectBloodtype"];
	$alibi=$_POST["suspectAlibi"];
	$feature=$_POST["suspectFeature"];
	
	$value_num=bucket($height);
	
	$suspect_al_bloom=BloomFunction($alibi);
	$suspect_f_bloom=BloomFunction($feature);
	
	$rand_num=random_int(1,1000);	
	
	//성별
	if($sex==4) $suspect_sex="여";
	else $suspect_sex="남";
	
	//혈액형
	if($bloodtype==17) $suspect_bt="A";
	else if($bloodtype==18) $suspect_bt="B";
	else if($bloodtype==19) $suspect_bt="O";
	else $suspect_bt="AB";
	
	$suspect_num= mysqli_num_rows($data)+1;

	$sql = "
		INSERT INTO suspectinfo VALUES
		($suspect_num, HEX(AES_ENCRYPT('$name','suspectisme')),HEX(AES_ENCRYPT($age+$rand_num,'suspectisme')),$value_num,HEX(AES_ENCRYPT('$suspect_sex','suspectisme')), SHA2('$suspect_bt$rand_num',256), '$suspect_al_bloom',HEX(AES_ENCRYPT('$alibi','suspectisme')), '$suspect_f_bloom',HEX(AES_ENCRYPT('$feature','suspectisme')),$rand_num)
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