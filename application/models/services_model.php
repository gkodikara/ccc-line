<?php 
	class Services_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    	$this->load->database();

    }

    function get_question_list() {
    	$query = $this->db->query('SELECT * FROM questions');
    	$results = array();
    	foreach ($query->result() as $question) {
    		$results[] = $question;
    	}
    	
    	return $results;
    }
}