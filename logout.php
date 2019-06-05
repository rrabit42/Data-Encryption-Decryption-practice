<?php
session_start();
session_destroy();

echo "로그아웃 완료";
?>
<meta http-equiv='refresh' content='0;url=main.php'>