<?php self::inc('user/header') ?>
<div id="account">
<form method="post" id="ajaxForm" action="<?= Sys\HTTP::fullPath() ?>">
  <h1><?= _('Sign Up') ?></h1>
  <div class="alert" role="alert"></div>
  <?= self::inc('inc/form') ?>
  <button type="submit" name="submit"><?= _('Sign Up') ?></button>
</form>
</div>
<script src="js/ajaxForm.js"></script>
<?php self::inc('user/footer') ?>
