<?php
    // フォームでitem_idが存在しない場合、リダイレクト
    if (!isset($_POST["item_id"])) {
        header('Location: ./');
        exit;
    }