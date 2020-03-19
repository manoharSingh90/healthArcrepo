<?php
if(isset($patientsData) && !empty($patientsData)) {
foreach($patientsData as $key => $value) { ?>
<section class="row mx-0 mb-3">
	<section class="bio-info float-left w-100 bg-white p-2 list">
		<section class="profile-bio">
			<span class="profile-img"><img src="<?php echo !empty($value["image_url"]) ? "https://healtharc-mobile-api.s3.amazonaws.com/".$value["image_url"] : IMAGE_PATH."default_profile.png"; ?>" alt="profile"></span>
			<div class="info">
				<?php
				$currentYear = date("Y");
				$dob = isset($value["dob"]) && !empty($value["dob"]) ? explode("/",date("d/m/Y",strtotime($value["dob"]))) : "";
				?>
			
				<h3><a href="<?php echo $this->Url->build(["controller"=>"Patients","action"=>"patientdetails",base64_encode($value["patient_id"])]); ?>"><?php echo $value["name"]; ?></a></h3>
				<p><?php echo !empty($dob) ? $dob[0]."/".$dob[1]."/".$dob[2] : ""; ?> <?php echo ($currentYear - $dob[2])==0 ? "" : "(".($currentYear - $dob[2]).")" ; ?> <br> <?php echo $value["condition_abbreviation"]; ?></p>
			</div>
		</section>
		
		<?php
		if(isset($value["patientappointmentrequests_data"]) && !empty($value["patientappointmentrequests_data"]))
		{
			$patientAppointmentRequestsData = json_decode($value["patientappointmentrequests_data"],true);
			//echo "<pre>"; print_r($patientAppointmentRequestsData);die;
		}
		?>
		<section class="contact-info">
			<?php
			$callColor = isset($patientAppointmentRequestsData["patient_id"]) && $patientAppointmentRequestsData["patient_id"]==$value["patient_id"] && isset($patientAppointmentRequestsData["appointment_type"]) && $patientAppointmentRequestsData["appointment_type"]==1 && isset($patientAppointmentRequestsData["is_completed"]) && $patientAppointmentRequestsData["is_completed"]==0 ? "red-cat" : "grey-cat";
			$callID = isset($patientAppointmentRequestsData["patient_id"]) && $patientAppointmentRequestsData["patient_id"]==$value["patient_id"] && isset($patientAppointmentRequestsData["appointment_type"]) && $patientAppointmentRequestsData["appointment_type"]==1 && isset($patientAppointmentRequestsData["is_completed"]) && $patientAppointmentRequestsData["is_completed"]==0 ? $patientAppointmentRequestsData["patient_appointment_request_id"] : "";
			
			$visitColor = isset($patientAppointmentRequestsData["patient_id"]) && $patientAppointmentRequestsData["patient_id"]==$value["patient_id"] && isset($patientAppointmentRequestsData["appointment_type"]) && $patientAppointmentRequestsData["appointment_type"]==2 && isset($patientAppointmentRequestsData["is_completed"]) && $patientAppointmentRequestsData["is_completed"]==0 ? "blue-cat" : "grey-cat";
			$visitID = isset($patientAppointmentRequestsData["patient_id"]) && $patientAppointmentRequestsData["patient_id"]==$value["patient_id"] && isset($patientAppointmentRequestsData["appointment_type"]) && $patientAppointmentRequestsData["appointment_type"]==2 && isset($patientAppointmentRequestsData["is_completed"]) && $patientAppointmentRequestsData["is_completed"]==0 ? $patientAppointmentRequestsData["patient_appointment_request_id"] : "";
			
			?>
			
			<span class="icon-box phn <?php echo $callColor; ?>" id="<?php echo $callID; ?>" data-toggle="modal" data-target="<?php echo !empty($callID) ? "#ph-off-request" : ""; ?>"></span>
			
			<span class="icon-box office <?php echo $visitColor; ?> ml-1" id="<?php echo $visitID; ?>" data-toggle="modal" data-target="<?php echo !empty($visitID) ? "#ph-off-request" : ""; ?>"></span>
		</section>
		
		
		<?php
		if(isset($value["patient_data"]) && !empty($value["patient_data"]))
		{
			$patientVitalData = json_decode($value["patient_data"],true);
			//echo "<pre>"; print_r($patientVitalData);die;
		}
		?>
		<section class="health-rate">
			<div class="info-panel h-rate">
				<?php
				$checkPulseKey = isset($patientVitalData["vital_id"]) && in_array(3,$patientVitalData["vital_id"]) ? array_search(3,$patientVitalData["vital_id"]) : "";
				$checkPulseValue = $patientVitalData["vital_value"][$checkPulseKey];
				$checkPulseValueType = $patientVitalData["vital_value_type"][$checkPulseKey];
				?>
				<span class="icon-box heart-rate <?php echo ($checkPulseValueType==1) ? "green-cat" : (($checkPulseValueType==2) ? "orange-cat" : (($checkPulseValueType==3) ? "red-cat" : "grey-cat")); ?> "></span>
				<span class="values"><?php echo isset($checkPulseValue) && !empty($checkPulseValue) ? $checkPulseValue : ""; ?></span>
			</div>
			
			<div class="info-panel bp-rate">
				<?php
				$checkBpSysKey = isset($patientVitalData["vital_id"]) && in_array(1,$patientVitalData["vital_id"]) ? array_search(1,$patientVitalData["vital_id"]) : "";
				$checkBpSysValue = $patientVitalData["vital_value"][$checkBpSysKey];
				$checkBpSysValueType = $patientVitalData["vital_value_type"][$checkBpSysKey];
				
				$checkBpDiaKey = isset($patientVitalData["vital_id"]) && in_array(2,$patientVitalData["vital_id"]) ? array_search(2,$patientVitalData["vital_id"]) : "";
				$checkBpDiaValue = $patientVitalData["vital_value"][$checkBpDiaKey];
				$checkBpDiaValueType = $patientVitalData["vital_value_type"][$checkBpDiaKey];
				?>
				<span class="icon-box bp <?php echo ($checkBpSysValueType==1) ? "green-cat" : (($checkBpSysValueType==2) ? "orange-cat" : (($checkBpSysValueType==3) ? "red-cat" : "grey-cat")); ?> "></span>
				<span class="values"><?php echo isset($checkBpSysValue) && !empty($checkBpSysValue) ? $checkBpSysValue."/" : ""; ?><?php echo isset($checkBpDiaValue) && !empty($checkBpDiaValue) ? $checkBpDiaValue : ""; ?></span>
			</div>
			
			<div class="info-panel glucose-rate">
				<?php
				$checkGlucoseKey = isset($patientVitalData["vital_id"]) && in_array(6,$patientVitalData["vital_id"]) ? array_search(6,$patientVitalData["vital_id"]) : "";
				$checkGlucoseValue = $patientVitalData["vital_value"][$checkGlucoseKey];
				$checkGlucoseValueType = $patientVitalData["vital_value_type"][$checkGlucoseKey];
				?>
				<span class="icon-box glucose <?php echo ($checkGlucoseValueType==1) ? "green-cat" : (($checkGlucoseValueType==2) ? "orange-cat" : (($checkGlucoseValueType==3) ? "red-cat" : "grey-cat")); ?> "></span>
				<span class="values"><?php echo isset($checkGlucoseValue) && !empty($checkGlucoseValue) ? $checkGlucoseValue : ""; ?></span>
			</div>
			
			<div class="info-panel cholesterol-rate">
				<?php
				$checkSpo2Key = isset($patientVitalData["vital_id"]) && in_array(5,$patientVitalData["vital_id"]) ? array_search(5,$patientVitalData["vital_id"]) : "";
				$checkSpo2Value = $patientVitalData["vital_value"][$checkSpo2Key];
				$checkSpo2ValueType = $patientVitalData["vital_value_type"][$checkSpo2Key];
				?>
				<span class="icon-box cholesterol <?php echo ($checkSpo2ValueType==1) ? "green-cat" : (($checkSpo2ValueType==2) ? "orange-cat" : (($checkSpo2ValueType==3) ? "red-cat" : "grey-cat")); ?> "></span>
				<span class="values"><?php echo isset($checkSpo2Value) && !empty($checkSpo2Value) ? $checkSpo2Value."%" : ""; ?></span>
			</div>
			
			<div class="info-panel weight-rate">
				<?php
				$checkWeightKey = isset($patientVitalData["vital_id"]) && in_array(4,$patientVitalData["vital_id"]) ? array_search(4,$patientVitalData["vital_id"]) : "";
				$checkWeightValue = $patientVitalData["vital_value"][$checkWeightKey];
				$checkWeightValueType = $patientVitalData["vital_value_type"][$checkWeightKey];
				?>
				<span class="icon-box weight <?php echo ($checkWeightValueType==1) ? "green-cat" : (($checkWeightValueType==2) ? "orange-cat" : (($checkWeightValueType==3) ? "red-cat" : "grey-cat")); ?> "></span>
				<span class="values"><?php echo isset($checkWeightValue) && !empty($checkWeightValue) ? $checkWeightValue : ""; ?></span>
			</div>
		</section>
		<section class="days-distance">
			<div class="info-panel calender-rate">
				<?php
				$now = time(); // or your date as well
				$startingDate = strtotime($value["monitoring_start"]);
				$endingDate = strtotime($value["monitoring_end"]);
				if($endingDate < $now)
				{
					$dateDiff = $endingDate - $startingDate;
				}
				else
				{
					$dateDiff = $now - $startingDate;
				}
				?>
				<span class="icon-box calender grey-cat"></span>
				<span class="values"><?php echo round($dateDiff / (60 * 60 * 24)) > 1 ? round($dateDiff / (60 * 60 * 24))." Days" : round($dateDiff / (60 * 60 * 24))." Day"; ?></span>
			</div>
			<?php
			$percentage = isset($patientVitalData["vitalIDTotal"]) ? number_format(($patientVitalData["vitalIDTotal"]*100)/(round($dateDiff / (60 * 60 * 24))*$value["measure_frequency_total"]), 2) : "";
			?>
			<div class="info-panel cheack-list-rate">
				<span class="icon-box cheack-list <?php echo ($percentage>66) ? "green-cat" : (($percentage>33) ? "orange-cat" : (($percentage>1) ? "red-cat" : "grey-cat")); ?> "></span>
				<span class="values"><?php echo ($percentage>100) ? "100%" : ((!empty($percentage)) ? $percentage."%" : ""); ?></span>
			</div>
			<div class="info-panel calender-rate">
				<?php
				$vitalIDTotal = isset($patientVitalData["vitalIDTotal"]) ? $patientVitalData["vitalIDTotal"] : 0;
				?>
				<span class="icon-box calender <?php echo ($percentage>66) ? "green-cat" : (($percentage>33) ? "orange-cat" : (($percentage>1) ? "red-cat" : "grey-cat")); ?> "></span>
				<span class="values"><?php echo $vitalIDTotal." of ". round($dateDiff / (60 * 60 * 24))*$value["measure_frequency_total"]; ?></span>
			</div>
			<div class="info-panel notifications ">
				<span class="icon-box notify grey-cat" data-toggle="modal" data-target="#notify"></span>
			</div>
		</section>
		<section class="right-side">
			<section class="office-visit red-cat">
				<h2 class="patientNotes_<?php echo $value["patient_id"]; ?>"><?php echo !empty($value["notes"]) ? $value["notes"] : "No notes added"; ?></h2>
				<section class="value-assign">
					<?php
					$startingDate = strtotime($value["monitoring_start"]);
					$endingDate = strtotime($value["monitoring_end"]);
					$checkDiff = $endingDate - $startingDate;
					?>
					<input type="text" class="patientPlaceholder_<?php echo $value["patient_id"]; ?>" placeholder="<?php echo !empty($value["doctorName"]) ? $value["doctorName"] : "No Provider Assign"; ?>" name="number">
					<span class="text float-left w-100"><?php echo date("d/m/Y",$endingDate); ?> (<?php echo round($checkDiff / (60 * 60 * 24)); ?>)</span>
				</section>
			</section>
			<section class="tog-btn-panel">
				<a href="#" class="tog-btn modalButton" id="<?php echo $value["patient_id"]; ?>" data-toggle="modal" data-target="#myModal"><img src="<?php echo IMAGE_PATH."tog-icn.png"; ?>" alt="tog-icn"></a>
				<span class="timming">00:00</span>
			</section>
		</section>
	</section>
</section>
<?php } }
else { ?>
<section class="row mx-0 mb-3">
	<section class="bio-info float-left w-100 bg-white p-2 list">
		<section class="profile-bio">
			<?php echo "No Data Found"; ?>
		</section>
	</section>
</section>
<?php } ?>

<div class="modal notes" id="myModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title text-uppercase">Add Notes</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
  
			<!-- Modal body -->
			<form id="additionalData">
			<div class="modal-body">
				<ul class="form-list">
					<input type="hidden" name="patient_id" class="patient_id">
					<li class="mb-4">
						<label>Patient Notes</label>
						<textarea placeholder="Notes" name="notes" class="addNotes"></textarea>
					</li>
					<li>
						<input type="checkbox" id="reminder" >
						<label class="check">Add Reminder</label class="check">
					</li>
					<li class="mb-4 reminder-form">
						<!--<label>Frequency</label>
						<select class="mb-3">
							<option>One Time</option>
							<option>Every day</option>
							<option>Once a week</option>
							<option>Every Week</option>
							<option>Every month</option>
						 </select>-->
						<section class="row">
							<div class="col-md-6">
								<form action="/action_page.php">
									<span class="date-pick"><input type="date" name="reminder_date" placeholder="Date" name="bday"></span>
								</form>
							</div>
							<div class="col-md-6">
								<input type="time" name="reminder_time" placeholder="Time" value="12:00">
							</div>
							<div class="col-md-12">
								<textarea class="mt-3" name="reminder_notes" placeholder="Reminder Notes"></textarea>
							</div>
						</section>
					</li>
					<li class="mb-4">
						<label>Add Extra Time</label>
						<select name="time_spent" class="w-auto">
							<option value="">Min</option>
							<?php for($i=1; $i<=30; $i++) { ?>
								<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
							<?php } ?>
						</select>
					</li>
					<li>
						<input type="checkbox" id="provider">
						<label class="check">Assign To Provider</label>
					</li>
					<li class="mb-2 provider-form">
						<select name="doctor_id" class="doctor">
							<option value="">Choose Doctor</option>
							<?php
							if(isset($doctorsData) && !empty(doctorsData)) {
							foreach($doctorsData as $doctorKey => $doctorValue) { ?>
								<option value="<?php echo $doctorValue["hospital_user_id"]; ?>"><?php echo $doctorValue["name"]; ?></option>
							<?php } } ?>
						</select>
					</li>
					<li>
						<input type="button" value="Save" class="save btn btn-primary">
					</li>
				</ul>
			</div>
			</form>
			
		</div>
	</div>
</div>