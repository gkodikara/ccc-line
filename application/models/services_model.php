<?php 
	class Services_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_services_list() {
    	$query = $this->db->query('SELECT * FROM services');

    	$results = array();
        $total_results_count = $this->db->get("services")->num_rows();
    	foreach ($query->result() as $service) {
    		$results[] = (array) $service;
    	}
    	
    	return array(
            "results" => $results,
            "field_names" => $this->db->list_fields('services')
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
            "service_type" => "",
            "service_address" => $service_location, 
            "service_contact" => $service_contact, 
            "service_contact_telephone" => $service_contact_telephone
            );
         
        $query = $this->db->insert('services', $data); 
           $id = mysql_insert_id();
           foreach ($service_type as $value) {
               $val = array(
                   'referrer_id' => $value,
                   'service_id' => $id
               );
               $query2 = $this->db->insert('service_referreral_links', $val);
           }
        
        return $query;
    }

    function update_service($service_id, $service_name, $service_type, $service_location, $service_contact, $service_contact_telephone) {
       
        $this->db->delete('service_referreral_links', array('service_id'=>$service_id));
        foreach ($service_type as $value) {
               $val = array(
                   'referrer_id' => $value,
                   'service_id' => $service_id
               );  
               $this->db->insert('service_referreral_links', $val);
        }
        
        $data = array(
            "service_name" => $service_name, 
            "service_type" => "", 
            "service_address" => $service_location, 
            "service_contact" => $service_contact, 
            "service_contact_telephone" => $service_contact_telephone
        );

        $this->db->where('id', $service_id);
        
        return $this->db->update('services', $data);
    }

    function remove_service($service_id) {
        $this->db->delete('service_referreral_links', array('service_id'=>$service_id));
        return $this->db->delete('services', array('id' => $service_id));
    }

    
    
    function get_service_types() {
        return $this->db->get('service_type');
    }

    function add_service_type($service_type_name, $service_type_description) {
        $data = array(
            "service_type_name" => $service_type_name,
            "description" => $service_type_description);

        return $this->db->insert('service_type', $data);
    }

    function remove_service_type($service_type_id) {
        return $this->db->delete('service_type', array("id" => $service_type_id));

    }

    function update_service_type($service_type_name, $service_type_description) {
        $data = array(
            "service_type_name" => $service_type_name,
            "description" => $service_type_description);

        $this->db->where('id', $service_type_id);

        return $this->db->update('service_type', $data);
    }
    
    function get_referreral_categories()
    {
        $val = $this->db->get('referreral_categories');
        return $val->result_array();
    }
    
    function service_type_id($id)
    {
        $this->db->select('rc.*');
        $this->db->from('service_referreral_links as sr');
        $this->db->join('referreral_categories as rc','rc.id = sr.referrer_id','inner');
        $this->db->distinct();
        $res = $this->db->get_where('service_referreral_links', array('sr.service_id'=>$id));
        return $res->result_array();
    }
}