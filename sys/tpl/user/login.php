<?php self::inc('user/header') ?>
<div id="account">
<form method="post" id="ajaxForm" action="<?= Sys\HTTP::pathStr() ?>">
  <h1><?= _('Log In') ?></h1>
  <?= new Sys\Form('user-login', array('remember' => 1)) ?>
  <button type="submit" name="submit"><?= _('Log In') ?></button>
</form>
</div>
<script src="js/ajaxForm.js"></script>
<?php self::inc('user/footer') ?>
