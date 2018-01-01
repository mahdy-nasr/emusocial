
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
            <b style="font-weight:50;">EMU Social Network</b>
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
				<li class="active dropdown" id='sdrop-nav'>
					<a href="#"  class='dropdown-toggle' data-toggle="dropdown">
						<?=$user->getName()?>
						<img src="<?=$base.$user->getProfilePicture()?>" class="img-nav">
						<span class="caret"></span>
					</a>
					<style type="text/css">

					</style>
					<ul class="dropdown-menu back-main-color"  >
					    <li><a href="<?=$base?>profile">Profile timeline</a></li>
					    <li><a href="#">About</a></li>
					    <li class="divider"></li>
					    <li><a href="<?=$base?>home/logout">Logout</a></li>
					</ul>

				</li>
				<li class=""><a href="<?=$base?>"><i class="fa fa-home"></i>&nbsp;Home</a></li>
				<li><a href="messages.html"><i class="fa fa-comments"></i></a></li>
				<li><a href="notifications.html"><i class="fa fa-globe"></i></a></li>
				<!--li class="active"><a href="home.html"><i class="fa fa-bars"></i>&nbsp;Home</a></li-->

				<li><a href="#" class="nav-controller"><i class="fa fa-user"></i> Chat</a></li>
			</ul>
        </div>
      </div>
    </nav>
    <style type="text/css">
    	.broad-div-cont
    	{
    		background: #d32a2a;
    		position:fixed;
    		top:50px;
    		z-index:9999; 
    		width:100%;
    		padding-left:100px;
    	}
    	.broad-div-cont div {
    		padding: 8px 0;
    	}
    	.broad-div-cont div:not(:last-child)
    	{
    		border-bottom: 1px dashed #fff;
    	}
    	.broad-div-cont h5,.broad-div-cont a{
    		color:#fff;
    		display: inline;
    	}
    	.broad-div-cont a{
    		margin-right: 15px;
    	}
    </style>
    <script type="text/javascript">
    	function removeBroad(elem)
    	{
    		$(elem).parent().slideUp();
    		return false;
    	}
    </script>

    <div class="container no-margin broad-div-cont">
    <?php foreach ($user->getBroadcats() as $broadcast) {?>
      	<div class="row">
      		<a href="#" onclick="return removeBroad(this);">x</a> <h5><?=$broadcast['course_code']?> Broadcast: &nbsp;&nbsp;&nbsp;<?=$broadcast['title']?></h5>
      	</div>
    <?php }?>

    </div>








