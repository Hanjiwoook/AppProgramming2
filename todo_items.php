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

// 새로운 데이터 저장
$success = true;
$uniqueItems = array_unique($todoItems);
foreach ($uniqueItems as $item) {
    $item = trim($item);
    if (!empty($item)) {
        $insertQuery = "INSERT INTO todo_items (title) VALUES ('$item')";
        if (!$mysqli->query($insertQuery)) {
            $success = false;
            break;
        }
    }
}

if (!$success) {
    echo "Failed to save changes";
    exit;
}

// 할 일 목록 가져오기
$selectQuery = "SELECT * FROM todo_items";
$result = $mysqli->query($selectQuery);
if (!$result) {
    die("Error fetching todo items: " . $mysqli->error);
}

// 할 일 목록 출력
while ($row = $result->fetch_assoc()) {
    echo '<div class="todo-item">';
    echo '<span class="title">' . $row['title'] . '</span>';
    echo '<button class="btn-delete" data-id="' . $row['id'] . '">X</button>';
    echo '</div>';
}

$mysqli->close();
?>
