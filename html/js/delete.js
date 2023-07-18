'use strict';

// 削除ボタンをクリックした時の処理を記述
// todo/delete.php で読み込み

const submitBtn = document.getElementById("submit-btn");

submitBtn.addEventListener("click", (e) => {
    // デフォルトのイベントをキャンセル
    e.preventDefault();

    // 削除ウィンドウを表示し、OKなら削除、キャンセルなら何もしない
    if(confirm("本当に削除してよろしいですか？")) {
        document.delete_form.submit();
        return;
    }
});