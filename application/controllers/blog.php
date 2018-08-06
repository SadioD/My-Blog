<?php
class Blog extends CI_Controller
{
    // ATTRIBUT + CONST --------------------------------------------------------------------------------------------------
    public $pageConfig = [];
    protected $limit   = 3;

    public function __construct() {
        parent::__construct();
        $this->load->model('newsManager');
        $this->load->model('commentsManager');
        $this->load->library('Comments');           // Class application\libraries\Comments (Entity)
        $this->load->library('form_validation');
        $this->layout->setLayout('bootstrap');
        $this->layout->loadView('menu.php');

        // On inclue le CSS et JS propre aux pages de Bootstrap
        $this->layout->includeCSS('clean-blog.min');
        $this->layout->includeCSS('menu');
        $this->layout->includeJS('menu');
        $this->layout->includeJS('clean-blog.min');
        $this->layout->includeJS('footer');

        // Début configuration des pagination - Bootstrap 4 (On aurait pu ajouter le tout dans la library Pagination)
        $this->pageConfig['per_page']       = $this->limit;
        $this->pageConfig['prev_link']      = '<i class = "fa fa-angle-double-left"></i>';
        $this->pageConfig['next_link']      = '<i class = "fa fa-angle-double-right"></i>';
        $this->pageConfig['full_tag_open']  = '<ul class="pagination">';
        $this->pageConfig['cur_tag_open']   = '<li class = "page-item active"><a href = "" class = "page-link" style = "background:rgb(0, 133, 161); border-color:rgb(0, 133, 161);">';
        $this->pageConfig['cur_tag_close']  = '</a></li>';
        $this->pageConfig['num_tag_open']   = '<li class="page-item">';
        $this->pageConfig['num_tag_close']  = '</li>';
        $this->pageConfig['full_tag_close'] = '</ul>';
        $this->pageConfig['attributes']     = array('class' => 'page-link');
    }//---------------------------------------------------------------------------------------------------------------------
    // ACCUEIL du Module -------------------------------------------------------------------------------------------
    public function index() {
		$this->lastNews();
    }//---------------------------------------------------------------------------------------------------------------------
    // Affiche les 3 dernières News ---------------------------------------------------------------------------------------
    public function lastNews() {
        $this->layout->setTitle('Flash news');
        $data['newsList'] = $this->newsManager->getJoinData('*', 'membres', 'membres.memberId = post.idMembre', array(), 3, null, 'post.id', 'DESC');
        $this->layout->showView('blog/lastNews', $data);
    }//---------------------------------------------------------------------------------------------------------------------
    // Afficher les anciennes news --------------------------------------------------------------------------------------
    public function oldNews() {
        $this->output->cache(1);                    // Mise en cacahe d'une minute
        $this->layout->setTitle('The Newslist');
        $this->layout->includeCSS('oldNews');
        $data['newsData'] = $this->setPagination('membres', 'membres.memberId = post.idMembre', 'blog/oldNews', 3, 'newsList', 'newsManager', array(), 'post.id', 'DESC');
        $this->layout->showView('blog/oldNews', array('newsList' => $data['newsData']['newsList']));
    }//---------------------------------------------------------------------------------------------------------------------
    // Afficher Une News + Comments --------------------------------------------------------------------------------------
    public function uniquePost($idNews, $page = null, $idComment = null)
    {
        // On recupère les données de la News et des commentaires associés
        $data['news']         = $this->newsManager->getJoinUnique('*', 'membres', 'membres.memberId = post.idMembre', array('post.id' => htmlspecialchars((int)$idNews)));
        $data['commentsData'] = $this->setPagination('membres', 'membres.memberId = commentaires.idMembre', 'blog/uniquePost/' . $idNews, 4, 'commentsList', 'commentsManager', array('commentaires.idNews' => htmlspecialchars((int)$idNews)), 'commentaires.id', 'DESC', 'Comments');

        // On charge le titre et les mises en forme CSS et JS
        if(isset($data['news']) && !empty($data['news'])) {
            $this->layout->setTitle($data['news']->titre);
            $this->layout->includeCSS('uniquePost');
            $this->layout->includeJS('uniquePost');
        }
        else {
            redirect(site_url('blog/oldNews'));
        }
        // On transforme la date d'ajout des commentaires au format - about X days ago
        // Et on recupère au passage la liste des réponses
        if(isset($data['commentsData']['commentsList']) && !empty($data['commentsData']['commentsList'])) {
            for($i = 0; $i < $this->limit; $i++)
            {
                if(isset($data['commentsData']['commentsList'][$i])) {
                    $data['commentsData']['commentsList'][$i]->setDateAjout($this->time->getTimeago($data['commentsData']['commentsList'][$i]->dateAjout()));
                    if($data['commentsData']['commentsList'][$i]->id() == $data['commentsData']['commentsList'][$i]->idRep()) {
                        $data['repliesList'][] = $this->commentsManager->getCustomJoinData('*', 'membres', 'membres.memberId = commentaires.idMembre', array('commentaires.idComment' => $data['commentsData']['commentsList'][$i]->id()), null, null, 'commentaires.id', 'DESC', 'Comments');
                    }
                }
            }
        }
        if($this->input->server('REQUEST_METHOD') == 'POST') {
            $this->processCommentsForm('contenu', $idNews, null, $idNews);
        }
        $this->processUserRequest($data);
    }//-------------------------------------------------------------------------------------------------------------------------------------------------------------
    // Permet de répondre à un commentaire ----------------------------------------------------------------------------------------------------------------------------
    public function reply($idNews, $idComment)
    {
        if($this->session->isAuthentificated()) {
            // On recupère la News et le Commentaire
            $data['news']     = $this->newsManager->getJoinUnique('*', 'membres', 'membres.memberId = post.idMembre', array('post.id' => htmlspecialchars((int)$idNews)));
            $data['comment'] = $this->commentsManager->getCustomJoinUnique('*', 'membres', 'membres.memberId = commentaires.idMembre', array('commentaires.id' => htmlspecialchars((int)$idComment)), null, null, null, null, 'Comments');

            if(isset($data['comment']) && !empty($data['comment']) && isset($data['news']) && !empty($data['news'])) {
                $data['comment']->setDateAjout($this->time->getTimeago($data['comment']->dateAjout()));
            }
            else {
                redirect(site_url('blog/uniquePost/' . $idNews));
            }
            // On charge le titre et les mises en forme CSS/JS
            $this->layout->setTitle($data['news']->titre);
            $this->layout->includeCSS('uniquePost');
            $this->layout->includeJS('uniquePost');

            // On traite les données du formulaire
            if($this->input->server('REQUEST_METHOD') == 'POST') {
                $this->processCommentsForm('contenu', null, $idComment, $idNews);
            }
            $this->layout->showView('blog/reply', array('news' => $data['news'], 'comment' => $data['comment']));
        }
        else {
            redirect(site_url('blog/lastNews'));
        }
    }//------------------------------------------------------------------------------------------------------------------------------------------------------------------
    // Permet d'ajouter ou modifier un post --------------------------------------------------------------------------------------------------------------------------------
    public function post($idNews = null) {
        if($this->session->isAuthentificated()) {
            $news      = null;
            $error     = null;
            $formTitle = null;
            if($idNews == null) {
                if($this->input->server('REQUEST_METHOD') == 'GET') {
                    $this->layout->setTitle('Add New Post');
                }
                else {
                    // Il s'agit d'un POST pour modifier/ajouter une News
                    $this->layout->setTitle('Post Edition');
                    $this->processNewsForm();
                }
            }
            else {
                $formTitle = 1;
                $news = $this->newsManager->getUnique('*', array('id' => $idNews));
                $this->layout->setTitle('Post Edition');
            }
            $this->layout->includeCSS('postForm');
            $this->layout->includeJS('postForm');
            $this->layout->showView('blog/postForm', array('news' => $news, 'formTitle' => $formTitle));
        }
        else {
            redirect(site_url('blog/lastNews'));
        }
    }//------------------------------------------------------------------------------------------------------------------------------------------------------------------
    // Permet de gérer les posts --------------------------------------------------------------------------------------------------------------------------------
    public function postsManagement() {
        if($this->session->isAuthentificated()) {
            $data['newsList'] = $this->newsManager->getData('*', array('idMembre' => $this->session->userdata('userId')), null, null, 'id', 'DESC');

            $this->layout->setTitle('The Board');
            $this->layout->includeJS('postsManagement');
            $this->layout->includeCSS('postsManagement');
            $this->layout->showView('blog/postsManagement', $data);
        }
        else {
            redirect(site_url('blog/lastNews'));
        }
    }//------------------------------------------------------------------------------------------------------------------------------------------------------------------
    // Permet de supprimer un post (Si JAVASCRIPT est désactivé) --------------------------------------------------------------------------------------------------------------------------------
    public function deletePost($idNews) {
        if($this->session->isAuthentificated()) {
            $news = $this->newsManager->getUnique('*', array('id' => $idNews));
            if(!empty($news)) {
                $this->newsManager->deleteEntry(array('id' => $news->id));
                $this->session->set_flashdata('flash', 'Le post a été supprimé!');
            }
            else {
                $this->session->set_flashdata('redFlash', 'Une erreur est survenue!');
            }
            redirect(site_url('blog/postsManagement'));
            exit;
        }
        else {
            redirect(site_url('blog/lastNews'));
        }
    }//------------------------------------------------------------------------------------------------------------------------------------------------------------------
    // Permet de supprimer un post (Si JAVASCRIPT est désactivé) --------------------------------------------------------------------------------------------------------------------------------
    public function search() {
        $this->layout->includeCSS('search');
        if(!empty($this->input->post('search')))
        {
            $newsList   = $this->newsManager->getData();
			foreach($newsList as $news)
			{
				if(preg_match('#' . $this->input->post('search') . '#i', $news->titre))
				{
					// Si RECHERCHE correspond à quelque chose dans BDD => On crée une ARRAY pour récupérer le résultat et l'ID
					$results[]  = $news;
				}
			}
            if(isset($results) && !empty($results)) {
                $this->layout->showView('blog/search', array('results' => $results));
                return true;
            }
        }
        $this->layout->showView('blog/search');
    }//------------------------------------------------------------------------------------------------------------------------------------------------------------------
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Fonctions Internes -----------------------------------------------------------------------------------------------------------------------------------------------
    // Permet d'éviter la duplication de code - Configuration Pagination
    protected function setPagination($leftTable, $joinOn, $path, $segment, $dataType, $model, $where = array(), $orderBy = null, $desc = null, $class = null) {
        $this->load->library('pagination');
        $this->pageConfig['uri_segment'] = $segment; 	// On indique à Codeigniter le segment qui contient les pages recherchées
        $data['totalRows']               = $this->$model->countJoinedEntries('*', $leftTable, $joinOn, $where);
        $this->pageConfig['total_rows']  = $data['totalRows'];
        $this->pageConfig['base_url']    = base_url() . $path;
        $data['page'] = $this->uri->segment($segment) ? $this->uri->segment($segment) : 0;

        if($class == null)
        {
            // Cas où le modele renvoie un standard Object
            $data[$dataType] = $this->$model->getJoinData('*', $leftTable, $joinOn, $where, $this->limit, $data['page'], $orderBy, $desc);
        }
        else {
            // Cas où le modèle renvoie un Customized Objeect (voir méthode de la classe My_Model)
            $data[$dataType] = $this->$model->getCustomJoinData('*', $leftTable, $joinOn, $where, $this->limit, $data['page'], $orderBy, $desc, $class);
        }
        $this->pagination->initialize($this->pageConfig);
        return $data;
    }//-------------------------------------------------------------------------------------------------------------------------------------------------------------------
    // Permet d'afficher la vue de UniquePost methode = GET et POST ---------------------------------------------------------------------------------------------------------
    protected function processUserRequest($data)
    {
        // On transforme la date d'ajout des Réponses au format - about -X days ago et on affiche la vue
        if(isset($data['repliesList']) && !empty($data['repliesList'])) {
            for($i = 0; $i < count($data['repliesList']); $i++) {       // (COUnt() nous renvoie la taille de l'array)
                for($j = 0; $j < count($data['repliesList'][$i]); $j++) {
                    $data['repliesList'][$i][$j]->setDateAjout($this->time->getTimeago($data['repliesList'][$i][$j]->dateAjout()));
                    $test[$j] = $data['repliesList'][$i][$j];
                }
            }
            $this->layout->showView('blog/uniquePost', array('news'         => $data['news'],
                                                             'page'         => $data['commentsData']['page'],
                                                             'comments'     => $data['commentsData']['commentsList'],
                                                             'repliesData'  => $data['repliesList']));
        }
        else {
            $this->layout->showView('blog/uniquePost', array('news'         => $data['news'],
                                                             'page'         => $data['commentsData']['page'],
                                                             'comments'     => $data['commentsData']['commentsList']));
        }
    }//----------------------------------------------------------------------------------------------------------------------------------------------------------
    // Permet de traiter les données du formulaire (Ajout ommentaires) ------------------------------------------------------------------------------------------
    protected function processCommentsForm($name, $idNews = null, $idComment = null, $redirectId) {
        $this->form_validation->set_rules($name, null, 'required');

        if($this->form_validation->run())
        {
            // Si le formulaire est valie => on save le commentaire, on save un flash et on redirige
            $this->commentsManager->addEntry(array('idMembre'  => $this->session->userdata('userId'),
                                                    'auteur'    => $this->session->userdata('pseudo'),
                                                    'idNews'    => $idNews,
                                                    'idComment' => $idComment,
                                                    'contenu'   => $this->input->post('contenu'),
                                                    'dateAjout' => time()));
            if($idComment != null) {
                $this->commentsManager->updateEntry(array('id'  => $idComment), array('idRep' => $idComment));
            }

            $this->session->set_flashdata('flash', 'Votre commentaire a bien été ajouté!');
            if($idNews != null) {
                redirect(site_url('blog/uniquePost/' . $idNews));
            }
            else {
                redirect(site_url('blog/uniquePost/' . $redirectId));
            }
        }
    }//--------------------------------------------------------------------------------------------------------------------------------------------------------

    // Permet de traiter le formulaire d'Ajout/modification de News -----------------------------------------------------------------------------------------------------------------------
    protected function processNewsForm() {
        $this->form_validation->set_rules('titre', 'Titre', 'required');
        $this->form_validation->set_rules('texte', 'texte', 'required');
        $idNews = $this->input->post('idNews');
        $formTitle = !empty($idNews) ? 1 : null;

        if($this->form_validation->run())
        {
            // Si le formulaire est OK, on vérifie s'il existe une PJ (Si Oui, on la traite)
            if(isset($_FILES['fichier']) AND $_FILES['fichier']['error'] == 0 AND $_FILES['fichier']['size'] > 0) {
                // On définit les paramètres et on charge la librairie
                $config['max_size']      = 100;
                $config['upload_path']   = './assets/documents/';
                $config['allowed_types'] = 'doc|pdf';
                $this->load->library('upload', $config);

                if(!$this->upload->do_upload('fichier'))
				{
					$error = $this->upload->display_errors();
                    $this->layout->showView('blog/postForm', array('errorUpload' => $error, 'idNews' => $idNews, 'formTitle' => $formTitle));
                    return false;
				}
				$file     = $this->upload->data();
                $fileName = $file['file_name'];
            }
            else {
                $fileName = null;
            }
            // Ensuite on Save le POST (Ajout/Modification)
            $this->newsManager->saveEntry($idNews, ['id' => $idNews], ['idMembre'  => $this->session->userdata('userId'),
                                                                       'titre'     => $this->input->post('titre'),
                                                                       'sousTitre' => $this->input->post('sousTitre'),
                                                                       'contenu'   => $this->input->post('texte'),
                                                                       'fichier'   => $fileName], ['datePub'   => 'NOW()']);

            if(isset($idNews) && !empty($idNews)) {
                $this->session->set_flashdata('flash', 'Votre Post a bien été modifié!');
                redirect(site_url('blog/postsManagement'));
            }
            else {
                $this->session->set_flashdata('flash', 'Votre Post a bien été ajouté!');
                redirect(site_url('blog/lastNews'));
            }
            exit;
        }
    }//--------------------------------------------------------------------------------------------------------------------------------------------------------
}
