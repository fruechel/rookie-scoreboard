<?php


if (!logged_in()) {
    redirect_to('?p=login');
}
if (!is_admin()) {
    redirect_to('?p=home');
}


if (!isset($_GET['a'])) {


    $chals = $db->fetchAll(
        'SELECT id, title, points FROM challenges WHERE ctf=? ORDER BY points',
        CTF_NAME
    );
    echo render('admin.html.php', array(
        'chals' => $chals,
        'csrf' => generate_csrftoken()
    ));


} elseif ($_GET['a'] === 'edit' && isset($_GET['id'])) {


    $chal = $db->fetch(
        'SELECT title, `desc`, flag, points FROM challenges
            WHERE id=? AND ctf=?',
        $_GET['id'],
        CTF_NAME
    );
    if (!$chal) {
        redirect_to('?p=admin');
    }
    if (valid_csrf()
            && strvals_exist($_POST, 'title', 'desc', 'flag', 'points')) {
        $db->put(
            'UPDATE challenges SET title=?, `desc`=?, flag=?, points=?
                WHERE id=?',
            $_POST['title'],
            $_POST['desc'],
            $_POST['flag'],
            $_POST['points'],
            $_GET['id']
        );
        redirect_to('?p=admin');
    }
    echo render('admin_edit.html.php', array(
        'chal' => $chal, 'csrf' => generate_csrftoken()
    ));


} elseif ($_GET['a'] === 'add') {


    if (valid_csrf()
            && strvals_exist($_POST, 'title', 'desc', 'flag', 'points')) {
        $db->put(
            'INSERT INTO challenges (title, `desc`, flag, points, ctf)
                VALUES (?, ?, ?, ?, ?)',
            $_POST['title'],
            $_POST['desc'],
            $_POST['flag'],
            $_POST['points'],
            CTF_NAME
        );
        redirect_to('?p=admin');
    }
    echo render('admin_edit.html.php', array('csrf' => generate_csrftoken()));


} elseif ($_GET['a'] === 'delete' && isset($_GET['id']) && valid_csrf()) {


    $db->put('DELETE FROM challenges WHERE id=?', $_GET['id']);
    $db->put('DELETE FROM solves WHERE challenge_id=?', $_GET['id']);
    redirect_to('?p=admin');


} elseif ($_GET['a'] === 'delete-solves' && valid_csrf()) {


    $db->put(
        'DELETE FROM solves WHERE challenge_id IN
            (SELECT id FROM challenges WHERE ctf=?)',
        CTF_NAME
    );
    redirect_to('?p=admin');


} elseif ($_GET['a'] === 'reported') {


if (valid_csrf() && strvals_exist($_GET, 'cid', 'uid')) {
    $db->put(
        'UPDATE solves SET reported=1 WHERE challenge_id=? AND user_id=?',
        $_GET['cid'],
        $_GET['uid']
    );
    redirect_to('?p=admin&a=reported');
}


$reported = $db->fetchAll(
    'SELECT solves.challenge_id, solves.user_id, challenges.title,
            challenges.ctf, users.name
        FROM users, solves, challenges
        WHERE users.id=solves.user_id AND solves.challenge_id=challenges.id
            AND solves.reported=0'
);
echo render('admin_reported.html.php', array(
    'reported' => $reported,
    'csrf' => generate_csrftoken()
));


} else {


    redirect_to('?p=admin');


}
