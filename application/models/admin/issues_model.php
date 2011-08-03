<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Issues_Model
 * 
 * @package Issues
 * 
 */

class Issues_model extends CI_Model{

	/** Utility Methods **/
	function _required($required, $data) {
		foreach ($required as $field)
			if(!isset($data[$field])) return false;
		return true;
	}
	
	function _default($defaults, $options) {
		return array_merge($defaults, $options);
	}
	
	
	/** Issues Methods **/
		
	/*
	 * GetIssues
	 * 
	 * Option: Values
	 * --------------
	 * idissue
	 * iduser
	 * idproject
	 * issuetitle
	 * issueintro
	 * issuedescription
	 * issueprint
	 * last_update
	 * issuetype
	 * issuestatus
	 * limit				limit the returned records
	 * offset				bypass this many records
	 * sortBy				sort by this column
	 * sortDirection		(ASC, DESC)
	 * 
	 * 
	 * Returned Object (array of)
	 * --------------------------
	 * idissue
	 * iduser
	 * idproject
	 * issuetitle
	 * issueintro
	 * issuedescription
	 * issueprint
	 * last_update
	 * issuetype
	 * issuestatus
	 *  
	 * @param array $options
	 * @result array of objects
	 * 
	 */
	
	
	function GetIssues($options = array()) {
		
		//required Values
		if(!isset($options['idissue'])){
			if(!$this->_required(
				array('idproject'),
				$options
			)) return false;
		}

		// QUALIFICATION
		if (isset($options['idissue']))
			$this->db->where('idissue', $options['idissue']);		
		if (isset($options['iduser']))
			$this->db->where('iduser', $options['iduser']);		
		if (isset($options['issuetitle']))
			$this->db->where('issuetitle', $options['issuetitle']);	
		if (isset($options['idproject']))
			$this->db->where('idproject', $options['idproject']);
		if (isset($options['issuestatus']))
			$this->db->where('issuestatus', $options['issuestatus']);
		if (isset($options['issuetype']))
			$this->db->where('issuetype', $options['issuetype']);
					
			
		//so you don't get any deleted values
		if(!isset($options['issuestatus'])) $this->db->where('issuestatus !=', 'deleted');
		
		// LIMIT OFFSET
		if (isset($options['limit']) && isset($options['offset'])){
			$this->db->limit($options['limit'], $options['offset']);
		}
		elseif (isset($options['limit'])){
			$this->db->limit($options['limit']);
		}
		// SORT
		if (isset($options['sortBy']) && isset($options['sortDirection']))
			$this->db->order_by($options['sortBy'], $options['sortDirection']);
		
		$query = $this->db->get('issues');
		
		
		if(isset($options['count'])) return $query->num_rows();
		
		if (isset($options['idissue']))
			return $query->row(0);
	
		return $query->result();
		
	}
		
}