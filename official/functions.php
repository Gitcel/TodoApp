<?php
    // Function to add a tasks / items. //
    function add_todo_item($item) {

        end(($_SESSION['todoItem']));
        $key = key($_SESSION['todoItem']);
        $_SESSION['todoItem'][$key + 1]['item'] = $item;
        $_SESSION['todoItem'][$key + 1]['completed'] = '';

    }
    // Function to delete a tasks / items. //
    function delete_todo_item($item) {

        unset($_SESSION['todoItem'][$item]);

    }
    // Function to add a due dates. //
    function add_todo_date($date) {

        $currentDate = Date("d-m-y", time());

        end($_SESSION['todoItem']);
        $key = key($_SESSION['todoItem']);

        $_SESSION['todoItem'][$key]['date'] = $date;

    }
    // Function to calculate countdowns between current and due dates. //
    function add_todo_countdown($date) {

        $setDate = $date;
        $currentDate = Date("Y-m-d", time());
        $date = new DateTime($setDate);
        $date2 = new DateTime($currentDate);
        $timeDiff = $date -> diff($date2);

        end($_SESSION['todoItem']);
        $key = key($_SESSION['todoItem']);

        echo $_SESSION['todoItem'][$key]['dateCountdown'] = $timeDiff -> format('%d days %m months %y years left.');

    }
    // Function to change button color. //
    function toggle_todo_item($item) {

        if ($_SESSION['todoItem'][$item]['completed'] == '') {

            $_SESSION['todoItem'][$item]['completed'] = 'success';
            return;
            
        }

        $_SESSION['todoItem'][$item]['completed'] = '';

    }
    // Function to sort the tasks / items. //
    function sortByDate() {

        $keys = array_column($_SESSION['todoItem'], 'date');
        $sorted = array_multisort($keys, SORT_ASC, $_SESSION['todoItem']);

    }
    // Function to update a task / item. //
    function update_todo_item($key, $item) {

        $_SESSION['todoItem'][$key]['item'] = $item;

    }
 
?>