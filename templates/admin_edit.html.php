<?php 
$this->extend('base.html.php');
$this->startBlock('content');
?>
<div class="middle">
    <form action="" method="post">
        <fieldset>
            <legend><h2>
                <?php if (isset($chal)): ?>
                    New
                <?php else: ?>
                    Edit
                <?php endif; ?>Challenge
            </h2></legend>
            <input type="text" placeholder="Title" name="title"
                   value="<?php if (isset($chal)) echo $encode($chal->title); ?>" required>
            <textarea name="desc" placeholder="Description (HTML allowed)"
                      required><?php if (isset($chal)) echo $encode($chal->desc); ?></textarea>
            <input type="text" placeholder="Flag" name="flag"
                   value="<?php if (isset($chal)) echo $encode($chal->flag); ?>" required>
            <input type="number" placeholder="Points" name="points"
                   value="<?php if (isset($chal)) echo $encode($chal->points); ?>" required>
            <input type="hidden" value="<?=$encode($csrf)?>" name="csrf"
                   required>
            <input type="submit" value="Save">
        </fieldset>
    </form>
</div>
<?php $this->endBlock(); ?>