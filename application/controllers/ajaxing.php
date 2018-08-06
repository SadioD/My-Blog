<?php
class Ajaxing extends CI_Controller
{
    // ATTRIBUT + CONST -------------------------------------------------------------------------------------------------------------------
    public function __construct()
    {
        parent::__construct();
        $this->load->model('newsManager');
        $this->load->model('commentsManager');
    }//--------------------------------------------------------------------------------------------------------------------------------------------
    // METHODS -------------------------------------------------------------------------------------------------------------------------------
    // Permet de traiter les données AJAX reçues par les bouttons LIKE et HATE
    public function socialButtons($socialPluggin, $idComment, $idMembre)
    {
        if(!empty($socialPluggin) && !empty($idComment) && !empty($idMembre) && isset($socialPluggin) && isset($idComment) && isset($idMembre))
        {
            // On charge le modele des Pluggins et on recupère l'entrée dans BDD socialButtons
            // On met à jour le nombre de likes(+/-) et ou hates en fonction du statut social déjà save en BDD
            // On encode le resultat au format JSON et on l'echo pour pouvoir le récupérer en JS
            $this->load->model('plugginManager');
            $button = $this->plugginManager->getUnique('*', array('idComment' => $idComment, 'idMembre' => $idMembre));

            if(isset($button) && !empty($button)) {
                if($button->socialStatus == $socialPluggin) {
                    $pluggins = $this->getNewSocialPluggin('none', $idComment, $idMembre, $socialPluggin, $socialPluggin . ' - 1', null, null, true);
                    echo $pluggins;
                }
                elseif($button->socialStatus == 'none') {
                     $pluggins = $this->getNewSocialPluggin($socialPluggin, $idComment, $idMembre, null, $socialPluggin . ' + 1', null, null, true);
                     echo $pluggins;
                }
                elseif($button->socialStatus != $socialPluggin && $button->socialStatus != 'none') {
                    if($button->socialStatus == 'liked') {
                        $pluggins = $this->getNewSocialPluggin('hated', $idComment, $idMembre, 'hated', 'hated + 1', 'liked', 'liked - 1', true);
                        echo $pluggins;
                    }
                    elseif($button->socialStatus == 'hated') {
                        $pluggins = $this->getNewSocialPluggin('liked', $idComment, $idMembre, 'liked', 'liked + 1', 'hated', 'hated - 1', true);
                        echo $pluggins;
                    }
                }
            }
            else {
                $pluggins = $this->getNewSocialPluggin($socialPluggin, $idComment, $idMembre, null, null, null, null, false);
                echo $pluggins;
            }
        }
        else {
            redirect(site_url('blog/home'));
        }
    }//--------------------------------------------------------------------------------------------------------------------------------------------
    // Traite le lien supprimer  blog/postsManagement ----------------------------------------------------------------------------------------
    public function deletePost($idNews)
    {
        $news = $this->newsManager->getUnique('*', array('id' => $idNews));
        if(!empty($news)) {
            $this->newsManager->deleteEntry(array('id' => $news->id));
            //$newsList = $this->newsManager->getArrayforAjax('*', array('idMembre' => $this->session->userdata('userId')), null, null, 'id', 'DESC');

            echo '<i class = "fa fa-check"> Le post a été supprimé!</i>';
            //echo json_encode($newsList);
        }
    }//--------------------------------------------------------------------------------------------------------------------------------------------
    // permet de gérer l'AutoCompletion du Formulaire de recherche --------------------------------------------------------------------------------------------
    public function search()
    {
        if(!empty($this->input->post('search')))
        {
            $newsList = $this->newsManager->getEntriesLike('titre', $this->input->post('search'), $limit = 3);

            if(isset($newsList) && !empty($newsList)) {
                for($i = 0; $i < count($newsList); $i++)
                {
                    // On réduit la taille des caractères du titre
                    if(strlen($newsList[$i]->titre) > 28) {
                        $titre = substr($newsList[$i]->titre, 0, 28);
                        $titre = substr($titre, 0, strrpos($titre, ' ')) . '...';
                        $newsTitles[] = $titre;
                    }
                    else {
                        $newsTitles[] = $newsList[$i]->titre;
                    }
                }
                // On affiche l'array NEWSTITLE en mode string séparé avec un '|'
                echo implode('|', $newsTitles);
            }
        }

    }//--------------------------------------------------------------------------------------------------------------------------------------------
    // Permet de réinitialiser le mot de passe -----------------------------------------------------------------------------------------------------------------------------------------------
    public function resetPass() {
        if(isset($_POST['email']) && !empty($_POST['email']))
        {
            $this->load->model('userManager');
            $member = $this->userManager->getUnique('*', array('email' => $_POST['email']));

            if(isset($member) && !empty($member))
            {
                $token = sha1(time() . $member->pseudo . $member->memberId . $member->nom);

                // Contenu alternatif au format TEXT si HTML non supporté
                $altFichier = fopen(__DIR__ . "/../views/ajax/ResetPassEmailText.txt", "r");   //on ouvre le fichier en lecture seule.
                $altContent = fread($altFichier, filesize(__DIR__ . "/../views/ajax/ResetPassEmailText.txt")); //on lit l'ensemble du fichier avec la fonction fread.
                fclose($altFichier);
                $altContent .= '\n{unwrap}http://homework:800/Projects/Blog/CodeIgniter/user/resetPass/' . $token . '{/unwrap}\n';
                $altContent .= 'Cordialement. \n Le Service Support. \n PS: Ne répondez pas à cet email!';

                // Contenu du mail au format HTML
                $fichier  = fopen(__DIR__ . "/../views/ajax/ResetPassEmailHTML.html", "r");   //on ouvre le fichier en lecture seule.
                $content  = fread($fichier, filesize(__DIR__ . "/../views/ajax/ResetPassEmailHTML.html")); //on lit l'ensemble du fichier avec la fonction fread.
                fclose($fichier);
                $content .= '<br/><br/><a href = "http://homework:800/Projects/Blog/CodeIgniter/user/resetPass/' . $token . '">Réinitialiser Password</a><br/><br/>';
                $content .= 'Cordialement. </p> Le Service Support. <br/> <strong>PS: Ne répondez pas à cet email!</strong>';
                $content .= '</body></html>';

                $this->sendEmail($member, $content, $altContent, $token);
                return true;
            }
        }
        // Si le membre n'a pas été trouvé on envoie le message NOT FOUND
        $data = array('keyWord' => 'userNotFound', 'response' => 'l\'adresse email entrée est invalide!');
        echo json_encode($data);
    }//---------------------------------------------------------------------------------------------------------------------------------------------------
    //--------------------------------------------------------------------------------------------------------------------------------------------
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Fonctions Internes -------------------------------------------------------------------------------------------------------------------------
    // Permet de mettre à jour le statut social et retourne le nouveau nombre de likes/hates
    protected function getNewSocialPluggin($socialPluggin = null, $idComment = null, $idMembre = null, $key = null, $value = null, $secondKey = null, $secondValue = null, $bool)
    {                                   //('none', $idComment, $idMembre, $socialPluggin, $socialPluggin . ' - 1', null, null, true);
        if($bool == true) {
            if($key == null) {
                $key = $socialPluggin;
            }
            // On met à jour le statut du boutton (none --> liked) et le nombre de likes
            $this->plugginManager->updateEntry(array('idComment' => $idComment, 'idMembre' => $idMembre), array('socialStatus' => $socialPluggin));

            if($secondKey == null && $secondValue == null) {
                $this->commentsManager->updateEntry(array('id' => $idComment),     array('socialStatus' => $socialPluggin), array($key => $value));
            }
            else {
                $this->commentsManager->updateEntry(array('id' => $idComment),     array('socialStatus' => $socialPluggin), array($key => $value, $secondKey => $secondValue));
            }
            // On recupère le nouveau nombre de likes
            $comment = $this->commentsManager->getUnique('*', array('id' => $idComment));
            if(isset($comment) && !empty($comment)) {
                $plugginsValues = array('liked' => $comment->liked, 'hated' => $comment->hated, 'status' => $comment->socialStatus, 'idComment' => $idComment, 'idMembre' => $idMembre);
                return json_encode($plugginsValues);
            }
            else {
                return false;
            }
        }
        else {
            if($socialPluggin == 'liked') {
                $this->plugginManager->addEntry(array('idMembre' => $idMembre, 'idComment' => $idComment, 'socialStatus' => 'liked'));
                $this->commentsManager->updateEntry(array('id' => $idComment), array('socialStatus' => 'liked'), array('liked' => 'liked + 1'));
                $comment = $this->commentsManager->getUnique('*', array('id' => $idComment));
                $plugginsValues = array('liked' => $comment->liked, 'hated' => $comment->hated, 'status' => $comment->socialStatus, 'idComment' => $idComment, 'idMembre' => $idMembre);
                return json_encode($plugginsValues);
            }
            elseif($socialPluggin == 'hated') {
                $this->plugginManager->addEntry(array('idMembre' => $idMembre, 'idComment' => $idComment, 'socialStatus' => 'hated'));
                $this->commentsManager->updateEntry(array('id' => $idComment), array('socialStatus' => 'hated'), array('hated' => 'hated + 1'));
                $comment = $this->commentsManager->getUnique('*', array('id' => $idComment));
                $plugginsValues = array('liked' => $comment->liked, 'hated' => $comment->hated, 'status' => $comment->socialStatus, 'idComment' => $idComment, 'idMembre' => $idMembre);
                return json_encode($plugginsValues);
            }
        }
    }//----------------------------------------------------------------------------------------------------------------------------------------------------------------
    // Envoi l'email permettant de réinitialiser le mot de passe ------------------------------------------------------------------------------------------------------------------------------------------------
    public function sendEmail($receiver, $content, $altContent, $token)
    {
        // On configure le titre et les paramètres (port, etc.)
        $sender     = 'amasadio85@gmail.com';
        $title      = 'Réinitialiser votre mot de passe';
        $config     = array('protocol' => 'smtp', 'smtp_host' => 'ssl://smtp.googlemail.com', 'smtp_port' => 465, 'smtp_user' => $sender, 'smtp_pass' => 'Dasadio85', 'mailtype' => 'html', 'charset' => 'utf-8', 'wordwrap' => TRUE);

        // On charge l'email et son contenu
        $this->load->library('email', $config);
        $this->email->from($sender);
        $this->email->to($receiver->email);
        $this->email->subject($title);
        $this->email->set_newline("\r\n");
        $this->email->message($content);
        $this->email->set_alt_message($altContent);

        if($this->email->send())
        {
            // Si l'email a été envoyé, on save le Token en BDD et on lui envoie la notification
            $this->load->model('tokenManager');
            $this->tokenManager->addEntry(array('memberId' => $receiver->memberId, 'pseudo' => $receiver->pseudo, 'token' => $token, 'savedTime' => time()));
            $data = array('keyWord' => 'emailSent', 'response' => 'Un email de réinitialisation a été envoyé à ' . $receiver->email);
        }
        else {
            $data = array('keyWord' => 'emailNotSent', 'response' => 'Oups... Une erreur est survenue - Email cannot be sent');
        }
        echo json_encode($data);
        return true;
    }//----------------------------------------------------------------------------------------------------------------------------------------------------------------
}
