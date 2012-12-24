<?php 

class Services extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model("services_model");
		$this->load->library('pagination');
		$this->load->library("table");

	}

	function index() {
		$this->get_services();
	}

	function get_services() {
		$config['per_page'] = 20; 

		$service_data = $this->services_model->get_services_list($config['per_page'], $this->uri->segment(3));

		$config['base_url'] = base_url('index.php/services/get_services');
		$config['total_rows'] = $service_data["total_count"];
		

		$this->pagination->initialize($config); 

		echo $this->pagination->create_links();

		$this->table->set_heading("Service ID", 
									"Service Name", 
									"Service Type", 
									"Service Location", 
									"Service Contact", 
									"Service Contact Telephone"
									);

		$this->table->set_caption('Available Services');

		$data = array(
			"services_table" => $this->table->generate($service_data["results"])
		);

		$this->load->view("services", $data);
	}

}

?>