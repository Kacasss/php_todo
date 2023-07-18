<?php
    // フォームでuser_idが存在しない場合、リダイレクト
    if (!isset($_POST["user_id"])) {
        header('Location: ./');
        exit;
    }
