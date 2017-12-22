
		function openReply(elem)
		{
			$(elem).parent().parent().find('.reply').slideToggle();
			return false;
		}



		

		function doLikeComment(elem,id) 
		{
			//console.log(elem.getAttribute('value'));
			func = $(elem).hasClass('liked')?"removeLike":"doLike";
			
			$.ajax({
					  type: "POST",
					  url: $base+"comment/"+func,
					  data: {post_id: id},
					  cache: false,
					  dataType: "json",
					  success: function(obj){
					  	console.log(obj);
					 

					  	if (obj.RC != 200)
					  		return 
					  	$(elem).find('span').html(obj.count);
					  	$(elem).toggleClass('liked');
						$(elem).toggleClass('not-liked');
					  }.bind(elem)
					});
			

			return false;
		}

		function refreshCommentsHTML($post_id)
		{
			$post_id_selector = "#comments_"+$post_id;
			$.ajax({
					  type: "GET",
					  url: $base+"post/getComments",
					  data: {post_id: $post_id},
					  cache: false,
					  dataType: "html",
					  success: function(data){
					  	prnt = $($post_id_selector).parent();
					  	$($post_id_selector).html('');

					  	prnt.html(data);
					  	//eval(data);
					  
					  }.bind($post_id_selector)
					});
		}
		function deleteComment($id)
		{
			id = parseInt($id);
			ans = window.confirm('do you want delete this Comment?');
			if (ans) {
				$.ajax({
					  type: "GET",
					  url: $base+"comment/deleteComment/"+id+"/profile",
					  cache: false,
					  dataType: "json",
					  success: function(obj){
					  	console.log(obj);
					 

					  	if (obj.RC != 200)
					  		return 
					  	refreshCommentsHTML(obj.post_id);
					  }
					});
			}
			
			return false;
		}

		function deleteReply($id)
		{
			id = parseInt($id);
			ans = window.confirm('do you want delete this Reply?');
			
				if (ans) {
				$.ajax({
					  type: "GET",
					  url: $base+"comment/deleteComment/"+id+"/profile",
					  cache: false,
					  dataType: "json",
					  success: function(obj){
					  	console.log(obj);
					 

					  	if (obj.RC != 200)
					  		return 
					  	refreshCommentsHTML(obj.post_id);
					  }
					});
			}
			return false;
		}


		$(document).off('keypress','.add-comment-input').on('keypress','.add-comment-input',function (e) {
			if (e.which == 13) {
		    	$post_id = $(this).parent().find("input[name='post_id']").val();
		    	$comment = $(this).parent().find("input[name='comment']").val();
		    	$parent_id = $(this).parent().find("input[name='parent_id']").val();
		    	console.log('pressed');
		    	$.ajax({
					  type: "POST",
					  url: $base+"comment/createComment/",
					  data: {post_id: $post_id, comment: $comment, parent_id : $parent_id},
					  cache: false,
					  dataType: "json",
					  success: function(obj){
					
					  	if (obj.RC == 200)
					  		refreshCommentsHTML($post_id);
					  	else 
					  	alert("problem submitting your comment!");
					  	console.log(obj);
					  
					  }.bind($post_id)
					});
		    	//refreshCommentsHTML()
		    	return false;    //<---- Add this line
		  	}
		});

			$(document).off('click', 'a.del-com').on('click', 'a.del-com', function(e){

    $(this).next().slideToggle();
    console.log('clicked');
    return false;
});

		$(document).off('click', 'ul.opt-del a.com').on('click', 'ul.opt-del a.com', function(){
			return deleteComment($(this).attr('link'));
			});
		$(document).off('click', '.comment-footer a.like-part').on('click', '.comment-footer a.like-part', function(){

			return doLikeComment(this,$(this).attr('link'));
			});
		$(document).off('click', '.comment-footer a.reply-sec').on('click', '.comment-footer a.reply-sec', function(){

		return openReply(this);
			});
		$(document).off('click', 'a.refresh-all-comments').on('click', 'a.refresh-all-comments', function(){
			refreshCommentsHTML($(this).attr('link'));
			return false;
			});