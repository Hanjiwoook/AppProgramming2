<?php
$host = 'localhost';
$user = 'korea';
$pw = '1234';
$dbName = 'todo';
$con = new mysqli($host, $user, $pw, $dbName);

$id = $_POST['id']; // 아이디
$pw = $_POST['pw']; // 패스워드

$query = "SELECT * FROM member WHERE member_email='$id' AND member_passwd='$pw'";
$result = mysqli_query($con, $query);
$count = mysqli_num_rows($result);

if($count > 0){ // 쿼리 결과에 레코드가 존재하면 login
    echo "<script>alert('로그인 성공');</script>";
    echo "<script>location.href = 'login.todo.php';</script>";
} else {
    echo "<script>alert('로그인 실패');</script>";
    echo "<script>location.href = 'login.html';</script>";
}
?>
