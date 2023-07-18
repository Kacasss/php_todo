<?php
    session_start();
    session_regenerate_id();

    // セッション破棄
    $_SESSION = null;
    session_destroy();
    header("Location: ./");
    exit;
?>