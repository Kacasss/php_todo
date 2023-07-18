<?php
    session_start();
    session_regenerate_id();

    require_once("../db/Database.php");
    require_once("../db/Users.php");
    // require_once("../common/login_check.php");
    // require_once("../common/date.php");

    // 管理者にチェックがある場合の処理
    $inputUser["is_admin"] = isset($_POST["is_admin"]) ? "1" : "0";

    $db = new Users();

    $afterPasswordHash = password_hash($_POST["pass"], PASSWORD_DEFAULT);

    $user = [
        "user" => $_POST["user"],
        "pass" => $afterPasswordHash,
        "family_name" => $_POST["family_name"],
        "first_name" => $_POST["first_name"],
        "is_admin" => $inputUser["is_admin"]
    ];


    if($db->add($user)) {
        var_dump("とうろくしました");
    } else {
        var_dump("できませんでした");
    }

    header('Location: ./');
    exit;
    