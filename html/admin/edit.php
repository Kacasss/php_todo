<?php
    session_start();
    session_regenerate_id();

    require_once("../db/Database.php");
    require_once("../db/Users.php");
    require_once("../common/login_check.php");
    require_once("../common/check_user_id.php");
    require_once("../common/date.php");

    $title = "ユーザー更新";


    $db = new Users();
    $getUser = $db->selectUserById($_POST["user_id"]);

?>

<?php include (dirname(__FILE__) . "/../common/admin/head.php"); ?>

<body>
    <!-- ナビゲーション -->
    <?php include (dirname(__FILE__) . "/../common/admin/nav.php"); ?>
    <!-- ナビゲーション ここまで -->

    <!-- コンテナ -->
    <div class="container">

        <!-- 入力フォーム -->
        <div class="row my-3">
            <div class="col-sm-3"></div>

            <div class="col-sm-6">
                <form action="./edit_action.php" method="post">
                    <input type="hidden" name="user_id" value="<?= $getUser["id"]; ?>">

                    <div class="form-group">
                        <label for="user">ユーザー名</label>
                        <input type="text" class="form-control" id="user" name="user" value="<?= $getUser["user"]; ?>">
                    </div>
                    <div class="form-group">
                        <label for="pass">パスワード</label>
                        <input type="password" class="form-control" id="pass" name="pass">
                    </div>
                    <div class="form-group">
                        <label for="family_name">ユーザー姓</label>
                        <input type="text" class="form-control" id="family_name" name="family_name" value="<?= $getUser["family_name"]; ?>">
                    </div>
                    <div class="form-group">
                        <label for="first_name">ユーザー名</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" value="<?= $getUser["first_name"]; ?>">
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="is_admin" name="is_admin" value="<?= $getUser["is_admin"] == "1" ? "1" : ""; ?>" <?= $getUser["is_admin"] == "1" ? "checked" : ""; ?>>
                        <label for="is_admin">管理者</label>
                    </div>

                    <input type="submit" value="更新" class="btn btn-secondary">
                    <input type="button" value="キャンセル" class="btn btn-outline-secondary"
                        onclick="location.href='./';">

                </form>
            </div>

            <div class="col-sm-3"></div>
        </div>
        <!-- 入力フォーム ここまで -->

    </div>
    <!-- コンテナ ここまで -->
    <?php  include (dirname(__FILE__) . "/../common/read_js.php"); ?>
</body>

</html>