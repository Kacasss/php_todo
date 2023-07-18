<?php if (isset($errMsgForm["form_expire_date"])) : ?>
    <div class="alert alert-danger alert-dismissble fade show my-2 p-2 form-alert" role="alert">
        <?= $errMsgForm["form_expire_date"]; ?>
    </div>
<?php endif ?>