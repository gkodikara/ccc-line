<?php 
	class Services_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_services_list() {
    	$query = $this->db->query('SELECT id, 
                                        service_name, 
                                        service_type, 
                                        service_location, 
                                        service_contact, 
                                        service_contact_telephone 
                                        FROM services');
                                    // LIMIT ?
                                    // OFFSET ?', array($limit, (int) $offset));
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

    function get_services_list_paginate($limit, $offset) {
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

    function add_service($service_name, $service_type, $service_location, $service_contact, $service_contact_telephone) {
        //This doesn't work - find out why...
        // $sql = 'INSERT INTO services (service_name, service_type, service_location, service_contact, service_contact_telephone) 
        //             VALUES ($service_name, $service_type, $service_location, $service_contact, $service_contact_telephone)';
        // $this->db->simple_query($sql);
        
        $data = array(
            "service_name" => $service_name, 
            "service_type" => $service_type, 
            "service_location" => $service_location, 
            "service_contact" => $service_contact, 
            "service_contact_telephone" => $service_contact_telephone
            );
         
        $this->db->insert('services', $data); 
    }

    function update_service($service_id, $service_name, $service_type, $service_location, $service_contact, $service_contact_telephone) {
        $data = array(
            "service_name" => $service_name, 
            "service_type" => $service_type, 
            "service_location" => $service_location, 
            "service_contact" => $service_contact, 
            "service_contact_telephone" => $service_contact_telephone
        );

        $this->db->where('id', $service_id);
        $this->db->update('services', $data);
    }
}


?>