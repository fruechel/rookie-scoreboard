<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/util.php';
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Template.php';


if (!defined('CTF_NAME')) {
    die('CTF_NAME must be set.');
}


ini_set('short_open_tag', 1);  // for templates


session_name('SCOREBOARDSESSID');
ini_set('session.cookie_httponly', 1);
// security fix: we want challenges to be able to set $_SESSION with extract()
//               so we change our session save path here
if (!is_dir(SESSION_PATH)) {
    mkdir(SESSION_PATH, 0330);
}
session_save_path(SESSION_PATH);
session_start();


header('Content-Type: text/html; charset=UTF-8');
header('X-XSS-Protection: 1; mode=block');
header('X-Frame-Options: DENY');


$db = new Database($dbhost, $dbname, $dbuser, $dbpass);


$page = (strvals_exist($_GET, 'p')) ? $_GET['p'] : 'home';
$page_path = __DIR__ . '/../pages/' . $page . '.php';
if (!preg_match('/^\w+$/', $page) || !file_exists($page_path)) {
    $page = '404';
}
include __DIR__ . '/../pages/' . $page . '.php';
