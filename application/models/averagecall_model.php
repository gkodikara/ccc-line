<?php
Class Averagecall_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    
    
    function average_call_range($start_date,$end_date)
    {
        $sql = "SELECT `date_of_call` as Date1,count(`id`) as Number_of_call  FROM callers WHERE `date_of_call` between '".$start_date . "' and '" .$end_date ."' group by `date_of_call`";
       
        $res = $this->db->query($sql);
        
        return $res->result_array();

    }
    
   
}
