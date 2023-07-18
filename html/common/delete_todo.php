<?php
    if (isset($_SESSION["todo_done"])) {
        $_SESSION["todo_done"] = null;
        unset($_SESSION["todo_done"]);
    }
?>
