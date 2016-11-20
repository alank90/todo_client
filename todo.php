<!DOCTYPE html>
<html>
<head>
		<title>TODO List</title>
		<!-- == CSS CDN's  =======================================-->
		<link rel="stylesheet" href="css/normailze.min.css" type="text/css" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" type="text/css" />
		<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/flick/jquery-ui.css" type="text/css" />
		<link rel="stylesheet" href="css/main_todo_client.css" type="text/css" media="screen" charset="utf-8"/>
	</head>
<!-- ================= PHP Here ==================-->
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
?>
	

	<!--============ HTML Here ======================-->
<body>
		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="container">
				<a class="brand" href="index.php">TODO List</a>
			</div>
		</nav>

		<div id="main" class="container">
			<div class="textalignright marginbottom10">
				<span id="newtodo" class="btn btn-info btn-lg">Create a new TODO item</span>
				<div id="newtodo_window" title="Create a new TODO item">
					<form method="POST" action="new_todo.php">
						<p>
							Title:
							<br />
							<input type="text" class="title" name="title" placeholder="TODO title" />
						</p>
						<p>
							Date Due:
							<br />
							<input type="text" class="datepicker" name="due_date" placeholder="MM/DD/YYYY" />
						</p>
						<p>
							Description:
							<br />
							<textarea class="description" name="description"></textarea>
                         </p>				
                        <div class="actions">
							<input type="submit" value="Create" name="new_submit" class="btn primary" />
						</div>
					</form>
				</div>
			</div>
			<div id="todolist">
				<p>Testing</p>
			</div>
			
		</div>  <!-- .container <div> end </div>  -->
	</body>


 <!-- =================  JS and JS Framework Files  ================-->
     <script src="js/vendor/modernizr-2.8.3.min.js"></script>
	<script  src="http://code.jquery.com/jquery-2.2.4.min.js"></script>
	<!-- Latest compiled and minified JavaScript UI -->
	<script  src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

	<script  src=" https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	<script src="js/plugins.js"></script>
	  
    <script>
		$(document).ready(function() {
			$("#todolist").accordion({
				collapsible : true
			});
			$(".datepicker").datepicker();
			$('#newtodo_window').dialog({
				autoOpen : false,
				height : 'auto',
				width : 'auto',
				modal : true
			});
			$('#newtodo').click(function() {
				$('#newtodo_window').dialog('open');
			});
		});
	</script>