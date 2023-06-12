<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Todolist</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
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

    $(document).ready(function() {
      function addTodoItem() {
        var todoItem = `
          <div class="todo-item">
            <input type="text" class="title-input">
            <button class="btn-delete">X</button>
          </div>
        `;

        $("#todo-list").append(todoItem);
      }

      function deleteTodoItem() {
        var todoItem = $(this).closest(".todo-item");
        todoItem.remove();
      } 

      function loadTodoItems() {
        $.ajax({
          url: "todo_items.php",
          method: "GET",
          success: function(response) {
            // 받아온 할 일 목록을 화면에 출력
            $("#todo-list").html(response);
          },
          error: function(xhr, status, error) {
            console.log(error);
          }
        });
      }
      // 
      loadTodoItems();

      // Save 버튼 클릭 이벤트 핸들러
      $("#save-button").click(function() {
        var todoItems = []; //todoItems 배열을 클릭 이벤트 핸들러 내에서 정의
        // 모든 할 일 아이템을 수집
        $(".todo-item").each(function() {
          var title = $(this).find(".title-input").val();
          if (title && title.trim() !== '') { // 빈 칸이 아닐 경우에만 수집
            todoItems.push(title);
          }
        });

        // todoItems 배열을 서버로 전송
        $.ajax({
          url: "save_todo_list.php",
          type: "POST",
          data: { todoItems: todoItems },
          success: function(response) {
            // 서버로부터 응답을 받았을 때 동작할 코드 작성
            if (response === "success") {
              alert("Changes saved successfully");
            } else {
              alert("Failed to save changes");
            }
          },
          error: function() {
            alert("An error occurred while saving changes");
          }
        });
      });

      $("#add-todo").on("click", addTodoItem);

      // 할 일 삭제 코드
      $(document).on("click", ".btn-delete", deleteTodoItem);



      $("#todo-form").submit(function(event) {
        event.preventDefault();

        // 모든 할 일 아이템을 수집
        var todoItems = [];
        $(".todo-item").each(function() {
          var titleInput = $(this).find(".title-input");
          var title = titleInput.val();
          if (title && title.trim() !== '') { // 빈 값이 아닐 경우에만 수집
            todoItems.push(title);
          }
        });


        // AJAX 요청으로 데이터 전송
        $.ajax({
          url: "todo_items.php",
          method: "POST",
          data: {
            todoItems: todoItems
          },
          success: function(response) {
            // 성공적으로 저장되었을 때의 처리 추가
            // 할 일 목록을 다시 불러와서 화면에 출력
            loadTodoItems();
          },
          error: function(xhr, status, error) {
            console.log(error);
            // 저장 실패 시의 처리 추가
          }
        });
      });
    });
  </script>

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
      width: 80%;
      box-sizing: border-box;
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
    .btn-delete {
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
    <form id="todo-form" action="todo_items.php" method="post">
      <div id="todo-list"></div>
      <button type="button" id="add-todo" class="btn-add">Add Todo</button>
      <button type="submit" class="btn-add" id="save-button">Save</button>
    </form>
  </div>
</body>

</html>
