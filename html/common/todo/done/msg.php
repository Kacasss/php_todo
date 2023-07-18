<?php if (isset($_SESSION["todo_done"])) : ?>
    <div class="alert alert-info text-center my-4">
        <?= $_SESSION["todo_done"]["success"] ? $_SESSION["todo_done"]["success"] : $_SESSION["todo_done"]["failure"]; ?>
    </div>
<?php endif ?>
<?php
    // メッセージを削除
    require_once("../common/delete_todo.php");
?>