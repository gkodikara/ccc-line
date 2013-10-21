<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI
class Averagecall extends CI_Controller {

 function __construct()
 {
   parent::__construct();
   $this->load->library("table");
 }

 function index()
 {
   if($this->session->userdata('logged_in'))
   {
     $session_data = $this->session->userdata('logged_in');
     $data['username'] = $session_data['username'];
     $this->load->view('header');
     $data['right'] = '<div style="width:50%;float:left">'. $this->date_ranger('pane1') .'<div id="pane1_avg_call" style="5%"></div><div id="table_tab" style="margin-top:20px"></div></div>' ;
//     $data['date_ranger'] = $this->date_ranger();
     $this->load->view('averagecall', $data);
     $this->load->view('footer');
   }
   else
   {
     //If no session, redirect to login page
     redirect('login', 'refresh');
   }
 }

 
 function date_ranger($name)
 {
     
     	
     $data =  '<fieldset class="field" style="height:150px">
               <legend class="leg">Select Date Ranger</legend>
                <div style="width:100%;margin-top:20px">  
                <span class="control-group" style="float:left;width:50%">
                    <label class="control-label" style="float: left" for="inputEmail">Start Date:</label>
                   <div class="controls controls-row">
                   <input class="span2" type="text" id="'.$name.'_start_date" required/>
                   </div>
               </span>
               <span class="control-group" style="float:left;width:50%">
                    <label class="control-label" style="float: left" for="inputEmail">End Date:</label>
                   <div class="controls controls-row">
                   <input class="span2" type="text" id="'.$name.'_end_date" required/>
                   </span></div>
                   <div>
</fieldset>';
     return $data;
             
 }

 function num_call()
 {
     $this->load->model('averagecall_model');
     
     $aveg_call =  new Averagecall_model();
     
     $start = $this->input->post('start_date');
     $end = $this->input->post('end_date');
     
    
        $data['table_data'] = $aveg_call->average_call_range($start,$end);
    
     
     $this->table->set_heading(array('Date','Number of Call'));
     
     $data_row = "";
     
     $table = array();
     
     foreach ($data['table_data'] as $index => $val)
                {
                    
                     $table['table_data'][$index] = $val;
                }
     $table_html = $this->table->generate($table['table_data']);
     
     $data['table_html'] = $table_html;
   
     $data_row[strlen($data_row)-1] = "";
     
     $data['chart'] =  $table['table_data'];
     
     $return_data = json_encode($data);
     
     echo $return_data;
     
     die;
 }

 function num_caller_categories()
 {
     $this->load->model('averagecall_model');
     
     $aveg_call =  new Averagecall_model();
     
     $start = $this->input->post('start_date');
     $end = $this->input->post('end_date');
     $cat = $this->input->post('categories');
 
        $data['table_data'] = $aveg_call->categories_call_range($start,$end,$cat);
     
     $this->table->set_heading(array('Date','Number of Call'));
     
     $data_row = "";
      $table = array();
     if(is_array($data['table_data']))
     {
     foreach ($data['table_data'] as $index => $val)
                {
                     $table['table_data'][$index] = $val;
                }
     $table_html = $this->table->generate($table['table_data']);
     
     $data['table_html'] = $table_html;
   
     $data_row[strlen($data_row)-1] = "";
     
     $data['chart'] =  $table['table_data'];
     
     $return_data = json_encode($data);
     }
     else
     {
         $data['table_html'] = "";
         $data['chart'] = "";
         $return_data = json_encode($data);
     }
     echo $return_data;
     
     die;
 }   
 
 function num_province_Categories(){
          $this->load->model('averagecall_model');
     
     $aveg_call =  new Averagecall_model();
     
     $start = $this->input->post('start_date');
     $end = $this->input->post('end_date');
     $cat = $this->input->post('district');
 
     $data['table_data'] = $aveg_call->num_province_Categories($start,$end,$cat);
     
     $this->table->set_heading(array('Date','Number of Call'));
     
     $data_row = "";
     if(is_array($data['table_data'] ))
     {
     foreach ($data['table_data'] as $index => $val)
                {
                    
                     $table['table_data'][$index] = $val;
                }
     $table_html = $this->table->generate($table['table_data']);
     
     $data['table_html'] = $table_html;
   
     $data_row[strlen($data_row)-1] = "";
     
     $data['chart'] =  $table['table_data'];
     
     $return_data = json_encode($data);
     }
     else
     {
         $data['table_html'] = "";
         $data['chart'] = "";
          $return_data = json_encode($data);
     }
     echo $return_data;
     
     die;
 }
         
 function caller_age_categories()
 {
     $data['right'] = '<div style="width:50%"><lable>Select Categories:</lable> '.$this->age_dropdown().'</div><div style="width:50%;float:left">'. $this->date_ranger('pane3') .'<div id="pane3_avg_call" style="5%"></div><div id="pane3_table_tab" style="margin-top:20px"></div></div><div id="pane3_chart_div" style="float:right;width: 50%; height:700px"></div>' ;
     echo json_encode($data);
 }
         
 function Caller_Categories()
{
     $data['right'] = '<div style="width:50%"><lable>Select Categories:</lable> '.$this->categories_dropdown().'</div><div style="width:50%;float:left">'. $this->date_ranger('pane2') .'<div id="pane2_avg_call" style="5%"></div><div id="pane2_table_tab" style="margin-top:20px"></div></div><div id="pane2_chart_div" style="float:right;width: 50%; height:700px"></div>' ;
     echo json_encode($data);
}


function province_Categories()
{
     $data['right'] = '<div style="width:50%"><lable>Select province:</lable> '.$this->district_dropdown().'</div><div style="width:50%;float:left">'. $this->date_ranger('pane4') .'<div id="pane4_avg_call" style="5%"></div><div id="pane4_table_tab" style="margin-top:20px"></div></div><div id="pane4_chart_div" style="float:right;width: 50%; height:700px"></div>' ;
     echo json_encode($data);
}

function age_dropdown()
{
    $val = "<select name=age id=age><option value=<15><15</option><option value=15-16>15-16</option><option value=26-30>26-30</option>
            <option value=36-50>36-50</option><option value=51-64>51-64</option><option value=65>>65</option>
            </select>";

    return $val;
}

function district_dropdown()
{
    $val =' <select id="district" multiple data-placeholder="Select District">
							<option value></option>
							<option value="Ampara">Ampara</option>
							<option value="Anuradhapura">Anuradhapura</option>
							<option value="Badulla">Badulla</option>
							<option value="Batticaloa">Batticaloa</option>
							<option value="Colombo">Colombo</option>
							<option value="Galle">Galle</option>
							<option value="Gampaha">Gampaha</option>
							<option value="Hambantota">Hambantota</option>
							<option value="Jaffna">Jaffna</option>
							<option value="Kalutara">Kalutara</option>
							<option value="Kandy">Kandy</option>
							<option value="Kegalle">Kegalle</option>
							<option value="Kilinochchi">Kilinochchi</option>
							<option value="Kurunegala">Kurunegala</option>
							<option value="Matale">Matale</option>
							<option value="Matara">Matara</option>
							<option value="Moneragala">Moneragala</option>
							<option value="Mullaitivu">Mullaitivu</option>
							<option value="Nuwara Eliya">Nuwara Eliya</option>
							<option value="Polonnaruwa">Polonnaruwa</option>
							<option value="Puttalam">Puttalam</option>
							<option value="Ratnapura">Ratnapura</option>
							<option value="Trincomalee">Trincomalee</option>
							<option value="Vavuniya">Vavuniya</option>
						</select>';
	
    return $val;
}
        function categories_dropdown()
{
     $this->load->model('averagecall_model');
     $this->load->helper('form');
     
     $aveg_call =  new Averagecall_model();
     
     $arr = $aveg_call -> categories_dropdown();
    
      $val = '<select multiple name=categories id=categories>';
    
     
     foreach ($arr as $key => $value) {
          $val .= '<option value='.$key.'>'.$value.'</option>';
     }
     $val .='</select>';
     
//     $val = form_dropdown('categories', $arr);
     
     
     return $val;
}

function num_caller_age()
{
    
     $this->load->model('averagecall_model');
     
     $aveg_call =  new Averagecall_model();
     
     $start = $this->input->post('start_date');
     $end = $this->input->post('end_date');
     $cat = $this->input->post('age');
 
     $data['table_data'] = $aveg_call->age_call_range($start,$end,$cat);
     
     $this->table->set_heading(array('Date','Number of Call'));
     
     $data_row = "";
     if(is_array($data['table_data'] ))
     {
     foreach ($data['table_data'] as $index => $val)
                {
                    
                     $table['table_data'][$index] = $val;
                }
     $table_html = $this->table->generate($table['table_data']);
     
     $data['table_html'] = $table_html;
   
     $data_row[strlen($data_row)-1] = "";
     
     $data['chart'] =  $table['table_data'];
     
     $return_data = json_encode($data);
     }
     else
     {
         $data['table_html'] = "";
         $data['chart'] = "";
          $return_data = json_encode($data);
     }
     echo $return_data;
     
     die;
}
function logout()
 {
   $this->session->unset_userdata('logged_in');
   session_destroy();
   redirect('home', 'refresh');
 }

}
