<?php


$error = '';
if (strvals_exist($_POST, 'name', 'password')) {
    $result = $db->fetch(
        'SELECT id, pass, is_admin FROM users WHERE name=?', $_POST['name']
    );
    if (!$result || !password_verify($_POST['password'], $result->pass)) {
        $error = 'Wrong username or password!';
    } else {
        log_in($result->id, $_POST['name'], $result->is_admin);
        $solves = $db->fetchAll(
            'SELECT challenge_id FROM solves WHERE user_id=?',
            $result->id
        );
        foreach ($solves as $solve) {
            add_solved_challenge($solve->challenge_id);
        }
        redirect_to('?p=home');
    }
}


echo render('login.html.php', array('error' => $error));
