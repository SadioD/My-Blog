
    <!-- Page Header -->
    <header class="masthead" style="background-image: url('<?php echo base_url() . 'assets/images/'; ?>about-bg.jpg')">
      <div class="overlay"></div>
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-10 mx-auto">
            <div class="site-heading">
              <h1>Search</h1>
              <span class="subheading">Les résultats de votre Recherche</span>
            </div>
          </div>
        </div>
      </div>
    </header>

    <!-- Main Content -->
    <?php if(isset($results) && !empty($results)) { ?>
    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-md-12 mx-auto">
                <p style = "text-align:justify;">
                    Nous avons trouvé au moins un post...
                </p>
            </div>
        </div>
        <div class = "row">
            <div class = "offset-1 col-6 col-sm-6 text-center box">
                <span style = "font-weight: bold;">Titre</span>
		    </div>
		    <div class = "d-none d-sm-block col-sm-2 text-center box">
			    <span style = "font-weight: bold;">Date</span>
		    </div>
		    <div class = "col-5 col-sm-3 text-center box">
		  	    <span style = "font-weight: bold;">Actions</span>
		    </div>
        </div>

        <!-- Affichage de la liste des Post -->
        <?php for($i = 0; $i < count($results); $i++) { ?>
            <div class = "row">
                <div class = "offset-1 col-6  col-sm-6 box">
                    <?php echo $results[$i]->titre; ?>
  	            </div>
  	            <div class = "d-none d-sm-block col-sm-2 text-center box">
  		            <?php
                        $dateTime =  new DateTime($results[$i]->datePub);
                        echo $dateTime->format('d-m-Y'); ?>
  	            </div>
  	            <div class = "col-5 col-sm-3 box text-center links">
                    <a href = "<?php echo site_url('blog/uniquePost/' . $results[$i]->id); ?>" title = "afficher le post" class = "icones">
                        <i class = "fa fa-eye"></i>
                    </a>
  	            </div>
            </div>
        <?php } ?>
    </div>
    <?php } else { ?>

        <div class="row">
            <div class="offset-1 col-10 offset-sm-3 col-sm-9">
                <p style = "text-align:justify;" class = "notFound">
                    Désolé votre recherche ne correspond à aucun Post!
                </p>
            </div>
        </div>
        <div class="row">
            <div class="offset-5 col-6">
                <i class="fa fa-frown-o fa-5x notFound"></i>
            </div>
        </div>


    <?php } ?>
