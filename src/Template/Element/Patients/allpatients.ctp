<?php
if(isset($patientsData) && !empty($patientsData)) {
foreach($patientsData as $key => $value) { ?>
<tr>
	<td><a href="<?php echo $this->Url->build(["controller"=>"Patients","action"=>"patientdetails"]); ?>"><?php echo $value["fname"]." ".$value["mname"]." ".$value["lname"]; ?></a></td>
	<td><span class="notify">56</span></td>
	<td><a href="javaScript:void(0)" class="float-none d-inline-block mr-3">List</a> <a href="javaScript:void(0)">Graph</a></td>
	<td><a href="javaScript:void(0)">54 min 30</a></td>
	<td>0 of 2</td>
	<td>99457</td>
	<td>
		<a class="icn" href="<?php echo $this->Url->build(["controller"=>"Chats","action"=>"index"]); ?>"><img src="<?php echo IMAGE_PATH."patient-mail-icn.png"; ?>" alt="icn"></a>
		<a class="icn" data-toggle="modal" data-target="#patient-reminder-one"><img src="<?php echo IMAGE_PATH."patient-note-icn.png"; ?>" alt="icn"></a>
		<a class="icn" data-toggle="modal" data-target="#patient-reminder-two"><img src="<?php echo IMAGE_PATH."nfcn.png"; ?>" alt="icn" style=" width: 17px; margin-top: 2px;"></a>
		<a class="icn" href="images/HealthNodes-MonthlyPDF.pdf " download="proposed_file_name"><img src="<?php echo IMAGE_PATH."patient-pdf-icn.png"; ?>" alt="icn"></a>
		<a class="icn" href="<?php echo $this->Url->build(["controller"=>"Patients","action"=>"index",base64_encode($value["patient_id"])]); ?>" >Edit</a>
		<?php if($value["is_active"]==0) { ?>
		<a class="icn resendCode" href="javaScript:void(0)" data-mobile="<?php echo $value["mobile_code"]." ".$value["mobile"]; ?>" id="<?php echo $value["patient_id"]; ?>" > | Resend Code</a>
		<br><span class="codeSent_<?php echo $value["patient_id"]; ?>" style="display:none; color:green;">Code Sent</span>
		<?php } ?>
	</td>
</tr>
<?php } }
else { ?>
<tr>
	<td>No Data Found</td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<?php } ?>