<?php
ini_set('display_errors',1); 
 error_reporting(E_ALL);
session_start();
include_once 'apicaller.php';
$serverAddress = "http://" . $_SERVER['SERVER_ADDR'];
 
$apicaller = new ApiCaller('APP001', '28e336ac6c9423d946ba02d19c6a2632', $serverAddress . '/todo_api/');

$todo_items = $apicaller->sendRequest(array(
    'controller' => 'todo',
    'action' => 'read',
    'username' => $_SESSION['username'],
    'userpass' => $_SESSION['userpass']
));
 echo '<br>';
echo 'This is todo_items: ';
echo '<br>';
var_dump($todo_items);