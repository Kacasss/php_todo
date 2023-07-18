<?php
    session_start();
    session_regenerate_id();

    require_once("../db/Database.php");
    require_once("../db/Users.php");
    require_once("../common/login_check.php");
    require_once("../common/check_user_id.php");


    $title = "ユーザー削除";

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

        <div class="row m-4">
            <div class="col-sm-3"></div>
            <div class="col-sm-6 alert alert-info">
                下記の項目を削除します。よろしいですか？
            </div>
            <div class="col-sm-3"></div>
        </div>







        <!-- 入力フォーム -->
        <div class="row my-3">
            <div class="col-sm-3"></div>

            <div class="col-sm-6">
                <form action="./delete_action.php" method="post">
                    <input type="hidden" name="user_id" value="<?= $getUser["id"]; ?>">

                    <div class="form-group">
                        <label for="user" class="my-1">ユーザー</label>
                        <p name="user" id="user"><?= $getUser["user"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label for="family_name">ユーザー姓</label>
                        <p name="family_name" id="family_name"><?= $getUser["family_name"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label for="first_name">ユーザー名</label>
                        <p name="first_name" id="first_name"><?= $getUser["first_name"]; ?></p>
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="is_admin" name="is_admin" value="<?= $getUser["is_admin"] == "1" ? "1" : ""; ?>" <?= $getUser["is_admin"] == "1" ? "checked" : ""; ?>  disabled>
                        <label for="is_admin">管理者</label>
                    </div>

                    <input type="submit" value="削除" class="btn btn-secondary">
                    <input type="button" value="キャンセル" class="btn btn-outline-secondary"
                        onclick="location.href='./';">

                </form>
            </div>

            <div class="col-sm-3"></div>
        </div>



        <!-- 入力フォーム ここまで -->

    </div>
    <!-- コンテナ ここまで -->

    <!-- 必要なJavascriptを読み込む -->
    <script src="../js/jquery-3.4.1.min.js"></script>
    <script src="../js/bootstrap.bundle.min.js"></script>

    <script>
        const submitBtn = document.getElementById("submit-btn");

        submitBtn.addEventListener("click", (e) => {
            // デフォルトのイベントをキャンセル
            e.preventDefault();

            // 削除ウィンドウを表示し、OKなら削除、キャンセルなら何もしない
            if(confirm("本当に削除してよろしいですか？")) {
                document.delete_form.submit();
                return;
            }
        });
    </script>

</body>

</html>