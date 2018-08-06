<header class="masthead" style="background-image: url('<?php echo base_url() . 'assets/images/';?>post-bg.jpg')">
      <div class="overlay"></div>
      <div class="container">
        <div class="row">
          <div class="col-lg-9   col-md-11 mx-auto">
            <div class="post-heading">
              <h1><?php echo $news->titre; ?></h1>
              <a class = "btn btn-primary float-right downloadButton" href = "<?php echo site_url('blog/uniquePost/' . $news->id); ?>">
                 &larr; Retour
              </a>
              <span class="meta">Posté sur le blog à la date du
                  <?php
                      $dateTime =  new DateTime($news->datePub);
                      echo $dateTime->format('d-m-Y'); ?>
              </span>
            </div>
          </div>
        </div>
      </div>
    </header>

    <!-- Comment -->
    <article>
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <div class="media mb-4">
                    <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
                    <div class="media-body commentBox">
                        <h5 class="mt-0"><?php echo $comment->auteur(); ?></h5>
                        <p><?php echo $comment->contenu(); ?><br/>
                            <span class = "timeAgo"><em>
                                Posté il y a <?php echo $comment->dateAjout(); ?>
                            </em></span>
                        </p>
                    </div>
                </div>
                <hr>
                <!-- Comments Form -->
                <div class="card my-4">
                    <h5 class="card-header">Répondre un commentaire:</h5>
                    <div class="card-body">
                        <form id = "myForm" method="post" action="<?php echo site_url('blog/reply/' . $news->id . '/' . $comment->id()); ?>">
                            <div class="form-group">
                                <span id = "errorMessage" style = 'color:red;'><?php if($this->input->server('REQUEST_METHOD') == 'POST') {echo form_error('contenu'); } ?></span>
                                <textarea name = "contenu" class="form-control" rows="3" id = "textArea"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary float-right" style = "border-radius:3px;">Envoyer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </article>
