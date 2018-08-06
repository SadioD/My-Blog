<!-- Page Header -->
<header class="masthead" style="background-image: url('<?php echo base_url() . 'assets/images/';?>home-bg.jpg')">
  <div class="overlay"></div>
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-md-10 mx-auto">
        <div class="site-heading">
          <h1>Get Online</h1>
          <span class="subheading">Remplissez le formulaire pour vous connecter...</span>
        </div>
      </div>
    </div>
  </div>
</header>

<div class = "row">
    <div class = "offset-1 col-11 offset-sm-1 col-sm-9 text-center">
        <!-- Message erreur LogIn email/password -->
        <?php if(isset($error) && !empty($error)) { ?>
            <span id = "errorMessage"><?php echo $error; ?></span> <?php } ?>

        <!-- Flash Message -->
        <?php if(isset($this->session->flashdata()['greenFlash'])) { ?>
            <span class = "meta" style="color:green;"><i class = "fa fa-check"><?php echo $this->session->flashdata('greenFlash'); ?></i></span><?php } ?>
        <?php if(isset($this->session->flashdata()['redFlash'])) { ?>
            <span class = "meta" style="color:red;"><i class = "fa fa-times"> <?php echo $this->session->flashdata('redFlash'); ?></i></span><?php } ?>

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
    <div class="form col-lg-8 col-md-10 mx-auto connectForm">
        <div class="tab-group row" tabindex = -1 id = "shiftLinks">
            <div class = "offset-1 col-5 connectLink activated">
                <span class="tab active">
                    <a href="#signup">Sign Up</a>
                </span>
            </div>
            <div class = "col-5 connectLink">
                <span class="tab">
                    <a href="#login">Log In</a>
                </span>
            </div>
        </div>
        <div class="tab-content">
            <!-- The SignUp Form -->
            <div id="signup">
                <h1>Sign Up for Free</h1>
                <form action="" method="post" id = "signUpForm">
                    <div class="top-row">
                        <div class="field-wrap">
                            <label>
                                First Name<span class="req">*</span>
                            </label>
                            <input type="text" name = "pseudo" id = "prenom" value="<?php echo set_value('pseudo'); ?>" required autocomplete="off" />
                            <span class = "formError"><?php echo form_error('pseudo'); ?></span>
                        </div>
                        <div class="field-wrap">
                            <label>
                                Last Name<span class="req">*</span>
                            </label>
                            <input type="text" name = "nom" id = "nom" value="<?php echo set_value('nom'); ?>" required autocomplete="off"/>
                            <span class = "formError"><?php echo form_error('nom'); ?></span>
                        </div>
                    </div>
                    <div class="field-wrap">
                        <label>
                            Email Address<span class="req">*</span>
                        </label>
                        <input type="email" name = "firstEmail" id = "firstEmail" value="<?php echo set_value('firstEmail'); ?>" required autocomplete="off"/>
                        <span class = "formError"><?php echo form_error('firstEmail'); ?></span>
                    </div>
                    <div class="field-wrap">
                        <label>
                            Confirm the email<span class="req">*</span>
                        </label>
                        <input type="email" name = "sndEmail" id = "sndEmail" value="<?php echo set_value('sndEmail'); ?>" required autocomplete="off"/>
                        <span class = "formError"><?php echo form_error('sndEmail'); ?></span>
                    </div>
                    <div class="field-wrap">
                        <label>
                            Set A Password<span class="req">*</span>
                        </label>
                        <input type="password" name = "firstPass" id = "firstPass" value="<?php echo set_value('firstPass'); ?>" required autocomplete="off" placeholder = "Au moins 6 caractères"/>
                        <span class = "formError"><?php echo form_error('firstPass'); ?></span>
                    </div>
                    <div class="field-wrap">
                        <label>
                            Confirm the Password<span class="req">*</span>
                        </label>
                        <input type="password" name = "sndPass" id = "sndPass" value="<?php echo set_value('sndPass'); ?>" required autocomplete="off"/>
                        <span class = "formError"><?php echo form_error('sndPass'); ?></span>
                    </div><br/>
                    <button type="submit" class="button button-block" style = "border-radius: 4px;"/>Get Started</button>
                </form>
            </div>
            <!-- The logIn Form -->
            <div id="login">
                <h1>Welcome Back!</h1>
                <form action="" method="post" id = "logInForm">
                    <div class="field-wrap">
                        <label>
                            Email Address<span class="req">*</span>
                        </label>
                        <input type="email" name = "email" id = "email" value="<?php echo set_value('email'); ?>" required autocomplete="off"/>
                    </div>
                    <div class="field-wrap">
                        <label>
                            Password<span class="req">*</span>
                        </label>
                        <input type="password" name = "password" id = "password" value="<?php echo set_value('password'); ?>" required autocomplete="off"/>
                    </div>
                    <p class="forgot"><a href="<?php echo site_url('user/resetPass'); ?>">Forgot Password?</a></p><br/>
                    <button class="button button-block" style = "border-radius: 4px;"/>Log In</button>
                </form>
            </div>
        </div>
    </div>
</div>
