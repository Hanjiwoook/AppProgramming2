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

// POST 요청에서 전송된 데이터 받기
$todoData = json_decode(file_get_contents('php://input'), true);

// 데이터베이스에 전송된 데이터 저장
if (!empty($todoData)) {
    foreach ($todoData as $item) {
        $escapedItem = $mysqli->real_escape_string($item);
        $sql = "INSERT INTO group_todo_items (item) VALUES ('$escapedItem')";
        $mysqli->query($sql);
    }
}

// 데이터베이스에 저장된 목록 가져오기
$sql = "SELECT * FROM group_todo_items";
$result = $mysqli->query($sql);
$todoItems = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $todoItems[] = $row['item'];
    }
}

// 가져온 목록과 POST로 전송된 데이터 출력
var_dump($todoItems);
var_dump($todoData);

// 데이터베이스 연결 닫기
$mysqli->close();
?>
