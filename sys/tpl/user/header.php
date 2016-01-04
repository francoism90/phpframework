<!DOCTYPE html>
<html lang="en">
<head>
<base href="<?= Sys\HTTP::host() ?>">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= self::get('title') ?> &middot; MyDomain</title>
<link rel="stylesheet" href="css/x.css">
<script src="js/jquery.min.js"></script>
</head>

<body>

<header>
  <div class="inner">
    <nav>
    <ul><?= Sys\Tpl\Widget::topnav('account') ?></ul>
    </nav>
  </div>
</header>

<div id="content" class="inner">
