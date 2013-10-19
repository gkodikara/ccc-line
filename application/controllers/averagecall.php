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
     $data['right'] = '<div style="width:50%;float:left">'. $this->date_ranger() .'<div id="avg_call" style="5%"></div><div id="table_tab" style="margin-top:20px"></div></div>' ;
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

 
 function date_ranger()
 {
     
     	
     $data =  '<fieldset class="field" style="height:150px">
               <legend class="leg">Select Date Ranger</legend>
                <div style="width:100%;margin-top:20px">  
                <span class="control-group" style="float:left;width:50%">
                    <label class="control-label" style="float: left" for="inputEmail">Start Date:</label>
                   <div class="controls controls-row">
                   <input class="span2" type="text" id="start_date" required/>
                   </div>
               </span>
               <span class="control-group" style="float:left;width:50%">
                    <label class="control-label" style="float: left" for="inputEmail">End Date:</label>
                   <div class="controls controls-row">
                   <input class="span2" type="text" id="end_date" required/>
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
         
 function logout()
 {
   $this->session->unset_userdata('logged_in');
   session_destroy();
   redirect('home', 'refresh');
 }

}
