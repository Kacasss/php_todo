<?php
    session_start();
    session_regenerate_id();
    require_once("../../util/SaftyUtil.php");

    $_SESSION["token"] = SaftyUtil::generateToken();
?>
<?php include (dirname(__FILE__) . "/../../common/login_head.php"); ?>
<body>

    <nav class="navbar navbar-expand-md navbar-dark bg-primary">
        <span class="navbar-brand">TODOリスト</span>
    </nav>

    <div class="container">

        <div class="row mx-3">
            <div class="col-sm-3"></div>

            <!-- ワンタイムトークンエラーか、フォーム入力エラーがあった場合 -->
            <?php if (isset($_SESSION["login_err"]["csrf_token"]) || isset($_SESSION["login_err"]["form_msg"])) : ?>
                <?php foreach ($err = $_SESSION["login_err"] as $key => $value) : ?>

                    <div class="col-sm-6 alert alert-danger alert-dismissble fade show mb-0 mt-3 p-2 form-alert" role="alert">
                        <!-- ワンタイムトークンエラー -->
                        <?= isset($_SESSION["login_err"]["csrf_token"]) && $err[$key] === $_SESSION["login_err"]["csrf_token"] ? $err[$key] : "" ?>
                        <!-- フォーム入力エラー -->
                        <?= isset($_SESSION["login_err"]["form_msg"]) && $err[$key] === $_SESSION["login_err"]["form_msg"] ? $err[$key] : "" ?>
                    </div>
                    
                <?php endforeach; ?>
            <?php endif ?>

            <div class="col-sm-3"></div>
        </div>

        <div class="row my-2">
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
                <form action="./login.php" method="post">
                    <input type="hidden" name="token" value="<?= $_SESSION["token"]; ?>">
                    
                    <div class="form-group mt-2">
                        <!-- ユーザー名バリデーションエラー -->
                        <?php if (isset($_SESSION["login_err"]["form_user"])) : ?>
                            <div class="alert alert-danger alert-dismissble fade show mb-0 mt-3 p-2 form-alert" role="alert">
                                <?= $_SESSION["login_err"]["form_user"]; ?>
                            </div>
                        <?php endif ?>
                        <label for="user">ユーザー名</label>
                        <input type="text" class="form-control" id="user" name="user" value="<?= isset($_SESSION["login"]["user"]) ? $_SESSION["login"]["user"] : "" ?>">
                    </div>

                    <div class="form-group mt-2">
                        <!-- パスワードバリデーションエラー -->
                        <?php if (isset($_SESSION["login_err"]["form_pass"])) : ?>
                            <div class="alert alert-danger alert-dismissble fade show mb-0 mt-3 p-2 form-alert" role="alert">
                                <?= $_SESSION["login_err"]["form_pass"]; ?>
                            </div>
                        <?php endif ?>
                        <label for="pass">パスワード</label>
                        <input type="password" class="form-control" id="pass" name="pass">
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">ログイン</button>
                </form>
            </div>
            <div class="col-sm-3"></div>
        </div>

    </div>
    <?php  include (dirname(__FILE__) . "/../../common/js/read_js.php"); ?>
</body>

</html>