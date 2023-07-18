'use strict';

// 完了ボタンをクリックした時の処理を記述
// todo/index.phpとsearch.php で読み込み

// <input type="submit" value="完了" class="btn btn-primary my-0 submit-btn">を複数取得
const submitBtns = document.getElementsByClassName("submit-btn");

// HTMLCollectionを配列にする
let arraySubmitBtns = Array.from(submitBtns);

// 1つずつ取り出す
arraySubmitBtns.forEach(function(arraySubmitBtn) {

    // クリック時の処理
    arraySubmitBtn.addEventListener("click", (e) => {
        // デフォルトのイベントをキャンセル
        e.preventDefault();

        // 削除ウィンドウを表示し、OKなら削除、キャンセルなら何もしない
        if(confirm("本当に完了してよろしいですか？")) {
            // クリックした<input type="submit" value="完了" class="btn btn-primary my-0 submit-btn">の
            // 直近の親タグ<form action="./complete.php" method="post" class="form my-sm-1">をsubmitする
            e.target.closest("form").submit();
            return;
        }
    });

});