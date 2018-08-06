<?php
class User extends CI_Controller
{
    // ATTRIBUT + CONST -------------------------------------------------------------------------------------------------------------------------------
    public function __construct() {
        parent::__construct();
        $this->load->model('userManager');
        $this->load->library('form_validation');
        $this->layout->setLayout('bootstrap');
        $this->layout->loadView('menu');
        // On inclue le CSS et JS propre aux pages pas de Bootstrap
        $this->layout->includeCSS('clean-blog.min');
        $this->layout->includeCSS('menu');
        $this->layout->includeJS('menu');
        $this->layout->includeJS('clean-blog.min');
        $this->layout->includeJS('footer');
    }//---------------------------------------------------------------------------------------------------------------------------------------------------
    // Permet de connecter l'User -----------------------------------------------------------------------------------------------------------------------------------------------
    public function connect() {
        $error = '';
        if($this->input->server('REQUEST_METHOD') == 'POST')
        {
            // Insription
            if($this->input->post('pseudo') && !empty($this->input->post('pseudo'))) {
                $this->processSignUpForm();
            }
            // Connexion
            elseif($this->input->post('email') && !empty($this->input->post('email'))) {
                $hashedPass = sha1(htmlspecialchars($this->input->post('password')));
                $email      = htmlspecialchars($this->input->post('email'));

                if($this->userManager->doExists('*', array('email' => $email, 'password' => $hashedPass)))
                {
                    $oldMember = $this->userManager->getUnique('*', array('email' => $email));
                    $this->session->set_userdata('userId', $oldMember->memberId);
                    $this->session->set_userdata('pseudo', $oldMember->pseudo);
                    $this->session->setAuthentificated(true);
                    $this->session->set_flashdata('flash', 'Vous êtes connecté!');
                    redirect(site_url('user/profile'));
                    exit;
                }
                $error = 'Le couple email/password n\'est pas valide!';
            }
        }
        $this->layout->setTitle('Connexion');
        $this->layout->includeJS('connexion');
        $this->layout->includeCSS('connexion');
        $this->layout->showView('user/connexion', array('error' => $error));
    }//---------------------------------------------------------------------------------------------------------------------------------------------------
    // Permet de réinitialiser le mot de passe -----------------------------------------------------------------------------------------------------------------------------------------------
    public function resetPass($token = null)
    {
        // Cas où l'user clique à partir de sa boite email au lien de reset Password
        $error = '';
        if($token != null)
        {
            // On vérifie si le membre dont le token a été fourni existe en BDD
            // On initialise la variable erreur et on supprime le tokken de la BDD (pour faire de l'espace)
            $this->load->model('tokenManager');
            $error  = 'Oups... Une erreur est survenue!';
            $member = $this->tokenManager->getUnique('*', array('token' => $token));
            $this->tokenManager->deleteEntry(array('token' => $token));

            if(isset($member) && !empty($member))
            {
                // On vérifie si le token fourni n'a pas expiré (durée de validité = 15mn soit 900 secondes)
                $validTime = $member->savedTime + 900;
                if(time() <= $validTime)
                {
                    $this->session->set_userdata('userId', $member->memberId);
                    $this->session->set_userdata('pseudo', $member->pseudo);
                    $this->session->setAuthentificated(true);
                    redirect(site_url('user/updateProfile'));
                    exit;
                }
                else {
                    $error = 'Ce lien de réinitialisation a expiré!';
                }
            }
        }
        // Cas où l'user clique sur le lien mot de passe oublié ou encore si l'user a modifié le token
        $this->layout->setTitle('Reset Password');
        $this->layout->includeCSS('resetPass');
        $this->layout->includeJS('resetPass');
        $this->layout->showView('user/resetPass', array('error' => $error));
    }//---------------------------------------------------------------------------------------------------------------------------------------------------
    // Affiche le profile ---------------------------------------------------------------------------------------------------------------------------------------------------------
    public function profile() {
        if($this->session->isAuthentificated()) {
            $member = $this->userManager->getUnique('*', array('memberId' => $this->session->userdata('userId')));
            $this->layout->setTitle('My Account');
            $this->layout->includeCSS('profile');
            $this->layout->showView('user/profile', ['member' => $member]);
        }
        else {
            redirect(site_url('user/connect'));
        }
    }//---------------------------------------------------------------------------------------------------------------------------------------------------
    // Met à joue le profile ---------------------------------------------------------------------------------------------------------------------------------------------------------
    public function updateProfile() {
        if($this->session->isAuthentificated()) {
            $this->layout->setTitle('Update Profile');
            $this->layout->includeCSS('cmxform');               // Pluggin Validation Form (Jquery) - Le CSS du message d'erreur
            $this->layout->includeCSS('updateProfile');
            $this->layout->includeJS('jquery.validate.min');    // Pluggin Validation Form (Jquery) - Valide le Form
            $this->layout->includeJS('additional-methods.min'); // Pluggin Validation Form (Jquery) - Valide les fichier à upload
            $this->layout->includeJS('messages_fr');            // Pluggin Validation Form (Jquery) - Met la langue en Francais
            $this->layout->includeJS('updateProfile');
            $member = $this->userManager->getUnique('*', array('memberId' => $this->session->userdata('userId')));
            $errorUpload = '';

            // Si le formulaire a été POSTé
            if($this->input->server('REQUEST_METHOD') == 'POST') {
                $member = '';
                $errorUpload = $this->processUserUpdatingForm();
            }
            $this->layout->showView('user/updateProfile', ['member' => $member, 'errorUpload' => $errorUpload]);
        }
        else {
            redirect(site_url('user/connect'));
        }
    }//---------------------------------------------------------------------------------------------------------------------------------------------------
    // Permet de déconnecter l'User -----------------------------------------------------------------------------------------------------------------------------------------------
    public function disconnect() {
        if($this->session->isAuthentificated()) {
            $this->session->setAuthentificated(false);
            $this->session->set_userdata('userId', null);
            $this->session->set_userdata('pseudo', null);
            $this->session->set_flashdata('greenFlash', 'Vous avez été déconnecté!');
            redirect(site_url('user/connect'));
            exit;
        }
        else {
            redirect(site_url('user/connect'));
        }        
    }//---------------------------------------------------------------------------------------------------------------------------------------------------
    // ACCUEIL DU CONTROLEUR ---------------------------------------------------------------------------------------------------------------------------------------------------------
    public function index() {
        $this->connect();
    }//----------------------------------------------------------------------------------------------------------------------------------------------------------------
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Fonctions Internes -----------------------------------------------------------------------------------------------------------------------------------------------
    // Traite le formulaire d'enregistrement ---------------------------------------------------------------------------------------------------------------------------------------------------------
    protected function processSignUpForm() {
        $this->form_validation->set_rules('pseudo', '"Prenom et Nom"', 'trim|required');
        $this->form_validation->set_rules('nom', '"Prenom et Nom"', 'trim|required');
        $this->form_validation->set_rules('firstEmail', '"Email"', 'trim|required|valid_email');
        $this->form_validation->set_rules('sndEmail', '"Email"', 'matches[firstEmail]', array('matches' => 'Les deux adresses email ne sont pas identiques!'));
        $this->form_validation->set_rules('firstPass', '"Password"', 'trim|required|min_length[6]');
        $this->form_validation->set_rules('sndPass', '"Password"', 'matches[firstPass]', array('matches' => 'Les deux passwords ne sont pas identiques!'));

        if($this->form_validation->run()) {
            $this->userManager->addEntry(array('nom'      => $this->input->post('nom'),
                                               'pseudo'   => $this->input->post('pseudo'),
                                               'email'    => $this->input->post('firstEmail'),
                                               'password' => sha1($this->input->post('firstPass'))), array('dateInsc' => 'NOW()'));
            $this->session->set_flashdata('flash', 'Votre compte a bien été créé!');

            // Ensuite on récupère les données récentes de l'User créé et on les passe en paramètre à la page PROFILE
            $newMember = $this->userManager->getUnique('*', array('pseudo' => $this->input->post('pseudo'), 'email' => $this->input->post('firstEmail')));
            $this->session->set_userdata('userId', $newMember->memberId);
            $this->session->set_userdata('pseudo', $newMember->pseudo);
            $this->session->setAuthentificated(true);
            redirect(site_url('user/profile'));
            exit;
        }
    }//-------------------------------------------------------------------------------------------------------------------------------------------------------------------
    // Traite le formulaire de mise à jour des données User -------------------------------------------------------------------------------------------------------------------
    protected function processUserUpdatingForm() {
        $this->form_validation->set_rules('pseudo', '"Prenom et Nom"', 'trim|required');
        $this->form_validation->set_rules('nom', '"Prenom et Nom"', 'trim|required');
        $this->form_validation->set_rules('firstEmail', '"Email"', 'trim|required|valid_email');
        $this->form_validation->set_rules('sndEmail', '"Email"', 'matches[firstEmail]', array('matches' => 'Les deux adresses email ne sont pas identiques!'));
        $this->form_validation->set_rules('firstPass', '"Password"', 'trim|min_length[6]|required');
        $this->form_validation->set_rules('sndPass', '"Password"', 'matches[firstPass]', array('matches' => 'Les deux passwords ne sont pas identiques!'));
        $this->form_validation->set_rules('preferences', "Preferences", 'trim|min_length[10]');
        if($this->form_validation->run())
        {
            // Si le formulaire est OK, on vérifie s'il existe une PJ (Si Oui, on la traite)
            if(isset($_FILES['photo']) AND $_FILES['photo']['error'] == 0 AND $_FILES['photo']['size'] > 0) {
                // On définit les paramètres et on charge la librairie
                $config['max_size']      = 500;
                $config['upload_path']   = './assets/images/';
                $config['allowed_types'] = 'png|jpg';
                $this->load->library('upload', $config);

                if(!$this->upload->do_upload('photo'))
                {
                    return $this->upload->display_errors();
                }

                // Si la photo a été upload, on récupère le nom du nouveau fichier et crée une miniature de la photo
                $file       = $this->upload->data();
                $fileName   = $file['file_name'];
                $image_src  = __DIR__ . '/../../assets/images/' . $fileName;
                $image_dest = __DIR__ . '/../../assets/images/miniatures/' . $fileName;
                $this->load->library('imagethumb');
                $this->imagethumb->createThumb($image_src, $image_dest, 90);
            }
            else {
                $fileName = 'avatar.png';
            }
            // Ensuite on met à jour les données User
            $this->userManager->updateEntry(['memberId' => $this->session->userdata('userId')], ['nom'         => $this->input->post('nom'),
                                                                                                 'pseudo'      => $this->input->post('pseudo'),
                                                                                                 'email'       => $this->input->post('firstEmail'),
                                                                                                 'password'    => sha1($this->input->post('firstPass')),
                                                                                                 'photo'       => $fileName,
                                                                                                 'preferences' => $this->input->post('preferences')]);
            $this->session->set_flashdata('flash', 'Vos données ont été mises à jour!');
            redirect(site_url('user/profile'));
            exit;
        }
        return false;
    }//----------------------------------------------------------------------------------------------------------------------------------------------------------------
}
