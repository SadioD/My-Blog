<!DOCTYPE html>
<html lang="fr">
    <head>
        <title><?php echo $title; ?></title>
	 <meta charset = "utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="<?php echo base_url() . 'assets/'; ?>vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
        <link href="<?php echo base_url() . 'assets/'; ?>vendor/bootstrap/css/mdb.min.css" rel="stylesheet"/>
	  <link href="<?php echo base_url() . 'assets/'; ?>vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	  <link rel = "stylesheet" href = "https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>
        <link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'/>
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'/>
	  <!-- link pour le formulaire de connexion -->
	  <link href='https://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'>
	<?php foreach($css as $url): ?>
            <link rel="stylesheet" type="text/css" href="<?php echo $url; ?>" />
        <?php endforeach; ?>
    </head>
    <body>
        <div id="contenu">

            <?php echo $output; ?>

        </div>
	 <hr>
        <!-- Footer -->
        <footer>
          <div class="container">
            <div class="row">
              <div class="col-lg-8 col-md-10 mx-auto">
                <ul class="list-inline text-center">
                  <li class="list-inline-item">
                    <a href="#">
                      <span class="fa-stack fa-lg">
                        <i class="fa fa-circle fa-stack-2x"></i>
                        <i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
                      </span>
                    </a>
                  </li>
                  <li class="list-inline-item">
                    <a href="#">
                      <span class="fa-stack fa-lg">
                        <i class="fa fa-circle fa-stack-2x"></i>
                        <i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
                      </span>
                    </a>
                  </li>
                  <li class="list-inline-item">
                    <a href="#">
                      <span class="fa-stack fa-lg">
                        <i class="fa fa-circle fa-stack-2x"></i>
                        <i class="fa fa-github fa-stack-1x fa-inverse"></i>
                      </span>
                    </a>
                  </li>
                </ul>
			<!-- contenu du footer dans footer.js -->	
                <p class="copyright text-muted"></p>
              </div>
            </div>
          </div>
        </footer>
        
	
	<!-- JS For BootsTrap -->
       <script src="<?php echo base_url() . 'assets/'; ?>vendor/jquery/jquery-3.2.1.min.js"></script>
	 <script src="<?php echo base_url() . 'assets/'; ?>vendor/jquery/jquery.min.js"></script>
       <script src="<?php echo base_url() . 'assets/'; ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	 <script src="<?php echo base_url() . 'assets/'; ?>vendor/bootstrap/js/bootstrap.min.js"></script>
	 <script src="<?php echo base_url() . 'assets/'; ?>vendor/bootstrap/js/popper.min.js"></script>
	 <script src="<?php echo base_url() . 'assets/'; ?>vendor/bootstrap/js/mdb.min.js"></script>
        <?php foreach($js as $url): ?>
            <script type="text/javascript" src="<?php echo $url; ?>"></script>
        <?php endforeach; ?>
    </body>
</html>
