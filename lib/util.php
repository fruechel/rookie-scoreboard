<?php


function redirect_to($location)
{
    header('Location: ' . $location);
    die();
}


function log_in($id, $name, $is_admin)
{
    $_SESSION['id'] = $id;
    $_SESSION['name'] = $name;
    $_SESSION['admin'] = $is_admin;
    $_SESSION['solves'] = array();
}

function logged_in()
{
    return isset($_SESSION['id']);
}

function is_admin()
{
    return isset($_SESSION['admin']) && $_SESSION['admin'];
}


function hash_pw($pw)
{
    return password_hash($pw, PASSWORD_BCRYPT);
}


/** Check if the current active user has solved a challenge with id $cid. */
function is_solved($cid)
{
    return in_array($cid, $_SESSION['solves']);
}


function add_solved_challenge($cid)
{
    $_SESSION['solves'][] = $cid;
}


function starts_with($haystack, $needle)
{
    $empty = $needle === "";
    return $empty || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
}


/** Mutate user flag from flag{...} to ... and compare with given flag. */
function validate_flag($user_flag, $flag)
{
    $user_flag = trim($user_flag);
    preg_match('/flag{([\w\?\'"\-!\+$#:,;\.\/ ]+)}/i', $user_flag, $m);
    $user_flag = (count($m)) ? $m[1] : $user_flag;
    return $flag === $user_flag;
}


function generate_csrftoken() {
    if (!isset($_SESSION['csrf'])) {
        // prolly shit
        $_SESSION['csrf'] = sha1(uniqid() . mt_rand() . mt_rand());
    }
    return $_SESSION['csrf'];
}


function valid_csrf()
{
    return isset($_POST['csrf']) && $_SESSION['csrf'] === $_POST['csrf'];
}


/**
 * Pre-fill function parameters. Functional programming pattern.
 *
 * First argument is a callable which gets partially applied, any other
 * arguments are function parameters to the callable. PHP 5.3 required.
 */
function apply_partial()
{
    $args = func_get_args();
    return function() use ($args) {
        return call_user_func_array(
            'call_user_func',
            array_merge($args, func_get_args())
        );
    };
}


function render($template_file, array $vars = array())
{
    $template = new Template($template_file, TEMPLATE_PATH);
    foreach ($vars as $key => $value) {
        $template->assign($key, $value);
    }
    return $template->render();
}


function strvals_exist()
{
    $args = func_get_args();
    $array = array_shift($args);
    foreach ($args as $key) {
        if (!array_key_exists($key, $array) || !is_string($array[$key])
                || empty($array[$key])) {
            return false;
        }
    }
    return true;
}

