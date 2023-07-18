<?php
    session_start();
    session_regenerate_id();
?>
<?php include (dirname(__FILE__) . "/../../common/login_head.php"); ?>
<body>
    <nav class="navbar navbar-expand-md navbar-dark bg-primary">
        <span class="navbar-brand">TODOリスト</span>
    </nav>

    <div class="container">

        <div class="row m-3">
            <div class="col-sm-3"></div>

            <!-- 例外エラー -->
            <?php if (isset($_SESSION["todo_err"]["exception"])) : ?>
                <div class="col-sm-6 alert alert-danger alert-dismissble fade show mb-0 mt-3 p-2 form-alert" role="alert">
                    <?= $_SESSION["todo_err"]["exception"]; ?>
                    <form class="mt-4">
                        <input type="button" class="btn btn-danger" value="ログアウト"
                        onclick="location.href='../../login/todo/logout.php'">
                    </form>
                </div>
            <?php endif ?>

            <div class="col-sm-3"></div>
        </div>

    </div>
    <?php  include (dirname(__FILE__) . "/../../common/js/read_js.php"); ?>
</body>

</html>