<header class="masthead" style="background-image: url('<?php echo base_url() . 'assets/images/';?>post-bg.jpg')">
      <div class="overlay"></div>
      <div class="container">
        <div class="row">
          <div class="col-lg-9   col-md-11 mx-auto">
            <div class="post-heading">
              <h1><?php echo $news->titre; ?></h1>
              <?php if($news->fichier != null) { ?>
                  <a class = "btn btn-primary float-right downloadButton" href = "<?php echo base_url() . 'assets/documents/' . $news->fichier; ?>" target = "_blank" title = "télécharger la pièce jointe">
                      download  <i class = "fa fa-cloud-download"></i>
                  </a>
              <?php } ?>
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

    <!-- Post Content -->
    <article>
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <h2 class="section-heading"><?php echo $news->sousTitre; ?></h2>
                <p><?php echo $news->contenu; ?></p>
                <a href="#">
                    <img class="img-fluid" src="<?php echo base_url() . 'assets/images/';?>post-sample-image.jpg" alt="">
                </a>

                <!-- Comments Form -->
                <?php if ($this->session->isAuthentificated()) { ?>
                    <?php if(isset($this->session->flashdata()['flash'])) { ?>
                <hr>
                <span class = "meta" style="color:green;"><i class = "fa fa-check"><?php echo $this->session->flashdata('flash'); ?></i></span><?php } ?>
                <div class="card my-4">
                    <h5 class="card-header">Ajouter un commentaire:</h5>
                    <div class="card-body">
                        <form method="post" id = "myForm" action="<?php echo site_url('blog/uniquePost/' . $news->id); ?>">
                            <div class="form-group">
                                <span id = "errorMessage" style = 'color:red;'><?php if($this->input->server('REQUEST_METHOD') == 'POST') {echo form_error('contenu'); } ?></span>
                                <textarea name = "contenu" class="form-control" rows="3" id = "textArea"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary float-right" style = "border-radius:3px;">Envoyer</button>
                        </form>
                    </div>
                </div>
            <?php } ?>

            <!-- Comments Title -->
            <?php if (!$this->session->isAuthentificated()) {
                     if(isset($comments) && !empty($comments)) {?>
            <hr><br/><h3>Les commentaires</h3><br/>
            <?php }
            } ?>

            <!-- Single Comment -->
    <?php for($i = 0; $i < count($comments); $i++) {
              if($comments[$i]->id() != $comments[$i]->idRep()) { ?>
                <div class="media mb-4">
                    <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
                    <div class="media-body commentBox">
                        <h5 class="mt-0"><?php echo $comments[$i]->auteur(); ?></h5>
                        <p><?php echo $comments[$i]->contenu(); ?><br/>
                            <span class = "timeAgo"><em>
                                Posted <?php echo $comments[$i]->dateAjout(); ?>
                            </em></span>
                            <?php if ($this->session->isAuthentificated()) { ?>
                            <a href = "<?php echo site_url('blog/reply/' . $news->id . '/' . $comments[$i]->id());?>" id = "replyLink" title = "répondre au commentaire">
                                <i class = "fa fa-reply"></i>
                            </a>
                            <span class = "links">
                                <a class="btn btn-blue btn-sm float-right likeButtons like" id = "<?php echo $comments[$i]->id(); ?>" href= "">
                                    <?php if($comments[$i]->socialStatus() == 'liked') { ?>
                                    <i class="fa fa-check"></i> <span id = "<?php echo $this->session->userdata('userId'); ?>"><?php echo $comments[$i]->liked(); ?></span>
                                    <?php } else { ?>
                                    <i class="fa fa-thumbs-up icon"></i> <span id = "<?php echo $this->session->userdata('userId'); ?>"><?php echo $comments[$i]->liked(); ?></span>
                                    <?php } ?>
                                </a>
                                <a class="btn btn-blue btn-sm float-right likeButtons hate" id = "<?php echo $comments[$i]->id(); ?>" href= "">
                                    <?php if($comments[$i]->socialStatus() == 'hated') { ?>
                                    <i class="fa fa-check"></i> <span id = "<?php echo $this->session->userdata('userId'); ?>"><?php echo $comments[$i]->hated(); ?></span>
                                    <?php } else { ?>
                                    <i class="fa fa-thumbs-down icon"></i> <span id = "<?php echo $this->session->userdata('userId'); ?>"><?php echo $comments[$i]->hated(); ?></span>
                                    <?php } ?>
                                </a>
                            </span>
                            <?php } ?>
                        </p>
                    </div>
                </div>
    <?php }
        else { ?>
                <div class="media mb-4">
                    <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
                    <div class="media-body commentBox">
                        <h5 class="mt-0"><?php echo $comments[$i]->auteur(); ?></h5>
                        <p><?php echo $comments[$i]->contenu(); ?><br/>
                            <span class="timeAgo"><em>
                                Posted <?php echo $comments[$i]->dateAjout(); ?>
                            </em></span>
                            <?php if ($this->session->isAuthentificated()) { ?>
                            <a href = "<?php echo site_url('blog/reply/' . $news->id . '/' . $comments[$i]->id());?>" id = "replyLink" title = "répondre au commentaire">
                                <i class = "fa fa-reply"></i>
                            </a> |
                            <?php } ?>
                            <a id = "nestLink" title = "afficher les réponses" data-toggle="collapse" href="<?php echo '#' . $i; ?>" role="button" aria-expanded="false" aria-controls="<?php echo $i; ?>">
                                <i class = "fa fa-comments"></i>
                            </a>
                            <?php if ($this->session->isAuthentificated()) { ?>
                            <span class = "links">
                                <a class="btn btn-blue btn-sm float-right likeButtons like" id = "<?php echo $comments[$i]->id(); ?>" href= "">
                                    <?php if($comments[$i]->socialStatus() == 'liked') { ?>
                                    <i class="fa fa-check"></i> <span id = "<?php echo $this->session->userdata('userId'); ?>"><?php echo $comments[$i]->liked(); ?></span>
                                    <?php } else { ?>
                                    <i class="fa fa-thumbs-up icon"></i> <span id = "<?php echo $this->session->userdata('userId'); ?>"><?php echo $comments[$i]->liked(); ?></span>
                                    <?php } ?>
                                </a>
                                <a class="btn btn-blue btn-sm float-right likeButtons hate" id = "<?php echo $comments[$i]->id(); ?>" href= "">
                                    <?php if($comments[$i]->socialStatus() == 'hated') { ?>
                                    <i class="fa fa-check"></i> <span id = "<?php echo $this->session->userdata('userId'); ?>"><?php echo $comments[$i]->hated(); ?></span>
                                    <?php } else { ?>
                                    <i class="fa fa-thumbs-down icon"></i> <span id = "<?php echo $this->session->userdata('userId'); ?>"><?php echo $comments[$i]->hated(); ?></span>
                                    <?php } ?>
                                </a>
                            </span>
                            <?php } ?>
                        </p>
                        <div class ="collapse" id = "<?php echo $i; ?>">
            <?php foreach($repliesData as $repliesList) {
                    foreach($repliesList as $reply) {
                        if($comments[$i]->id() == $reply->idComment()) {?>
                            <div class="media mt-4">
                                <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
                                <div class="media-body nestComment">
                                    <h5 class="mt-0">
                                        <?php echo $reply->auteur(); ?>
                                    </h5>
                                    <p>
                                        <?php echo $reply->contenu() . '<br/>'; ?>
                                        <span class="timeAgo"><em>
                                            Posted
                                            <?php echo $reply->dateAjout(); ?>
                                        </em></span>
                                    </p>
                                </div>
                            </div>
                            <?php }
                               }
                           } ?>
                        </div>
                    </div>
                </div>
            <?php }
                } ?>
            </div>
        </div>
    </article>
    <!-- Pager -->
    <div class="d-flex justify-content-center" id = "pagination">
       <?php echo $this->pagination->create_links(); ?>
   </div>
