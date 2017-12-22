
<!-- Fixed navbar -->
					<script src="<?=$base?>js/jquery.ui.widget.js"></script>
					<script src="<?=$base?>js/jquery.iframe-transport.js"></script>
					<script src="<?=$base?>js/jquery.fileupload.js"></script>
    <nav class="navbar navbar-default navbar-fixed-top navbar-principal">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.html">
            <img src="<?=$base?>img/emu-logo.png" class="img-logo">
            <b>EMU Social Network</b>
          </a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
			<div class="col-md-5 col-sm-4">         
			 <form class="navbar-form">
			    <div class="form-group" style="display:inline;">
			      <div class="input-group" style="float:left; width:80%;">
			        <input class="form-control" name="search" placeholder="Search..." autocomplete="off" type="text">
			      </div>
			      <div class="input-group" style="float:left;z-index:3;">

				      <button class="input-group-addon" style="width:45px;">
				        	<span class="glyphicon glyphicon-search"></span>
				      </button>
				 </div>
			    </div>
			  </form>
			</div>        
			<ul class="nav navbar-nav navbar-right">
				<li>
					<a href="profile.html">
						<?=$user->getName()?>
						<img src="<?=$user->getProfilePicture()?>" class="img-nav">
					</a>
				</li>
				<li class="active"><a href="home.html"><i class="fa fa-bars"></i>&nbsp;Home</a></li>
				<li><a href="messages.html"><i class="fa fa-comments"></i></a></li>
				<li><a href="notifications.html"><i class="fa fa-globe"></i></a></li>
				<li><a href="#" class="nav-controller"><i class="fa fa-user"></i>Users</a></li>
			</ul>
        </div>
      </div>
    </nav>