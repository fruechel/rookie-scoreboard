<?php


$adminpw = getenv('ADMIN_PW');
if($adminpw === FALSE)
    die('No admin PW');
define('ADMIN_PW', $adminpw);

$dbname = getenv('PG_DB_SCHEMA');
$dbhost = getenv('PG_DB_HOST');
$dbuser = getenv('PG_DB_ROLE');
$dbpass = getenv('PG_DB_PASSWORD');

define('SESSION_PATH', '/tmp/scoreboardsessions');
define('TEMPLATE_PATH', __DIR__ . '/templates/');
define('BASE_URI', '/');
