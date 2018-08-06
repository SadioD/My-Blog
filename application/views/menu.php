<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <a class="navbar-brand" href="index.html">Sadio Diallo</a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        Menu
        <i class="fa fa-bars"></i>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="<?php echo site_url('/'); ?>">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo site_url('blog/lastNews'); ?>">Blog</a> <!-- 3 dernieres News + Older -->
            </li><?php if ($this->session->isAuthentificated()) { ?>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo site_url('blog/postsManagement'); ?>">Settings</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo site_url('blog/post'); ?>">New Post</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo site_url('user/profile'); ?>">Profile</a><!-- Affichage des liens modifier et supprmier -->
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo site_url('user/disconnect'); ?>">Disconnect</a>
            </li><?php } if (!$this->session->isAuthentificated()) { ?>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo site_url('user/connect'); ?>">Connexion</a>
            </li><?php } ?>
        </ul>
        <!-- Search form -->
        <i class="fa fa-search d-none d-sm-block" style = "color:lightgray; opacity:0.5"></i>
        <form id = "myResearch" class = "form-inline d-none d-sm-block" method = "post" action = "<?php echo site_url('blog/search'); ?>">
            <input type = "text" name = "search" placeholder = "SEARCH" id = "search" autocomplete = "off" style = "color:white;" />
        </form>
    </div>
    <div id = "searchDiv"></div>
</nav>
