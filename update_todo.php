<?php
ini_set('display_errors',1); 
error_reporting(E_ALL);
session_start();
include_once 'apicaller.php';
 $serverAddress = "http://" . $_SERVER['SERVER_ADDR'];
 
$apicaller = new ApiCaller('APP001', '28e336ac6c9423d946ba02d19c6a2632', $serverAddress . '/todo_api/');
 
if (isset($_POST['markasdone_button']))  {
	 $new_item = $apicaller->sendRequest(array(
     'controller' => 'todo',
     'action' => 'update',
     'title' => $_POST['title'],
     'due_date' => $_POST['due_date'],
     'description' => $_POST['description'],
     'is_done' => 'true',  // add is_done = true
     'todo_id' => $_POST['todo_id'],
     'username' => $_SESSION['username'],
     'userpass' => $_SESSION['userpass']
  ));
} else  {
	 $new_item = $apicaller->sendRequest(array(
     'controller' => 'todo',
     'action' => 'update',
     'title' => $_POST['title'],
     'due_date' => $_POST['due_date'],
     'description' => $_POST['description'],
     'todo_id' => $_POST['todo_id'],
     'username' => $_SESSION['username'],
     'userpass' => $_SESSION['userpass']
  ));
}
header('Location: todo.php');
exit();
