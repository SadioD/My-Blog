<?php if(isset($member) && !empty($member)) { ?>
<!-- Page Header -->
<header class="masthead" style="background-image: url('<?php echo base_url() . 'assets/images/';?>home-bg.jpg')">
  <div class="overlay"></div>
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-md-10 mx-auto">
        <div class="site-heading">
          <h1>You are Online</h1>
          <span class="subheading">Bienvenue sur votre profile...</span>
        </div>
      </div>
    </div>
  </div>
</header>

<!-- Flash Message -->
<?php if(isset($this->session->flashdata()['flash'])) { ?>
<div class = "row">
    <div class = "offset-1 col-11 offset-sm-1 col-sm-9 text-center">
        <span class = "meta" style="color:green;"><i class = "fa fa-check"><?php echo $this->session->flashdata('flash'); ?></i></span>
    </div>
</div><?php } ?>

<!-- Page Content -->
<section class = "row">
	<div class = "col-1 offset-sm-1 col-sm-1">
		<img class = "rounded-circle" src = "<?php echo base_url() . '/assets/images/miniatures/' . $member->photo; ?>" alt =  "avatar"/>
	</div>
	<div  id = "intro" class = "offset-2 col-9 offset-sm-0 col-sm-10">
		<p>Bonjour <em><?php echo $member->pseudo; ?></em>,<br/>
		   Sur cette page vous avez accès à vos données personnelles.<br/>
		   Je vous propose de les revoir ensemble, pour être sûr qu'elles sont bien à jour...</p>
	</div>
</section>
<section class = "row">
	<div class = "offset-1 col-11 offset-sm-1 col-sm-10">
		<p>Votre adresse email est la suivante : <em style = "color:blue;"><?php echo $member->email;?></em></p>
		<p>
            <?= $member->preferences != null ? 'Vos préférences :<br/><span id = "preferences"><em>' . $member->preferences . '</em></span>' : 'Vous n\'avez pas déclaré de préférences à ce jour. (Pour mettre à jour votre profile, merci de cliquer sur lien situé en bas de page)' ?>
		</p>
	</div>
</section>
<section class = "row">
	<div class = "col-12 text-center updateButton">
		<a class = "btn btn-primary" href = "<?php echo site_url('user/updateProfile'); ?>">mettre à jour le profile</a>
	</div>
</section>

<?php } else {
    $this->session->set_flashdata('redFlash', 'Oups... une erreur est survenue, merci de réessayer!');
    $this->session->set_userdata('userId', '');
    $this->session->set_userdata('pseudo', '');
    $this->session->setAuthentificated(false);
    redirect(site_url('user/connect'));
    exit;
} ?>
