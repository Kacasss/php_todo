<?php
    session_start();
    session_regenerate_id();

    require_once("../../db/Database.php");
    require_once("../../db/Users.php");

    $db = new Users();
    $user = $db->getUser($_POST["user"], $_POST["pass"]);
    
    // 管理者権限がない場合、ユーザーログインせずに、TODOリスト用のログインフォームに飛ばす
    if ($user["is_admin"] == 0) {
        header("Location: ../todo/");
        exit;
    }

    // ログイン成功の場合、ユーザーを格納し、ログインエラーを削除
    $_SESSION["user"] = $user;

    header("Location: ../../admin/");
    exit;
?>