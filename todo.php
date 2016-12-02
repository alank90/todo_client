<!DOCTYPE html>
<meta charset=utf-8>
<html>
<head>
		<title>TODO List</title>
		<!-- == CSS CDN's  =======================================-->
		<link rel="stylesheet" href="css/normalize.min.css" type="text/css" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" type="text/css" />
		<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/flick/jquery-ui.css" type="text/css" />
		<link href="https://fonts.googleapis.com/css?family=Abril+Fatface|Playfair+Display" rel="stylesheet"> 
		<link rel="stylesheet" href="css/todo.css" type="text/css"  charset="utf-8"/>
	</head>
	
<!-- ================= PHP Here ==================-->
<?php
// Start with a read of all todo items off the server
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

//var_dump($todo_items);
?>
	

	<!--========================================================================
	======================== HTML Here =========================================
	 ==========================================================================-->
<body>
		<nav class="navbar navbar-default navbar-fixed-top">  <!-- navbar-fixed-top -->
			<div class="container">
				<a class="brand" href="index.html"><?php echo $_SESSION['username'] ?>'s TODO List</a>
				<img class="nav_image" src="img/todo_small.png" alt="checklist-picture" />
			</div>
		</nav>

 		<div id="main" class="container">  <!-- Main Container  -->
	
		 <!-- ========================= jQuery UI Dialog Markup  =============================-->
			<div class="textalignright marginbottom10">
				<span id="newtodo" class="btn btn-info btn-lg fade-in one">Create a new TODO item</span>
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
			
			<!-- Check If there are any todo items. If not skip Todo list markup. =====-->
			<?php 
			  $result = $todo_items[0];
			  if ($result->todo_id == '1234567')  {
				 $todo = new stdClass();
				 $todo->todo_id = '0'; /*assign a value todo_id. If not get error in JS line 
				                                       delete_todo.php?todo_id=<?php echo $todo->todo_id; below*/
		  	 }
		     else  {
			?>
			<div id="todolist">
				<!-- Note in source $todo_items is written as an object returned, but in article example
					he returns it as an array -->
				<?php	foreach($todo_items as $todo): ?>
                <h3> <a href="#"><?php echo $todo->title; ?></a> <p>Due <?php echo $todo->due_date;?> </p> </h3>
                <div>
                  <form method="POST" action="update_todo.php">
                  <div class="textalignright">
                       <a  class="delete_button btn btn-danger fade-in two" href="#" data-todo_id="<?php echo $todo->todo_id; ?>"/>Delete</a>
                   </div>
                <div>
                    <p>Date Due:<br /><input type="text" id="datepicker_<?php echo $todo->todo_id; ?>" class="datepicker" name="due_date" value=<?php echo $todo->due_date;?> /></p>
                    <p>Description:<br /><textarea class="span8" id="description_<?php echo $todo->todo_id; ?>" class="description" name="description"><?php echo $todo->description; ?></textarea></p>
                </div>
                <div class="textalignright">
                    <?php if( $todo->is_done == 'false' ): ?>  <!-- Display Mark Done/Savechanges Buttons  -->
                                     <input type="hidden" value="false" name="is_done" />
                                    <input type="submit" class="btn btn-success fade-in three" value="Mark as Done?" name="markasdone_button" />
                                    <input type="hidden" value="<?php echo $todo->todo_id; ?>" name="todo_id" />
                                    <input type="hidden" value="<?php echo $todo->title; ?>" name="title" />
                                    <input type="submit" class="btn btn-primary fade-in four" value="Save Changes" name="update_button" />
                    <?php else: ?>  <!-- Display Done / Undo Button -->
                                    <input type="hidden" value="false" name="is_done" />
                                    <input type="hidden" value="<?php echo $todo->todo_id; ?>" name="todo_id" />
                                    <input type="hidden" value="<?php echo $todo->title; ?>" name="title" />
                                    <input type="submit" class="btn success fade-in three" value="Done! / Undo" name="done_button" />
                    <?php endif; ?>
                
                </div>
                </form>
            </div>
            <?php 
                     endforeach;
                 } // End   Else
            ?>  
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
			
			$(".delete_button").on("click",function(e)  {
				e.preventDefault();
				var result = confirm("Are You Sure You Want To Delete This Item?");
                if (result) { 
                     //Redirect to delete page
                   var todo_id = this.getAttribute("data-todo_id");
                   window.location = "delete_todo.php?todo_id=" + todo_id; 
               }
			});
			
			// Add .done class to <h3> to show completed items in green w/checkmark.
			$( ".success" ).closest("div.ui-accordion-content").prev("h3").addClass( "done" );
		    $( ".success" ).closest("div.ui-accordion-content").prev("h3").append( "<span>&#10004</span>" );
		});
	</script>
	
</body>