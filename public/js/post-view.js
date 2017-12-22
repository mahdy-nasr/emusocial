$start_post=0;$limit_post=10; 
function videoShow(link,name) {
			console.log(link+name);
			$('#file-preview h4.modal-title').html(name);
			elem = "<video width='100%'' controls><source src='"+link+"' type='video/mp4'></video>";
			$('#file-preview div.modal-body').html(elem);
			$('#file-preview').modal('show');
			return false;
		}

		function imageShow(link,name) {
			console.log(link+name);
			$('#file-preview h4.modal-title').html(name);
			elem = "<img  style='display:block;margin:0 auto;' src='"+link+"' class='image show-in-modal' alt='image post' >";
			$('#file-preview div.modal-body').html(elem);
			$('#file-preview').modal('show');
			return false;
		}

		function fileShow(link,name) {
			console.log(link+name);
			$('#file-preview h4.modal-title').html(name);
			elem ="<a href='"+link+"' style='text-align:center' download='download'><h5>Download the file</h5></a>";
			$('#file-preview div.modal-body').html(elem);
			$('#file-preview').modal('show');
			return false;
		}
		function deletePost($id)
		{
			id = parseInt($id);
			ans = window.confirm('do you want delete this post?');
			if (ans)
			window.location = $base+"post/deletePost/"+id+"/profile";
			return false;
		}

		
		function doLike(elem,idd) 
		{
			//console.log(elem.getAttribute('value'));
			
			func = $(elem).hasClass('font-main-color')?"removeLike":"doLike";
			console.log($base);
			
			$.ajax({
					  type: "POST",
					  url: $base+"post/"+func,
					  data: {post_id: idd},
					  cache: false,
					  dataType: "html",
					  success: function(data){
					  	console.log(data);
					  	obj=JSON.parse(data) 

					  	if (obj.RC != 200)
					  		return 
					  	$(elem).find('span').html(obj.count);
					  	$(elem).toggleClass('font-main-color');
						$(elem).toggleClass('not-liked');
					  }.bind(elem)
					});
			

			return false;
		}

		$(document).off('click', 'a.post-user-del').on('click', 'a.post-user-del', function(){
			$(this).parent().next().slideToggle();return false;
			});
		$(document).off('click', 'ul.opt-del-post a').on('click', 'ul.opt-del-post a', function(){

			return deletePost($(this).attr('link'));
			});
		$(document).off('click', 'a.video-list').on('click', 'a.video-list', function(){
			return videoShow($(this).attr('link'),$(this).attr('name'));
			});

		$(document).off('click', 'a.image-list').on('click', 'a.image-list', function(){
			return imageShow($(this).attr('link'),$(this).attr('name'));
			});

		$(document).off('click', 'a.ffile-list').on('click', 'a.ffile-list', function(){
			return fileShow($(this).attr('link'),$(this).attr('name'));
			});


		$(document).off('click', 'a.like-stat').on('click', 'a.like-stat', function(){
			//alert($(this).attr('link'));
			return doLike(this,$(this).attr('link'));
			});
	
		$(document).off('click', 'a.stat-com').on('click', 'a.stat-com', function(){

		return false;
			});


		function refreshPostsHTML()
		{
			//$post_id_selector = "#comments_"+$post_id;
			 $start_post+=10;$limit_post+=10;
			$.ajax({
					  type: "GET",
					  url: $base+"post/getProfilePosts?id="+$profile_id,
					  data: {start: $start_post, limit: $limit_post},
					  cache: false,
					  dataType: "html",
					  success: function(data){
					  	//console.log(data);
					  	console.log(data.length);
					  	if(data.length<50) {
					  		$('#id-post-load-more').css('display','none');
					  	} else{
					  		$('#id-post-load-more').css('display','block');
					  	}
					  	$('#post-cont').append(data);
					  
					  }
					});
		}

$(window).scroll(function() {
   if($(window).scrollTop() + $(window).height() == $(document).height()) {
       refreshPostsHTML();
      // $(window).scrollTop($(document).height() - 150);

   }
});