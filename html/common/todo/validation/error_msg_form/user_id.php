<?php if (isset($errMsgForm["form_user_id"])) : ?>
    <div class="alert alert-danger alert-dismissble fade show my-2 p-2 form-alert" role="alert">
        <?= $errMsgForm["form_user_id"]; ?>
    </div>
<?php endif ?>