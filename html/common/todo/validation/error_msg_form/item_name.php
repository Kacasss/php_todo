<?php if (isset($errMsgForm["form_item_name"])) : ?>
    <div class="alert alert-danger alert-dismissble fade show my-2 p-2 form-alert" role="alert">
        <?= $errMsgForm["form_item_name"]; ?>
    </div>
<?php endif ?>