<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Questions extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

	function __construct() {
		parent::__construct();
		$this->load->model("login");
		$this->load->model("questions_model");
                $this->load->model('services_model');
		$this->load->library("table");
	}

	public function index() {

	}

	public function new_call() {
		$data['static_fields'] = $this->questions_model->get_static_fields();
                $table = $this->questions_model->get_service_table();
		$this->table->set_heading($table['table_headers']);
                
                foreach ($table['table_data'] as $index => $val)
                {
                     $table['table_data'][$index]['service_type'] = $this->service_type_id($val['id']);
                     
                }
//                var_dump($table);
		$table_html = $this->table->generate($table['table_data']);
                
                $data['services_table'] = $table_html;
                
		$this->load->view('header');
		$this->login->check_login();
		$this->load->view('new_call', $data);
		$this->load->view('footer');
	}

	public function new_call_log() {
		$result = $this->questions_model->new_call_log($this->input->post());
		echo $result;
	}

	public function show_questions() {
		$table = $this->questions_model->get_caller_table();
		
		$this->table->set_heading($table['table_headers']);
		$table_html = $this->table->generate($table['table_data']);
		
		$this->load->view('header');
		$this->login->check_login();
		$this->load->view('questions', array('table_body' => $table_html));
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

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */