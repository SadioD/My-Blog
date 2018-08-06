
    <!-- Page Header -->
    <header class="masthead" style="background-image: url('<?php echo base_url() . 'assets/images/';?>home-bg.jpg')">
      <div class="overlay"></div>
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-10 mx-auto">
            <div class="site-heading">
              <h1>The Blog</h1>
              <span class="subheading">Découvrez nos dernières news...</span>
            </div>
          </div>
        </div>
      </div>
    </header>

    <!-- Main Content -->
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <?php foreach($newsList as $news): ?>
                    <div class="post-preview">
                        <a href="<?php echo site_url('blog/uniquePost/' . $news->id); ?>">
                            <h2 class="post-title">
                                <?php echo $news->titre; ?>
                            </h2>
                            <h3 class="post-subtitle">
                                <?php // On affiche au max 200 caractères du contenu
                                    if(strlen($news->contenu) > 100) {
                                        $contenu = substr($news->contenu, 0, 100);
                                        $contenu = substr($contenu, 0, strrpos($contenu, ' ')) . '...';
                                        echo $contenu;
                                    } ?>
                            </h3>
                        </a>
                        <p class="post-meta">Posté par
                            <span style = "color:black;"><?php echo $news->pseudo; ?></span>, le
                            <?php
                                $dateTime = new DateTime($news->datePub);
                                echo $dateTime->format('d-m-Y'); ?>
                        </p>
                    </div>
                    <hr>
                <?php endforeach; ?>

                 <!-- Pager -->
                 <div class="d-flex justify-content-center" id = "pagination">
                    <?php echo $this->pagination->create_links(); ?>
                </div>
            </div>
        </div>
    </div>
