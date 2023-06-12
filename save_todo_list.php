<?php
$host = 'localhost';
$user = 'korea';
$pw = '1234';
$dbName = 'todo';

$mysqli = new mysqli($host, $user, $pw, $dbName);

// DB 연결 오류 확인
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// POST로 전달된 todoItems 배열 가져오기
$todoItems = $_POST['todoItems'];

// 기존 데이터 모두 삭제
$deleteQuery = "DELETE FROM todo_items";
if (!$mysqli->query($deleteQuery)) {
    die("Error deleting todo items: " . $mysqli->error);
}

// 새로운 데이터 저장
$success = true;
foreach ($todoItems as $item) {
    $item = trim($item);
    if (!empty($item)) {
        $insertQuery = "INSERT INTO todo_items (title) VALUES ('$item')";
        if (!$mysqli->query($insertQuery)) {
            $success = false;
            break;
        }
    }
}

// 결과 반환
if ($success) {
    echo "success";
} else {
    echo "error";
}

$mysqli->close();
?>
