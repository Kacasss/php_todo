<?php
    session_start();
    session_regenerate_id();

    require_once("../db/Database.php");
    require_once("../db/TodoItems.php");
    require_once("../common/login_check.php");
    require_once("../common/check_item_id.php");
    require_once("../common/date.php");
    require_once("../util/SaftyUtil.php");

    // サニタイズ処理
    $inputTodoItem = SaftyUtil::sanitize($_POST);

    try {
        $db = new TodoItems();
        $todo = $db->selectTodoItemById($inputTodoItem["item_id"]);
    } catch (Exception $e) {
        $_SESSION["todo_err"]["exception"] = "申し訳ございません。エラーが発生しました"; 
        header("Location: ../error/todo/error.php");
        exit;
    }

    $title = "作業削除";
    $msg = "削除";

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

        <!-- 入力フォーム -->
        <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
                <form action="./delete_action.php" method="post" name="delete_form">
                    <input type="hidden" name="item_id" value="<?= $todo["id"]; ?>">
                    <input type="hidden" name="search" value="<?= isset($_POST["search"]) ? $_POST["search"] : ""; ?>">

                    <div class="form-group m-0">
                        <label for="item_name">項目名</label>
                        <p name="item_name" id="item_name"><?= $todo["item_name"]; ?></p>
                    </div>

                    <div class="form-group">
                        <label for="user_id">担当者</label>
                        <p name="user_id" id="user_id"><?= $todo["family_name"]; ?><?= $todo["first_name"]; ?></p>
                    </div>

                    <div class="form-group">
                        <label for="expire_date">期限</label>
                        <p id="expire_date" name="expire_date"><?= $todo["expire_date"]; ?></p>
                    </div>

                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="finished" name="finished" value="1" <?= isset($todo["finished_date"]) ? "checked" : ""; ?> disabled>
                        <label for="finished">完了</label>
                    </div>

                    <!-- searchがある場合、search.phpへ、ない場合はindex.phpへ転移 -->
                    <?php if (isset($_POST["search"]) && $_POST["search"] !== "") : ?>
                        <input type="button" value="戻る" class="btn btn-outline-secondary" onclick="location.href='./search.php?page_num=<?= $page_num ?>&search=<?= $_POST['search'] ?>';">
                    <?php else : ?>
                        <input type="button" value="戻る" class="btn btn-outline-secondary" onclick="location.href='./?page_num=<?= $page_num ?>';">
                    <?php endif; ?>

                    <input type="submit" value="削除" class="btn btn-danger ml-2" id="submit-btn">
                </form>
            </div>
            <div class="col-sm-3"></div>
        </div>

    </div>
    <!-- bootstrap用のjsファイルと、jqueryを読み込む -->
    <?php  include (dirname(__FILE__) . "/../common/js/read_js.php"); ?>
    <!-- 削除ボタンをクリックした時の動作 -->
    <script src="../js/delete.js"></script>
</body>

</html>