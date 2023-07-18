<?php
    session_start();
    session_regenerate_id();

    require_once("../db/Database.php");
    require_once("../db/TodoItems.php");
    require_once("../util/Pagination.php");
    require_once("../common/login_check.php");
    require_once("../common/date.php");
    require_once("../common/delete_todo_err.php");

    // 追加・更新・完了・削除時のメッセージを保存
    $todoDone = isset($_SESSION["todo_done"]) ? $_SESSION["todo_done"] : "";

    // 入力したキーワードを変数に代入
    $search = $_GET["search"];

    if (isset($search)) {
        $todoItem = [
            "item_name" => $search,
            "family_name" => $search,
            "first_name" => $search,
        ];
    }

    try {
        $db = new TodoItems();
        $todos = $db->searchTodoItemByKeyword($todoItem);
    } catch (Exception $e) {
        $_SESSION["todo_err"]["exception"] = "申し訳ございません。エラーが発生しました"; 
        header('Location: ../error/todo/error.php');
        exit;
    }

    // ペジネーション
    $_SESSION["page_num"] = isset($_GET["page_num"]) ? $_GET["page_num"] : 1;
    $page_num = $_SESSION["page_num"];

    $returnTodosArray = Pagination::paginateTodoItems($todos, $page_num);
    $max_page = $returnTodosArray["max_page"];
    $now_page = $returnTodosArray["now_page"];
    $todos = $returnTodosArray["todos"];

    $title = "作業一覧";
?>
<!-- html～headタグ読み込み -->
<?php include (dirname(__FILE__) . "/../common/todo/head.php"); ?>
<body>
    <!-- ナビゲーション -->
    <?php include (dirname(__FILE__) . "/../common/todo/nav.php"); ?>
    <!-- コンテナ -->
    <div class="container">
        <!-- メッセージ成功 追加・修正・完了・削除 -->
        <?php include (dirname(__FILE__) . "/../common/todo/done/msg.php"); ?>

        <table class="table table-striped table-hover table-sm my-4 text-center">
            <!-- theadタグ -->
            <?php include (dirname(__FILE__) . "/../common/todo/thead.php"); ?>
            <tbody>
                <?php if (0 < count($todos)) : ?>

                    <?php foreach ($todos as $todo) : ?>
                        <?php
                            $tr = "";

                            if ($todo["expire_date"] < $date && is_null($todo["finished_date"])) {
                                // 期限日が過去日で、完了日が未の場合、文字を赤くする
                                $tr = "text-danger";
                            } elseif (isset($todo["finished_date"])) {
                                // 完了日に日付がある場合
                                $tr = "del";
                            } 
                        ?>

                        <tr class="<?= $tr ?>">
                            <td class="align-middle"><!-- 項目名 -->
                                <?= $todo["item_name"]; ?>
                            </td>
                            <td class="align-middle"><!-- 担当者 -->
                                <?= $todo["family_name"]; ?><?= $todo["first_name"]; ?>
                            </td>
                            <td class="align-middle"><!-- 登録日 -->
                                <?= $todo["registration_date"]; ?>
                            </td>
                            <td class="align-middle"><!-- 期限日 -->
                                <?= $todo["expire_date"]; ?>
                            </td>
                            <td class="align-middle"><!-- 完了日 -->
                                <?= isset($todo["finished_date"]) ? $todo["finished_date"] : "未"; ?>
                            </td>

                            <!-- ログイン中のユーザーか、管理者の場合は操作可能 -->
                            <?php if (($user["id"] == $todo["user_id"]) || $user["is_admin"] == 1) : ?> 

                                <td class="align-middle button">
                                    <!-- 完了ボタン -->
                                    <form action="./complete.php" method="post" class="form my-sm-1">
                                        <input type="hidden" name="item_id" value="<?= $todo["id"]; ?>">
                                        <input type="hidden" name="search" value="<?= $search; ?>">

                                        <?php if (isset($todo["finished_date"])) : ?> 
                                            <!-- 完了日に日付がある場合、完了ボタンは押せない -->
                                            <input type="submit" value="完了" class="btn btn-outline-success my-0 btn-disabled" disabled>
                                        <?php else : ?> 
                                            <!-- 完了日が未の場合、完了ボタンを押せる -->
                                            <input type="submit" value="完了" class="btn btn-success my-0 submit-btn">
                                        <?php endif; ?>
                                    </form>

                                    <!-- 修正ボタン -->
                                    <form action="./edit.php" method="post" class="form my-sm-1">
                                            <input type="hidden" name="item_id" value="<?= $todo["id"]; ?>">
                                            <input type="hidden" name="search" value="<?= $search; ?>">
                                            <input type="submit" value="修正" class="btn btn-primary my-0" name="edit">
                                    </form>

                                    <!-- 削除ボタン -->
                                    <form action="./delete.php" method="post" class="form my-sm-1">
                                        <input type="hidden" name="item_id" value="<?= $todo["id"]; ?>">
                                        <input type="hidden" name="search" value="<?= $search; ?>">
                                        <input type="submit" value="削除" class="btn btn-danger my-0">
                                    </form>
                                </td>

                            <?php else : ?> 
                                <!-- 管理者ではなく、他ユーザーの場合は、操作が出来ない為、操作ボタンを出さない -->
                                <td class="align-middle py-4"></td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach ?>
                    
                <?php else : ?> 
                    <!-- レコードが0個の場合 -->
                    <tr class="align-middle py-4"></tr>
                <?php endif; ?>
            </tbody>
        </table>
        <!-- ペジネーション -->
        <?php  include (dirname(__FILE__) . "/../common/todo/pagination/pagination_search.php"); ?>

        <!-- 検索のとき、戻るボタンを表示する -->
        <?php include (dirname(__FILE__) . "/../common/todo/goback.php"); ?>
    </div>

    <!-- bootstrap用のjsファイルと、jqueryを読み込む -->
    <?php  include (dirname(__FILE__) . "/../common/js/read_js.php"); ?>
    <!-- 完了ボタンをクリックした時の動作 -->
    <script src="../js/main.js"></script>
</body>

</html>