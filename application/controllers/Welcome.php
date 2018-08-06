<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	// ATTRIBUT + CONST --------------------------------------------------------------------------------------------------
	public function __construct()
    {
        parent::__construct();
        $this->output->cache(3);
        $this->layout->setLayout('bootstrap');
        $this->layout->loadView('menu.php');
        // On inclue le CSS et JS propre aux pages de Bootstrap
        $this->layout->includeCSS('clean-blog.min');
        $this->layout->includeCSS('menu');
        $this->layout->includeJS('menu');
        $this->layout->includeJS('clean-blog.min');
        $this->layout->includeJS('footer');

    }//---------------------------------------------------------------------------------------------------------------------
	// ACCUEIL SITE + 404 ERROR -------------------------------------------------------------------------------------------
    public function index()
    {
		$this->layout->setTitle('Welcome to our Blog');
		$this->layout->showView('welcome/about.php');
    }//---------------------------------------------------------------------------------------------------------------------
}
