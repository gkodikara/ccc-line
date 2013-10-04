<?php date_default_timezone_set("Australia/Canberra"); ?>
<div class="new-call-container">   
	<h3>New Call</h3>
	<br/>
	<div class="row-fluid ">
		<div class="container">
			<form class="form-horizontal">
				<div class="control-group">
					<label class="control-label" for="inputEmail">Log Date: </label>
					<div class="controls">
						<input type="text" class="span7" id="log_date" placeholder="Email" value="<?= date("Y-m-d H:i:s"); ?>" disabled>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputEmail">Counsellor Username:</label>
					<div class="controls">
						<input type="text" class="span7" id="counsellor_username" placeholder="Email" user-id="<?= $user_id; ?>" value="<?= $username; ?>" disabled>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="district">Caller District: </label>
					<div class="controls">
						<select id="district" class="span7" data-placeholder="Select District">
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
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputEmail">Date of call:</label>
					<div class="controls controls-row">
						<input class="span4" type="text" id="date_of_call" required/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputEmail">Start of call:</label>
					<div class="controls controls-row">
						<input type="text" class="time-field span4" id="start_time" size="10" required/> 
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputEmail">End of call:</label>
					<div class="controls controls-row">
						<input type="text" class="time-field span4" id="end_time" size="10" required/> 
					</div>
				</div>
				<div class="control-group" style="display:none;">
					<label class="control-label" for="inputEmail">Duration: </label>
					<div class="controls">
					<input type="text" class="span7" id="call_duration" placeholder="Auto Duration" disabled>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputEmail">Gender: </label>
					<div class="controls">
						<select class="span7" id="gender" data-placeholder="Select Gender">
							<option value></option>
							<option value="Male">Male</option>
							<option value="Female">Female</option>
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="ageRange">Callers age: </label>
					<div class="controls">
						<select class="span7" id="ageRange" data-placeholder="Select Age Range">
							<option value></option>
							<option value="<15">Under 15</option>
							<option value="15-25">15-25</option>
							<option value="26-35">26-35</option>
							<option value="36-50">36-50</option>
							<option value="51-64">51-64</option>
							<option value=">65">Over 65</option>
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputEmail">Language Spoken: </label>
					<div class="controls">
						<select class="span7" id="language_spoken" data-placeholder="Select Language">
							<option value></option>
							<option value="english">English</option>
							<option value="sinhala">Sinhala</option>
							<option value="tamil">Tamil</option>
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="major_issue_2">Major Issue(s): </label>
					<div class="controls">
						<select data-placeholder="Select Major Issue(s)" class="span12" id="major_issues" multiple >
							<?php foreach($static_fields['issue_codes'] as $issue) {
								echo '<option value="'.$issue->id.'">'.$issue->issue_name.'</option>';
							} ?>
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputEmail">Outcome: </label>
					<div class="controls">
						<select id="outcome_actions" class="span12" data-placeholder="Select Outcome(s) from the call" multiple >
							<?php foreach($static_fields['outcome_codes'] as $outcome) {
								echo '<option value="'.$outcome->id.'">'.$outcome->outcome_name.'</option>';
							} ?>
						</select>
					</div>
				</div>
				
                                <div class="control-group">
					<label class="control-label" for="referral">Referral Given: </label>
					<div class="controls">
						<select id="referral" class="span12" data-placeholder="Select Outcome(s) from the call" multiple >
							<?php foreach($static_fields['referral'] as $referral) {
								echo '<option value="'.$referral->id.'">'.$referral->category_name.'</option>';
							} ?>
						</select>
					</div>
				</div>
                                
                                <div class="control-group">
					<label class="control-label" for="inputEmail">Caller Feelings: </label>
					<div class="controls">
						<textarea class="span12" id="caller_feelings" required></textarea>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputEmail">Caller's Story: </label>
					<div class="controls">
						<textarea class="span12" id="caller_story" required></textarea>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="inputEmail">Counsellors Response: </label>
					<div class="controls">
						<select id="skills_used" class="span12" data-placeholder="Select skills" multiple>
							<option value="questioning_skills">Questioning Skills</option>
							<option value="reflective_skills">Reflective Skills</option>
							<option value="active_listening">Active Listening</option>
							<option value="other">Other</option>
						</select>
					</div>
					<br/>
					<label class="control-label" for="otherResponse">If "Other", please specify: </label>
					<div class="controls">
						<textarea class="span12" id="other_response"></textarea>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="inputEmail">Discussion: </label>
					<div class="controls">
						<br/>

						Were there parts of this call that you found difficult or upsetting? 
						<textarea class="span12" id="discussion_1" required></textarea>
						<br/>
						<br/>

						Are there parts of the call that you could have handled better?
						<textarea class="span12" id="discussion_2" required></textarea>
						<br/>
						<br/>

						Would you like to speak with someone about this call? 
						<textarea class="span12" id="discussion_3" required></textarea>
						<br/>
						<br/>

						Do you require further training related to this call?
						<br/>

						<select class="span3" id="further_training" data-placeholder="Select an option">
							<option value="yes">Yes</option>
							<option value="no">No</option>
						</select>

					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<button class="submit-form btn btn-large btn-success"><i class="icon-white icon-thumbs-up"></i> Submit</button>
						<button class="save-form btn btn-large btn-info"><i class="icon-white icon-file"></i> Save</button>
						<button class="btn btn-large btn-danger"><i class="icon-white icon-trash"></i> Clear</button>
					</div>
				</div>
			</form>

		</div>
	</div>
</div>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/question_form.js"></script>
