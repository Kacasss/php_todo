<!-- エラーメッセージ -->
<div class="row m-0">
    <div class="col-sm-3"></div>

    <!-- フォーム入力エラーがあった場合 -->
    <?php if (isset($errMsgForm["form_msg"])) : ?>
        <div class="col-sm-6 alert alert-danger alert-dismissble fade show form-alert" role="alert">
            <?= $errMsgForm["form_msg"]; ?>
        </div>
    <?php endif ?>

    <div class="col-sm-3"></div>
</div>