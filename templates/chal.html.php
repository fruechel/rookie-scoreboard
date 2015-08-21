<?php 
$this->extend('base.html.php');
$this->startBlock('content');
?>
<div class="middle">
    <form action="?p=chal&amp;id=<?=$encode(urlencode($_GET['id']))?>" method="post">
        <fieldset>
            <legend>
                <h2><?=$encode($chal->title)?></h2>
            </legend>
            <h4><?=$encode($chal->points)?> Points</h4>
            <?php if (is_solved($chal->id) && !is_bool($valid_flag)): ?>
                <div class="important">Already solved.</div>
            <?php endif; ?>
            <div class="main-text">
                <?php /* "vulnerable" to xss by purpose */ ?>
                <?=$chal->desc?>
            </div>
            <?php if (is_bool($valid_flag)): ?>
                <div class="important">
                    <?=$encode($flag_msg)?>
                </div><br>
            <?php endif; ?>
            <input type="text" name="flag" placeholder="Flag">
            <input type="submit" value="Verify"><br>
        </fieldset>
    </form>
</div>
<?php $this->endBlock(); ?>