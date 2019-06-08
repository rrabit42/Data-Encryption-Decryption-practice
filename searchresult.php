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
	<h1>용의자 검색</h1>
	<!-- <form class="row" name="SearchForm" method="POST" action="searchresult.php">
		<div class="search-box">
			<select id="inputState" class="form-control" name="option">
				<option selected value="0">전체</option>
				<option value="name">이름</option>
				<option value="alibi">알리바이</option>
				<option value="feature">특징</option>
			</select>
		</div>
		<div class="search">
			<input name="word" type="text" class="form-control" id="info" placeholder="검색">
		</div>
	</form>
	<small id="emailHelp" class="form-text text-muted">검색하고 싶은 용의자의 정보를 입력하세요.</small> -->
  </div>
  
<?php
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
	
	function BloomEqual($index, $bloomfilter){
		if ($bloomfilter[$index] == '1'){
			return true;
		}
		else
			return false;
	}
	$con = mysqli_connect("localhost", "root", "", "conandb") or die("MySQL 접속 실패 !!");
         
   $sql = "SELECT * FROM suspectinfo";
   $ret = mysqli_query($con, $sql);
	
	$select = $_POST["option"];
	$text = $_POST["word"];

	if($ret) {
		//이름 검색
		if($select == "name") {
			$sql="SELECT AES_DECRYPT(UNHEX(NAME),'suspectisme') as NAME,
			AES_DECRYPT(UNHEX(AGE),'suspectisme')-SALT as AGE,
			HEIGHT as HEIGHT,
			AES_DECRYPT(UNHEX(SEX),'suspectisme') as SEX,
			BLOOD_TYPE as BLOOD_TYPE,
			AES_DECRYPT(UNHEX(PR_ALIBI),'suspectisme') as PR_ALIBI,
			AES_DECRYPT(UNHEX(PR_FEATURE),'suspectisme') as PR_FEATURE,
			SALT as SALT
			from suspectinfo where NAME=HEX(AES_ENCRYPT('".$text."','suspectisme'))";
		}
		//알리바이 검색
		else if($select == "alibi"){
			$sql="SELECT NUM as NUM,
			AES_DECRYPT(UNHEX(NAME),'suspectisme') as NAME,
			ALIBI as ALIBI,
			AES_DECRYPT(UNHEX(PR_ALIBI),'suspectisme') as PR_ALIBI from suspectinfo";
		}
		//특징 검색
		else if($select == "feature"){
			$sql="SELECT NUM as NUM,
			AES_DECRYPT(UNHEX(NAME),'suspectisme') as NAME,
			FEATURE as FEATURE,
			AES_DECRYPT(UNHEX(PR_FEATURE),'suspectisme') as PR_FEATURE
			from suspectinfo";
		}
		
		
		function bucket_result($value){
			if ($value==4) return "160 이하";
			else if($value==3) return "160대";
			else if($value==7) return "170 초반";
			else if($value==9) return "170 후반";
			else if($value==1) return "180 초반";
			else if($value==8) return "180 후반";
			else "알수 없음";
		}
		
		$ret2=mysqli_query($con,$sql);
			if($ret2) {
				if($select == "name"){
					$blood = 'A';
					$count = 0;
					while($row=mysqli_fetch_array($ret2)){
						$array_bloodtype= array("A","B","O","AB");
						for($i=0 ; $i<4 ; $i++){
							$check = $array_bloodtype[$i].$row['SALT'];
							$encrypt_bloodtype=hash('sha256', $check);
							if($encrypt_bloodtype==$row['BLOOD_TYPE']){
								$blood = $array_bloodtype[$i];
							}
						}
							$age=substr($row['AGE'],0,2);
							echo "이름 : ",$row['NAME'],"<br>나이 : ",$age,"<br>신장 : ",bucket_result($row['HEIGHT']),
							"<br>성별 : ",$row['SEX'],"<br>혈액형 : ",$blood,"<br>알리바이 : ",$row['PR_ALIBI'],
							"<br>특징 : ",$row['PR_FEATURE'];
							$count+=1;
					}
					if($count == 0){
						echo "입력하신 이름을 가진 용의자가 없습니다.";
					}
				}
				
				
				else if($select == "alibi"){
					$count = 0;
					while($row=mysqli_fetch_array($ret2)){
						$alibi=$row['ALIBI'];
						$wantIndex = IndexFunction($text);
						if(BloomEqual($wantIndex,$alibi)){
								echo "번호:",$row['NUM'],"<br>이름 : ",$row['NAME'],"<br>알리바이 : ",$row['PR_ALIBI'];
								$count += 1;
						}
					}
					if($count == 0){
						echo "입력하신 알리바이를 가진 용의자가 없습니다.";
					}
					
				}
				
				else if($select == "feature"){
					$count = 0;
					while($row=mysqli_fetch_array($ret2)){
						$alibi=$row['FEATURE'];
						$wantIndex = IndexFunction($text);
						if(BloomEqual($wantIndex,$alibi)){	
								echo "<br><br><br>번호:",$row['NUM'],"<br>이름 : ",$row['NAME'],"<br>특징 : ",$row['PR_FEATURE'];
								$count += 1;
							}
					}
					if($count == 0){
						echo "입력하신 특징을 가진 용의자가 없습니다.";
					}
				}
				
		}
		
		
	}
		
	else {
	   echo "오류발생";
	   echo "실패 원인: ".mysqli_error($con);
	}
   mysqli_close($con);

?>

</html>

<style>
h1 {
	margin: 50px;
	text-align: center;
	font-size: 50px;
}
.row{
	align-items: center;
	justify-content: center;
}

.search-box{
	padding-right: 5px;
}

.search{
	padding:0;
	width: 500px;
}

small{
	text-align: center;
}

</style>
