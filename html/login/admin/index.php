<?php
    session_start();
    session_regenerate_id();

    $title = "ログイン（管理者画面）";
?>

<?php include (dirname(__FILE__) . "/../../common/admin/login/head.php"); ?>

<body>
    <nav class="navbar navbar-expand-md navbar-dark bg-secondary">
        <span class="navbar-brand">ログイン（管理者画面）</span>
    </nav>

    <div class="container">

        <div class="row my-2">
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
                <form action="./login.php" method="post">

                    <div class="form-group mt-2">
                        <label for="user">ユーザー名</label>
                        <input type="text" class="form-control" id="user" name="user">
                    </div>

                    <div class="form-group mt-2">
                        <label for="pass">パスワード</label>
                        <input type="password" class="form-control" id="pass" name="pass">
                    </div>

                    <button type="submit" class="btn btn-secondary mt-3">ログイン</button>
                </form>
                <a href="../../admin/register.php" class="btn btn-outline-secondary mt-3">ユーザー登録はこちら</a>
            </div>
            <div class="col-sm-3"></div>
        </div>


    </div>
    <?php  include (dirname(__FILE__) . "/../../common/js/read_js.php"); ?>
</body>

</html>