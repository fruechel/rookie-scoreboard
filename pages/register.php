<?php


if (logged_in()) {
    redirect_to('?p=home');
}


$error = '';
if (strvals_exist($_POST, 'name', 'pass')) {
    $user = $db->fetch('SELECT id FROM users WHERE name=?', $_POST['name']);
    if ($user) {
        $error = 'User already exists.';
    } else {
        $admin = 0;
        if (strvals_exist($_POST, 'admin-pass')) {
            if ($_POST['admin-pass'] === ADMIN_PW) {
                $admin = 1;
            } else {
                $error = 'Admin password wrong!';
            }
        }
        if (empty($error)) {
            $db->put(
                'INSERT INTO users (name, pass, is_admin) VALUES (?, ?, ?)',
                $_POST['name'],
                password_hash($_POST['pass'], PASSWORD_DEFAULT),
                $admin
            );
            log_in($db->lastInsertId(), $_POST['name'], $admin);
            redirect_to('?p=home');
        }
    }
}


echo render('register.html.php', array('error' => $error));
