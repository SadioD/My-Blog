<!-- Page Header -->
<header class="masthead" style="background-image: url('<?php echo base_url() . 'assets/images/';?>home-bg.jpg')">
  <div class="overlay"></div>
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-md-10 mx-auto">
        <div class="site-heading">
          <h1>The Profile</h1>
          <span class="subheading">Réinitialiser votre mot de passe...</span>
        </div>
      </div>
    </div>
  </div>
</header>

<div class = "row">
    <div class = "offset-1 col-11 offset-sm-0 col-sm-12 text-center flashMessage">
        <?php if(isset($error) && !empty($error)) { ?>
            <span id = "#spanError" style = "color:red;fontStyle:italic;">
                <i class="fa fa-times"></i> <?php echo $error; ?>
            </span>
        <?php } ?>
        <!-- Alerte Désactivation Javascript -->
        <noscript>
            <span style = "color:red;">
                Oups... Il semblerait que Javascript ne soit pas activé sur votre navigateur.
                Certaines fonnalités de ce site ne seront pas accessibles.
            </span>
        </noscript>
    </div>
</div>

<!-- Formulaire de Connexion/Inscription -->
<div class = "row formRow">
    <div class="form col-lg-8 col-md-10 mx-auto resetBlock">
        <div class="tab-content">
            <!-- The SignUp Form -->
            <div id="signup">
                <h1>Your infos</h1>
                <form action="" method="post" id = "resetForm">
                    <div class="group">
                        <label>
                            Email Address
                        </label>
                        <input type="email" name = "email" id = "email" />
                    </div>
                    <button type="submit" class="btn btn-primary btn-block"/>Reset Your Password</button>
                </form>
            </div>
        </div>
    </div>
</div>
