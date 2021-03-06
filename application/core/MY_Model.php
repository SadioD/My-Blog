<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MY_Model extends CI_Model
{
    //--------------------------------------------------------------------------------------------------------------//
	/* IMPORTANT : $this->db->result()       => renvoie liste objet => foreach(list as object) echo object->titre	//
	//			   $this->db->result_array() => renvoie liste array => foreach(list as array) echo array['titre']	//
	//			   $this->db->custom_result_object('News') => renvoir liste objet de la classe News (si on l'a créé)//
	//			   $this->db->row()          => renvoie un seul objet => row->titre 								//
	//			   $this->db->row_array()    => renvoie un seul array => row['titre'] */							//
	//--------------------------------------------------------------------------------------------------------------//

    // ADD and UPDATE ----------------------------------------------------------------------------------------------------
    // Cette méthode évite la duplication de code
    public function saveEntry($id = null, $where = null, $escaped_data = array(), $not_escaped_data = array())
    {
        if(isset($id) && !empty($id)) {
            $this->updateEntry($where, $escaped_data, $not_escaped_data);
        }
        else {
            $this->addEntry($escaped_data, $not_escaped_data);
        }
    }
    // Cette méthode ajoute une entrée en BDD
    public function addEntry($escaped_data = array(), $not_escaped_data = array())
    {
        // Cette méthode insère une entrée en BDD
        if(empty($escaped_data) AND empty($not_escaped_data))
        {
            return false;
        }
        return (bool) $this->db->set($escaped_data)
                               ->set($not_escaped_data, null, false)
                               ->insert($this->table);
    }
    // Cette méthode modifie une entrée en BDD
    public function updateEntry($where, $escaped_data = array(), $not_escaped_data = array())
    {
        if(empty($escaped_data) AND empty($not_escaped_data))
        {
            return false;
        }
        if(is_integer($where))
        {
            $where = array('id' => $where);
        }
        return (bool) $this->db->set($escaped_data)
                               ->set($not_escaped_data, null, false)
                               ->where($where)
                               ->update($this->table);
    }//-------------------------------------------------------------------------------------------------------------------

    // DELETE and COUNT --------------------------------------------------------------------------------------------------
    public function deleteEntry($where)
    {
        // Cette méthode supprime une entrée
        if(empty($where))
        {
            return false;
        }
        if(is_integer($where))
        {
            $where = array('id' => $where);
        }
        return (bool) $this->db->where($where)
                               ->delete($this->table);
    }
    // Cette méthode compte des entrées en BDD
    public function countEntries($champ = array(), $valeur = null)
    {
        return (int) $this->db->where($champ, $valeur)
                              ->from ($this->table)
                              ->count_all_results();
    }
    // Cette méthode compte des entrées en BDD + JOIN ON
    public function countJoinedEntries($select, $left_table, $joinOn, $champ = array(), $valeur = null)
    {
        return (int) $this->db->select($select)
                              ->join($left_table, $joinOn)
                              ->where($champ, $valeur)
                              ->from ($this->table)
                              ->count_all_results();
    }

    //---------------------------------------------------------------------------------------------------------------------------------
    // GETTERS ARRAYS - STANDARD OBJECTS ----------------------------------------------------------------------------------------------
    // Elle permet de récupérer une lise d'entrées si result = 1 => array(0) - Array d'objet
    public function getData($select = '*', $where = array(), $limit = null, $debut = null, $orderId = null, $orderDESC = null)
    {
        // cette méthode permet de récupérer une liste d'entrées - $where renseigné
        // Ou une seule entrée (getUnique) - $where non enrenseigné => mais résultat array(0)
        return $this->db->select($select)
                        ->from($this->table)
                        ->where($where)
                        ->limit($limit, $debut)
                        ->order_by($orderId, $orderDESC)
                        ->get()
                        ->result();
    }
    // Elle permet de récupérer une lise d'entrées si result = 1 => array(0) - Simple Tableau de variables (Utile pour Ajax)
    public function getArrayforAjax($select = '*', $where = array(), $limit = null, $debut = null, $orderId = null, $orderDESC = null)
    {
        // cette méthode permet de récupérer une liste d'entrées - $where renseigné
        // Ou une seule entrée (getUnique) - $where non enrenseigné => mais résultat array(0)
        return $this->db->select($select)
                        ->from($this->table)
                        ->where($where)
                        ->limit($limit, $debut)
                        ->order_by($orderId, $orderDESC)
                        ->get()
                        ->result_array();
    }

    // Elle permet de récupérer un seule entrée si result = 1 => 1 pas d'array
    public function getUnique($select = '*', $where = array(), $limit = null, $debut = null, $orderId = null, $orderDESC = null)
    {
        // cette méthode permet de récupérer une seule entrée - $where doit etre renseigné sous forme d'array
        return $this->db->select($select)
                        ->from($this->table)
                        ->where($where)
                        ->limit($limit, $debut)
                        ->order_by($orderId, $orderDESC)
                        ->get()
                        ->row();
    }

    // Elle permet de récupérer les donnnées dont le champ est comme $champ (clause LIKE de SQL)
    public function getEntriesLike($champ, $valeur, $limit = null, $debut = null)
	{
		// EXEMPLE SUR UN SYSTEME DE NEWS --------------------------------//
		//  	%$titre  => dont le titre finit par $titre      - before  //
		//		%$titre% => dont le titre est exactement $titre - both    //
		//		$titre%  => dont le titre commence par $titre   - after   //
		return $this->db->select('*')
					    ->from($this->table)
                        ->like($champ, $valeur, 'after')  // SELECT * FROM post WHERE titre LIKE $titre%
                        //->or_like(	 $champ, $valeur, 'before') // SELECT * FROM post WHERE titre LIKE %$titre
					    //->or_like($champ, $valeur, 'both')   // SELECT * FROM post WHERE titre LIKE %$titre%

                        ->limit($limit, $debut)
                        ->get()
					    ->result();
	}
    // Cette méthode permet derécupérer une liste d'entrées de jointures => si result = 1 => array(0)
    public function getJoinData($select = '*', $left_table, $joinOn, $where = array(), $limit = null, $debut = null, $orderId = null, $orderDESC = null)
	{
		/* PROTOTYPE -------------------------------------------------------//
        //  return $this->db->select('*')                                   //
		//			        ->from($this->table)                            //
		//			        ->join('membres', 'membres.id = post.idMembre') //
		//			        ->where('post.id', (int)$id)                    //
		//			        ->get()                                         //
		//			        ->result();                                     //
        //------------------------------------------------------------------*/
		return $this->db->select($select)
					    ->from($this->table)
					    ->join($left_table, $joinOn)
					    ->where($where)
                        ->limit($limit, $debut)
                        ->order_by($orderId, $orderDESC)
					    ->get()
					    ->result();
	}
    // Cette méthode permet derécupérer une seule entrée de jointures => si result = 1 => 1 pas d'array
    public function getJoinUnique($select = '*', $left_table, $joinOn, $where = array(), $limit = null, $debut = null, $orderId = null, $orderDESC = null)
	{
		return $this->db->select($select)
					    ->from($this->table)
					    ->join($left_table, $joinOn)
					    ->where($where)
                        ->limit($limit, $debut)
                        ->order_by($orderId, $orderDESC)
					    ->get()
					    ->row();
	}//-------------------------------------------------------------------------------------------------------------------

    // GETTERS ARRAYS - CUSTOMIZED OBJECT ----------------------------------------------------------------------------------------
    // Elle permet de récupérer une lise d'entrées si result = Customized Object
    public function getCustomData($select = '*', $where = array(), $limit = null, $debut = null, $orderId = null, $orderDESC = null, $class)
    {
        // cette méthode permet de récupérer une liste d'objets customizé - $where renseigné
        // Ou un array contenant un objet customisé  - $where non enrenseigné => mais résultat array(0 => object customized)
        return $this->db->select($select)
                        ->from($this->table)
                        ->where($where)
                        ->limit($limit, $debut)
                        ->order_by($orderId, $orderDESC)
                        ->get()
                        ->custom_result_object($class); // Exemple custom_result_object('News')
    }
    // Elle permet de récupérer un seule entrée si result = 1 => 1 objet customizé
    public function getCustomUnique($select = '*', $where, $limit = null, $debut = null, $orderId = null, $orderDESC = null, $class)
    {
        // cette méthode permet de récupérer une seule entrée - $where doit etre renseigné sous forme d'array
        return $this->db->select($select)
                        ->from($this->table)
                        ->where($where)
                        ->limit($limit, $debut)
                        ->order_by($orderId, $orderDESC)
                        ->get()
                        ->custom_row_object($class); // Exemple custom_row_object('News')
    }

    // Requetes de type clause LIKE de SQL => Result = Object customizé
    public function getCustomLike($champ, $valeur, $class)
	{
		// EXEMPLE SUR UN SYSTEME DE NEWS --------------------------------//
		//  	%$titre  => dont le titre finit par $titre      - before  //
		//		%$titre% => dont le titre est exactement $titre - both    //
		//		$titre%  => dont le titre commence par $titre   - after   //
		return $this->db->select('*')
					    ->from($this->table)
					    ->like(	 $champ, $valeur, 'before') // SELECT * FROM post WHERE titre LIKE %$titre
					    ->or_like($champ, $valeur, 'both')   // SELECT * FROM post WHERE titre LIKE %$titre%
					    ->or_like($champ, $valeur, 'after')  // SELECT * FROM post WHERE titre LIKE $titre%
					    ->get()
					    ->custom_result_object($class);
	}
    // Elle permet de récupérer une lise d'entrées jointes si result = Customized Object
    public function getCustomJoinData($select = '*', $left_table, $joinOn, $where = array(), $limit = null, $debut = null, $orderId = null, $orderDESC = null, $class)
	{
		return $this->db->select($select)
					    ->from($this->table)
					    ->join($left_table, $joinOn)
					    ->where($where)
                        ->limit($limit, $debut)
                        ->order_by($orderId, $orderDESC)
					    ->get()
					    ->custom_result_object($class);
	}
    // Elle permet de récupérer un seule entrée jointe si result = 1 => 1 objet customizé
    public function getCustomJoinUnique($select = '*', $left_table, $joinOn, $where = array(), $limit = null, $debut = null, $orderId = null, $orderDESC = null, $class)
	{
		/* PROTOTYPE -------------------------------------------------------//
        //  return $this->db->select('*')                                   //
		//			        ->from($this->table)                            //
		//			        ->join('membres', 'membres.id = post.idMembre') //
		//			        ->where('post.id', (int)$id)                    //
		//			        ->get()                                         //
		//			        ->result();                                     //
        //------------------------------------------------------------------*/
		return $this->db->select($select)
					    ->from($this->table)
					    ->join($left_table, $joinOn)
					    ->where($where)
                        ->limit($limit, $debut)
                        ->order_by($orderId, $orderDESC)
					    ->get()
					    ->custom_row_object(0, $class);
	}//-------------------------------------------------------------------------------------------------------------------

    // OTHERS  -----------------------------------------------------------------------------------------------------------
    // cette méthode permet de vérifier si une entrée existe en BDD
    public function doExists($select = '*', $where)
    {
        $result =  $this->db->select($select)
                            ->from($this->table)
                            ->where($where)
                            ->get()
                            ->result();

        return !empty($result) ? true : false;
    }//-------------------------------------------------------------------------------------------------------------------
}
