<?php
    // todoエラーがあった場合、削除
    if (isset($_SESSION["todo_err"])) {
        $_SESSION["todo_err"] = null;
        unset($_SESSION["todo_err"]);
    }
?>
