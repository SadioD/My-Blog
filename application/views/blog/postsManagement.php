
    <!-- Page Header -->
    <header class="masthead" style="background-image: url('<?php echo base_url() . 'assets/images/'; ?>about-bg.jpg')">
      <div class="overlay"></div>
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-10 mx-auto">
            <div class="site-heading">
              <h1>Options</h1>
              <span class="subheading">Gérez vos Posts</span>
            </div>
          </div>
        </div>
      </div>
    </header>

    <!-- Main Content -->
    <div class="container">
      <?php if(isset($newsList) && !empty($newsList)) { ?>
      <div class="row">
        <div class="col-lg-10 col-md-12 mx-auto">
            <?php if(isset($this->session->flashdata()['flash'])) { ?>
            <span class = "meta" style="color:green;"><i class = "fa fa-check"> <?php echo $this->session->flashdata('flash'); ?></i></span><?php }
            elseif(isset($this->session->flashdata()['redFlash'])) { ?>
            <span class = "meta" style="color:red;"><i class = "fa fa-times"> <?php echo $this->session->flashdata('redFlash'); ?></i></span><?php } ?>
            <span  id = "ajaxBox" class = "meta" style="display:none;"></span>
            <p style = "text-align:justify;">
                Bienvenue dans vos paramètres de gestion de Posts...<br/>
                Vous souhaitez supprimer ou éditer un contenu? Rien de plus simple, cliquez simplement sur le lien correspondants
                à votre action.
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
    <?php foreach($newsList as $news) { ?>
                <div class = "row">
                    <div class = "offset-1 col-6  col-sm-6 box">
                        <?php // On affiche au max 200 caractères du titre
                            if(strlen($news->titre) > 100) {
                                $titre = substr($news->titre, 0, 100);
                                $titre = substr($titre, 0, strrpos($titre, ' ')) . '...';
                                echo $titre;
                            } else { echo $news->titre; }?>
  		            </div>
  		            <div class = "d-none d-sm-block col-sm-2 text-center box">
  			            <?php
                            $dateTime =  new DateTime($news->datePub);
                            echo $dateTime->format('d-m-Y'); ?>
  		            </div>
  		            <div class = "col-5 col-sm-3 box text-center links">
                        <a href = "<?php echo site_url('blog/uniquePost/' . $news->id); ?>" title = "afficher le post" class = "icones">
                            <i class = "fa fa-eye"></i>
                        </a> |
                        <a href = "<?php echo site_url('blog/post/' . $news->id); ?>" title = "modifier le post" class = "icones">
                            <i class = "fa fa-pencil"></i>
                        </a> |
                        <a href="<?php echo site_url('blog/deletePost/' . $news->id); ?>" title = "supprimer le post" class = "icones" id = "<?php echo $news->id; ?>">
                            <i class = "fa fa-trash"></i>
                        </a>
  		            </div>
                </div>
        <?php }
        } else {?>
        <div class="row">
          <div class="col-lg-10 col-md-12 mx-auto">
              <p style = "text-align:center;">
                  Bienvenue dans vos paramètres de gestion de Posts.<br/>
                  A ce jour, vous n'avez encore publier aucun post. <br/>
                  Vous vous sentez inspiré(e) et vous avez envie de vous lacher...
              </p>
              <p style = "text-align:center;">
                  <a style = "border-radius: 4px; text-decoration: none;" class = "btn btn-primary" href = "<?php echo site_url('blog/post'); ?>">Publier un Post</a>
              </p>
          </div>
        </div>
    <?php } ?>
    </div>
    <!-- Overlay -->
    <div id = "setOverlay"></div>

    <!-- AJAX Progess Event Message -->
    <div id = "progressDiv">chargement en cours...</div>
