<?php
    session_start();
    session_regenerate_id();

    $title = "ユーザー登録";
?>

<?php include (dirname(__FILE__) . "/../common/admin/user/head.php"); ?>

<body>
    <nav class="navbar navbar-expand-md navbar-dark bg-secondary">
        <span class="navbar-brand">ログイン（管理者画面）</span>
    </nav>

    <!-- コンテナ -->
    <div class="container">

            <div class="row my-3">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <form action="./register_action.php" method="post">

                        <div class="form-group">
                            <label for="user">ユーザー名</label>
                            <input type="text" class="form-control" id="user" name="user">
                        </div>
                        <div class="form-group">
                            <label for="pass">パスワード</label>
                            <input type="password" class="form-control" id="pass" name="pass">
                        </div>
                        <div class="form-group">
                            <label for="family_name">ユーザー姓</label>
                            <input type="text" class="form-control" id="family_name" name="family_name">
                        </div>
                        <div class="form-group">
                            <label for="first_name">ユーザー名</label>
                            <input type="text" class="form-control" id="first_name" name="first_name">
                        </div>

                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="is_admin" name="is_admin">
                            <label for="is_admin">管理者</label>
                        </div>

                        <input type="button" value="キャンセル" class="btn btn-outline-secondary"
                            onclick="location.href='./';">
                        <input type="submit" value="登録" class="btn btn-secondary">

                    </form>
                </div>
                <div class="col-sm-3"></div>
            </div>

    </div>

    <?php  include (dirname(__FILE__) . "/../common/js/read_js.php"); ?>
</body>

</html>