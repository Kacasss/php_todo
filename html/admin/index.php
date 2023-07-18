<?php
    session_start();
    session_regenerate_id();

    require_once("../db/Database.php");
    require_once("../db/Users.php");
    require_once("../common/admin/login_check.php");
    require_once("../common/admin/is_admin.php");
    require_once("../common/date.php");

    $title = "ユーザー一覧";

    // 1ページの記事の表示数
    define("MAX", "3");


    // try {
        $db = new Users();
        $users = $db->selectAll();
    // } catch (Exception $e) {
    //     // $_SESSION['exception_err'] = "申し訳ございません。エラーが発生しました"; 
    //     header('Location: ../error/error.php');
    //     exit;
    // }


     // トータルデータ件数
     // （例）レコードが10個の場合、10が代入
     $users_num = count($users);

     // トータルページ数
     // ※ceilは小数点を切り上げる関数
     // （例）レコードが10個で、MAXが3の場合
     // 10/3は3.333（略）だが、切り上げの為4が代入される
     $max_page = (int) ceil($users_num / MAX);
         
     // $_GET["page_id"] はURLに渡された現在のページ数
     if (!isset($_GET["page_id"]) || $_GET["page_id"] <= 0) {
        // ページが設定されてない、または0以下の場合は1を代入
        $now = 1; 
     } else if ($max_page <= $_GET["page_id"]) {
        // トータルページ数以上の場合は最大のページ数を代入
        // （例）レコードが10個の場合、4を代入
        $now = $max_page;
     } else {
        $now = (int) $_GET["page_id"];
     }
     
      // 配列の何番目から取得すればよいか
      // （例）レコードが10個の場合、0, 3, 6, 9 のいずれかが代入される
      // （例）（1ページ目） (1 - 1) * 3 ... 0
      // （例）（2ページ目） (2 - 1) * 3 ... 3
      // （例）（3ページ目） (3 - 1) * 3 ... 6
      // （例）（4ページ目） (4 - 1) * 3 ... 9
     $start_array_num = ($now - 1) * MAX;
 
     // array_sliceは、配列の何番目（$start_array_num）から何番目（MAX）まで切り取る
     $users = array_slice($users, $start_array_num, MAX, true);

?>
<?php include (dirname(__FILE__) . "/../common/admin/user/head.php"); ?>
<body>
    <!-- ナビゲーション -->
    <?php include (dirname(__FILE__) . "/../common/admin/user/nav.php"); ?>

    <!-- コンテナ -->
    <div class="container">

            <?php if (0 < count($users)) : ?>
                <table class="table table-striped table-hover table-sm my-4 text-center">

                    <thead>
                        <tr>
                            <th scope="col">ユーザー</th>
                            <th scope="col">ユーザー姓</th>
                            <th scope="col">ユーザー名</th>
                            <th scope="col">管理者</th>
                            <th scope="col">削除</th>
                            <th scope="col">編集</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($users as $user) : ?>
                            


                            <tr>
                                <td class="align-middle">
                                    <?= $user["user"]; ?>
                                </td>
                                <td class="align-middle">
                                    <?= $user["family_name"]; ?>
                                </td>
                                <td class="align-middle">
                                    <?= $user["first_name"]; ?>
                                </td>
                                <td class="align-middle">
                                    <?= isset($user["is_admin"]) && $user["is_admin"] == 1 ? "〇" : "×"; ?>
                                </td>

                                <td class="align-middle">
                                    <?= isset($user["is_deleted"]) && $user["is_deleted"] == 1 ? "済" : ""; ?>
                                </td>
                           


                            <!-- ユーザーが削除されていない場合は、編集ボタンを表示させる -->
                            <?php if ($user["is_deleted"] == 0) : ?> 

                                <td class="align-middle button">
                                    <form action="./edit.php" method="post" class="form my-sm-1">
                                            <input type="hidden" name="user_id" value="<?= $user["id"]; ?>">
                                            <input class="btn btn-secondary my-0" type="submit" value="更新">
                                    </form>

                                    <form action="./delete.php" method="post" class="form my-sm-1">
                                        <input type="hidden" name="user_id" value="<?= $user["id"]; ?>">
                                        <input type="submit" value="削除" class="btn btn-danger my-0">
                                    </form>
                                </td>

                            <?php else : ?> 
                                <!-- ユーザーが削除されている場合は、編集ボタンを表示させない -->
                                <td class="align-middle py-4"></td>
                            <?php endif; ?>


                            </tr>
                            
                        <?php endforeach ?>
                    </tbody>


                </table>


                <nav aria-label="Page navigation example">
                    <ul class="pagination">

                    <li class="page-item <?= $now === 1 ? "disabled" : ""; ?>">
                        <a class="page-link" href="./?page_id=<?= $now - 1; ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                        </a>
                    </li>

                    <?php for ($i = 1; $i <= $max_page; $i++) { ?>
                        <!-- 現在表示中のページ数の場合はリンクを貼らない -->

                        <?php if ($i == $now) : ?>
                            <li class="page-item active">
                                <a class="page-link" href="./?page_id=<?= $i; ?>"><?= $now ?></a>
                            </li>
                        <?php else : ?>
                            <li class="page-item">
                                <a class="page-link" href="./?page_id=<?= $i; ?>"><?= $i; ?></a>
                            </li>
                        <?php endif ?>

                    <?php } ?>

                    <li class="page-item <?= $now === $max_page ? "disabled" : ""; ?>">
                        <a class="page-link" href="./?page_id=<?= $now + 1; ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                        </a>
                    </li>

                    </ul>
                </nav>


            <?php endif ?>
            
    </div>
    <!-- コンテナ ここまで -->
    <?php  include (dirname(__FILE__) . "/../common/js/read_js.php"); ?>

    <script>
        // <button type="submit" class="btn btn-primary my-0 submit-btn">完了</button>タグを複数取得
        const submitBtns = document.getElementsByClassName("submit-btn");
        
        // HTMLCollectionを配列にする
        arraySubmitBtns = Array.from(submitBtns);

        // 1つずつ取り出す
        arraySubmitBtns.forEach(function(arraySubmitBtn) {

            // クリック時の処理
            arraySubmitBtn.addEventListener("click", (e) => {
                // デフォルトのイベントをキャンセル
                e.preventDefault();

                // 削除ウィンドウを表示し、OKなら削除、キャンセルなら何もしない
                if(confirm("本当に完了してよろしいですか？")) {
                    // クリックした<button type="submit" class="btn btn-primary my-0 submit-btn">完了</button>の
                    // 直近の親タグ<form action="./complete.php" method="post" class="form my-sm-1 index_form">をsubmitする
                    e.target.closest("form").submit();
                    return;
                }
            });

        });
    </script>
</body>

</html>