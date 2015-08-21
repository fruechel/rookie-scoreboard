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


} else {


    redirect_to('?p=admin');


}
