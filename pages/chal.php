<?php


if (!logged_in()) {
    redirect_to('?p=login');
}


$error = 'Invalid id.';
if (!strvals_exist($_GET, 'id')) {
    die($error);
}


$chal = $db->fetch(
    'SELECT id, title, "desc", flag, points FROM challenges
        WHERE id=? AND ctf=?',
    $_GET['id'],
    CTF_NAME
);


if (!$chal) {
    die($error);
}


$valid_flag = '';
$flag_msg = 'Incorrect flag.';
if (strvals_exist($_POST, 'flag')) {
    $valid_flag = false;
    if (validate_flag($_POST['flag'], $chal->flag)) {
        $valid_flag = true;
        if (is_solved($chal->id)) {
            $flag_msg = 'Correct flag but you already solved the challenge.';
        } else {
            $db->put(
                'INSERT INTO solves (user_id, challenge_id) VALUES (?, ?)',
                $_SESSION['id'],
                $chal->id
            );
            add_solved_challenge($chal->id);
            $flag_msg = 'Correct flag! +' . $chal->points . ' points!';
        }
    }
}


echo render('chal.html.php', array(
    'chal' => $chal, 'valid_flag' => $valid_flag, 'flag_msg' => $flag_msg
));
