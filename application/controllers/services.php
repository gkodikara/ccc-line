<?php 

class Services extends CI_Controller {

	public function index() {
		$this->load->model("services_model");
		$this->get_questions();
	}

	function get_questions() {
		var_dump($this->services_model->get_question_list());
	}

}

?>