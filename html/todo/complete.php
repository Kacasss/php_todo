<?php
    session_start();
    session_regenerate_id();

    require_once("../db/Database.php");
    require_once("../db/TodoItems.php");
    require_once("../common/login_check.php");
    require_once("../common/date.php");
    require_once("../util/SaftyUtil.php");

    // サニタイズを行う
    $inputTodoItem = SaftyUtil::sanitize($_POST);

    // 変数に保存
    $todoItem = [
        "id" => $inputTodoItem["item_id"],
        "finished_date" => $date
    ];

    try {
        $db = new TodoItems();

        if ($db->doneFinishedDateByID($todoItem)) {
            $_SESSION["todo_done"]["success"] = "完了しました";
        } else {
            $_SESSION["todo_done"]["failure"] = "完了できませんでした";
        }

        // search.phpで検索を押した場合の処理
        if (isset($_POST["search"]) && $_POST["search"] !== "") {
            header("Location: ./search.php?search=" . $_POST["search"] . "&page_num=" . $_SESSION["page_num"]);
            exit;
        }

        // セッション、各内容の削除
        require_once("../common/delete_todo_err.php");
        $inputTodoItem = null;
        $todoItem = null;
        $_SESSION["todo_item"] = null;

        header("Location: ./?page_num=" . $_SESSION["page_num"]);
        exit;
        
    } catch (Exception $e) {
        $_SESSION["todo_err"]["exception"] = "申し訳ございません。エラーが発生しました"; 
        header("Location: ../error/todo/error.php");
        exit;
    }

