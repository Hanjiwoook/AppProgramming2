<html>
<!-- <meta charset="utf-8"> -->
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

	<?php

		$host = 'localhost';
		$user = 'korea';
		$pw = '1234';
		$dbName = 'todo';
		$mysqli = new mysqli($host, $user, $pw, $dbName);

		$member_name = $_POST['name'];
	    $member_stuid = $_POST['stuid'];
		$member_email = $_POST['email'];
		$member_passwd = $_POST['passwd'];

		$sql = "insert into member ( 
				member_name,
				member_stuid,
				member_email,
				member_passwd
		)";
		
		$sql = $sql. "values (
				'$member_name',
				'$member_stuid',
				'$member_email',
				'$member_passwd'
		)";

		if($mysqli->query($sql)){ 
		  echo '<script>alert("success inserting")</script>'; 
		}else{ 
		  echo '<script>alert("fail to insert sql")</script>';
		}

		mysqli_close($mysqli);
	  
	?>

<script>
	location.href = "join.suc.html";
</script>
</html>