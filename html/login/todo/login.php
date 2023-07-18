<?php
    session_start();
    session_regenerate_id();

    require_once("../../db/Database.php");
    require_once("../../db/Users.php");
    require_once("../../util/SaftyUtil.php");
    require_once("../../validation/Validation.php");
    require_once("../../common/delete_login_err.php");

    // ワンタイムトークンのチェック
    if (!isset($_POST["token"]) || !(SaftyUtil::isValidToken($_SESSION["token"], $_POST["token"]))) {
        $_SESSION["login_err"]["csrf_token"] = "不正な処理が行われました";
        $_SESSION["login_failure"]++;
        header("Location: ./");
        exit;
    }

    // サニタイズを行う
    $post = SaftyUtil::sanitize($_POST);

    // セッションにログイン失敗がなければ、回数を0に初期化
    if (!isset($_SESSION["login_failure"])) {
        $_SESSION["login_failure"] = 0;
    }

    // ログインに3回失敗し、4回目にログインしようとした時
    if (isset($_SESSION["login_failure"]) && 3 <= $_SESSION["login_failure"]) {
        $_SESSION["login_failure_err"] = "ログインできません";
        header("Location: ../../error/error.php");
        exit;
    }

    // フォーム入力をセッションに保存
    $_SESSION["login"] = $_POST;

    // フォーム入力チェック
    $formErr = Validation::validateFormByUserAndPass($post["user"], $post["pass"]);

    // フォーム入力でエラーがある場合
    if (!empty($formErr) || 0 < count($formErr)) {
        if (isset($formErr["user"])) {
            $_SESSION["login_err"]["form_user"] = $formErr["user"];
        }

        if (isset($formErr["pass"])) {
            $_SESSION["login_err"]["form_pass"] = $formErr["pass"];
        }

        $_SESSION["login_failure"]++;
        header("Location: ./");
        exit;
    }

    try {
        $db = new Users();
        $user = $db->getUser($post["user"], $post["pass"]);

        // DBにユーザーが存在しない場合
        if (empty($user)) {
            $_SESSION["login_err"]["form_msg"] = "ユーザー名、またはパスワードが違います";
            $_SESSION["login_failure"]++;
            header("Location: ./");
            exit;
        }

        // ログイン成功の場合、ユーザーを格納し、ログインエラーを削除
        $_SESSION["user"] = $user;
        require_once("../../common/delete_login_err.php");
        require_once("../../common/delete_login_failure.php");
        header("Location: ../../todo/");
        exit;

    } catch (Exception $e) {
        $_SESSION["login_err"]["exception"] = "申し訳ございません。エラーが発生しました"; 
        $_SESSION["login_failure"]++;
        header("Location: ../../error/error.php");
        exit;
    }

?>