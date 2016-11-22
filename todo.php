<!DOCTYPE html>
<html>
<head>
		<title>TODO List</title>
		<!-- == CSS CDN's  =======================================-->
		<link rel="stylesheet" href="css/normalize.min.css" type="text/css" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" type="text/css" />
		<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/flick/jquery-ui.css" type="text/css" />
		<link rel="stylesheet" href="css/todo.css" type="text/css" media="screen" charset="utf-8"/>
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
$today = date("Ymd");
//echo '';
//var_dump($todo_items);
?>
	

	<!--========================================================================
	======================== HTML Here =========================================
	 ==========================================================================-->
<body>
		<nav class="navbar navbar-default navbar-fixed-top">  <!-- navbar-fixed-top -->
			<div class="container">
				<a class="brand" href="index.php">TODO List</a>
			</div>
		</nav>

 		<div id="main" class="container">  <!-- Main Container  -->
	
		 <!-- ========================= jQuery UI Dialog Markup  =============================-->
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
							<input type="submit" value="Create" name="new_submit" class="btn btn-primary" />
						</div>
					</form>
				</div>
			</div>
			
			<!-- ================= Todo List User markup  ==============================-->
			<div id="todolist">
				<!-- Note in source $todo_items is written as an object returned, but in article example
					he returns it as an array -->
				<?php foreach($todo_items as $todo): ?>
                    <h3><a href="#"><?php echo $todo->title; ?></a></h3>
                    <div>
                <form method="POST" action="update_todo.php">
                <div class="textalignright">
                    <a id='delete_button'  href="delete_todo.php?todo_id=<?php echo $todo->todo_id; ?>">Delete</a>
                </div>
                <div>
                    <p>Date Due:<br /><input type="text" id="datepicker_<?php echo $todo->todo_id; ?>" class="datepicker" name="due_date" value=<?php echo $todo->due_date;?> /></p>
                    <p>Description:<br /><textarea class="span8" id="description_<?php echo $todo->todo_id; ?>" class="description" name="description"><?php echo $todo->description; ?></textarea></p>
                </div>
                <div class="textalignright">
                    <?php if( $todo->is_done == 'false' ): ?>
                    <input type="hidden" value="false" name="is_done" />
                    <input type="submit" class="btn btn-success" value="Mark as Done?" name="markasdone_button" />
                    <?php else: ?>
                    <input type="hidden" value="true" name="is_done" />
                    <input type="button" class="btn success" value="Done!" name="done_button" />
                    <?php endif; ?>
                    <input type="hidden" value="<?php echo $todo->todo_id; ?>" name="todo_id" />
                    <input type="hidden" value="<?php echo $todo->title; ?>" name="title" />
                    <input type="submit" class="btn btn-primary" value="Save Changes" name="update_button" />
                </div>
                </form>
            </div>
                 <?php endforeach; ?>
			</div>
			
		</div>  <!-- End of Main .container   -->
	


 <!-- ======================  JS and JS Framework Files  ===============================-->
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
			
			$("#delete_button").on("click",function(e)  {
				e.preventDefault();
				var result = confirm("Are You Sure You Want To Delete This Item?");
                if (result) {
                     //Redirect to delete page
                   window.location = "delete_todo.php";
               }
			});
		});
	</script>
	
</body>