<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <title>ToDo List</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="ToDo List: REST API / Twitter Bootstrap / jQuery  for a recruitment test.">
    <meta name="author" content="NAcho">

    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }

      @media (max-width: 980px) {
        /* Enable use of floated navbar text */
        .navbar-text.pull-right {
          float: none;
          padding-left: 5px;
          padding-right: 5px;
        }
      }
	
    </style>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="ico/favicon.png">
  
  
  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          
          <a class="brand" href="#">ToDo NAcho</a>
          <div class="nav-collapse collapse">
            
			<ul class="nav pull-right">
			  <li class="divider-vertical"></li>
			  <li><a href="login.php?action=logout">Logout</a></li>
			</ul>
			
			<p class="navbar-text pull-right">
              <?=$_SESSION['username']?>
			</p>
			<ul class="nav">
              <li><a href="#" class="btn-inverse popover-link" id="popover_addList">New List</a></li>
			  <li><a href="#" class="btn-inverse popover-link" onClick="return orderListByDueDate();" id="orderDueDate" >Order By Due Date <i class="icon-chevron-up icon-white"></i></a></li>
			  <li><a href="#" class="btn-inverse popover-link" onClick="return orderListByPriority();" id="orderPriority" >Order By Priority <i class="icon-chevron-up icon-white"></i></a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
	
    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span3" style="width:100%;max-width:700px;float: none;margin-left: auto;margin-right: auto;">
          <div class="well sidebar-nav" id="lists">

          </div><!--/.well -->
		  
        </div><!--/span-->
      </div><!--/row-->
	  

      <hr>

      <footer>
        <p>ToDo NAcho &copy; Company 2013</p>
      </footer>

    </div><!--/.fluid-container-->
	<div id="addList_head" class="hide">Add a ToDo List   <i id="popover_list_close" onClick="$(this).parent().parent().prev().popover('hide')" class="icon-remove pull-right" ></i></div>
	<div id="addList_content" class="hide">
		<form class="form" >
		<input type="hidden" name="idList" >
		<div class="control-group">
			<label class="control-label" for="inputTitle">Title</label>
			<div class="controls">
			  <input type="text" id="title" name="title" placeholder="Title">
			</div>
			<div class="controls">
				<button type="submit" onClick="return submitAddList($(this).closest('form'));" class="btn">Add</button>
			</div>
		</div>
		</form>
	</div>
	
	<div id="addTask_head" class="hide"><a href="#" class="remove_list" >Remove list   <i id="popover_list_close" class="icon-remove pull-right" ></i></a></div>
	<div id="addTask_content" class="hide">
		<h5>Add a Task:</h5>
		<form class="form" >
		<input type="hidden" name="idList" >
		<div class="control-group">
			<label class="control-label" for="inputTitle">Title</label>
			<div class="controls">
			  <input type="text" id="title" name="title" placeholder="Title">
			</div>
			<label class="control-label" for="inputPriority">Priority</label>
			<div class="controls">
				<select id="priority" name="priority" placeholder="Priority">
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select>
			</div>
			<label class="control-label" for="inputEmail">Due Date</label>
			<div class="controls">
				<div class="input-append date" id="dueDate" >
				<input class="span2"  name="dueDate" style="width:220px" size="16" type="text" placeholder="yyyy-mm-dd">
				
				</div>
			</div>
		</div>
		  
			<div class="controls">
				<button type="submit" onClick="return submitAddTask($(this).closest('form'));" class="btn">Add</button>
			</div>
		
		</form>
	</div>
	
	<div id="popover_items_head" class="hide" style="z-index:9999">Task Actions  <i id="popover_item_close" class="icon-remove pull-right" ></i></div>
	<div id="popover_items_content" class="hide" style="z-index:9999">
		
		<form class="form" >
		<a href="#"  id="popover_items_done" >Done</a> | <a id="popover_items_delete" href="#">Delete</a><br>
		<input type="hidden" name="idList" >
		<input type="hidden" name="status" >
		<input type="hidden" name="idItem" >
		<div class="control-group">
			<label class="control-label" for="inputTitle">Title</label>
			<div class="controls">
			  <input type="text" id="title" name="title" placeholder="Title">
			</div>
			<label class="control-label" for="inputPriority">Priority</label>
			<div class="controls">
				<select id="priority" name="priority" placeholder="Priority">
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select>
			</div>
			<label class="control-label" for="inputEmail">Due Date</label>
			<div class="controls">
				<div class="input-append date" id="dueDate" >
				<input class="span2"  name="dueDate" style="width:220px" size="16" type="text" placeholder="yyyy-mm-dd">
				
				</div>
			</div>
			<div class="controls">
				<button type="submit" onClick="return submitModifyTask($(this).closest('form'))" class="btn">Modify</button>
			</div>
		</div>
		</form>
	</div>
	
    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery.2.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/scripts.js"></script>
	
	<script>
  
	  $(document).ready(function(){
		
		getLists();
		
		popoverHideOnOut();
		
		popoverAddList();
		
		
		
	  });
	  
  
  </script>
  
  </body>
</html>
