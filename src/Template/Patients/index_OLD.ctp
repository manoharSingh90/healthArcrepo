<body class="add-p">
<!-- HEADER -->
<?php echo $this->element("header"); ?>
<!-- HEADER -->
		
<section class="data-details">
	<!-- LEFT PANEL -->
	<?php echo $this->element("left_panel"); ?>
	<!-- LEFT PANEL -->
			
	<div class="right-cont">
		<div class="click"><span><img src="<?php echo IMAGE_PATH."toggle.png"; ?>"></span></div>
		<ul class="breadcrumb">
			<li><a href="javaScript:void(0)">Patient Dashboard</a></li>
			<li class="active"><a href="javaScript:void(0)"> <?php echo isset($patientData["patient_id"]) && !empty($patientData["patient_id"]) ? "Edit" : "Add"; ?> Patient</a></li>
		</ul>  
				
		<section class="add-patient-panel mb-4">
		
		<form method="post" action="<?php echo $this->Url->build(["controller"=>"Patients","action"=>"save"]); ?>" enctype="multipart/form-data">
		
			<section class="patient-info info lightblue-bg mb-2 float-left w-100 p-4">
			
			<input type="hidden" name="patient_id" value="<?php echo isset($patientData["patient_id"]) && !empty($patientData["patient_id"]) ? $patientData["patient_id"] : ""; ?>" >
			
				<h3>Patient Info</h3>
				<section class="form-control-row float-left w-100 mb-3">
					<section class="half-width">
						<section class="items float-none d-inline-block align-middle">
							<label class="mr-2">MRN#<span class="starClass"> *</span></label>
							<input autocomplete="off" type="text" name="mrn_no" maxlength="64" class="mrnNo" value="<?php echo isset($patientData["mrn_no"]) && !empty($patientData["mrn_no"]) ? $patientData["mrn_no"] : ""; ?>" >
							<span class="errorClass mrnNoErrorClass">Field Required</span>
						</section>
					</section>
				</section>

				<section class="form-control-row name-info float-left w-100 mb-3">
					<section class="half-width">
						<section class="items float-none d-inline-block align-top mb-2">
							<label class="mr-2">First Name<span class="starClass"> *</span></label>
							<input autocomplete="off" type="text" name="fname" maxlength="64" class="mr-2 fname" value="<?php echo isset($patientData["fname"]) && !empty($patientData["fname"]) ? $patientData["fname"] : ""; ?>" >
							<span class="errorClass fnameErrorClass">Field Required</span>
						</section>

						<section class="items float-none d-inline-block align-top mb-2">
							<label class="mr-2">Middle Name</label>
							<input autocomplete="off" type="text" name="mname" maxlength="64" class="mr-2 mname" value="<?php echo isset($patientData["mname"]) && !empty($patientData["mname"]) ? $patientData["mname"] : ""; ?>" >
						</section>
						<section class="items float-none d-inline-block align-top mb-2">
							<label class="mr-2">Last Name<span class="starClass"> *</span></label>
							<input autocomplete="off" type="text" name="lname" maxlength="64" class="mr-2 lname" value="<?php echo isset($patientData["lname"]) && !empty($patientData["lname"]) ? $patientData["lname"] : ""; ?>" >
							<span class="errorClass lnameErrorClass">Field Required</span>
						</section>
						<!--<section class="items float-none d-inline-block align-middle mb-2">
							<label class="mr-2">Date of Birth</label>
							<input type="text" name="midname" class="mr-2">
						</section>-->
					</section>
				</section>
				
				<?php $dob = isset($patientData["dob"]) && !empty($patientData["dob"]) ? explode("/",date("d/m/Y",strtotime($patientData["dob"]))) : ""; ?>
				<section class="form-control-row float-left w-100 mb-3">
					<section class="half-width">
						<section class="items float-none d-inline-block align-middle mb-2">
							<label class="mr-2">Date of Birth<span class="starClass"> *</span></label>
							<!--<input autocomplete="off" type="date" name="dob" placeholder="MM/DD/YYYY" class="mr-2 dob">-->
							<input autocomplete="off" type="text" id="birthdateval" style="cursor:pointer;" class="mr-2 dob" name="dob" value="<?php echo !empty($dob) ? $dob[0]."/".$dob[1]."/".$dob[2] : ""; ?>" placeholder="DD/MM/YYYY"/>
							<span class="errorClass dobErrorClass"></span>
						</section>
						
						<section class="items float-none d-inline-block align-middle mb-2">
							<label class="mr-2">Gender<span class="starClass"> *</span></label>
							<label class="float-none d-inlin-block aligm-middle w-auto">
								<input type="radio" name="gender" value="1" <?php echo (isset($patientData["gender"]) && $patientData["gender"]=="1") ? "checked" : ((!isset($patientData["gender"])) ? "checked" : ""); ?> > Male <span class="radiobtn"></span>
							</label>
							<label class="float-none d-inlin-block aligm-middle w-auto ml-3">
								<input type="radio" name="gender" value="2" <?php echo isset($patientData["gender"]) && $patientData["gender"]=="2" ? "checked" : ""; ?> > Female <span class="radiobtn"></span>
							</label>
						</section>
					</section>
				</section>

				<section class="form-control-row float-left w-100">
					<section class="half-width">
						<section class="items float-none d-inline-block align-middle">
							<label class="mr-2">Email<span class="starClass"> *</span></label>
							<input autocomplete="off" type="email" name="email" maxlength="128" class="mr-2 <?php echo isset($patientData["patient_id"]) && !empty($patientData["patient_id"]) ? "" : "email"; ?>" value="<?php echo isset($patientData["email"]) && !empty($patientData["email"]) ? $patientData["email"] : ""; ?>" <?php echo isset($patientData["patient_id"]) && !empty($patientData["patient_id"]) ? "readonly" : ""; ?> style="background-color:<?php echo isset($patientData["patient_id"]) && !empty($patientData["patient_id"]) ? "#d2d2d2" : ""; ?>" >
							<span class="errorClass emailErrorClass">Field Required</span>
						</section>
						<section class="items float-none d-inline-block align-middle">
							<label class="mr-2">Mobile<span class="starClass"> *</span></label>
							
							<input autocomplete="off" type="tel" name="mobile" maxlength="10" class="mr-2 <?php echo isset($patientData["patient_id"]) && !empty($patientData["patient_id"]) ? "" : "mobile"; ?>" value="<?php echo isset($patientData["mobile"]) && !empty($patientData["mobile"]) ? $patientData["mobile"] : ""; ?>" <?php echo isset($patientData["patient_id"]) && !empty($patientData["patient_id"]) ? "readonly" : ""; ?> style="width:60% !important; background-color:<?php echo isset($patientData["patient_id"]) && !empty($patientData["patient_id"]) ? "#d2d2d2" : ""; ?>" >
							
							<?php
							if(isset($patientData["mobile_code"]) && !empty($patientData["mobile_code"])) {
							?>
							<select class="col-md-4 mr-2 float-left" name="mobile_code">
								<option value="<?php echo isset($patientData["mobile_code"]) ? $patientData["mobile_code"] : ""; ?>" ><?php echo isset($patientData["mobile_code"]) ? $patientData["mobile_code"] : ""; ?></option>
							</select>
							<?php }
							else { ?>
							<select class="col-md-4 mr-2 float-left" name="mobile_code">
								<option value="+1" >+1</option>
								<option value="+91" >+91</option>
							</select>
							<?php } ?>
							
							<span class="errorClass mobileErrorClass">Field Required</span>
						</section>
					</section>
				</section>
			</section>

			<section class=" patient-info patient-health lightblue-bg mb-2 float-left w-100 p-4">
				<h3>Patient Health Info</h3>
				<section class="form-control-row float-left w-100">
					<h4>Chronic Conditions:</h4>
					<?php
					if(isset($conditionsData) && !empty($conditionsData)) {
					foreach($conditionsData as $key => $value) { ?>
					<section class="items float-none d-inline-block align-middle">
						<input type="checkbox" name="condition_id[]" class="condition" value="<?php echo $value["condition_id"]; ?>" <?php echo isset($savedConditions) && in_array($value["condition_id"],$savedConditions) ? "checked" : ""; ?> ><label class="mr-3 ml-2"><?php echo $value["condition_name"]; ?></label>
					</section>
					<?php } } ?>
				</section>
				<span class="errorClass conditionErrorClass">Field Required</span>
				
				<section class="form-control-row float-left w-100 mt-3">
					<?php
					if(isset($vitalsData) && !empty($vitalsData)) {
					foreach($vitalsData as $key => $value) { ?>
					<section class="items float-none d-inline-block align-middle btnbox">
						<a href="javascript:void(0);" id="<?php echo $value["vital_id"]; ?>" class="btn btn-primary moniter-btn vital_id vital_id_<?php echo $value["vital_id"]; ?> <?php echo isset($savedVitals) && in_array($value["vital_id"],$savedVitals) ? "active" : ""; ?> ">Add <?php echo $value["vital_name"]; ?></a>
						
						<?php if(isset($savedVitals) && in_array($value["vital_id"],$savedVitals)) { ?>
						<input type="hidden" name="vital_id[]" class="vitalIDText vitalIDText_<?php echo $value["vital_id"]; ?>" value="<?php echo $value["vital_id"]; ?>" >
						<?php }
						else { ?>
						<input type="hidden" name="vital_id[]" class="vitalIDText vitalIDText_<?php echo $value["vital_id"]; ?>">
						<?php } ?>
						
					</section>
					<?php } } ?>
				</section>
				<span class="errorClass vitalErrorClass">Field Required</span>
				
				<!-- BLOOD PRESSURE DIV -->
				<?php
				$bpKey = isset($patientData["patientvitalsettings"]) ? array_column($patientData["patientvitalsettings"],"vital_id") : "";
				$bpKeyFinal = isset($bpKey) && !empty($bpKey) ? array_keys($bpKey,1) : ""; ?>
				<section class="form-extend chf mt-4 float-left w-100 <?php echo isset($savedVitals) && in_array(1,$savedVitals) ? "active" : ""; ?> ">
					<section class="form-control-row float-left w-100">
						<h4>Blood Pressure</h4>
						<section class="items float-none d-inline-block align-middle">
							<label class="mr-2"><b>Normal</b></label>
						</section>
						<section class="items float-none d-inline-block align-middle">
							<label class="mr-2">Systolic</label>
							<input autocomplete="off" type="text" placeholder="Min." class="mr-3 value-text bpNormalMinSystolic_1" name="bp_normal_min[]" value="<?php echo !empty($bpKeyFinal) ? $patientData["patientvitalsettings"][0]["normal_min"] : ""; ?>" >
							<input autocomplete="off" type="text" placeholder="Max." class="mr-4 value-text bpNormalMaxSystolic_1" name="bp_normal_max[]" value="<?php echo !empty($bpKeyFinal) ? $patientData["patientvitalsettings"][0]["normal_max"] : ""; ?>" >
						</section>
						<section class="items float-none d-inline-block align-middle">
							<label class="mr-2">Diastolic</label>
							<input autocomplete="off" type="text" placeholder="Min." class="mr-3 value-text bpNormalMinDiastolic_1" name="bp_normal_min[]" value="<?php echo !empty($bpKeyFinal) ? $patientData["patientvitalsettings"][1]["normal_min"] : ""; ?>" >
							<input autocomplete="off" type="text" placeholder="Max." class="mr-4 value-text bpNormalMaxDiastolic_1" name="bp_normal_max[]" value="<?php echo !empty($bpKeyFinal) ? $patientData["patientvitalsettings"][1]["normal_max"] : ""; ?>" >
						</section>
						<section class="items float-none d-inline-block align-middle">
							<input type="checkbox" name="template" class="templateData" id="1">
							<label class="float-none d-inline-block w-auto align-middle">Standard template</label>
						</section>
					</section>

					<section class="form-control-row float-left w-100 mt-3">
						<textarea placeholder="Intervention Notes" name="bp_intervention_notes" class="interventionNotes_1"><?php echo !empty($bpKeyFinal) ? $patientData["patientvitalsettings"][0]["intervention_notes"] : ""; ?></textarea>
					</section>
					
					<section class="form-control-row float-left w-100 mt-3">
						<section class="items float-none d-inline-block align-middle">
							<label class="mt-3 mr-4"><b>Warning</b></label>
						</section>
						<section class="items float-none d-inline-block align-middle">
							<div class="w-100">
								<span class="lessThan pl-4 mr-2">Less then</span>
								<span class="mr-2">More then</span>
							</div>
							<label class="mr-2">Systolic</label>
							<input autocomplete="off" type="text" placeholder="Min." class="mr-3 value-text bpWarningMinSystolic_1" name="bp_warning_min[]" value="<?php echo !empty($bpKeyFinal) ? $patientData["patientvitalsettings"][0]["warning_min"] : ""; ?>" >
							<input autocomplete="off" type="text" placeholder="Max." class="mr-4 value-text bpWarningMaxSystolic_1" name="bp_warning_max[]" value="<?php echo !empty($bpKeyFinal) ? $patientData["patientvitalsettings"][0]["warning_max"] : ""; ?>" >
						</section>
						<section class="items float-none d-inline-block align-middle">
							<div class="w-100">
								<span class="lessThan pl-4 mr-2">Less then</span>
								<span class="mr-2">More then</span>
							</div>
							<label class="mr-2">Diastolic</label>
							<input autocomplete="off" type="text" placeholder="Min." class="mr-3 value-text bpWarningMinDiastolic_1" name="bp_warning_min[]" value="<?php echo !empty($bpKeyFinal) ? $patientData["patientvitalsettings"][1]["warning_min"] : ""; ?>" >
							<input autocomplete="off" type="text" placeholder="Max." class="mr-4 value-text bpWarningMaxDiastolic_1" name="bp_warning_max[]" value="<?php echo !empty($bpKeyFinal) ? $patientData["patientvitalsettings"][1]["warning_max"] : ""; ?>" >
						</section>
					</section>
					
					<section class="form-control-row float-left w-100 mt-3">
						<section class="items float-none d-inline-block align-middle">
							<label class="mr-2"><b>Emergency</b></label>
						</section>
						<section class="items float-none d-inline-block align-middle">
							<label class="mr-2">Systolic</label>
							<input autocomplete="off" type="text" placeholder="Min." class="mr-3 value-text bpEmergencyMinSystolic_1" name="bp_emergency_min[]" value="<?php echo !empty($bpKeyFinal) ? $patientData["patientvitalsettings"][0]["emergency_min"] : ""; ?>" >
							<input autocomplete="off" type="text" placeholder="Max." class="mr-4 value-text bpEmergencyMaxSystolic_1" name="bp_emergency_max[]" value="<?php echo !empty($bpKeyFinal) ? $patientData["patientvitalsettings"][0]["emergency_max"] : ""; ?>" >
						</section>
						<section class="items float-none d-inline-block align-middle">
							<label class="mr-2">Diastolic</label>
							<input autocomplete="off" type="text" placeholder="Min." class="mr-3 value-text bpEmergencyMinDiastolic_1" name="bp_emergency_min[]" value="<?php echo !empty($bpKeyFinal) ? $patientData["patientvitalsettings"][1]["emergency_min"] : ""; ?>" >
							<input autocomplete="off" type="text" placeholder="Max." class="mr-4 value-text bpEmergencyMaxDiastolic_1" name="bp_emergency_max[]" value="<?php echo !empty($bpKeyFinal) ? $patientData["patientvitalsettings"][1]["emergency_max"] : ""; ?>" >
						</section>
					</section>

					<section class="form-control-row float-left w-100 mt-3">
						<label>Frequency</label>
						<select name="bp_measure_frequency">
							<option value="">Select</option>
							<option value="1" <?php echo isset($patientData["patientvitalsettings"]) && $patientData["patientvitalsettings"][0]["measure_frequency"]==1 ? "selected" : ""; ?> >1 times a day</option>
							<option value="2" <?php echo isset($patientData["patientvitalsettings"]) && $patientData["patientvitalsettings"][0]["measure_frequency"]==2 ? "selected" : ""; ?> >2 times a day</option>
							<option value="3" <?php echo isset($patientData["patientvitalsettings"]) && $patientData["patientvitalsettings"][0]["measure_frequency"]==3 ? "selected" : ""; ?> >3 times a day</option>
						</select>
					</section>
				</section>
				<!-- BLOOD PRESSURE DIV -->
				
				<!-- PULSE DIV -->
				<?php $pulseKey = isset($savedVitals) && !empty($savedVitals) && in_array(2,$savedVitals) ? array_search(2,$savedVitals) : ""; ?>
				<section class="form-extend astma mt-4 float-left w-100 <?php echo isset($savedVitals) && in_array(2,$savedVitals) ? "active" : ""; ?> ">
					<section class="form-control-row float-left w-100">
						<h4>PULSE</h4>
						<label class="mr-2">Normal</label>
						<input autocomplete="off" type="text" placeholder="Min." class="mr-3 value-text normalMin_2" name="pulse_normal_min" value="<?php echo isset($patientData["patientvitalsettings"]) ? $patientData["patientvitalsettings"][$pulseKey]["normal_min"] : ""; ?>" >
						<input autocomplete="off" type="text" placeholder="Max." class="mr-4 value-text normalMax_2" name="pulse_normal_max" value="<?php echo isset($patientData["patientvitalsettings"]) ? $patientData["patientvitalsettings"][$pulseKey]["normal_max"] : ""; ?>" >

						<input type="checkbox" name="template" class="templateData" id="2">
						<label>Standard template</label>
					</section>

					<section class="form-control-row float-left w-100 mt-3">
						<textarea placeholder="Intervention Notes" name="pulse_intervention_notes" class="interventionNotes_2"><?php echo isset($patientData["patientvitalsettings"]) ? $patientData["patientvitalsettings"][$pulseKey]["intervention_notes"] : ""; ?></textarea>
					</section>
					
					<section class="form-control-row float-left w-100 mt-3">
						<label class="mr-4">Warning</label>
						<input autocomplete="off" type="text" placeholder="Min." class="mr-3 value-text warningMin_2" name="pulse_warning_min" value="<?php echo isset($patientData["patientvitalsettings"]) ? $patientData["patientvitalsettings"][$pulseKey]["warning_min"] : ""; ?>" >
						<input autocomplete="off" type="text" placeholder="Max." class="mr-4 value-text warningMax_2" name="pulse_warning_max" value="<?php echo isset($patientData["patientvitalsettings"]) ? $patientData["patientvitalsettings"][$pulseKey]["warning_max"] : ""; ?>" >
					</section>
					
					<section class="form-control-row float-left w-100 mt-3">
						<label class="mr-2">Emergency</label>
						<input autocomplete="off" type="text" placeholder="Min." class="mr-3 value-text emergencyMin_2" name="pulse_emergency_min" value="<?php echo isset($patientData["patientvitalsettings"]) ? $patientData["patientvitalsettings"][$pulseKey]["emergency_min"] : ""; ?>" >
						<input autocomplete="off" type="text" placeholder="Max." class="mr-4 value-text emergencyMax_2" name="pulse_emergency_max" value="<?php echo isset($patientData["patientvitalsettings"]) ? $patientData["patientvitalsettings"][$pulseKey]["emergency_max"] : ""; ?>" >
					</section>

					<section class="form-control-row float-left w-100 mt-3">
						<label>Frequency</label>
						<select name="pulse_measure_frequency">
							<option value="">Select</option>
							<option value="1" <?php echo isset($patientData["patientvitalsettings"]) && $patientData["patientvitalsettings"][$pulseKey]["measure_frequency"]==1 ? "selected" : ""; ?> >1 times a day</option>
							<option value="2" <?php echo isset($patientData["patientvitalsettings"]) && $patientData["patientvitalsettings"][$pulseKey]["measure_frequency"]==2 ? "selected" : ""; ?> >2 times a day</option>
							<option value="3" <?php echo isset($patientData["patientvitalsettings"]) && $patientData["patientvitalsettings"][$pulseKey]["measure_frequency"]==3 ? "selected" : ""; ?> >3 times a day</option>
						</select>
					</section>
				</section>
				<!-- PULSE DIV -->
				
				<!-- WEIGHT DIV -->
				<?php $weightKey = isset($savedVitals) && !empty($savedVitals) && in_array(3,$savedVitals) ? array_search(3,$savedVitals) : ""; ?>
				<section class="form-extend diabetes mt-4 float-left w-100 <?php echo isset($savedVitals) && in_array(3,$savedVitals) ? "active" : ""; ?> ">
					<section class="form-control-row float-left w-100">
						<h4>WEIGHT</h4>
						<label class="mr-2">Normal</label>
						<input autocomplete="off" type="text" placeholder="Min." class="mr-3 value-text normalMin_3" name="weight_normal_min" value="<?php echo isset($patientData["patientvitalsettings"]) ? $patientData["patientvitalsettings"][$weightKey]["normal_min"] : ""; ?>" >
						<input autocomplete="off" type="text" placeholder="Max." class="mr-4 value-text normalMax_3" name="weight_normal_max" value="<?php echo isset($patientData["patientvitalsettings"]) ? $patientData["patientvitalsettings"][$weightKey]["normal_max"] : ""; ?>" >

						<input type="checkbox" name="template" class="templateData" id="3">
						<label>Standard template</label>
					</section>

					<section class="form-control-row float-left w-100 mt-3">
						<textarea placeholder="Intervention Notes" name="weight_intervention_notes" class="interventionNotes_3"><?php echo isset($patientData["patientvitalsettings"]) ? $patientData["patientvitalsettings"][$weightKey]["intervention_notes"] : ""; ?></textarea>
					</section>
					
					<section class="form-control-row float-left w-100 mt-3">
						<label class="mr-4">Warning</label>
						<input autocomplete="off" type="text" placeholder="Min." class="mr-3 value-text warningMin_3" name="weight_warning_min" value="<?php echo isset($patientData["patientvitalsettings"]) ? $patientData["patientvitalsettings"][$weightKey]["warning_min"] : ""; ?>" >
						<input autocomplete="off" type="text" placeholder="Max." class="mr-4 value-text warningMax_3" name="weight_warning_max" value="<?php echo isset($patientData["patientvitalsettings"]) ? $patientData["patientvitalsettings"][$weightKey]["warning_max"] : ""; ?>" >
					</section>
					
					<section class="form-control-row float-left w-100 mt-3">
						<label class="mr-2">Emergency</label>
						<input autocomplete="off" type="text" placeholder="Min." class="mr-3 value-text emergencyMin_3" name="weight_emergency_min" value="<?php echo isset($patientData["patientvitalsettings"]) ? $patientData["patientvitalsettings"][$weightKey]["emergency_min"] : ""; ?>" >
						<input autocomplete="off" type="text" placeholder="Max." class="mr-4 value-text emergencyMax_3" name="weight_emergency_max" value="<?php echo isset($patientData["patientvitalsettings"]) ? $patientData["patientvitalsettings"][$weightKey]["emergency_max"] : ""; ?>" >
					</section>

					<section class="form-control-row float-left w-100 mt-3">
						<label>Frequency</label>
						<select name="weight_measure_frequency">
							<option value="">Select</option>
							<option value="1" <?php echo isset($patientData["patientvitalsettings"]) && $patientData["patientvitalsettings"][$weightKey]["measure_frequency"]==1 ? "selected" : ""; ?> >1 times a day</option>
							<option value="2" <?php echo isset($patientData["patientvitalsettings"]) && $patientData["patientvitalsettings"][$weightKey]["measure_frequency"]==2 ? "selected" : ""; ?> >2 times a day</option>
							<option value="3" <?php echo isset($patientData["patientvitalsettings"]) && $patientData["patientvitalsettings"][$weightKey]["measure_frequency"]==3 ? "selected" : ""; ?> >3 times a day</option>
						</select>
					</section>
				</section>
				<!-- WEIGHT DIV -->
				
				<!-- SPO2 DIV -->
				<?php $spoKey = isset($savedVitals) && !empty($savedVitals) && in_array(4,$savedVitals) ? array_search(4,$savedVitals) : ""; ?>
				<section class="form-extend hypertension mt-4 float-left w-100 <?php echo isset($savedVitals) && in_array(4,$savedVitals) ? "active" : ""; ?> ">
					<section class="form-control-row float-left w-100">
						<h4>SPO2</h4>
						<label class="mr-2">Normal</label>
						<input autocomplete="off" type="text" placeholder="Min." class="mr-3 value-text normalMin_4" name="spo_normal_min" value="<?php echo isset($patientData["patientvitalsettings"]) ? $patientData["patientvitalsettings"][$spoKey]["normal_min"] : ""; ?>" >
						<input autocomplete="off" type="text" placeholder="Max." class="mr-4 value-text normalMax_4" name="spo_normal_max" value="<?php echo isset($patientData["patientvitalsettings"]) ? $patientData["patientvitalsettings"][$spoKey]["normal_max"] : ""; ?>" >

						<input type="checkbox" name="template" class="templateData" id="4">
						<label>Standard template</label>
					</section>

					<section class="form-control-row float-left w-100 mt-3">
						<textarea placeholder="Intervention Notes" name="spo_intervention_notes" class="interventionNotes_4"><?php echo isset($patientData["patientvitalsettings"]) ? $patientData["patientvitalsettings"][$spoKey]["intervention_notes"] : ""; ?></textarea>
					</section>
					
					<section class="form-control-row float-left w-100 mt-3">
						<label class="mr-4">Warning</label>
						<input autocomplete="off" type="text" placeholder="Min." class="mr-3 value-text warningMin_4" name="spo_warning_min" value="<?php echo isset($patientData["patientvitalsettings"]) ? $patientData["patientvitalsettings"][$spoKey]["warning_min"] : ""; ?>" >
						<input autocomplete="off" type="text" placeholder="Max." class="mr-4 value-text warningMax_4" name="spo_warning_max" value="<?php echo isset($patientData["patientvitalsettings"]) ? $patientData["patientvitalsettings"][$spoKey]["warning_max"] : ""; ?>" >
					</section>
					
					<section class="form-control-row float-left w-100 mt-3">
						<label class="mr-2">Emergency</label>
						<input autocomplete="off" type="text" placeholder="Min." class="mr-3 value-text emergencyMin_4" name="spo_emergency_min" value="<?php echo isset($patientData["patientvitalsettings"]) ? $patientData["patientvitalsettings"][$spoKey]["emergency_min"] : ""; ?>" >
						<input autocomplete="off" type="text" placeholder="Max." class="mr-4 value-text emergencyMax_4" name="spo_emergency_max" value="<?php echo isset($patientData["patientvitalsettings"]) ? $patientData["patientvitalsettings"][$spoKey]["emergency_max"] : ""; ?>" >
					</section>

					<section class="form-control-row float-left w-100 mt-3">
						<label>Frequency</label>
						<select name="spo_measure_frequency">
							<option value="">Select</option>
							<option value="1" <?php echo isset($patientData["patientvitalsettings"]) && $patientData["patientvitalsettings"][$spoKey]["measure_frequency"]==1 ? "selected" : ""; ?> >1 times a day</option>
							<option value="2" <?php echo isset($patientData["patientvitalsettings"]) && $patientData["patientvitalsettings"][$spoKey]["measure_frequency"]==2 ? "selected" : ""; ?> >2 times a day</option>
							<option value="3" <?php echo isset($patientData["patientvitalsettings"]) && $patientData["patientvitalsettings"][$spoKey]["measure_frequency"]==3 ? "selected" : ""; ?> >3 times a day</option>
						</select>
					</section>
				</section>
				<!-- SPO2 DIV -->
				
				<!-- GLUCOSE DIV -->
				<?php $glucoseKey = isset($savedVitals) && !empty($savedVitals) && in_array(5,$savedVitals) ? array_search(5,$savedVitals) : ""; ?>
				<section class="form-extend glucos mt-4 float-left w-100 <?php echo isset($savedVitals) && in_array(5,$savedVitals) ? "active" : ""; ?> ">
					<section class="form-control-row float-left w-100">
						<h4>GLUCOSE</h4>
						<label class="mr-2">Normal</label>
						<input autocomplete="off" type="text" placeholder="Min." class="mr-3 value-text normalMin_5" name="glucose_normal_min" value="<?php echo isset($patientData["patientvitalsettings"]) ? $patientData["patientvitalsettings"][$glucoseKey]["normal_min"] : ""; ?>" >
						<input autocomplete="off" type="text" placeholder="Max." class="mr-4 value-text normalMax_5" name="glucose_normal_max" value="<?php echo isset($patientData["patientvitalsettings"]) ? $patientData["patientvitalsettings"][$glucoseKey]["normal_max"] : ""; ?>" >

						<input type="checkbox" name="template" class="templateData" id="5">
						<label>Standard template</label>
					</section>

					<section class="form-control-row float-left w-100 mt-3">
						<textarea placeholder="Intervention Notes" name="glucose_intervention_notes" class="interventionNotes_5"><?php echo isset($patientData["patientvitalsettings"]) ? $patientData["patientvitalsettings"][$glucoseKey]["intervention_notes"] : ""; ?></textarea>
					</section>
					
					<section class="form-control-row float-left w-100 mt-3">
						<label class="mr-4">Warning</label>
						<input autocomplete="off" type="text" placeholder="Min." class="mr-3 value-text warningMin_5" name="glucose_warning_min" value="<?php echo isset($patientData["patientvitalsettings"]) ? $patientData["patientvitalsettings"][$glucoseKey]["warning_min"] : ""; ?>" >
						<input autocomplete="off" type="text" placeholder="Max." class="mr-4 value-text warningMax_5" name="glucose_warning_max" value="<?php echo isset($patientData["patientvitalsettings"]) ? $patientData["patientvitalsettings"][$glucoseKey]["warning_max"] : ""; ?>" >
					</section>
					
					<section class="form-control-row float-left w-100 mt-3">
						<label class="mr-2">Emergency</label>
						<input autocomplete="off" type="text" placeholder="Min." class="mr-3 value-text emergencyMin_5" name="glucose_emergency_min" value="<?php echo isset($patientData["patientvitalsettings"]) ? $patientData["patientvitalsettings"][$glucoseKey]["emergency_min"] : ""; ?>" >
						<input autocomplete="off" type="text" placeholder="Max." class="mr-4 value-text emergencyMax_5" name="glucose_emergency_max" value="<?php echo isset($patientData["patientvitalsettings"]) ? $patientData["patientvitalsettings"][$glucoseKey]["emergency_max"] : ""; ?>" >
					</section>

					<section class="form-control-row float-left w-100 mt-3">
						<label>Frequency</label>
						<select name="glucose_measure_frequency">
							<option value="">Select</option>
							<option value="1" <?php echo isset($patientData["patientvitalsettings"]) && $patientData["patientvitalsettings"][$glucoseKey]["measure_frequency"]==1 ? "selected" : ""; ?> >1 times a day</option>
							<option value="2" <?php echo isset($patientData["patientvitalsettings"]) && $patientData["patientvitalsettings"][$glucoseKey]["measure_frequency"]==2 ? "selected" : ""; ?> >2 times a day</option>
							<option value="3" <?php echo isset($patientData["patientvitalsettings"]) && $patientData["patientvitalsettings"][$glucoseKey]["measure_frequency"]==3 ? "selected" : ""; ?> >3 times a day</option>
						</select>
					</section>
				</section>
				<!-- GLUCOSE DIV -->
				
				
				<?php
				$monitoringStart = isset($patientData["monitoring_start"]) && !empty($patientData["monitoring_start"]) ? date("Y-m-d", strtotime($patientData["monitoring_start"])) : "";
				$monitoringEnd = isset($patientData["monitoring_end"]) && !empty($patientData["monitoring_end"]) ? date("Y-m-d", strtotime($patientData["monitoring_end"])) : "";
				?>
				<section class="form-control-row float-left w-100 mt-3 monitoring" style="display:<?php echo isset($patientData["patient_id"]) && !empty($patientData["patient_id"]) ? "block" : "none"; ?>" >
					<section class="divider">
						<label class="mr-2">Monitoring start Date<span class="starClass"> *</span></label>
						<input type="date" name="monitoring_start" id="monitoring_start" class="mr-3 w-100" value="<?php echo !empty($monitoringStart) ? $monitoringStart : ""; ?>" >
						<span class="errorClass monitoringStartErrorClass">Field Required</span>
					</section>
					<section class="divider">
						<label class="mr-2">Monitoring End Date<span class="starClass"> *</span></label>
						<input type="date" name="monitoring_end" id="monitoring_end" class="mr-3 w-100" value="<?php echo !empty($monitoringEnd) ? $monitoringEnd : ""; ?>" >
						<span class="errorClass monitoringEndErrorClass ">Field Required</span>
					</section>
				</section>
			</section>
			
			<section class="patient-info patient-device lightblue-bg mb-2 float-left w-100 p-4">
				<h3>Provided Device<span class="starClass"> *</span></h3>
				<section class="half-width">
					<?php
					if(isset($deviceData) && !empty($deviceData)) {
					foreach($deviceData as $key => $value) { ?>
					<div class="items float-none d-inline-block align-bottom mr-3">
						<input type="checkbox" name="device_id[<?php echo $key; ?>]" value="<?php echo $value["device_id"]; ?>" class="deviceID" id="deviceID_<?php echo $value["device_id"]; ?>" <?php echo isset($savedDevices) && in_array($value["device_id"],$savedDevices) ? "checked" : ""; ?> >
						<label ><?php echo $value["device_model"]; ?></label>
						
						<?php $deviceKey = isset($savedDevices) && in_array($value["device_id"],$savedDevices) ? array_search($value["device_id"],$savedDevices) : ""; ?>
						<section class="form-extend serialNo_<?php echo $value["device_id"]; ?> <?php echo isset($savedDevices) && in_array($value["device_id"],$savedDevices) ? "active" : ""; ?> ">
							<input autocomplete="off" type="text" name="serial_no[<?php echo $key; ?>]" placeholder="Device Serial Number" value="<?php echo isset($serialNo) ? $serialNo[$deviceKey] : ""; ?>" >
						</section>
					</div>
					<?php } } ?>
				</section>
				<span class="errorClass deviceErrorClass">Field Required</span>
			</section>

			<section class=" patient-info patient-caregiver lightblue-bg mb-2 float-left w-100 p-4">
				<h3>Caregiver Info</h3>
				<?php
				$count = isset($patientData["patientcaregivers"]) && !empty($patientData["patientcaregivers"]) ? count($patientData["patientcaregivers"]) : "";
				if(isset($patientData["patientcaregivers"]) && !empty($patientData["patientcaregivers"])) {
				foreach($patientData["patientcaregivers"] as $key => $value) { ?>
				<input autocomplete="off" type="hidden" class="form-control" name="patient_caregiver_id[]" value="<?php echo $value["patient_caregiver_id"]; ?>" />
				<section class="<?php echo ($key+1)==$count ? "input_fields_wrap" : ""; ?> caregiverDiv caregiverDiv_<?php echo $key+1; ?>" >
					<section class="items float-none d-inline-block align-middle">
						<label>First Name<span class="starClass"><?php echo $key==0 ? " *" : "&nbsp;&nbsp;"; ?></span></label>
						<input autocomplete="off" type="text" placeholder="First Name" name="caregiver_fname[]" class="caregiverFname" value="<?php echo $value["fname"]; ?>" >
						<?php if($key==0) { ?>
							<span class="errorClass caregiverFnameErrorClass">Field Required</span>
						<?php } ?>
					</section>

					<section class="items float-none d-inline-block align-middle">
						<label>Last Name<span class="starClass"><?php echo $key==0 ? " *" : "&nbsp;&nbsp;"; ?></label>
						<input autocomplete="off" type="text" placeholder="Last Name" name="caregiver_lname[]" class="caregiverLname" value="<?php echo $value["lname"]; ?>" >
						<?php if($key==0) { ?>
							<span class="errorClass caregiverLnameErrorClass">Field Required</span>
						<?php } ?>
					</section>

					<section class="items float-none d-inline-block align-middle">
						<label>Email<span class="starClass"><?php echo $key==0 ? " *" : "&nbsp;&nbsp;"; ?></label>
						<input autocomplete="off" type="text" placeholder="Email" name="caregiver_email[]" class="caregiverEmail" value="<?php echo $value["email"]; ?>" >
						<?php if($key==0) { ?>
							<span class="errorClass caregiverEmailErrorClass">Field Required</span>
						<?php } ?>
					</section>

					<section class="items float-none d-inline-block align-middle">
						<label>Phone<span class="starClass"><?php echo $key==0 ? " *" : "&nbsp;&nbsp;"; ?></label>
						
						<select class="col-md-4 mr-2 float-left" name="caregiver_phone_code[]">
							<option value="+1" <?php echo isset($value["phone_country_code"]) && $value["phone_country_code"]=="+1" ? "selected" : ""; ?> >+1</option>
							<option value="+91" <?php echo isset($value["phone_country_code"]) && $value["phone_country_code"]=="+91" ? "selected" : ""; ?> >+91</option>
						</select>
						
						<input autocomplete="off" type="text" placeholder="Phone" name="caregiver_phone[]" maxlength="10" class="caregiverPhone" value="<?php echo $value["phone"]; ?>" style="width:45% !important;">
						
						<?php if($key==0) { ?>
							<span class="errorClass caregiverPhoneErrorClass">Field Required</span>
						<?php } ?>
					</section>
					<section class="items float-none d-inline-block align-middle">
						<label class="mr-3"><input type="radio" name="is_primary[]" value="1" class="is_primary" checked> Primary Contact <span class="radiobtn"></span></label>
						<?php if($key==0) { ?>
							<button class="add_field_button">Add More Fields</button>
						<?php }
						else { ?>
							<button class="remove_field" data-id="<?php echo $key+1; ?>" id="<?php echo $value["patient_caregiver_id"]; ?>" style="margin-left:45%;"></button>
						<?php } ?>
					</section>
				</section>
				<?php } }
				else { ?>
				<section class="input_fields_wrap caregiverDiv">
					<section class="items float-none d-inline-block align-middle">
						<label>First Name<span class="starClass"> *</span></label>
						<input autocomplete="off" type="text" placeholder="First Name" name="caregiver_fname[]" class="caregiverFname">
						<span class="errorClass caregiverFnameErrorClass">Field Required</span>
					</section>

					<section class="items float-none d-inline-block align-middle">
						<label>Last Name<span class="starClass"> *</span></label>
						<input autocomplete="off" type="text" placeholder="Last Name" name="caregiver_lname[]" class="caregiverLname">
						<span class="errorClass caregiverLnameErrorClass">Field Required</span>
					</section>

					<section class="items float-none d-inline-block align-middle">
						<label>Email<span class="starClass"> *</span></label>
						<input autocomplete="off" type="text" placeholder="Email" name="caregiver_email[]" class="caregiverEmail">
						<span class="errorClass caregiverEmailErrorClass">Field Required</span>
					</section>

					<section class="items float-none d-inline-block align-middle">
						<label>Phone<span class="starClass"> *</span></label>
						
						<select class="col-md-4 mr-2 float-left" name="caregiver_phone_code[]">
							<option value="+1">+1</option>
							<option value="+91">+91</option>
						</select>
						
						<input autocomplete="off" type="text" placeholder="Phone" name="caregiver_phone[]" maxlength="10" class="caregiverPhone" style="width:45% !important;">
						<span class="errorClass caregiverPhoneErrorClass">Field Required</span>
					</section>
					<section class="items float-none d-inline-block align-middle">
						<label class="mr-3"><input type="radio" name="is_primary[]" value="1" class="is_primary" checked> Primary Contact <span class="radiobtn"></span></label>
						 <button class="add_field_button">Add More Fields</button>
					</section>
				</section>
				<?php } ?>
			</section>

			<section class=" patient-info patient-payer lightblue-bg mb-2 float-left w-100 p-4">
				<h3>Payer<span class="starClass"> *</span></h3>
				<section class="form-control-row float-left w-100">
					<label class="mr-3" ><input type="radio" name="payer_type" value="1" <?php echo (isset($patientData["payer_type"]) && $patientData["payer_type"]=="1") ? "checked" : ((!isset($patientData["payer_type"])) ? "checked" : ""); ?> > Medicare <span class="radiobtn"></span></label>
					<label class="mr-3"><input type="radio" name="payer_type" value="2" <?php echo isset($patientData["payer_type"]) && $patientData["payer_type"]=="2" ? "checked" : ""; ?> > Commercial <span class="radiobtn"></span></label>
					<section class="float-left w-100 mt-3">
						<div id="Cars1" class="desc">
							<textarea placeholder="Add details" name="payer_details" class="payerDetails"><?php echo isset($patientData["payer_details"]) && !empty($patientData["payer_details"]) ? $patientData["payer_details"] : ""; ?></textarea>
							<span class="errorClass payerDetailsErrorClass">Field Required</span>
						</div>
					</section>
				</section>
			</section>

			<section class="patient-info patient-assign lightblue-bg mb-2 float-left w-100 p-4">
				<h3>Assigned to<span class="starClass"> *</span></h3>
				<input type="hidden" name="patient_nurse_doctor_id" value="<?php echo isset($patientData["patientnursedoctor"]["patient_nurse_doctor_id"]) ? $patientData["patientnursedoctor"]["patient_nurse_doctor_id"] : ""; ?>">
				<select class="assignNurse" name="nurse_id">
					<option value="">Select a Nurse</option>
					<?php
					if(isset($nurseData) && !empty($nurseData)) {
					foreach($nurseData as $key => $value) { ?>
						<option value="<?php echo $value["hospital_user_id"]; ?>" <?php echo isset($patientData["patientnursedoctor"]["nurse_id"]) && $patientData["patientnursedoctor"]["nurse_id"]==$value["hospital_user_id"] ? "selected" : ""; ?> ><?php echo $value["fname"]." ".$value["lname"]; ?></option>
					<?php } } ?>
				</select><br><br><br><br>
				<span class="errorClass assignNurseErrorClass">Field Required</span>
			</section>
			
			<section class="patient-info patient-assign lightblue-bg mb-4 float-left w-100 p-4">
				<h3>Device Procured by</h3>
				<label class="mr-3" ><input type="radio" name="procured_by" value="1" id="provider" <?php echo isset($patientData["patientdevices"][0]["procured_by"]) && $patientData["patientdevices"][0]["procured_by"]==1 ? "checked" : ((!isset($patientData["patientdevices"][0]["procured_by"])) ? "checked" : ""); ?> > Provider <span class="radiobtn"></span></label>
				<label class="mr-3"><input type="radio" name="procured_by" value="2" id="insurance" <?php echo isset($patientData["patientdevices"][0]["procured_by"]) && $patientData["patientdevices"][0]["procured_by"]==2 ? "checked" : ""; ?> > Insurance <span class="radiobtn"></span></label>
				<label class="mr-3" ><input type="radio" name="procured_by" value="3" id="patient" <?php echo isset($patientData["patientdevices"][0]["procured_by"]) && $patientData["patientdevices"][0]["procured_by"]==3 ? "checked" : ""; ?> > Patient <span class="radiobtn"></span></label>
			</section>
			
			<div class="last-toggle float-left w-100 position-relative mb-4">
				<h5>Monitoring Status:</h5>
				<label class="switch">
					<input type="checkbox" name="is_monitored" <?php echo (isset($patientData["is_monitored"]) && $patientData["is_monitored"]=="1") ? "checked" : ((!isset($patientData["is_monitored"])) ? "checked" : ""); ?> >
					<span class="slider round"></span>
				</label>
			</div>

			<input type="submit" class="btn btn-primary text-uppercase checkValidation" value="<?php echo isset($patientData["patient_id"]) && !empty($patientData["patient_id"]) ? "Update" : "Submit"; ?>">
			
		</form>	
		
		</section>
	</div>		
</section>

<?php echo $this->Html->script(['patient/jquery.formatter.min.js']); ?>

<script>
$(document).ready(function(){
	  
	$('#birthdateval').formatter({
	 'pattern': '{{99}}/{{99}}/{{9999}}'
	});
	
  $('.breadcrumb li a').click(function(){
    $('li a').removeClass("active");
    $(this).addClass("active");
});
});
</script>


<script>
$(document).ready(function(){
  $(".click").click(function(){
    $(".sidebar").toggleClass("intro");
	$(".right-cont").toggleClass("full");
	$(".click").toggleClass("pos");
	$(".breadcrumb").toggleClass("mid");
	$(".upper-cont").toggleClass("mid");
	$("#s").toggleClass("midd");
  });



});
</script>

<script>
$(document).ready(function(){
  $(".status").click(function(){
  $(".status").toggleClass("side");
    });
});
</script>


	
	
<script>
$(document).ready(function()
{
	csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;
	
	$(".deviceID").click(function()
	{
		$(".serialNo_"+$(this).val()).toggleClass("active");
	});
	
	$(".vital_id").click(function()
	{
		$(".vital_id_"+$(this).attr("id")).toggleClass("active");
		
		if($(".vital_id_"+$(this).attr("id")).hasClass("active"))
		{
			$(".vitalIDText_"+$(this).attr("id")).val($(this).attr("id"));
		}
		else
		{
			$(".vitalIDText_"+$(this).attr("id")).val("");
		}
		
		$(".vitalErrorClass").css("display","none");
	});
});
</script>

<script>
	$(document).ready(function(){
	  $("#1").click(function(){
		$(".chf").toggleClass("active");
	  });
	
	
	  $("#2").click(function(){
		$(".astma").toggleClass("active");
	  });
	
	
	  $("#3").click(function(){
		$(".diabetes").toggleClass("active");
	  });
	
	
	  $("#4").click(function(){
		$(".hypertension").toggleClass("active");
	  });
	
	
	  $("#5").click(function(){
		$(".glucos").toggleClass("active");
	  });


	  $(".moniter-btn").click(function(){
		$('.monitoring').css('display','block');
	  });
	  
	});
	</script>

<script>


$(document).ready(function() {
	var max_fields      = 10; //maximum input boxes allowed
	var wrapper   		= $(".input_fields_wrap"); //Fields wrapper
	var add_button      = $(".add_field_button"); //Add button ID
	
	//var x = 1; //initlal text box count
	var x = $(".caregiverDiv").length;
	$(add_button).click(function(e){ //on add input button click
		e.preventDefault();
		if(x < max_fields){ //max input box allowed
			x++; //text box increment
		//$(wrapper).append('<div><label>First Name</label><input type="name" name="mytext[]" placeholder=""/><label>Last Name</label> <input type="text" name="mytext[]" placeholder=""/> <label>EMail</label><input type="text" name="mytext[]" placeholder=""/><label>Phone</label><input type="text" name="mytext[]" placeholder=""/><a href="#" class="remove_field">Remove</a></div>'); //add input box
			$(wrapper).append('<div class="full-items caregiverDiv caregiverDiv_'+x+'"><section class="items float-none d-inline-block align-middle"><label>First Name<span class="starClass">&nbsp;&nbsp;</span></label><input autocomplete="off" type="text" placeholder="First Name" name="caregiver_fname[]"></section><section class="items float-none d-inline-block align-middle"><label>Last Name<span class="starClass">&nbsp;&nbsp;</span></label><input autocomplete="off" type="text" placeholder="Last Name" name="caregiver_lname[]"></section><section class="items float-none d-inline-block align-middle"><label>Email<span class="starClass">&nbsp;&nbsp;</span></label><input autocomplete="off" type="text" placeholder="Email" name="caregiver_email[]"></section><section class="items float-none d-inline-block align-middle"><label>Phone<span class="starClass">&nbsp;&nbsp;</span></label><select class="col-md-4 mr-2 float-left" name="caregiver_phone_code[]"><option value="+1">+1</option><option value="+91">+91</option></select><input autocomplete="off" type="text" placeholder="Phone" name="caregiver_phone[]" maxlength="10" class="caregiverPhone"  style="width:45% !important;"></section><section class="items float-none d-inline-block align-middle"><label class="mr-3"><input type="radio" name="is_primary[]" value="'+x+'" class="is_primary" > Primary Contact <span class="radiobtn"></span></label></section><a href="#" class="remove_field" id="" data-id="'+x+'">Remove</a></div>'); //add input box
			}
	});
	
	$(wrapper).on("click",".remove_field", function(e){ //user click on remove text
		e.preventDefault(); //$(this).parent('div').remove(); x--;
		
		var id = $(this).attr("id");
		var dataID = $(this).attr("data-id");
		$(".caregiverDiv_"+dataID).remove();
		
		if(id!="") {
		$.ajax({
			url: '<?php echo $this->url->build(["controller"=>"Patients", "action"=>"deletecaregiver"]); ?>',
			type: "POST",
			headers:
			{
				'X-CSRF-Token': csrfToken    
			},
			data: {'caregiverID':id},
			success: function(data)
			{
			}   
		}); }
		
	});
	
	$("body").on("blur",".mrnNo, .payerDetails",function()
	{
		$(this).next(".errorClass").css("display","none");
	});
	
	$("body").on("blur",".fname, .lname, .caregiverFname, .caregiverLname",function()
	{
		$(this).next(".errorClass").css("display","none");
		
		if($(this).val()!="")
		{
			var regex = /^([a-zA-Z_ ])+$/;
			if(regex.test($(this).val()) == false)
			{
				$(this).next(".errorClass").text("Field should be alphabetic").css("display","block");
				return false;
			}
		}
	});
	
	$("body").on("blur",".email",function()
	{
		$(this).next(".errorClass").css("display","none");
		
		if($(this).val()!="")
		{
			var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			if(regex.test($(this).val()) == false)
			{
				$(this).next(".errorClass").text("Enter Valid Email").css("display","block");
				return false;
			}
			
			var emailValue = $(this).val();
			$.ajax({
				url: '<?php echo $this->Url->build(["controller"=>"Patients", "action"=>"checkemail"]); ?>',
				type: "POST",
				headers:
				{
					'X-CSRF-Token': csrfToken    
				},
				data: {'emailValue':emailValue},
				success: function(data)
				{
					
					if(data==1)
					{
						$(".emailErrorClass").css("display","block");
						$(".emailErrorClass").text("Email Exists");
						$(".email").addClass("exists");
					}
					else
					{
						$(".emailErrorClass").css("display","none");
						$(".email").removeClass("exists");
					}
				}   
			});
		}
	});
	
	$("body").on("blur",".caregiverEmail",function()
	{
		$(this).next(".errorClass").css("display","none");
		
		if($(this).val()!="")
		{
			var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			if(regex.test($(this).val()) == false)
			{
				$(this).next(".errorClass").text("Enter Valid Email").css("display","block");
				return false;
			}
		}
	});
	
	$("body").on("blur",".dob",function(e)
	{
		$(this).next(".errorClass").css("display","none");
		
		var value = $(this).val();
		if($(this).val().length!=10)
		{
			$(".dobErrorClass").text("Enter Valid Dob").css("display","block");
		}
	});
	
	var regExp = /[0-9]/;
	$("body").on("keydown keyup",".mobile, .caregiverPhone",function(e)
	{
		$(this).parent().next(".errorClass").css("display","none");
		$(this).next(".errorClass").css("display","none");
		var value = String.fromCharCode(e.which) || e.key;
		
		if(!regExp.test(value) && e.which != 8 && e.which != 9 && e.which != 46 && e.which != 96 && e.which != 97 && e.which != 98 && e.which != 99 && e.which != 100 && e.which != 101 && e.which != 101 && e.which != 102 && e.which != 103 && e.which != 104 && e.which != 105)
		{
			  e.preventDefault();
			  return false;
		}
	});
	
	$("body").on("blur",".mobile",function()
	{
		$(this).next(".errorClass").css("display","none");
		
		if($(this).val()!="")
		{
			var mobileValue = $(this).val();
			$.ajax({
				url: '<?php echo $this->Url->build(["controller"=>"Patients", "action"=>"checkmobile"]); ?>',
				type: "POST",
				headers:
				{
					'X-CSRF-Token': csrfToken    
				},
				data: {'mobileValue':mobileValue},
				success: function(data)
				{
					
					if(data==1)
					{
						$(".mobileErrorClass").css("display","block");
						$(".mobileErrorClass").text("Mobile Exists");
						$(".mobile").addClass("exists");
					}
					else
					{
						$(".mobileErrorClass").css("display","none");
						$(".mobile").removeClass("exists");
					}
				}   
			});
		}
	});
	
	$("body").on("blur","#monitoring_start",function(e)
	{
		if($(this).val()!="")
		{
			$(".monitoringStartErrorClass").css("display","none");
		}
	});
	
	$("body").on("blur","#monitoring_end",function(e)
	{
		if($(this).val()!="")
		{
			$(".monitoringEndErrorClass").css("display","none");
		}
	});
	
	$("body").on("change",".assignNurse",function()
	{
		$(".assignNurseErrorClass").css("display","none");
	});
	
	$("body").on("click",".condition",function()
	{
		$(".conditionErrorClass").css("display","none");
	});
	
	$("body").on("click",".checkValidation",function()
	{
		if($(".mrnNo").val()=="")
		{
			$(".mrnNo").next(".errorClass").css("display","block");
		}
		else
		{
			$(".mrnNo").next(".errorClass").css("display","none");
		}
		
		if($(".fname").val()=="" || /^([a-zA-Z_ ])+$/.test($(".fname").val()) == false)
		{
			$(".fname").next(".errorClass").css("display","block");
		}
		else
		{
			$(".fname").next(".errorClass").css("display","none");
		}
		
		if($(".lname").val()=="" || /^([a-zA-Z_ ])+$/.test($(".lname").val()) == false)
		{
			$(".lname").next(".errorClass").css("display","block");
		}
		else
		{
			$(".lname").next(".errorClass").css("display","none");
		}
		
		if($(".dob").val()=="")
		{
			$(".dobErrorClass").text("Field Required").css("display","block");
		}
		else if($(".dob").val().length!=10)
		{
			$(".dobErrorClass").text("Enter Valid Dob").css("display","block");
		}
		else
		{
			$(".dob").next(".errorClass").css("display","none");
		}
		
		if($(".email").val()=="")
		{
			$(".email").next(".errorClass").css("display","block");
			$(".emailErrorClass").text("Field Required");
		}
		else if(/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/.test($(".email").val()) == false)
		{
			$(".email").next(".errorClass").css("display","block");
			$(".emailErrorClass").text("Enter Valid Email");
		}
		else if($(".email").hasClass("exists"))
		{
			$(".email").next(".errorClass").css("display","block");
			$(".emailErrorClass").text("Email Exists");
		}
		else
		{
			$(".email").next(".errorClass").css("display","none");
		}
		
		if($(".mobile").val()=="")
		{
			$(".mobileErrorClass").css("display","block");
		}
		else
		{
			$(".mobileErrorClass").css("display","none");
		}
		
		if($("#monitoring_start").val()=="")
		{
			$(".monitoringStartErrorClass").css("display","block");
		}
		else
		{
			$(".monitoringStartErrorClass").css("display","none");
		}
		
		if($("#monitoring_end").val()=="")
		{
			$(".monitoringEndErrorClass").css("display","block");
		}
		else
		{
			$(".monitoringEndErrorClass").css("display","none");
		}
		
		if($(".caregiverFname").val()=="")
		{
			$(".caregiverFname").next(".errorClass").css("display","block");
		}
		else
		{
			$(".caregiverFname").next(".errorClass").css("display","none");
		}
		
		if($(".caregiverLname").val()=="")
		{
			$(".caregiverLname").next(".errorClass").css("display","block");
		}
		else
		{
			$(".caregiverLname").next(".errorClass").css("display","none");
		}
		
		if($(".caregiverEmail").val()=="")
		{
			$(".caregiverEmail").next(".errorClass").css("display","block");
		}
		else
		{
			$(".caregiverEmail").next(".errorClass").css("display","none");
		}
		
		if($(".caregiverPhone").val()=="")
		{
			$(".caregiverPhone").next(".errorClass").css("display","block");
		}
		else
		{
			$(".caregiverPhone").next(".errorClass").css("display","none");
		}
		
		if($(".payerDetails").val()=="")
		{
			$(".payerDetails").next(".errorClass").css("display","block");
		}
		else
		{
			$(".payerDetails").next(".errorClass").css("display","none");
		}
		
		if($(".assignNurse").val()=="")
		{
			$(".assignNurseErrorClass").css("display","block");
		}
		else
		{
			$(".assignNurseErrorClass").css("display","none");
		}
		
		if($(".condition").is(":checked")==false)
		{
			$(".conditionErrorClass").css("display","block");
		}
		
		var $nonempty = $(".vitalIDText").filter(function()
		{
			return this.value != ''
		});
		if($nonempty.length==0)
		{
			$(".vitalErrorClass").css("display","block");
		}
		if($nonempty.length!=0)
		{
			$(".vitalIDText").each(function()
			{
				if($(this).val()==1)
				{
					if($("#deviceID_1").is(":checked")==false && $("#deviceID_2").is(":checked")==false)
					{
						$(".deviceErrorClass").css("display","block");
					}
					else
					{
						$(".deviceErrorClass").css("display","none");
					}
				}
				if($(this).val()==2)
				{
					if($("#deviceID_1").is(":checked")==false && $("#deviceID_2").is(":checked")==false && $("#deviceID_5").is(":checked")==false)
					{
						$(".deviceErrorClass").css("display","block");
					}
					else
					{
						$(".deviceErrorClass").css("display","none");
					}
				}
				if($(this).val()==3)
				{
					if($("#deviceID_4").is(":checked")==false)
					{
						$(".deviceErrorClass").css("display","block");
					}
					else
					{
						$(".deviceErrorClass").css("display","none");
					}
				}
				if($(this).val()==4)
				{
					if($("#deviceID_5").is(":checked")==false)
					{
						$(".deviceErrorClass").css("display","block");
					}
					else
					{
						$(".deviceErrorClass").css("display","none");
					}
				}
				if($(this).val()==5)
				{
					if($("#deviceID_3").is(":checked")==false)
					{
						$(".deviceErrorClass").css("display","block");
					}
					else
					{
						$(".deviceErrorClass").css("display","none");
					}
				}
			})
		}
		
		if($('.mrnNoErrorClass').css('display')=='block' || $('.fnameErrorClass').css('display')=='block' || $('.lnameErrorClass').css('display')=='block' || $('.dobErrorClass').css('display')=='block' || $('.emailErrorClass').css('display')=='block' || $('.mobileErrorClass').css('display')=='block' || $('.caregiverFnameErrorClass').css('display')=='block' || $('.caregiverLnameErrorClass').css('display')=='block' || $('.caregiverEmailErrorClass').css('display')=='block' || $('.caregiverPhoneErrorClass').css('display')=='block' || $('.conditionErrorClass').css('display')=='block' || $('.vitalErrorClass').css('display')=='block' || $('.deviceErrorClass').css('display')=='block' || $('.payerDetailsErrorClass').css('display')=='block' || $('.assignNurseErrorClass').css('display')=='block')
		{
			return false;
		}
		else
		{
			setTimeout(function(){
			   $(".checkValidation").attr("disabled", true);
			},1000);
		}
	});
	
	$("body").on("click",".templateData",function()
	{
		var id = $(this).attr("id");
		if($(this).is(":checked"))
		{
			$.ajax({
				url: '<?php echo $this->url->build(["controller"=>"Patients", "action"=>"gettemplatedata"]); ?>',
				type: "POST",
				headers:
				{
					'X-CSRF-Token': csrfToken    
				},
				data: {'vitalID':id},
				success: function(data)
				{
					var obj = $.parseJSON(data);
					if(obj!="")
					{
						jQuery.each(obj, function(key, val)
						{
							if(id==1)
							{
								if(key==0)
								{
									$(".bpNormalMinSystolic_"+id).val(val.normal_min);
									$(".bpNormalMaxSystolic_"+id).val(val.normal_max);
									$(".interventionNotes_"+id).val(val.intervention_notes);
									$(".bpWarningMinSystolic_"+id).val(val.warning_min);
									$(".bpWarningMaxSystolic_"+id).val(val.warning_max);
									$(".bpEmergencyMinSystolic_"+id).val(val.emergency_min);
									$(".bpEmergencyMaxSystolic_"+id).val(val.emergency_max);
								}
								if(key==1)
								{
									$(".bpNormalMinDiastolic_"+id).val(val.normal_min);
									$(".bpNormalMaxDiastolic_"+id).val(val.normal_max);
									$(".interventionNotes_"+id).val(val.intervention_notes);
									$(".bpWarningMinDiastolic_"+id).val(val.warning_min);
									$(".bpWarningMaxDiastolic_"+id).val(val.warning_max);
									$(".bpEmergencyMinDiastolic_"+id).val(val.emergency_min);
									$(".bpEmergencyMaxDiastolic_"+id).val(val.emergency_max);
								}
							}
							else
							{
								$(".normalMin_"+id).val(val.normal_min);
								$(".normalMax_"+id).val(val.normal_max);
								$(".interventionNotes_"+id).val(val.intervention_notes);
								$(".warningMin_"+id).val(val.warning_min);
								$(".warningMax_"+id).val(val.warning_max);
								$(".emergencyMin_"+id).val(val.emergency_min);
								$(".emergencyMax_"+id).val(val.emergency_max);
							}
						});
					}
				}   
			});
		}
		else
		{
			if(id==1)
			{
				$(".bpNormalMinSystolic_"+id).val("");
				$(".bpNormalMaxSystolic_"+id).val("");
				$(".bpNormalMinDiastolic_"+id).val("");
				$(".bpNormalMaxDiastolic_"+id).val("");
				$(".interventionNotes_"+id).val("");
				$(".bpWarningMinSystolic_"+id).val("");
				$(".bpWarningMaxSystolic_"+id).val("");
				$(".bpWarningMinDiastolic_"+id).val("");
				$(".bpWarningMaxDiastolic_"+id).val("");
				$(".bpEmergencyMinSystolic_"+id).val("");
				$(".bpEmergencyMaxSystolic_"+id).val("");
				$(".bpEmergencyMinDiastolic_"+id).val("");
				$(".bpEmergencyMaxDiastolic_"+id).val("");
			}
			else
			{
				$(".normalMin_"+id).val("");
				$(".normalMax_"+id).val("");
				$(".interventionNotes_"+id).val("");
				$(".warningMin_"+id).val("");
				$(".warningMax_"+id).val("");
				$(".emergencyMin_"+id).val("");
				$(".emergencyMax_"+id).val("");
			}
		}
	});
	
});
</script>
	
</body>

