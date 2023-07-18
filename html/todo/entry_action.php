<?php
    session_start();
    session_regenerate_id();

    require_once("../db/Database.php");
    require_once("../db/TodoItems.php");
    require_once("../validation/Validation.php");
    require_once("../common/login_check.php");
    require_once("../common/delete_todo_err.php");
    require_once("../common/delete_todo.php");
    require_once("../common/date.php");
    require_once("../util/SaftyUtil.php");

    // サニタイズを行う
    $inputTodoItem = SaftyUtil::sanitize($_POST);

    // サニタイズ後のフォーム入力内容をセッションに保存
    $_SESSION["todo_item"] = $inputTodoItem;

    // フォーム入力チェック
    $formErr = Validation::validateForm($inputTodoItem);

    // フォーム入力でエラーがある場合
    if (isset($formErr) && 0 < count($formErr)) {

        if (isset($formErr["item_name"])) {
            $_SESSION["todo_err"]["form_item_name"] = $formErr["item_name"];
        }

        if (isset($formErr["user_id"])) {
            $_SESSION["todo_err"]["form_user_id"] = $formErr["user_id"];
        }

        if (isset($formErr["expire_date"])) {
            $_SESSION["todo_err"]["form_expire_date"] = $formErr["expire_date"];
        }

        header('Location: ./entry.php');
        exit;
    }

    // 項目名が100文字より大きい場合、エラー処理
    if (Validation::validateFormLength($inputTodoItem["item_name"])) {
        $_SESSION["todo_err"]["form_msg"] = "100文字以内の入力にしてください";
    }

    // ログイン中のユーザーと一致しているか確認
    if ($inputTodoItem["user_id"] != $user["id"]) {
        $_SESSION["todo_err"]["form_msg"] = "ユーザーが一致しません";
    }

    // 日付のチェック
    if (!Validation::validateDate($inputTodoItem["expire_date"])) {
        $_SESSION["todo_err"]["form_msg"] = "日付が正しくありません";
    }

    // 完了チェックありの場合は1が入っているか確認
    if (isset($inputTodoItem["finished"]) && $inputTodoItem["finished"] != 1) {
        $_SESSION["todo_err"]["form_msg"] = "完了のチェックボックスの値が正しくありません。";
    }

    // エラーがある場合は、処理を中断
    if (isset($_SESSION["todo_err"]) && 0 < count($_SESSION["todo_err"])) {
        header('Location: ./entry.php');
        exit;
    }

    // 完了にチェックがある場合の処理
    $inputTodoItem["finished"] = isset($inputTodoItem["finished"]) && $inputTodoItem["finished"] == 1 ? $date : null;

    // 追加用の配列を用意
    $todoItem = [
        "user_id" => $inputTodoItem["user_id"],
        "item_name" => $inputTodoItem["item_name"],
        "expire_date" => $inputTodoItem["expire_date"],
        "registration_date" => $date,
        "finished_date" => $inputTodoItem["finished"]
    ];

    try {
        $db = new TodoItems();

        if ($db->add($todoItem)) {
            $_SESSION["todo_done"]["success"] = "登録しました";
        } else {
            $_SESSION["todo_done"]["failure"] = "登録できませんでした";
        }

        // セッション、各内容の削除
        require_once("../common/delete_todo_err.php");
        $inputTodoItem = null;
        $todoItem = null;
        $_SESSION["todo_item"] = null;

        header('Location: ./');
        exit;
  
    } catch (Exception $e) {
        $_SESSION["todo_err"]["exception"] = "申し訳ございません。エラーが発生しました"; 
        header("Location: ../error/todo/error.php");
        exit;
    }