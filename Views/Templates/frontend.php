
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
    <link href="<?=$base?>vendor/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?=$base?>vendor/datepicker/datepicker.min.css" rel="stylesheet">


    <link href="<?=$base?>css/timeline.css" rel="stylesheet">
    <script src="<?=$base?>js/jquery.1.11.1.min.js"></script>
    <script src="<?=$base?>vendor/bootstrap-3/js/bootstrap.min.js"></script>
    <script src="<?=$base?>vendor/datepicker/datepicker.min.js"></script>

    <script src="<?=$base?>js/custom.js"></script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="animated fadeIn">
  <?php include $this->partPath("frontend-parts/loged_nav");?>

  <?php include $file;?>  

  <?php include $this->partPath("frontend-parts/chat"); ?>
    
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
