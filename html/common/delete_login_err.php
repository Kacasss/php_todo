<?php
    // ログインエラーがあった場合、削除
    if (isset($_SESSION["login_err"])) {
        $_SESSION["login_err"] = null;
        unset($_SESSION["login_err"]);
    }
