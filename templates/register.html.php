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
            <legend><h2>Register</h2></legend>
            <input type="text" name="name" placeholder="Name" required>
            <input type="password" name="pass" placeholder="Password" required>
            <?php if (isset($_GET['admin'])): ?>
                <input type="password" name="admin-pass" placeholder="Admin Password">
            <?php endif; ?>
            <input type="submit" value="Register"><br>
            <a class="register" href="?p=login">Login</a>
        </fieldset>
    </form>
</div>
<?php $this->endBlock(); ?>