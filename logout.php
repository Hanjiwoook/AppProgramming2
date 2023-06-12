<?php
// 세션 시작
session_start();

// 세션 데이터 삭제 (로그아웃)
session_unset();
session_destroy();

// 로그아웃 후 리다이렉트할 페이지로 이동
header('Location: login.html');
exit;
?>
