<?php
    session_start();
    session_regenerate_id();

    require_once("../db/Database.php");
    require_once("../db/Users.php");
    require_once("../common/login_check.php");
    require_once("../common/check_user_id.php");


    // 管理者にチェックがある場合の処理
    $inputUser["is_admin"] = isset($_POST["is_admin"]) ? "1" : "0";

    $afterPasswordHash = password_hash($_POST["pass"], PASSWORD_DEFAULT);


    $user = [
        "id" => $_POST["user_id"],
        "user" => $_POST["user"],
        "pass" => $afterPasswordHash,
        "family_name" => $_POST["family_name"],
        "first_name" => $_POST["first_name"],
        "is_admin" => $inputUser["is_admin"]
    ];

    $db = new Users();

    if($db->update($user)) {
        var_dump("とうろくしました");
    } else {
        var_dump("できませんでした");
    }


    header('Location: ./');
    exit;
        