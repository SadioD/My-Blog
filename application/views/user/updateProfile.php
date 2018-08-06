<!-- Page Header -->
<header class="masthead" style="background-image: url('<?php echo base_url() . 'assets/images/';?>home-bg.jpg')">
  <div class="overlay"></div>
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-md-10 mx-auto">
        <div class="site-heading">
          <h1>The Profile</h1>
          <span class="subheading">Mettez à jour votre profile...</span>
        </div>
      </div>
    </div>
  </div>
</header>

<div class = "row">
    <div class = "offset-1 col-11 offset-sm-0 col-sm-12 text-center">

        <!-- Flash Message -->
        <?php if(isset($errorUpload) && !empty($errorUpload)) { ?>
            <span class = "meta formError"><?php echo $errorUpload; ?></span><?php } ?>

        <!-- Alerte Désactivation Javascript -->
        <noscript>
            <span style = "color:red;">
                Oups... Il semblerait que Javascript ne soit pas activé sur votre navigateur.
                Certaines fonnalités de ce site ne seront pas accessibles.
            </span>
        </noscript>
    </div>
</div>

<!-- Formulaire de mise à jour des données -->
<div class = "row formRow">
    <div class="form col-lg-8 col-md-10 mx-auto connectForm">
        <div class="tab-content">
            <!-- The SignUp Form -->
            <div id="signup">
                <h1>Your Infos</h1>
                <form action="" method="post" id = "updateForm" enctype="multipart/form-data">
                    <div class="group">
                        <label>First Name</label>
                        <input type="text" name = "pseudo" id = "prenom" value="<?php echo isset($member) && !empty($member) ? $member->pseudo : set_value('pseudo'); ?>" />
                        <span class = "formError"><?php echo form_error('pseudo'); ?></span>
                    </div>
                    <div class="group">
                        <label>
                            Last Name
                        </label>
                        <input type="text" name = "nom" id = "nom" value="<?php echo isset($member) && !empty($member) ? $member->nom : set_value('nom'); ?>" />
                        <span class = "formError"><?php echo form_error('nom'); ?></span>
                    </div>
                    <div class="group">
                        <label>
                            Email Address
                        </label>
                        <input type="email" name = "firstEmail" id = "firstEmail" value="<?php echo isset($member) && !empty($member) ? $member->email : set_value('firstEmail'); ?>" />
                        <span class = "formError"><?php echo form_error('firstEmail'); ?></span>
                    </div>
                    <div class="group">
                        <label>
                            Confirm the email
                        </label>
                        <input type="email" name = "sndEmail" id = "sndEmail" value="<?php echo isset($member) && !empty($member) ? $member->email : set_value('sndEmail'); ?>" />
                        <span class = "formError"><?php echo form_error('sndEmail'); ?></span>
                    </div>
                    <div class="group">
                        <label>
                            Set A Password
                        </label>
                        <input type="password" name = "firstPass" id = "firstPass" value="<?php echo set_value('firstPass'); ?>" placeholder = "Au moins 6 caractères"/>
                        <span class = "formError"><?php echo form_error('firstPass'); ?></span>
                    </div>
                    <div class="group">
                        <label>
                            Confirm the Password
                        </label>
                        <input type="password" name = "sndPass" id = "sndPass" value="<?php echo set_value('sndPass'); ?>" />
                        <span class = "formError"><?php echo form_error('sndPass'); ?></span>
                    </div><br/>
                    <div class="group">
                        <label>Your Preferences</label><br/>
                        <textarea id = "preferences" name = "preferences" class = "form-control" rows = "5"><?php echo isset($member) && !empty($member) ? $member->preferences : set_value('preferences'); ?></textarea>
                        <span class = "formError"><?php echo form_error('preferences'); ?></span>
                    </div><br/>
                    <div class="group">
                        <label>Your Photo (Max 200Ko - png|jpg)</label><br/>
                        <input type="file" name = "photo" id = "photo"/>
                    </div><br/>

                    <button type="submit" class="btn btn-primary btn-block"/>Update Your Profile</button>
                </form>
            </div>
        </div>
    </div>
</div>
