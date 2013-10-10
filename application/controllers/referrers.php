<?php 
//0312228068
class Referrers extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model("login");
		$this->load->model("services_model");
		$this->load->library("table");
	}

	function index() {
		$this->load->view("header");
		$this->login->check_login();
		$this->get_services();
		$this->load->view("footer");
	}

	function get_services($return_json = false) {
		$service_data = $this->services_model->get_services_list();
		
		$field_names = $this->field_name_process($service_data["field_names"]);

		$this->table->set_heading($field_names["field_names_readable"]);
		$table_string = "<table>";
		$table_head = "<thead>";

		foreach ($service_data["field_names"] as $index => $header_name) {
			$table_head .= "<th data-id='".$field_names["field_names_readable"][$index]."'>" . $field_names["field_names_readable"][$index] . "</th>";
		}

		$table_head .= "</thead>";
		$table_string .= $table_head; 

		$table_string .= "<tbody>";

		foreach($service_data["results"] as $result_row) {
			$table_string .= "<tr data-item-id=".$result_row["id"].">";
			foreach($result_row as $result_cell_id => $value) {
                                if($result_cell_id == 'service_type')
                                {
                                    $table_string .= "<td id='' data-id='".$result_cell_id."'>". $this->service_type_id($result_row["id"])."</td>";
                                }
                                else
				$table_string .= "<td id='' data-id='".$result_cell_id."'>".$value."</td>"; 
				// var_dump($result_row);			
			}
			$table_string .= "</tr>";
		}

		$table_string .= "<tbody></table>";
                
                $service_type =  $this->get_referreral_categories();
                
		$data = array(
			"services_table" => $table_string,//$this->table->generate($service_data["results"]),
			"field_names_data" => $field_names,
                        "service_type" => $service_type
		);
                
//                $data['service_type'] = $this->services_model->get_referreral_categories();
                
		if ($return_json) {
			echo json_encode($data);
		} else {
//                    var_dump($data);die;
			$this->load->view("services_table", $data);
		}
	}
        
	function field_name_process($field_names) {
		$field_name_html = "";
		$field_names_readable = array();
		$field_names_underscore = array();

		$count = 0;

		foreach($field_names as $field) {
			// $field_name = str_replace("service", "referrer", $field);
			$field_name_readable = ucfirst(str_replace("_", " ", $field));
			// array_push($field_names_underscore, $field_name);
			array_push($field_names_readable, $field_name_readable);
                        
			$field_name_html .= "<label><input class='field-name-select' data-toggle='' type='checkbox' col-index='".$count."' value='".$field_name_readable."'/> ".$field_name_readable."</label>";
			$count++;
		}

                
		$return_array = array("field_name_html" => $field_name_html, 
								"field_names_readable" => $field_names_readable);

		return $return_array;
	}

	//PHP Paginate - not used
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
		$service_location = $this->input->post("service_address");
		$service_contact = $this->input->post("service_contact");
		$service_contact_telephone = $this->input->post("service_contact_telephone");
		$services_offered = $this->input->post("services_offered");
		$service_fax = $this->input->post("service_fax");
		$service_website = $this->input->post("service_website");
		$service_comments = $this->input->post("service_comments");



//
		$this->services_model->add_service(
			$service_name, 
			$service_type, 
			$service_location, 
			$service_contact, 
			$service_contact_telephone,
			$services_offered,
			$service_website,
			$service_comments, 
			$service_fax);

		return $this->get_services(true);
	}

	function update_service() {
		$service_id = $this->input->post("service_id");
		$service_name = $this->input->post("service_name");
		$service_type = $this->input->post("service_type");
		$service_location = $this->input->post("service_address");
		$service_contact = $this->input->post("service_contact");
		$service_fax = $this->input->post("service_fax");

		$service_contact_telephone = $this->input->post("service_contact_telephone");
		$services_offered = $this->input->post("services_offered");
		$service_website = $this->input->post("service_website");
		$service_comments = $this->input->post("service_comments");



//
		$this->services_model->update_service(
			$service_id,
			$service_name, 
			$service_type, 
			$service_location, 
			$service_contact, 
			$service_contact_telephone,
			$services_offered,
			$service_website,
			$service_comments,
			$service_fax);

		return $this->get_services(true);
	}

	function remove_service() {
		$delete_service_id = $this->input->post("service_id");

		$this->services_model->remove_service($delete_service_id);
  
		return $this->get_services(true);
	}

	function get_service_types() {
		return $this->services_model->get_service_types();

	}

	function add_service_type() {
		$service_type_name = $this->input->post("service_type_name");
		$service_type_description = $this->input->post("service_type_description");

		$this->services_model->add_service_type($service_type_name, 
			$service_type_description);
	}

	function remove_service_type() {
		$service_type_id = $this->input->post("service_type_id");

		$this->services_model->remove_service_type($service_type_id);
	}

	function update_service_type() {
		$service_type_id = $this->input->post("service_type_id");
		$service_type_name = $this->input->post("service_type_name");
		$service_type_description = $this->input->post("service_type_description");

		$this->services_model->update_service_type($service_type_id, 
			$service_type_name, 
			$service_type_description);
	}
        
        function get_referreral_categories()
        {
            $result = "";
            $result .= '<div id="dropdown_div" style="display: none">';
            $var = $this->services_model->get_referreral_categories();
            foreach ($var as $val) {
                              $result .=  '<option value='.$val['id'].'>'.$val['category_name'].'</option>';
                            }
                            
           $result .= '</div>';                 
                            return $result;
        }
        
        function service_type_id($id)
        {
            $val = $this->services_model->service_type_id($id);
            $res ="";
            $i =0;
            foreach ($val as $value)
            {
                if($i != 0)
                {
                    $res .= ',';
                }
                
                $res .=$value['category_name'];
                $i++;
            }
            
            return $res;
        }

}
