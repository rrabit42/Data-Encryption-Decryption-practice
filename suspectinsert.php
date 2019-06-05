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
					<a class="nav-link active" href="suspectinsert.php">Suspect Insert<a>
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

  <div class="form-group">
	<h1>용의자 추가</h1>
 <form name="suspect_form" method="post"  action="insertresult.php">
   <table width="940" style="padding:5px 0 5px 0; ">
      <tr height="2" bgcolor="#006633"><td colspan="2"></td></tr>
		<tr>
         <th> 이름</th>
         <td><input type="text" name="suspectName"></td>
		</tr>
		<tr>
         <th> 나이</th>
         <td><input type="text" name="suspectAge"></td>
		</tr>
		<tr>
         <th> 신장</th>
         <td><input type="number" name="suspectHeight"></td>
		</tr>
		<tr>
         <th>성별</th>
			<td class="s">
               <input type="radio" name="suspectSex" value="xx"> 여  
               <input type="radio" name="suspectSex" value="xy"> 남
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
  </form>
</div>
</html>

<style>
h1 {
	margin: 30px;
	font-size: 25px;
}

</style>




