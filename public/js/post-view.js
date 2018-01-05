function ucfirst(string) 
{
    return string.charAt(0).toUpperCase() + string.slice(1);
}

var post = new function() 
{
	this.start_post = 0;
	this.limit_post = 10;
	this.base = '';
	this.profile_id=0;
	this.type='profile';
	this.autoPull = true;
	this.refreshPostURL='';
	
	this.modal = {
		title: 'h4.modal-title',
		body: 'div.modal-body',
		id: "file-preview"
	};

	this.css_class = {
		liked: "font-main-color",
		not_liked :"not-liked"
	};

	this.post_main_container = 'post-cont';
	this.loading_div = "id-post-load-more";
	
	this.init =  function (obj) {
		console.log(obj.base);
		this.base = obj.base;
		this.type = obj.type;
		this.profile_id = obj.profile_id;
		this.refreshPostURL = obj.refreshPostURL;
		this.autoPull = obj.autoPull;

	};

	this.fileShow = function (link,name,type) {
			console.log(link+name);
			$id  = '#'+this.modal.id;
			$($id+' '+this.modal.title).html(name);

			if (type == 'video') {
				elem = "<video width='100%'' controls><source src='"+link+"' type='video/mp4'></video>";
			} else if (type == 'image') {
				elem = "<img  style='display:block;margin:0 auto;' src='"+link+"' class='image show-in-modal' alt='image post' >";
			} else {
							elem ="<a href='"+link+"' style='text-align:center' download='download'><h5>Download the file</h5></a>";
			}

			$($id+' '+this.modal.body).html(elem);
			$($id).modal('show');
			return false;
		}


	this.deletePost = function($id)
		{
			id = parseInt($id);
			ans = window.confirm('do you want delete this post?');
			if (ans)
			window.location = this.base+"post/deletePost/"+id+"/"+this.type;
			return false;
		}

	 this.doLike = function (elem,idd) 
		{
			//console.log(elem.getAttribute('value'));
			
			func = $(elem).hasClass(this.css_class.liked)?"removeLike":"doLike";
			console.log(this);
			//base = 
			$.ajax({
					  type: "POST",
					  url: this.base+"post/"+func,
					  data: {post_id: idd},
					  cache: false,
					  dataType: "html",
					  success: function(obj,data) {
					  	console.log(data);
					  	res=JSON.parse(data) 

					  	if (res.RC != 200)
					  		return 
					  	$(elem).find('span').html(res.count);
					  	$(elem).toggleClass(obj.css_class.liked);
						$(elem).toggleClass(obj.css_class.not_liked);
					  }.bind(elem,this)
					});
			

			return false;
		}

		this.refreshPostsHTML = function ()
		{
			//$post_id_selector = "#comments_"+$post_id;
			 this.start_post+=10;this.limit_post+=10;
			 post_container = '#'+this.post_main_container;
			 loading_div = '#'+this.loading_div;


			$.ajax({
					  type: "GET",
					  url: this.base+this.refreshPostURL+"?id="+this.profile_id,
					  data: {start: this.start_post, limit: this.limit_post},
					  cache: false,
					  dataType: "html",
					  success: function(data){
					  	//console.log(data);
					  	console.log(data.length);
					  	if(data.length<50) {
					  		$(loading_div).css('display','none');
					  	} else{
					  		$(loading_div).css('display','block');
					  	}
					  	$(post_container).append(data);
					  
					  }
					});
		}
		this.run = function()
		{
				$(document).off('click', 'a.post-user-del').on('click', 'a.post-user-del', function(){
				$(this).parent().next().slideToggle();return false;
				});

				$(document).off('click', 'ul.opt-del-post a').on('click', 'ul.opt-del-post a', function(){

					return post.deletePost($(this).attr('link'));
					});
				$(document).off('click', 'a.video-list').on('click', 'a.video-list', function(){
					return post.fileShow($(this).attr('link'),$(this).attr('name'),'video');
					});

				$(document).off('click', 'a.image-list').on('click', 'a.image-list', function(){
					return post.fileShow($(this).attr('link'),$(this).attr('name'),'image');
					});

				$(document).off('click', 'a.ffile-list').on('click', 'a.ffile-list', function(){
					return post.fileShow($(this).attr('link'),$(this).attr('name'),'file');
					});


				$(document).off('click', 'a.like-stat').on('click', 'a.like-stat', function(){
					//alert($(this).attr('link'));
					return post.doLike(this,$(this).attr('link'));
					});
			
				$(document).off('click', 'a.stat-com').on('click', 'a.stat-com', function(){

				return false;
					});
			if (this.autoPull) {
				console.log(this.autoPull+'why !!');
				$(window).scroll(function() {
				   if($(window).scrollTop() + $(window).height() == $(document).height()) {
				       post.refreshPostsHTML();
				      // $(window).scrollTop($(document).height() - 150);

				   }
				});
			}
		}



}



		


		

