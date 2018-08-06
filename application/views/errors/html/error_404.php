<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="eng">
    <head>
	 	<meta charset = "utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="http://homework:800/Projects/Blog/CodeIgniter/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
        <link href="http://homework:800/Projects/Blog/CodeIgniter/assets/vendor/bootstrap/css/mdb.min.css" rel="stylesheet"/>
	  	<link href="http://homework:800/Projects/Blog/CodeIgniter/assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	  	<link rel = "stylesheet" href = "https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>
        <link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'/>
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'/>

		<link href="http://homework:800/Projects/Blog/CodeIgniter/assets/css/clean-blog.min.css" rel="stylesheet" type="text/css" />
		<link href="http://homework:800/Projects/Blog/CodeIgniter/assets/css/menu.css" rel="stylesheet" type="text/css" />
		<link href="http://homework:800/Projects/Blog/CodeIgniter/assets/css/footer.css" rel="stylesheet" type="text/css" />
		<title>404 Page Not Found</title>
	</head>
    <body>
		<!--- MENU -->
		<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
		    <a class="navbar-brand" href="index.html">Sadio Diallo</a>
		    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
		        Menu
		        <i class="fa fa-bars"></i>
		    </button>
		    <div class="collapse navbar-collapse" id="navbarResponsive">
		        <ul class="navbar-nav ml-auto">
		            <li class="nav-item">
		                <a class="nav-link" href="http://homework:800/Projects/Blog/CodeIgniter/">Home</a>
		            </li>
		            <li class="nav-item">
		                <a class="nav-link" href="http://homework:800/Projects/Blog/CodeIgniter/blog/lastNews">Blog</a> <!-- 3 dernieres News + Older -->
		            </li>
		        </ul>
		    </div>
		</nav>

		<!-- HEADER - arrière plan Menu -->
		<!-- Page Header -->
	    <header class="masthead" style="background-image: url('http://homework:800/Projects/Blog/CodeIgniter/assets/images/about-bg.jpg')">
	      <div class="overlay"></div>
	      <div class="container">
	        <div class="row">
	          <div class="col-lg-8 col-md-10 mx-auto">
	            <div class="page-heading">
				  <h2><i class="fa fa-frown-o fa-4x"></i></h2>
				  <h2><?php echo $heading; ?></h2>
	              <span class="subheading"><?php echo $message; ?></span>
	            </div>
	          </div>
	        </div>
	      </div>
	    </header>

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
       	<script src="http://homework:800/Projects/Blog/CodeIgniter/assets/vendor/jquery/jquery-3.2.1.min.js"></script>
	 	<script src="http://homework:800/Projects/Blog/CodeIgniter/assets/vendor/jquery/jquery.min.js"></script>
       	<script src="http://homework:800/Projects/Blog/CodeIgniter/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	 	<script src="http://homework:800/Projects/Blog/CodeIgniter/assets/vendor/bootstrap/js/bootstrap.min.js"></script>
	 	<script src="http://homework:800/Projects/Blog/CodeIgniter/assets/vendor/bootstrap/js/popper.min.js"></script>
	 	<script src="http://homework:800/Projects/Blog/CodeIgniter/assets/vendor/bootstrap/js/mdb.min.js"></script>
		<script src="http://homework:800/Projects/Blog/CodeIgniter/assets/js/clean-blog.min.js"></script>
		<script src="http://homework:800/Projects/Blog/CodeIgniter/assets/js/footer.js"></script>
    </body>
</html>
