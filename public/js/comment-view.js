var comment = new function() 
{
	this.base = '';
	this.prefix_container = "comments_";

	this.init =  function (obj) {
		this.base = obj.base;
	};

	this.openReply = function(elem) {
		$(elem).parent().parent().find('.reply').slideToggle();
		return false;
	};

	this.doLikeComment = function(elem,id) 
		{
			//console.log(elem.getAttribute('value'));
			func = $(elem).hasClass('liked')?"removeLike":"doLike";
			
			$.ajax({
					  type: "POST",
					  url: this.base+"comment/"+func,
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
		};

		this.refreshCommentsHTML = function ($post_id)
		{
			$post_id_selector = "#"+this.prefix_container+$post_id;
			$.ajax({
					  type: "GET",
					  url: this.base+"post/getComments",
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
		};

		

		this.deleteCommentAjax = function($id)
		{
			$.ajax({
					  type: "GET",
					  url: this.base+"comment/deleteComment/"+id+"/profile",
					  cache: false,
					  dataType: "json",
					  success: function(obj){
					  	console.log(obj);
					 

					  	if (obj.RC != 200)
					  		return 
					  	comment.refreshCommentsHTML(obj.post_id);
					  }
					});
		};

		this.addCommentAjax = function(elem) 
		{
			$post_id = $(elem).parent().find("input[name='post_id']").val();
		    $comment = $(elem).parent().find("input[name='comment']").val();
		    $parent_id = $(elem).parent().find("input[name='parent_id']").val();
		    console.log('pressed');
	    	$.ajax({
				  type: "POST",
				  url: this.base+"comment/createComment/",
				  data: {post_id: $post_id, comment: $comment, parent_id : $parent_id},
				  cache: false,
				  dataType: "json",
				  success: function(obj){
				
				  	if (obj.RC == 200)
				  		comment.refreshCommentsHTML($post_id);
				  	else 
				  	alert("problem submitting your comment!");
				  	console.log(obj);
				  
				  }.bind($post_id)
				});
		};

		this.deleteComment = function ($id)
		{
			id = parseInt($id);
			ans = window.confirm('do you want delete this Comment?');
			if (ans) {
				this.deleteCommentAjax($id);
			}
			
			return false;
		};

		this.deleteReply  = function ($id)
		{
			id = parseInt($id);
			ans = window.confirm('do you want delete this Reply?');
			
				if (ans) {
				this.deleteCommentAjax($id)
			}
			return false;
		};

		this.run = function() 
		{
			$(document).off('keypress','.add-comment-input').on('keypress','.add-comment-input',function (e) {
				if (e.which == 13) {
			    	comment.addCommentAjax(this);
			    	return false;    //<---- Add this line
			  	}
			});

			$(document).off('click', 'a.del-com').on('click', 'a.del-com', function(e){
				$(this).next().slideToggle();
				return false;
			});

			$(document).off('click', 'ul.opt-del a.com').on('click', 'ul.opt-del a.com', function(){
				return comment.deleteComment($(this).attr('link'));
			});

			$(document).off('click', '.comment-footer a.like-part').on('click', '.comment-footer a.like-part', function(){
				return comment.doLikeComment(this,$(this).attr('link'));
			});
			
			$(document).off('click', '.comment-footer a.reply-sec').on('click', '.comment-footer a.reply-sec', function(){
				return comment.openReply(this);
			});
			
			$(document).off('click', 'a.refresh-all-comments').on('click', 'a.refresh-all-comments', function(){
				comment.refreshCommentsHTML($(this).attr('link'));
				return false;
			});


		};

}




		

		

		
		
		

