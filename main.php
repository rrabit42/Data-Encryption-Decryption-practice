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
			  <li class="nav-item active">
				<a class="nav-link" href="main.php">Home <span class="sr-only">(current)</span></a>
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
				<a class="nav-link" href="login.php">Login</a>
			  </li>';
			  }
			  ?>
			</ul>
		  </div>
		</nav>
	</head>
	<body>
		<img src="banner.png" width=976px, height=320px>
	</body>
</html>