<?php
    // 管理者ではない場合は、ログイン画面へ
    if ($user["is_admin"] != 1) {
        header("Location: ./login.php");
        exit;
    }