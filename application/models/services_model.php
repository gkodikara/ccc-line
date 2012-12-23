<?php 
	class Services_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_services_list($limit, $offset) {
    	$query = $this->db->query('SELECT * FROM services
                                    LIMIT ?
                                    OFFSET ?', array($limit, (int) $offset));
    	$results = array();
        $total_results_count = $this->db->get("services")->num_rows();
    	foreach ($query->result() as $service) {
    		$results[] = (array) $service;
    	}
    	
    	return array(
            "results" => $results,
            "total_count" => $total_results_count
            );
    }
}


?>