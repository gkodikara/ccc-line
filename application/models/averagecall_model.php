<?php
Class Averagecall_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    
    
    function date_range()
    {
        $sql = "SELECT max(`date_of_call`) as max,min(`date_of_call`) as min from callers";
        
        $res = $this->db->query($sql);
        if($res->num_rows())
        {
        return $res->result_array();
        }
        ELSE
        {
            return "";
        }
        
    }
            
    function average_call_range($start_date,$end_date)
    {
        $sql = "SELECT `date_of_call` as Date1,count(`id`) as Number_of_call  FROM callers WHERE `date_of_call` between '".$start_date . "' and '" .$end_date ."' group by `date_of_call`";
       
        $res = $this->db->query($sql);
        if($res->num_rows())
        {
        return $res->result_array();
        }
        ELSE
        {
            return "";
        }
    }
    
    function categories_dropdown()
    {
        $val = $this->db->get('referreral_categories');
        
        $res = $val->result_array();
        $temp = array();
        
        foreach ($res as $key => $value) {
            $temp[$key] = $value['category_name'];
        }
        
        return $temp;
    }
    
    function categories_call_range($start_date,$end_date)
    {
        
                $sql = "SELECT rc.category_name as Date1,count(callers.id) as Number_of_call FROM callers \n"
                    . "INNER JOIN caller_service_link as csl on csl.caller_id = callers .id\n"
                    . "INNER JOIN referreral_categories as rc on rc.id = csl.service_id\n"
                    . "WHERE callers.date_of_call between '".$start_date."' and '".$end_date."' group by csl.service_id";
                
               
                $res = $this->db->query($sql);
                if($res->num_rows())
                {
                return $res->result_array();
                }
                else
                {
                    return "";
                }
        
        
    }
    
    function num_province_Categories($start_date,$end_date)
    {
        $sql = "SELECT `caller_district` AS Date1, count( `id` ) AS Number_of_call
        FROM callers
        WHERE `date_of_call`
        BETWEEN '".$start_date . "' and '" .$end_date ."'
        GROUP BY `caller_district`
        ";
        

                $res = $this->db->query($sql);
                if($res->num_rows()>0)
                {
                  
                    return $res->result_array();
                }
                else
                {
                   
                    return "";
                }
        
    }
    
            
    function age_call_range($start_date,$end_date)
    {
        
        
         $sql = "SELECT `caller_age` as Date1 ,count(`id`) as Number_of_call  FROM callers WHERE `date_of_call` between '".$start_date . "' and '" .$end_date ."' group by `caller_age`";
       
     
                $res = $this->db->query($sql);
                if($res->num_rows()>0)
                {
                  
                    return $res->result_array();
                }
                else
                {
                   
                    return "";
                }
    }
}
