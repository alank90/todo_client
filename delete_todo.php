<?php
ini_set('display_errors',1); 
error_reporting(E_ALL);
session_start();
include_once 'apicaller.php';
 $serverAddress = "http://" . $_SERVER['SERVER_ADDR'];
 $apicaller = new ApiCaller('APP001', '28e336ac6c9423d946ba02d19c6a2632', $serverAddress . '/todo_api/');
 
$delete_item = $apicaller->sendRequest(array(
    'controller' => 'todo',
    'action' => 'delete',
     'todo_id' => $_GET['todo_id'],
    'username' => $_SESSION['username'],
    'userpass' => $_SESSION['userpass']
));
 
//header('Location: todo.php');
exit();
?>