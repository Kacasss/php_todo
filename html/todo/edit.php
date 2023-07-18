<?php
    session_start();
    session_regenerate_id();

    require_once("../db/Database.php");
    require_once("../db/TodoItems.php");
    require_once("../common/login_check.php");
    require_once("../common/date.php");
    require_once("../util/SaftyUtil.php");

    if (isset($_POST["edit"]) && $_POST["edit"] === "修正") {
        // index.phpからedit.phpへ転移した場合の処理
        $inputTodoItem = SaftyUtil::sanitize($_POST);
    } else if (isset($_SESSION["item_id"])) {
        // edit_action.phpからedit.phpへ転移した場合の処理
        $inputTodoItem["item_id"] = $_SESSION["item_id"];
    }

    // 修正ボタンクリックでの転移や、edit_action.phpからの転移ではなく、
    // 直接URLでedit.phpと入力された場合の処理
    if (!isset($inputTodoItem)) {
        header('Location: ./');
        exit;
    }

    try {
        $db = new TodoItems();
        $todo = $db->selectTodoItemById($inputTodoItem["item_id"]);
    } catch (Exception $e) {
        $_SESSION["todo_err"]["exception"] = "申し訳ございません。エラーが発生しました"; 
        header("Location: ../error/todo/error.php");
        exit;
    }

    $title = "作業更新";
    $msg = "更新";

    // エラー内容を保存
    $errMsgForm = isset($_SESSION["todo_err"]) ? $_SESSION["todo_err"] : "";

    // ページ数を保存
    $page_num = isset($_SESSION["page_num"]) ? $_SESSION["page_num"] : 1;
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
                <form action="./edit_action.php" method="post">
                    <input type="hidden" name="item_id" value="<?= $todo["id"]; ?>">
                    <input type="hidden" name="search" value="<?= isset($_POST["search"]) ? $_POST["search"] : null; ?>">

                    <div class="form-group mt-2">
                        <!-- バリデーションエラー -->
                        <?php include (dirname(__FILE__) . "/../common/todo/validation/error_msg_form/item_name.php"); ?>
                        <label for="item_name">項目名</label>
                        <input type="text" class="form-control" name="item_name" id="item_name" value="<?= $todo["item_name"]; ?>">
                    </div>

                    <div class="form-group mt-2">
                        <!-- バリデーションエラー -->
                        <?php include (dirname(__FILE__) . "/../common/todo/validation/error_msg_form/user_id.php"); ?>
                        <label for="user_id">担当者</label>
                        <p name="user_id" id="user_id"><?= $todo["family_name"]; ?><?= $todo["first_name"]; ?></p>
                        <input type="hidden" id="user_id" name="user_id" value="<?= isset($_SESSION["todo_item"]["id"]) ? $_SESSION["todo_item"]["id"] : $user["id"]; ?>">
                    </div>

                    <div class="form-group mt-2">
                        <!-- バリデーションエラー -->
                        <?php include (dirname(__FILE__) . "/../common/todo/validation/error_msg_form/expire_date.php"); ?>
                        <label for="expire_date">期限</label>
                        <input type="date" class="form-control" id="expire_date" name="expire_date" value="<?= $todo["expire_date"]; ?>">
                    </div>

                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="finished" name="finished" value="1" <?= isset($todo["finished_date"]) ? "checked" : ""; ?>>
                        <label for="finished">完了</label>
                    </div>

                    <!-- searchがある場合、search.phpへ、ない場合はindex.phpへ転移 -->
                    <?php if (isset($_POST["search"]) && $_POST["search"] !== "") : ?>
                        <input type="button" value="戻る" class="btn btn-outline-secondary" onclick="location.href='./search.php?page_num=<?= $page_num ?>&search=<?= $_POST['search'] ?>';">
                    <?php else : ?>
                        <input type="button" value="戻る" class="btn btn-outline-secondary" onclick="location.href='./?page_num=<?= $page_num ?>';">
                    <?php endif; ?>

                    <input type="submit" value="更新" class="btn btn-primary ml-2">
                </form>
            </div>
            <div class="col-sm-3"></div>
        </div>

    </div>
    <!-- bootstrap用のjsファイルと、jqueryを読み込む -->
    <?php  include (dirname(__FILE__) . "/../common/js/read_js.php"); ?>
</body>

</html>