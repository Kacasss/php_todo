<?php
    session_start();
    session_regenerate_id();

    require_once("../db/Database.php");
    require_once("../db/TodoItems.php");
    require_once("../common/login_check.php");
    require_once("../common/check_item_id.php");
    require_once("../common/date.php");
    require_once("../util/SaftyUtil.php");
    
    try {
        $db = new TodoItems();

        if ($db->delete($_POST["item_id"])) {
            $_SESSION["todo_done"]["success"] = "削除しました";
        } else {
            $_SESSION["todo_done"]["failure"] = "削除できませんでした";
        }

        // セッション、各内容の削除
        require_once("../common/delete_todo_err.php");
        $inputTodoItem = null;
        $todoItem = null;
        $_SESSION["todo_item"] = null;

        // search.phpから削除を押した場合の処理
        if (isset($_POST["search"]) && $_POST["search"] !== "") {
            header("Location: ./search.php?page_num=" . $_SESSION["page_num"] . "&search=" . $_POST["search"]);
            exit;
        }

        header("Location: ./?page_num=" . $_SESSION["page_num"]);
        exit;
        
    } catch (Exception $e) {
        $_SESSION["todo_err"]["exception"] = "申し訳ございません。エラーが発生しました"; 
        header("Location: ../error/todo/error.php");
        exit;
    }