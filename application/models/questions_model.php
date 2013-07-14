<?php 
	class Questions_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_static_fields() {
    	$outcome_array = $this->get_outcomes()->result();
    	$issue_array = $this->get_issues()->result();

    	return array('outcome_codes'=>$outcome_array, 'issue_codes'=>$issue_array);
    }

    function get_outcomes() {
    	return $this->db->get('outcome_codes');
    }

    function get_issues() {
    	return $this->db->get('issue_codes');
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
    }

    function get_caller_table() {
    	$table_headers = $this->db->list_fields('callers');
    	foreach ($this->db->get('callers')->result() as $callers) {
    		$table_data[] = (array) $callers;
    	}	
    	return array('table_headers' => $table_headers, 'table_data' => $table_data);
    }

}
