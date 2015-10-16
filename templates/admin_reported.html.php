<?php 
$this->extend('base.html.php');
$this->startBlock('content');
?>
<div class="middle">
    <div class="top-button">
        <a class="button" href="?p=admin">View Admin</a>
    </div>
    <table>
        <thead>
            <tr>
                <td>Team</td>
                <td>Scoreboard</td>
                <td>Challenge</td>
                <td>Done</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reported as $report): ?>
                <tr>
                    <td><?=$encode($report->name)?></td>
                    <td><?=$encode($report->ctf)?></td>
                    <td><?=$encode($report->title)?></td>
                    <td class="buttons">
                        <form method="post"
                              action="?p=admin&amp;a=reported&amp;uid=<?=$encode($report->user_id)?>&amp;cid=<?=$encode($report->challenge_id)?>"
                              data-question="Do you really want to mark this solve as reported?">
                            <input type="hidden" value="<?=$encode($csrf)?>" name="csrf">
                            <input type="submit" value="&#10003;">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script src="<?=BASE_URI?>static/delete.js"></script>
<?php $this->endBlock(); ?>