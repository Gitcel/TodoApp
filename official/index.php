<?php

    session_start();
    $updatedTask = "";

?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">    
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="custom.css">
    <link href="https://fonts.googleapis.com/css?family=Indie+Flower" rel="stylesheet">

    <title>Todo app - Ancel</title>

</head>

<body>

    <?php require('functions.php'); ?>

    <?php 
        
        // What happens when adding a task, date ( with a countdown ). //
        if(isset($_POST['submit']) && isset($_POST['todoItem'])) {
            add_todo_item($_POST['todoItem']);
            add_todo_date($_POST['todoDate']);
            add_todo_countdown($_POST['todoDate']);          
        }

        // When a Remove button is clicked. //
        if(isset($_POST['delete'])) {
            delete_todo_item($_POST['delete']);
        }

        // When a status of the task is given. //
        if(isset($_POST['complete'])) {
            toggle_todo_item($_POST['complete']);
        }
        
        // When the list of tasks are sorted. //        
        if(isset($_POST['sort'])) {
            sortByDate();
        }
    
        // When an Edit button is clicked. //
        if(isset($_POST['edit'])) {                      
            $_SESSION['editKey'] = $_POST['edit'];            
            echo "<br><h2 style='color: red;'>Edit button pressed. Key: ".$_SESSION['editKey']."</h2><br>";            
        }

        // When the Update button is clicked. //
        if(isset($_POST['update'])) {
            echo "<br><h2 style='color: red;'>Update button pressed. Key: ".$_SESSION['editKey']."</h2><br>";  
            $updatedTask = $_POST['todoItem'];
            $_SESSION['editDate'] = "";
            
            if (!empty($_POST['todoDate'])) {
                $_SESSION['editDate'] = $_POST['todoDate'];
                echo "<br><h2 style='color: red;'>Update button pressed. Date: ".$_SESSION['editDate']."</h2><br>";
            }

            update_todo_item($_SESSION['editKey'], $updatedTask, $_SESSION['editDate']);

        }

    ?>

    <div class="container">

        <h1 class="text-center">Tasks</h1>

        <form action="" method="post">
            <!-- Check if the array is empty, before displaying anything in it. -->
            <?php if(!empty($_SESSION['todoItem'])) : ?>

                <ul class="list-group">
                    <!-- Display the tasks in the array. -->
                    <?php foreach($_SESSION['todoItem'] as $key => $item) : ?>
                        
                        <span class="date-class">
                        
                            <?php
                                
                                if ($item['date'] > Date("Y-m-d", time())) {
                                    echo "Due:  ".$item['date'];

                                } else {

                                    $item['date'] = "Expired";                                    
                                    echo $item['date'];
                                }

                                if ($item['date'] == "Expired") {
                                    $item['completed'] = 'danger';
                                }

                            ?>

                            <div class="date-time-diff-class">
                                <?php ($item['date'] != "Expired") ? add_todo_countdown($item['date']) : ''; ?>
                            </div>

                        </span>

                        <li class="list-group-item list-group-item-<?php echo $item['completed']; ?>">
                            
                            <span class="task-class">
                                <?php
                                    
                                    echo $item['item'];
                                    
                                ?>
                            </span>

                                <?php if ($item['date'] != "Expired") : ?>
                            <button type="submit" class="btn btn-success float-right" name="complete" value="<?php echo $key; ?>"><?php echo ($item['completed'] == '') ? 'Done' : 'Undo'; ?></button>
                                <?php endif; ?>

                            <button type="submit" class="btn btn-danger float-right" name="delete" value="<?php echo $key; ?>">Remove</button>
                            <button type="submit" class="btn btn-danger float-right" name="edit" value="<?php echo $key; ?>">Edit</button>

                        </li>

                    <?php endforeach; ?>

                </ul>

            <?php endif; ?>
        
            <div class="form-group">
                <label for="todoDate" class="form-control-label">Set a date</label>
                <input type="date" class="form-control" name="todoDate">
                <label for="todoItem" class="form-control-label">Task description</label>
                <input type="text" class="form-control" name="todoItem"  value="<?php echo isset($_POST['edit']) ? $_SESSION['todoItem'][$_POST['edit']]['item'] : '' ?>" placeholder="What is your plan?...">
            </div>
            
            <button type="submit" class="btn btn-primary" name=<?php echo isset($_POST['edit']) ? "update" : "submit" ?> value="submit"><?php echo isset($_POST['edit']) ? "Update task" : "Add task"; ?></button>
            <button type="submit" class="btn btn-primary" name="sort" value="submit">Sort by earliest</button>

        </form>

    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    <!-- The codes below was my visual way of debugging. -->
    <pre style="color: white; font-size: 18px;"><?php
        //unset($_SESSION['todoItem']);
        //print_r($_SESSION['todoItem']);
        //print_r($_POST['edit']);
        //print_r($updatedTask);
        //print_r($_POST['todoItem']);
    ?></pre>

</body>

</html>