<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Comments
{
    // ATTR + CONST + GETTERS -----------------------------------------------------------------------------------------------------------------------------
	protected $id,
              $idMembre,
			  $auteur,
			  $idNews,
			  $idComment,
			  $idRep,
			  $contenu,
			  $liked,
			  $hated,
			  $socialStatus,
              $dateAjout;

    public function __construct(array $donnees = []) {
        foreach($donnees as $key => $value)
        {
            $method = 'set' . ucfirst($key);
            if(is_callable([$this, $method]))
            {
                $this->$method($value);
            }
        }
    }
    public function id()    		{	return $this->id;   		}
    public function idMembre()		{	return $this->idMembre;		}
	public function auteur()		{	return $this->auteur;		}
	public function idNews()		{	return $this->idNews;		}
	public function idComment()		{	return $this->idComment;	}
	public function idRep()			{	return $this->idRep;		}
	public function contenu()		{	return $this->contenu;		}
	public function liked()			{	return $this->liked;		}
	public function hated()			{	return $this->hated;		}
	public function socialStatus()	{	return $this->socialStatus;	}
	public function dateAjout()     {	return $this->dateAjout;   	}
	//-----------------------------------------------------------------------------------------------------------------------------------------------------
	// SETTERS --------------------------------------------------------------------------------------------------------------------------------------------
    public function setIdMembre($idMembre) {
		$this->idMembre = (int)$idMembre;
	}
	public function setAuteur($auteur) {
		if(is_string($auteur) AND !empty($auteur))
		{
			$this->auteur = $auteur;
		}
	}
	public function setIdNews($idNews) {
		$this->idNews = (int)$idNews;
	}
	public function setIdComment($idComment) {
		$this->idComment = (int)$idComment;
	}
	public function setIdRep($idRep) {
		$this->idRep = (int)$idRep;
	}
	public function setContenu($contenu) {
        $this->contenu = (string)$contenu;
	}
	public function setDateAjout($dateAjout) {
		$this->dateAjout = $dateAjout;
	}//----------------------------------------------------------------------------------------------------------------------------------------------------
}
