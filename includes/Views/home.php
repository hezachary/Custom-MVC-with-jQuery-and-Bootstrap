<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo AUTHOR;?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo BASEURLPATH;?>assests/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?php echo BASEURLPATH;?>assests/css/style.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="<?php echo BASEURLPATH;?>assests/js/html5shiv.3.7.2.min.js"></script>
      <script src="<?php echo BASEURLPATH;?>assests/js/respond.1.4.2.min.js"></script>
    <![endif]-->
    <script>
    //<![CDATA[
        var basepath = <?php echo json_encode( BASEURLPATH );?>;
    //]]>
    </script>
  </head>

  <body>

    <div class="container">
        <div class="row">
          <form class="form-contact-us" name="contact_us" action="" method="POST">
            <?php if( $this->blnFormSuccess ):?>
            <?php $this->loadTemplate( 'home.thankyou', true );?>
            <?php else:?>
            <h2 class="form-contact-us-heading">Contact Us</h2>
            <input type="hidden" name="mode" value="submit" />
            <?php $this->loadTemplate( 'home.firstname', true );?>
            <?php $this->loadTemplate( 'home.lastname', true );?>
            <?php $this->loadTemplate( 'home.dob', true );?>
            <?php $this->loadTemplate( 'home.email', true );?>
            <?php $this->loadTemplate( 'home.comments', true );?>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button>
            <?php endif;?>
          </form>
        </div>

    </div> <!-- /container -->


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="<?php echo BASEURLPATH;?>assests/js/jquery.1.11.1.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo BASEURLPATH;?>assests/js/bootstrap.min.js"></script>
    <script src="<?php echo BASEURLPATH;?>assests/js/project.js"></script>
  </body>
</html>
