<?php self::inc('inc/header') ?>
<h1><?= self::get('title') ?></h1>
<?php $e = is_string(self::get('e')) ? array(self::get('e')) : self::get('e') ?>
<?php foreach ($e as $k => $v): ?>
<p><?= $v ?></p>
<?php endforeach; ?>
<?php self::inc('inc/footer') ?>
