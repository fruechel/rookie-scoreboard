<?php


if (!logged_in()) {
    redirect_to('?p=login');
}


$users = $db->fetchAll(
    'SELECT users.name,
        (SELECT SUM(challenges.points) FROM challenges, solves
            WHERE challenges.ctf=? AND challenges.id=solves.challenge_id
            AND solves.user_id=users.id) AS points
     FROM users WHERE users.is_admin=0 ORDER BY points DESC, name ASC',
    CTF_NAME
);


$chals = $db->fetchAll(
    'SELECT id, title, points,
        (SELECT count(*) FROM solves, users WHERE challenge_id=challenges.id
            AND users.id=solves.user_id AND users.is_admin=0) AS solved
        FROM challenges WHERE ctf=? ORDER BY points',
    CTF_NAME
);


echo render('home.html.php', array('users' => $users, 'chals' => $chals));
