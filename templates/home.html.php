<?php 
$this->extend('base.html.php');
$this->startBlock('content');
?>
<section>
    <h2>Scoreboard</h2>
    <table id="scoreboard">
        <thead>
            <tr>
                <td>#</td>
                <td>Name</td>
                <td>Points</td>
            </tr>
        </thead>
        <tbody>
            <?php
            $rank = 0;
            $rank_diff = 0;
            $last_points = -1;
            foreach ($users as $user):
                if ($user->points != $last_points) {
                    $rank += 1 + $rank_diff;
                    $rank_diff = 0;
                } else {
                    $rank_diff++;
                }
                $last_points = $user->points;
            ?>
                <?php if ($user->points): ?>
                    <tr<?php if ($rank == 1) echo ' class="first"'; ?>>
                        <td>
                            <?=$rank?>
                        </td>
                        <td>
                            <?=$encode($user->name)?>
                        </td>
                        <td>
                            <?=$encode($user->points)?>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>
<section>
    <h2>Challenges</h2>
    <table id="challenges">
        <thead>
            <tr>
                <td>Title</td>
                <td># Solves</td>
                <td>Points</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($chals as $chal): ?>
                <tr<?php if (is_solved($chal->id)) echo ' class="solved"' ?>>
                    <td><a href="?p=chal&amp;id=<?=$chal->id?>">
                        <?=$encode($chal->title)?>
                    </a></td>
                    <td><?=$encode($chal->solved)?></td>
                    <td><?=$encode($chal->points)?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>
<?php $this->endBlock(); ?>