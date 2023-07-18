<?php
    session_start();
    session_regenerate_id();

    require_once("../common/login_check.php");
    require_once("../common/date.php");

    $title = "作業登録";
    $msg = "登録";

    // エラーフォームを保存
    $errMsgForm = isset($_SESSION["todo_err"]) ? $_SESSION["todo_err"] : "";
?>
<!-- html～headタグ読み込み -->
<?php include (dirname(__FILE__) . "/../common/todo/head.php"); ?>
<body>
    <!-- ナビゲーション -->
    <?php include (dirname(__FILE__) . "/../common/todo/nav.php"); ?>
    <!-- コンテナ -->
    <div class="container">
        <!-- メッセージ -->
        <?php include (dirname(__FILE__) . "/../common/todo/msg.php"); ?>
        <!-- フォームエラー-->
        <?php include (dirname(__FILE__) . "/../common/todo/validation/error_msg_form/msg.php"); ?>

        <!-- 入力フォーム -->
        <div class="row m-3">
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
                <form action="./entry_action.php" method="post">
                    <div class="form-group mt-2">
                        <!-- バリデーションエラー -->
                        <?php include (dirname(__FILE__) . "/../common/todo/validation/error_msg_form/item_name.php"); ?>
                        <label for="item_name">項目名</label>
                        <input type="text" class="form-control" id="item_name" name="item_name" value="<?= isset($_SESSION["todo_item"]["item_name"]) ? $_SESSION["todo_item"]["item_name"] : "" ?>">
                    </div>

                    <div class="form-group mt-2">
                        <!-- バリデーションエラー -->
                        <?php include (dirname(__FILE__) . "/../common/todo/validation/error_msg_form/user_id.php"); ?>
                        <label for="user_id">担当者</label>
                        <p name="user_id" id="user_id"><?= $user["family_name"]; ?><?= $user["first_name"]; ?></p>
                        <input type="hidden" id="user_id" name="user_id" value="<?= isset($_SESSION["todo_item"]["id"]) ? $_SESSION["todo_item"]["id"] : $user["id"]; ?>">
                    </div>

                    <div class="form-group mt-2">
                        <!-- バリデーションエラー -->
                        <?php include (dirname(__FILE__) . "/../common/todo/validation/error_msg_form/expire_date.php"); ?>
                        <label for="expire_date">期限</label>
                        <input type="date" class="form-control" id="expire_date" name="expire_date" value="<?= isset($_SESSION["todo_item"]["expire_date"]) ? $_SESSION["todo_item"]["expire_date"] : $date; ?>">
                    </div>

                    <div class="form-group form-check mt-2">
                        <input type="checkbox" class="form-check-input" id="finished" name="finished" value="1" <?= isset($_SESSION["todo_item"]["finished_date"]) ? "checked" : ""; ?>>
                        <label for="finished">完了</label>
                    </div>

                    <input type="button" value="戻る" class="btn btn-outline-secondary"
                        onclick="location.href='./';">
                    <input type="submit" value="登録" class="btn btn-primary ml-2">
                </form>
            </div>
            <div class="col-sm-3"></div>
        </div>

    </div>
    <!-- bootstrap用のjsファイルと、jqueryを読み込む -->
    <?php  include (dirname(__FILE__) . "/../common/js/read_js.php"); ?>
</body>

</html>