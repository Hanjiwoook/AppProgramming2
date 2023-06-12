<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Todolist</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  <style>
    body {
      margin: 0;
      padding: 0;
      background-color: #e6f2ff;
    }

    .header {
      background-color: #f8f9fa;
      padding: 10px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    #clock {
      font-size: 24px;
      font-weight: bold;
    }

    .todo-list {
      width: 100px;
      height: auto;
    }

    .todo-container {
      max-width: 500px;
      margin: 20px auto;
      background-color: #fff;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .todo-item {
      width: 100%;
      box-sizing: border-box;
      margin-bottom: 10px;
    }

    .title-input {
      flex: 1;
      margin-right: 10px;
    }
    .todo-item-container{
      display: flex;
      align-items: center;
      margin-bottom: 10px;
    }

    .btn-add {
      background-color: #64b5f6;
      color: #fff;
      border: none;
      padding: 8px 16px;
      border-radius: 4px;
      cursor: pointer;
    }

    .btn-add:hover {
      background-color: #4285f4;
    }

    .delete-button {
      color: red;
      cursor: pointer;
      margin-left: 5px;
    }
  </style>
</head>

<body>
  <div class="header">
    <h1>Todolist</h1>
    <div id="clock"></div>
    <img src="todolist.jpg" alt="투두리스트" class="todo-list">
  </div>

  <!-- navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="login.todo.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="group_todo.php">group</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="logout.php">Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- navbar end -->

  <div class="todo-container">
    <h2>Todo List</h2>
    <form id="todo-form" action="group_todo_items1.php" method="post">
      <div id="todo-list">
        <!-- DB에서 가져온 데이터 출력 -->
        <?php foreach ($todoItems as $item): ?>
          <div class="todo-item-container">
            <input type="text" value="<?= $item ?>" readonly>
            <span class="delete-button">X</span>
          </div>
        <?php endforeach; ?>
      </div>
      <button type="button" id="add-todo" class="btn-add">Add Todo</button>
      <button type="submit" class="btn-add" id="save-button">Save</button>
    </form>
  </div>

  <script>
    function displayTime() {
      var now = new Date();
      var hours = now.getHours();
      var minutes = now.getMinutes();
      var seconds = now.getSeconds();

      // 12시간 형식으로 변경
      var period = hours >= 12 ? 'PM' : 'AM';
      hours = hours % 12;
      hours = hours ? hours : 12;

      // 시, 분, 초가 10보다 작을 경우 앞에 0 추가
      hours = hours < 10 ? '0' + hours : hours;
      minutes = minutes < 10 ? '0' + minutes : minutes;
      seconds = seconds < 10 ? '0' + seconds : seconds;

      // 시계 표시 엘리먼트에 시간 업데이트
      document.getElementById('clock').innerHTML = hours + ':' + minutes + ':' + seconds + ' ' + period;

      // 1초마다 시간 업데이트
      setTimeout(displayTime, 1000);
    }

    // 페이지 로드 시 시계 표시 시작
    window.onload = displayTime;

    document.addEventListener('DOMContentLoaded', function() {
      var addButton = document.getElementById('add-todo');
      var todoList = document.getElementById('todo-list');

      addButton.addEventListener('click', function(event) {
        event.preventDefault();

        var input = document.createElement('input');
        input.setAttribute('type', 'text');
        input.setAttribute('name', 'todo-item');
        input.classList.add('todo-item');

        var deleteButton = document.createElement('span');
        deleteButton.innerHTML = 'X';
        deleteButton.classList.add('delete-button');
        deleteButton.addEventListener('click', function() {
          todoList.removeChild(todoItem);
        });

        var todoItem = document.createElement('div');
        todoItem.classList.add('todo-item-container');
        todoItem.appendChild(input);
        todoItem.appendChild(deleteButton);

        todoList.appendChild(todoItem);
      });
    });

    document.addEventListener('DOMContentLoaded', function() {
      var todoForm = document.getElementById('todo-form');

      todoForm.addEventListener('submit', function(event) {
        event.preventDefault();

        var todoItems = document.querySelectorAll('.todo-item');

        var todoData = [];
        todoItems.forEach(function(item) {
          todoData.push(item.value);
        });

         // AJAX 요청 전송 (fetch API 사용)
      fetch(todoForm.action, {
        method: todoForm.method,
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(todoData)
      })
        .then(function(response) {
          if (response.ok) {
            console.log('Todo items saved successfully.');

            // 페이지 다시로드
            location.reload();
          } else {
            console.error('Request failed. Status:', response.status);
          }
        })
        .catch(function(error) {
          console.error('Request failed. Error:', error);
        });
    });
  });
  </script>
</body>

</html>
