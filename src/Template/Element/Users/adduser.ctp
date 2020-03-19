<input type="hidden" name="_csrfToken" value=<?php echo json_encode($this->request->getParam('_csrfToken')); ?> >
<input type="hidden" id="hospitalID" value="<?php echo $this->request->getSession()->read("hospital_id"); ?>" >
<input type="hidden" id="hospitalName" value="<?php echo $this->request->getSession()->read("hospital_name"); ?>" >
<input type="hidden" id="subDomain" value="<?php echo $this->request->getSession()->read("sub_domain"); ?>" >
<input type="hidden" name="hospital_user_id" class="hospital_user_id" value="<?php echo isset($userDetails["hospital_user_id"]) ? $userDetails["hospital_user_id"] : ""; ?>" >
<input type="hidden" id="password" value="<?php echo isset($userDetails["password"]) ? convert_uudecode(base64_decode($userDetails["password"])) : ""; ?>" >
<section class="form-extand lightblue-bg mt-2 mb-2 p-4 ad-users-form" id="form-extand">
	<h2><?php echo isset($userDetails["hospital_user_id"]) ? "Edit" : "Add"; ?> Users</h2>
	<section class="row add-user-form">
		<div class="col-md-6 my-2">
			<label>First Name<span class="starClass"> *</span></label>
			<input autocomplete="off" type="text" class="fname" id="fname" name="fname" maxlength="64" value="<?php echo isset($userDetails["fname"]) ? $userDetails["fname"] : ""; ?>" >
			<span class="errorClass fnameErrorClass" style="text-align:right;">Field Required</span>
		</div>
		<div class="col-md-6 my-2">
			<label>Last Name<span class="starClass"> *</span></label>
			<input autocomplete="off" type="text" class="lname" name="lname" maxlength="64" value="<?php echo isset($userDetails["lname"]) ? $userDetails["lname"] : ""; ?>" >
			<span class="errorClass lnameErrorClass" style="text-align:right;">Field Required</span>
		</div>
		<div class="col-md-6 my-2">
			<label>Email<span class="starClass"> *</span></label>
			<input autocomplete="off" type="email" class="<?php echo isset($userDetails["hospital_user_id"]) && !empty($userDetails["hospital_user_id"]) ? "" : "email"; ?>" id="email" name="email" maxlength="128" value="<?php echo isset($userDetails["email"]) ? $userDetails["email"] : ""; ?>" <?php echo isset($userDetails["hospital_user_id"]) && !empty($userDetails["hospital_user_id"]) ? "readonly" : ""; ?> style="background-color:<?php echo isset($userDetails["hospital_user_id"]) && !empty($userDetails["hospital_user_id"]) ? "#d2d2d2" : ""; ?>" >
			<span class="errorClass emailErrorClass" style="text-align:right;">Field Required</span>
		</div>
		<div class="col-md-6 my-2">
			<label>Phone<span class="starClass"> *</span></label>
			<input autocomplete="off" type="text" class="col-md-9 phone" id="phone" name="phone" maxlength="10" value="<?php echo isset($userDetails["phone"]) ? $userDetails["phone"] : ""; ?>" >
			<select class="col-md-1 mr-4" name="phone_code" id="phone_code">
				<option value="+1" <?php echo isset($userDetails["phone_code"]) && $userDetails["phone_code"]=="+1" ? "selected" : ""; ?> >+1</option>
				<option value="+91" <?php echo isset($userDetails["phone_code"]) && $userDetails["phone_code"]=="+91" ? "selected" : ""; ?> >+91</option>
			</select>
			<span class="errorClass phoneErrorClass" style="text-align:right;">Field Required</span>
		</div>
		<div class="col-md-6 my-2">
			<label>Group Type<span class="starClass"> *</span></label>
			<select name="role_id" class="groupType" id="groupType">
				<option value="">Select</option>
				<?php
				if(isset($rolesData) && !empty($rolesData)) {
				foreach($rolesData as $key => $value) { ?>
					<option value="<?php echo $value["role_id"]; ?>" <?php echo isset($userDetails["role_id"]) && $userDetails["role_id"]==$value["role_id"] ? "selected" : ""; ?> ><?php echo $value["role_name"]; ?></option>
				<?php } } ?>
			</select>
			<span class="errorClass groupTypeErrorClass" style="text-align:right;">Field Required</span>
		</div>
		<div class="col-md-6 my-2">
			<label>Location<span class="starClass"> *</span></label>
			<select name="hospital_location_id" class="location">
				<option value="">Select</option>
				<?php
				if(isset($locationsData) && !empty($locationsData)) {
				foreach($locationsData as $key => $value) { ?>
					<option value="<?php echo $value["hospital_location_id"]; ?>" <?php echo isset($userDetails["hospital_location_id"]) && $userDetails["hospital_location_id"]==$value["hospital_location_id"] ? "selected" : ""; ?> ><?php echo $value["location_name"].", ".$value["city"]; ?></option>
				<?php } } ?>
			</select>
			<span class="errorClass locationErrorClass" style="text-align:right;">Field Required</span>
		</div>
		<div class="col-md-6 my-2">
			<input type="button" value="<?php echo isset($userDetails["hospital_user_id"]) ? "Submit" : "Save"; ?>" class="btn btn-primary checkValidation">
		</div>
	</section>
</section>