<?php self::inc('inc/header') ?>
<?php if (is_string(self::get('msg'))): ?>
  <p><?= self::get('msg') ?>
<?php else: ?>
  <?php foreach (self::get('msg') as $k => $v): ?>
    <p><strong><?= $k ?>:</strong> <?= $v ?></p>
  <?php endforeach; ?>
<?php endif; ?>
<?php self::inc('inc/footer') ?>
