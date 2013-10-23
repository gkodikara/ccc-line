<?php
Class Averagecall_model extends CI_Model {
    function __construct() {
        parent::__construct();
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
    
    function categories_call_range($start_date,$end_date,$categories)
    {
        
        $this->db->select('caller_id');
        $this->db->from('caller_service_link');
        $this->db->where_in('service_id',$categories);
        $this->db->distinct();
        $val = $this->db->get();
                
        if($val->num_rows())
        {
            $t = $val->result_array();
            $va = array();
            
            foreach ($t as $value) {
                $va[] = $value['caller_id'];
            }
            
            $str = implode(',', $va);
            
                $sql = "SELECT `date_of_call` as Date1,count(`id`) as Number_of_call  FROM callers WHERE `date_of_call` between '".$start_date . "' and '" .$end_date ."' and id in ($str) group by `date_of_call`";
                
                $res = $this->db->query($sql);
                
                return $res->result_array();
        }
        else
        {
            return "";
        }
        
        
    }
    
    function num_province_Categories($start_date,$end_date,$province)
    {
        $str ="";
        foreach ($province as $value) {
            $str  .= '"'.$value.'",';
        }
        
          $str =  substr($str,0, strlen($str)-1);
        
        $sql = "SELECT `date_of_call` AS Date1, count( `id` ) AS Number_of_call
        FROM callers
        WHERE `date_of_call`
        BETWEEN '2013-07-01'
        AND '2013-10-31'
        AND caller_district
        IN ($str)
        GROUP BY `date_of_call`
        ";
        
//     echo $sql;
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
    
            
    function age_call_range($start_date,$end_date,$age)
    {
        
        
         $sql = "SELECT `date_of_call` as Date1,count(`id`) as Number_of_call  FROM callers WHERE `date_of_call` between '".$start_date . "' and '" .$end_date ."' and caller_age ='$age' group by `date_of_call`";
       
     
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
