<?php
    // ログインチェック
    if (!isset($_SESSION["user"])) {
        header("Location: ../login/todo/");
        exit;
    } else {
        $user = $_SESSION["user"];
    }