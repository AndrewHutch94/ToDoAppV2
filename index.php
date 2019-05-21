<?php
$errors = "";
    
    //CONNECT TO THE DATABASE:
    $db = mysqli_connect('localhost', 'root', '', 'todolist');

    $sql = "CREATE TABLE tasks (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        task VARCHAR(50),
        duedate VARCHAR(50),
        active VARCHAR(50)
        )";

    if(isset($_POST['submit'])) {

        $due = $_POST['duedate'];
        $task = $_POST['task'];
        
        if(empty($task)){
            $errors = "In order to submit, please add a task.";
        } else {
            mysqli_query($db, "INSERT INTO tasks (task, duedate) VALUES ('$task', '$due')");
            header('location: index.php');
        }
    }

    //TO DELETE A TASK:
    if(isset($_GET['del_task'])) {
        
        $id = $_GET['del_task'];
        mysqli_query($db, "DELETE FROM tasks WHERE id=$id");
        header('location: index.php');
    }
    
    $tasks = mysqli_query($db, "SELECT * FROM tasks ORDER BY task");

    //TO UPDATE A TASK:
    if(isset($_POST['update'])) {
        
        $uTask = $_POST['uTask'];
        $uDate = $_POST['uDate'];
        $upT = $_POST['upT'];

        if($_POST['update']) {
            
            $sql = "UPDATE tasks SET task='$uTask', due='$uDate' WHERE id='$upT'";
            
            if ($db->query($sql) === TRUE) {
                echo "Task updated successfully <br>";
                header('location: index.php');

            } else {
                echo "Error: " . $sql . "<br>" . $db->error;
            }

        }
    }
?>

<!DOCTYPE html>
    <html lang="en">
    
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>To Do App</title>
        <link rel="stylesheet" type="text/css" href="style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
            integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>

<body style = "text-align:center;">
    
<nav class="navbar navbar-dark bg-dark" style="width: 100%;">
        <h1><a class="navbar-brand" style="color:#ADD8E6;">Personal To-Do List Application</a></h1>
    </nav>

    <div class="heading">
        <h2>Add Something to Your List</h2>
    </div>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <?php if (isset($errors)){ ?>
            <p><?php echo $errors; ?></p>
        <?php  }?>
        
        <input type="text" name="task" class="task_input" placeholder="Add a Task"><br><br>
        <input type="date" id="start" name="duedate" class="task_input" min="2019-05-21" max="2020-12-31"><br><br>
        <button type="submit" class="task_btn" name="submit">Add Task</button><br><br>
        
        <h4 class="tasks-update">Update Your Tasks Here</h4>
            
        <div class="content">
            <input type="text" name="upT" class="task_input" placeholder="Insert Task Number"><br><br>
            <input type="text" name="uTask" class="task_input"placeholder="Update Task Here"><br><br>
            <input type="date" id="update" name="uDate" class="task_input" min="2019-05-21" max="2019-12-31"><br><br>
            <button type="submit" class="task_btn" name="update">Update!</button>
        </div>
        </form>
      
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Task</th>
                    <th>Due Date</th>
                    <th>Delete</th>
                </tr>
            </thead>

          <tbody>
                <?php
                 while($row = mysqli_fetch_array($tasks)){ ?>

                    <tr>
                    <td><?php echo $row['id'];?></td>
                    <td class="task"><?php echo $row['task'];?></td>
                    <td class="due"><?php echo $row['duedate'];?></td>
                    <td class="delete">
                        <a href="index.php?del_task= <?php echo $row['id'];?>">x</a>
                    </td>
                </tr>
                <?php }; ?>
          </tbody>
        </table>

</body>
</html>