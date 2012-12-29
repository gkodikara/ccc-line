<?php 

class Services extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model("services_model");
		$this->load->library("table");

	}

	function index() {
		$this->load->view("header");
		$this->get_services();
		$this->load->view("footer");
	}

	function get_services($return_json = false) {
		$service_data = $this->services_model->get_services_list();

		$this->table->set_heading("Service ID", 
									"Service Name", 
									"Service Type", 
									"Service Location", 
									"Service Contact", 
									"Service Contact Telephone"
									);
		
		$data = array(
			"services_table" => $this->table->generate($service_data["results"])
		);

		if ($return_json) {
			echo json_encode($data);
		} else {
			$this->load->view("services_table", $data);
		}
	}

	function get_services_paginate() {
		$this->load->library('pagination');

		$config['per_page'] = 20; 

		$service_data = $this->services_model->get_services_list($config['per_page'], $this->uri->segment(3));
		$service_data = $this->services_model->get_services_list();

		$config['base_url'] = base_url('index.php/services/get_services');
		$config['total_rows'] = $service_data["total_count"];
		$config['full_tag_open'] = "<div class='pagination'>";
		$config['full_tag_close'] = "</div>";

		$this->pagination->initialize($config);

		$data = array(
			"services_table" => $this->table->generate($service_data["results"])
		);

		$this->load->view("services", $data);

	}

	function add_service() {
		$service_name = $this->input->post("service_name");
		$service_type = $this->input->post("service_type");
		$service_location = $this->input->post("service_location");
		$service_contact = $this->input->post("service_contact");
		$service_contact_telephone = $this->input->post("service_contact_telephone");


		$this->services_model->add_service($service_name, 
			$service_type, 
			$service_location, 
			$service_contact, 
			$service_contact_telephone);

		return $this->get_services(true);
	}

	function update_service() {
		$service_id = $this->input->post("service_id");
		$service_name = $this->input->post("service_name");
		$service_type = $this->input->post("service_type");
		$service_location = $this->input->post("service_location");
		$service_contact = $this->input->post("service_contact");
		$service_contact_telephone = $this->input->post("service_contact_telephone");


		$this->services_model->update_service(
			$service_id,
			$service_name, 
			$service_type, 
			$service_location, 
			$service_contact, 
			$service_contact_telephone);

		return $this->get_services(true);
	}

	function remove_service() {
		$delete_service_id = $this->input->post("service_id");

		$this->services_model->remove_service($delete_service_id);

		return $this->get_services(true);
	}

}

?>