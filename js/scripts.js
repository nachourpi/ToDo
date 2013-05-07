		
		/* This is seems to be the most complex function. But actually what it does is just
		   retrive the toDo lists with its respectives tasks and initialize each popover tooltip.
		*/
		function getLists(){
	  
			if(typeof getLists.order == 'undefined'){		
				var order;
			}
			if(typeof getLists.orderBy == 'undefined'){
				var orderBy;
			}
			
			$('#lists').html('');
			$.ajax({
				  url: "lists.php?action=list",
				  data:{orderBy:getLists.orderBy,order:getLists.order},
				  dataType:'json',
				  context: document.body
				}).done(function(data) {
				  
				  $.each(data, function() { 
						
						$('#lists').append('<ul class="nav nav-list" id="list_'+this.idList+'"><li id="popover_'+this.idList+'" class="nav-header" style="cursor:pointer" ><i value="'+this.idList+'" class="icon-file popover-link"></i>'+this.title+'</li></ul>');	
						
						var list = this;
						
						/* Now we format each item from the toDo list with it corresponding popover tooltip */
						$.each(this.items, function() {
							$('#list_'+this.idList).append('<li><a href="#" class="popover-link" id="popover_items_'+this.idItem+'" value="'+this.idItem+'" '+((this.status==2)?'style="text-decoration: line-through;"':'')+'><span style="margin-right:10px;">'+this.priority+'</span><span style="margin-right:20px;">'+this.dueDate+'</span>'+this.title+'</a></li>');
							
							var item = this;
							
							$('#popover_items_'+this.idItem).popover({ 
								html : true,
								placement:'bottom',
								title: function() {
									$('#popover_item_close').attr('onClick','$(this).parent().parent().prev().popover("hide")');
									
									return $("#popover_items_head").html();
								},
								content: function() {
								  
								  $("#popover_items_content input[name=title]").attr('value',item.title);
								  $("#popover_items_content input[name=dueDate]").attr('value',item.dueDate);
								  $("#popover_items_content input[name=idList]").attr('value',item.idList);
								  $("#popover_items_content input[name=idItem]").attr('value',item.idItem);
								  $("#popover_items_content input[name=status]").attr('value',item.status);
								  $("#popover_items_content option").removeAttr('selected');
								  $("#popover_items_content option[value="+item.priority+"]").attr('selected','selected');
								  
								  
								  $("#popover_items_delete").attr('onClick','return deleteItem('+item.idItem+')');
								  $("#popover_items_done").html((item.status==1)?'Done':'Undone');
								  
								  $("#popover_items_done").attr("onClick","$(this).parent().find('input[name=status]').attr('value','"+((item.status==1)?"2":"1")+"');return submitModifyTask($(this).parent());");
								  
								  return $("#popover_items_content").html();
								  
								}
							});
						});
						
						/* Now we initialize the popover tooltip for each toDo list in order to add items or tasks */
						$('#popover_'+this.idList).popover({ 
						html : true,
						placement:'bottom',
						title: function() {
							$('#popover_list_close').attr('onClick','$(this).parent().parent().prev().popover("hide")');
							$("#addTask_head .remove_list").attr('onClick','return deleteList('+list.idList+')');
							return $("#addTask_head").html();
						},
						content: function() {
						  $("#addTask_content input[name=idList]").attr('value',list.idList);
						  return $("#addTask_content").html();
						}
					});
					});
					
					
					
					
				  
				});
		}
		
		/* Function just to initialize the popover tooltip for adding new toDo lists */
		function popoverAddList(){
			$("#popover_addList").popover({ 
						html : true,
						placement:'bottom',
						title: function() {
							return $("#addList_head").html();
						},
						content: function() {
						  return $("#addList_content").html();
						}
			});
		}
		
		/* This is a sort of fix for the twitter bootstrap popover in order to hide them when we click somewhere else */
		function popoverHideOnOut(){
			$('body').on('click', function (e) {
				$('.popover-link').each(function () {
					//the 'is' for buttons that triggers popups
					//the 'has' for icons within a button that triggers a popup
					if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
						$(this).popover('hide');
					}
				});
			});
		}
	
	  /* The following 2 functions set the order and orderBy parameters in order to list the toDo lists */
	  function orderListByDueDate(){
		
		if(typeof orderListByDueDate.order == 'undefined'){
			var order = 1;
		}
		
		if($("#orderDueDate i").hasClass('icon-chevron-down')){
			$("#orderDueDate i").removeClass('icon-chevron-down');
			$("#orderDueDate i").addClass('icon-chevron-up');
		}else{
			$("#orderDueDate i").removeClass('icon-chevron-up');
			$("#orderDueDate i").addClass('icon-chevron-down');
		}
		
		getLists.orderBy=1;
		getLists.order=orderListByDueDate.order;
		
		orderListByDueDate.order=((orderListByDueDate.order==1)?2:1);
		
		return getLists();
	  }
	  
	  function orderListByPriority(){
		
		if(typeof orderListByPriority.order == 'undefined'){
			var order = 1;
		}
		
		if($("#orderPriority i").hasClass('icon-chevron-down')){
			$("#orderPriority i").removeClass('icon-chevron-down');
			$("#orderPriority i").addClass('icon-chevron-up');
		}else{
			$("#orderPriority i").removeClass('icon-chevron-up');
			$("#orderPriority i").addClass('icon-chevron-down');
		}
		
		getLists.orderBy=2;
		getLists.order=orderListByPriority.order;
		
		orderListByPriority.order=((orderListByPriority.order==1)?2:1);
		
		return getLists();
	  }
	  
	  function submitAddList(form){

			
			$.ajax({
			  url: "lists.php?action=create",
			  type:"post",
			  data:form.serialize(),
			  context: document.body
			}).done(function(data) {
			
			  getLists();
			  
			});
			
			return false;
		}
	  function submitAddTask(form){

					
			$.ajax({
			  url: "items.php?action=create",
			  type:"post",
			  data:form.serialize(),
			  context: document.body
			}).done(function(data) {
			  getLists();
			});
			
			return false;
		}
		function submitModifyTask(form){

			$.ajax({
			  url: "items.php?action=modify",
			  type:"post",
			  data:form.serialize(),
			  context: document.body
			}).done(function(data) {
			  getLists();
			});
			
			return false;
		}
		function deleteItem(idItem){
			$.ajax({
			  url: "items.php?action=delete",
			  type:"post",
			  data:{idItem:idItem},
			  context: document.body
			}).done(function(data) {
			  getLists();
			});
			
			return false;
		}
		function deleteList(idList){
			$.ajax({
			  url: "lists.php?action=delete",
			  type:"post",
			  data:{idList:idList},
			  context: document.body
			}).done(function(data) {
			  getLists();
			});
			
			return false;
		}