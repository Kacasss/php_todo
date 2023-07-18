<?php
    session_start();
    session_regenerate_id();

    require_once("../db/Database.php");
    require_once("../db/Users.php");


    $db = new Users();

    if ($db->delete($_POST["user_id"])) {
        var_dump("さくじょしました");
    } else {
        var_dump("できませんでした");
    }

    header('Location: ./');
    exit;

