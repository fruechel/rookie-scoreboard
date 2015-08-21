<?php 
$this->extend('base.html.php');
$this->startBlock('content');
?>
<div class="middle">
    <form action="" name="login" method="post">
        <fieldset>
            <?php if ($error): ?>
                <div class="important"><?=$encode($error)?></div>
            <?php endif; ?>
            <legend><h2>Login</h2></legend>
            <input type="text" name="name" placeholder="Name">
            <input type="password" name="password" placeholder="Password">
            <input type="submit" value="Login"><br>
            <a class="register" href="?p=register">Register</a>
        </fieldset>
    </form>
</div>
<?php $this->endBlock(); ?>