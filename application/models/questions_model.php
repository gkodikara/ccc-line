<?php 
	class Questions_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_static_fields() {
    	$outcome_array = $this->get_outcomes()->result();
    	$issue_array = $this->get_issues()->result();
        $referral_array = $this->get_referral()->result();
        
    	return array('outcome_codes'=>$outcome_array, 'issue_codes'=>$issue_array , 'referral' =>$referral_array)  ;
    }

    function get_outcomes() {
    	return $this->db->get('outcome_codes');
    }

    function get_issues() {
    	return $this->db->get('issue_codes');
    }
    
    function get_referral()
    {
        return $this->db->get('referreral_categories');
    }
            
    function new_call_log($call_data_array) {
    	
        $data = array(
            "log_date" => $call_data_array['sLogDate'], 
            "user_id" => $call_data_array['sCounsellorUserId'], 
            "caller_district" => $call_data_array['sDistrict'], 
            "date_of_call" => $call_data_array['sDateOfCall'], 
            "start_of_call" => $call_data_array['sStartTime'], 
            "end_of_call" => $call_data_array['sEndTime'],
            "caller_gender" => $call_data_array['sGender'],
            "language_spoken" => $call_data_array['sLanguageSpoken'],
            "major_issues" => implode(",", $call_data_array['aChosenIssues']),
            "outcome" => implode(",", $call_data_array['aChosenOutcomes']),
            "caller_feelings" => $call_data_array['sCallerFeelings'],
            "caller_story" => $call_data_array['sCallerStory'],
            "counsellors_response" => implode(",", $call_data_array['sSkillsUsed']),
            "discussion_1" => $call_data_array['sDiscussion1'],
            "discussion_2" => $call_data_array['sDiscussion2'],
            "discussion_3" => $call_data_array['sDiscussion3'],
            "further_training" => $call_data_array['sFurtherTraining']
        );

    	$query = $this->db->insert('callers', $data); 
        $id = $this->db->insert_id();
        
        $referral = $call_data_array['referral'];
        foreach ($referral as $value) {
            $this->db->insert('caller_referreral_link', array('referreral_id'=>$value,'caller_id'=>$id));
        }
        
    }

    function get_caller_table() {
    	$table_headers = $this->db->list_fields('callers');
        $inserted = array('   referral_given   ');
        array_splice( $table_headers,12,0, $inserted );  
    	foreach ($this->db->get('callers')->result_array() as $callers) {
    		 $newArray = array_slice($callers, 0, 12, true) +
                            $this->get_caller_referral($callers['id']) +
                            array_slice($callers, 12, NULL, true);
                
                $table_data[] = $newArray ;
                   
    	}	
            
    	return array('table_headers' => $table_headers, 'table_data' => $table_data);
    }
    
    function get_caller_referral($id)
    {
        $this->db->select('rc.category_name');
        $this->db->from('referreral_categories as rc');
        $this->db->join('caller_referreral_link crl', 'crl.referreral_id = rc.id','inner');
        $this->db->where('crl.caller_id',$id);
        $result = $this->db->get();
        
        $return_val ="";
        if($result->num_rows()>0)
        {
            $i =0;
            foreach ($result->result() as $val)
            {
                if($i >0)
                {
                    $return_val .=',';
                }
                $return_val .= $val->category_name;
                $i++;
            }
        }
        else
        {
            $return_val ="";
        }
        
        $val = array(
            'referral_given'=>$return_val
        );
        
        return $val;
    }

}
