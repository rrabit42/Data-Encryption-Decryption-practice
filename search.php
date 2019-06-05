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
				  <li class="nav-item active">
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
	<form class="row" name="SearchForm" method="POST" action="searchresult.php">
		<div class="search-box">
			<select id="inputState" class="form-control" name="option">
				<!--전체를 빼면 검색창이 좀 이상해지는데 이건 계속 생각을 해보자 디자인을. 보민이가 말한대로 그냥 필드별로 나눠서 선택하게 하는게 보이게 좋은것 같기도...-->
				<!-- <option selected value="0">전체</option> -->
				<option value="name">이름</option>
				<option value="alibi">알리바이</option>
				<option value="feature">특징</option>
			</select>
		</div>
		<div class="search">
			<input name="word" type="text" class="form-control" id="info" placeholder="검색">
		</div>
	</form>
	<small id="emailHelp" class="form-text text-muted">검색하고 싶은 용의자의 정보를 입력하세요.</small>
  </div>


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