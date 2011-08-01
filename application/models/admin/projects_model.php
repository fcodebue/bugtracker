<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Projects_Model
 * 
 * @package Projects
 * 
 */

class Projects_model extends CI_Model{

	/** Utility Methods **/
	function _required($required, $data) {
		foreach ($required as $field)
			if(!isset($data[$field])) return false;
		return true;
	}
	
	function _default($defaults, $options) {
		return array_merge($defaults, $options);
	}
	
	
	/** Projects Methods **/
		
	/*
	 * GetProjects
	 * 
	 * Option: Values
	 * --------------
	 * idproject
	 * projectname
	 * projectstatus
	 * limit				limit the returned records
	 * offset				bypass this many records
	 * sortBy				sort by this column
	 * sortDirection		(ASC, DESC)
	 * 
	 * 
	 * Returned Object (array of)
	 * --------------------------
	 * idproject
	 * projectname
	 * projectstatus
	 * 
	 * @param array $options
	 * @result array of objects
	 * 
	 */
	
	
	function GetProjects($options = array()) {
		
		// QUALIFICATION
		if (isset($options['idproject']))
			$this->db->where('idproject', $options['idproject']);		
		if (isset($options['projectname']))
			$this->db->where('projectname', $options['projectname']);		
		if (isset($options['projectstatus']))
			$this->db->where('projectstatus', $options['projectstatus']);			
			
		//so you don't get any deleted values
		if(!isset($options['projectstatus'])) $this->db->where('projectstatus !=', 'deleted');
		
		// LIMIT OFFSET
		if (isset($options['limit']) && isset($options['offset']))
			$this->db->limit($options['limit'], $options['offset']);
		elseif (isset($options['limit']))
			$this->db->limit($options['limit']);
			
		// SORT
		if (isset($options['sortBy']) && isset($options['sortDirection']))
			$this->db->order_by($options['sortBy'], $options['sortDirection']);
		

		$query = $this->db->get('projects');
		
		if(isset($options['count'])) return $query->num_rows();
		
		if (isset($options['idproject']))
			return $query->row(0);
	
		return $query->result();
		
	}
		
}