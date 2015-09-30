<!DOCTYPE html>
<!-- Proudly made by
                        _|.
                      _/ ||\_ 
                    _/   ||  \__ 
                  _/     ||     \__ 
                 /_______||________\ 
==RUHR-UNi======.___________________.============================
 ___  _____ __  |\_____  __  ______/|\ | |/  ___/| ______|/ ___/ 
 \  \/  /  |  \ |  |__|  ||  |___|_|| \| || / __ | __  __ \___ \ 
  >    <|  |  /_|  |\__  ||  __/|  || .` || |_\ || ___ | |/ \_) |
 / _/\__\____/_____|  |__||__|  |__||_|\ |\_____/|____\| ||____/ 
=\/===================\_ || _/==========\|BOCHUM!================
                        \||/             !
                         !!
                                 FluxFingers // tangled & qll -->
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>&#x202E;<?=$encode(strrev(CTF_NAME))?></title>
<link rel="icon" href="<?=BASE_URI?>static/favicon.ico">
<link rel="stylesheet" href="<?=BASE_URI?>static/style.css">
<?php if (defined('CSS')): ?>
    <link rel="stylesheet" href="<?=BASE_URI?><?=CSS?>">
<?php endif; ?>
<div id="content">
    <?php if (logged_in()): ?>
        <nav>
            <span><?=$encode($_SESSION['name'])?></span>
            // <a href="?p=home">[index]</a>
            <?php if (is_admin()): ?>
                // <a href="?p=admin">[admin]</a>
            <?php endif; ?>
            // <a href="?p=logout">[logout]</a>
        </nav>
    <?php endif; ?>
    <header>
        <p class="fluxfingers">CTF by RUB &amp; <a href="http://www.fluxfingers.net/" target="_blank">FluxFingers</a></p>
	<div class="important"><?=$encode(CTF_NAME)?></div>
    </header>
    <?=$this->block('content')?>
</div>
