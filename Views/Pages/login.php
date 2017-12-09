
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="<?=$base?>img/favicon.ico">
    <title>CMPE-Socail</title>
    <!-- Bootstrap core CSS -->
    <link href="<?=$base?>vendor/bootstrap-3/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?=$base?>css/animate.min.css" rel="stylesheet">
    <link href="<?=$base?>vendor/font-awesome-4.4.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?=$base?>css/timeline.css" rel="stylesheet">
    <script src="<?=$base?>js/jquery.1.11.1.min.js"></script>
    <script src="<?=$base?>vendor/bootstrap-3/js/bootstrap.min.js"></script>
    <script src="<?=$base?>js/custom.js"></script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="welcome-page animated fadeIn">
    <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top navbar-principal welcome-nav">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">
            <img src="<?=$base?>img/emu-logo.png" class="img-logo">
            <b>EMU Social Network</b>
          </a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav navbar-right">
              <form class="navbar-form form-login" role="form">
                  <div class="form-group">
                      <input type="text" class="form-control" name="username" placeholder="Username">
                  </div>
                  <div class="form-group">
                      <input type="text" class="form-control" name="password" placeholder="Password">
                  </div>
                  <button type="submit" class="btn btn-default btn-login">Login</button>
              </form>     
          </ul>        
        </div>
      </div>
    </nav><!-- end fixed nav-->


     <div class="row-welcome" style="background-image: url('<?=$base?>img/Bg/faces2.png');">
      <div class="row-body">
        <div class="welcome-inner">
          <!-- welcome message -->
          <div class="welcome-message">
            <div class="welcome-title">
              Welcome
            </div>
            <div class="welcome-desc">
              to EMU Computer Engineering social network
            </div>
            <div class="welcome-about">
              best way to communicate with instructor, make friends , for your success!.
            </div>                        
          </div><!-- end welcome message-->
          <!-- register and login form-->
          <div class="welcome-inputs">
            <div class=" animated fadeInLeft">
             
              <img src="<?=$base?>img/emu-logo-badg.png" style='max-width: 70%;position: relative; left:100px;'>

            </div>          
             
          </div><!-- end register and login form -->
        </div>
      </div>
    </div>

    <div class="welcome-full animated fadeInLeft">
      <div class="row-body">
        <!-- some registered users -->
        <h3 class="font-main-color">Computer Engineering Department</h3>
        </div><!-- some registered users -->
      </div>
    </div>


    


    <footer class="welcome-footer">
      <div class="container">
        <p>
          <div class="footer-links">
            <a href="#">Terms of Use</a> | 
            <a href="#">Privacy Policy</a> | 
            <a href="#">Developers</a> | 
            <a href="#">Contact</a> | 
            <a href="#">About</a>
          </div>   
          Copyright &copy; Company - All rights reserved       
        </p>
      </div>
    </footer>
  </body>
</html>
