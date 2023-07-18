<?php
    // ログイン回数の削除
    if (isset($_SESSION["login_failure"])) {
        $_SESSION["login_failure"] = null;
        unset($_SESSION["login_failure"]);
    }