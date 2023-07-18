<?php
    // ログインチェック
    if (!isset($_SESSION["user"])) {
        header("Location: ../admin/login.php");
        exit;
    } else {
        $user = $_SESSION["user"];
    }