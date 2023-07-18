<?php
    session_start();
    session_regenerate_id();
    require_once("../../common/admin/login_check.php");

    // セッション破棄
    $_SESSION = null;
    session_destroy();
    header("Location: ./");
    exit;
?>