<header class="masthead" style="background-image: url('<?php echo base_url() . 'assets/images/';?>post-bg.jpg')">
      <div class="overlay"></div>
      <div class="container">
        <div class="row">
          <div class="col-lg-9   col-md-11 mx-auto">
            <div class="post-heading">
              <h1>Le formulaire</h1>
              <span class="meta">Les champs Titre et Contenu doivent être renseignés</span>
            </div>
          </div>
        </div>
      </div>
    </header>

    <!-- The Form -->
    <article>
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <div class="card my-4">
                    <h5 class="card-header"><?php echo isset($formTitle) && !empty($formTitle) ? 'Modifier le Post' : 'Ajouter un Post'; ?></h5>
                    <div class="card-body">
                        <form id = "myForm" method="post" action="<?php echo site_url('blog/post'); ?>" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for = "titre">Veuillez entrer un titre :</label><br/>
                                <?php if(isset($news) && !empty($news)) { ?>
                                    <input type = "text" name = "titre" id = "titre" value = "<?php echo $news->titre; ?>" />
                                <?php }  else { ?>
                                    <input type = "text" name = "titre" id = "titre" value = "<?= set_value('titre') ?>"/>
                                <?php } ?>
                                <span class = "errorMessage" style = 'color:red;'><?php if($this->input->server('REQUEST_METHOD') == 'POST') {echo form_error('titre'); } ?></span><br/>
                            </div>
                            <div class="form-group">
                                <label for = "sousTitre">Veuillez entrer un sous-titre :</label><br/>
                                <?php if(isset($news) && !empty($news)) { ?>
                                    <input type = "text" name = "sousTitre" id = "sousTitre" value = "<?php echo $news->sousTitre; ?>" />
                                <?php }  else { ?>
                                    <input type = "text" name = "sousTitre" id = "sousTitre" value = "<?php echo set_value('sousTitre'); ?>"/>
                                <?php } ?>
                                <span class = "sousTitre" style = 'color:red;'></span><br/>
                            </div>
                            <div class="form-group">
                                <label for = "texte">Veuillez entrer un contenu :</label><br/>
                                <?php if(isset($news) && !empty($news)) { ?>
                                    <textarea name = "texte" class="form-control" rows="10" id = "texte"><?php echo $news->contenu; ?></textarea>
                                <?php }  else { ?>
                                    <textarea name = "texte" class="form-control" rows="10" id = "texte"><?php echo set_value('texte'); ?></textarea>
                                <?php } ?>
                                <span class = "errorMessage" style = 'color:red;'><?php if($this->input->server('REQUEST_METHOD') == 'POST') {echo form_error('texte'); } ?></span>
                            </div>
                            <?php if(isset($news) && !empty($news)) { ?>
                                <input type = "text" name = "idNews" value = "<?php echo $news->id; ?>" hidden />
                            <?php } elseif(isset($idNews) && !empty($idNews)) {?>
                                <input type = "text" name = "idNews" value = "<?php echo $idNews; ?>" hidden />
                            <?php } ?>
                            <div class="form-group">
                                <input type = "file" name = "fichier" id = "fichier"/><br/>
                                <label for = "fichier">upload pdf|doc - max 100Ko</label><br/>
                                <span id = "errorUpload" style = "color:red;"><?php if(isset($errorUpload) && !empty($errorUpload)) { echo $errorUpload; } ?></span>
                            </div>
                            <button type="submit" class="btn btn-primary float-right" style = "border-radius:3px;">Envoyer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </article>
