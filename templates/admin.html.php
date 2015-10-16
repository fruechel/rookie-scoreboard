<?php 
$this->extend('base.html.php');
$this->startBlock('content');
?>
<div class="middle">
    <div class="top-button">
        <form method="post" action="?p=admin&amp;a=delete-solves"
              data-question="Do you really want to reset the Scoreboard?">
            <input type="hidden" value="<?=$encode($csrf)?>" name="csrf">
            <input type="submit" value="Reset Scoreboard">
        </form>
        <a class="button" href="?p=admin&amp;a=add">New Challenge</a>
        <a class="button" href="?p=admin&amp;a=reported">View Solves</a>
    </div>
    <table>
        <thead>
            <tr>
                <td>ID</td>
                <td>Title</td>
                <td>Points</td>
                <td>Actions</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($chals as $chal): ?>
                <tr>
                    <td><?=$encode($chal->id)?></td>
                    <td><?=$encode($chal->title)?></td>
                    <td><?=$encode($chal->points)?></td>
                    <td class="buttons">
                        <a href="?p=admin&amp;a=edit&amp;id=<?=$encode($chal->id)?>" class="button">
                            E
                        </a>
                        <form method="post"
                              action="?p=admin&amp;a=delete&amp;id=<?=$encode($chal->id)?>"
                              data-question="Do you really want to delete this challenge?">
                            <input type="hidden" value="<?=$encode($csrf)?>" name="csrf">
                            <input type="submit" value="D">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script src="<?=BASE_URI?>static/delete.js"></script>
<?php $this->endBlock(); ?>