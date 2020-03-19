
<?php echo $this->Html->script(["awsCognito/amazon-cognito-auth.min.js","awsCognito/amazon-cognito-identity.min.js","awsCognito/config.js"]); ?>

<form id="adminForm">
	<section class="form-extand lightblue-bg mt-2 mb-2 p-4 ad-users-form" id="form-extand">
		<h2>Add Admins</h2>
		<section class="row add-user-form">
			<div class="col-md-12 my-2">
				<label>Hospital Name :<span class="starClass"> *</span></label>
				<input autocomplete="off" type="text" class="hospital_name" id="hospital_name" name="hospital_name" maxlength="64" >
				<span class="errorClass hospitalNameErrorClass" style="text-align:right;">Field Required</span>
			</div>
			
			<div class="col-md-12 my-2">
				<label>Hospital Email :<span class="starClass"> *</span></label>
				<input autocomplete="off" type="text" class="email" id="email" name="email" maxlength="64" >
				<span class="errorClass emailErrorClass" style="text-align:right;">Field Required</span>
			</div>
			
			<input type="hidden" name="phone_code" value="+91" class="phone_code" id="phone_code" name="phone_code">
			<div class="col-md-12 my-2">
				<label>Phone :<span class="starClass"> *</span></label>
					<select class="col-md-1 mr-4" name="phone_code" id="phone_code">
					<option value="+1">+1</option>
					<option value="+91">+91</option>
				</select>
				<input autocomplete="off" type="text" class="phone_no" id="phone_no" name="phone_no" maxlength="10" >
				<span class="errorClass phoneNoErrorClass" style="text-align:right;">Field Required</span>
			</div>
			
			<div class="col-md-12 my-2">
				<label>Domain :<span class="starClass"> *</span></label>
				<input autocomplete="off" type="text" class="sub_domain" id="sub_domain" name="sub_domain" >
				<span class="errorClass subDomainErrorClass" style="text-align:right;">Field Required</span>
			</div>
			
			<div class="col-md-12 my-2">
				<label>Logo :</label>
				<input type="file" class="logo_url" id="logo_url" name="logo_url" >
			</div>
			
			<div class="col-md-6 my-2">
				<input type="button" class="btn btn-primary text-uppercase checkValidation" value="Save" >
			</div>
		</section>
	</section>
</form>

<script>
$(document).ready(function()
{
	csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;
	
	$("body").on("blur",".hospital_name",function()
	{
		$(".hospitalNameErrorClass").css("display","none");
		
		if($(this).val()!="")
		{
			var regex = /^([a-zA-Z" ])+$/;
			if(regex.test($(this).val()) == false)
			{
				$(".hospitalNameErrorClass").text("Field should be alphabetic").css("display","inline-block");
				return false;
			}
		}
	});
	
	$("body").on("blur",".email",function()
	{
		$(".emailErrorClass").css("display","none");
		
		if($(this).val()!="")
		{
			var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			if(regex.test($(this).val()) == false)
			{
				$(".emailErrorClass").text("Enter Valid Email").css("display","inline-block");
				return false;
			}
			
			var emailValue = $(this).val();
			$.ajax({
				url: '<?php echo $this->Url->build(["controller"=>"Superadmin", "action"=>"checkemail"]); ?>',
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
						$(".emailErrorClass").css("display","inline-block");
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
	
	var regExp = /[0-9]/;
	$("body").on("keydown keyup",".phone_no",function(e)
	{
		$(".phoneNoErrorClass").css("display","none");
		var value = String.fromCharCode(e.which) || e.key;
		
		if(!regExp.test(value) && e.which != 8 && e.which != 9 && e.which != 46 && e.which != 96 && e.which != 97 && e.which != 98 && e.which != 99 && e.which != 100 && e.which != 101 && e.which != 101 && e.which != 102 && e.which != 103 && e.which != 104 && e.which != 105)
		{
			  e.preventDefault();
			  return false;
		}
	});
	
	
	$("body").on("click",".checkValidation",function()
	{
		if($(".hospital_name").val()=="" || /^([a-zA-Z' ])+$/.test($(".hospital_name").val()) == false)
		{
			$(".hospitalNameErrorClass").css("display","inline-block");
		}
		else
		{
			$(".hospitalNameErrorClass").css("display","none");
		}
		
		if($(".email").val()=="")
		{
			$(".emailErrorClass").css("display","inline-block");
			$(".emailErrorClass").text("Field Required");
		}
		else if(/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/.test($(".email").val()) == false)
		{
			$(".emailErrorClass").css("display","inline-block");
			$(".emailErrorClass").text("Enter Valid Email");
		}
		else if($(".email").hasClass("exists"))
		{
			$(".emailErrorClass").css("display","inline-block");
			$(".emailErrorClass").text("Email Exists");
		}
		else
		{
			$(".emailErrorClass").css("display","none");
		}
		
		if($(".phone_no").val()=="")
		{
			$(".phoneNoErrorClass").css("display","inline-block");
		}
		else
		{
			$(".phoneNoErrorClass").css("display","none");
		}
		
		if($(".sub_domain").val()=="")
		{
			$(".subDomainErrorClass").css("display","inline-block");
		}
		else
		{
			$(".subDomainErrorClass").css("display","none");
		}
		
		if($('.hospitalNameErrorClass').css('display')=='inline-block' || $('.emailErrorClass').css('display')=='inline-block' || $('.phoneNoErrorClass').css('display')=='inline-block' || $('.subDomainErrorClass').css('display')=='inline-block')
		{
			return false;
		}
		else
		{
			var form = $('#adminForm')[0]; 
			var data = new FormData(form);
			
			$(this).attr("disabled", true);
			
			var groupTypeTEXT = "admin";
			
			var phoneValue = document.getElementById("phone_code").value + document.getElementById("phone_no").value;
			
			$.ajax({
				url: '<?php echo $this->Url->build(["controller"=>"Superadmin", "action"=>"register"]); ?>',
				data: data,
				processData: false,
				contentType: false,
				type: 'POST',
				success: function(data)
				{
					var obj = $.parseJSON(data);
					//SAVE DATA IN COGNITO
					if(obj!="")
					{
						name =  document.getElementById("hospital_name").value;	
						email = document.getElementById("email").value;
						phone = phoneValue;
						hospitalID = $.trim(obj.hospital_id);
						hospitalName = document.getElementById("hospital_name").value;
						subDomain = document.getElementById("sub_domain").value;
						groupType = groupTypeTEXT;
						password = obj.password;
						
						poolData = {
								UserPoolId : _config.cognito.userPoolId, // Your user pool id here
								ClientId : _config.cognito.clientId // Your client id here
							};	
						var userPool = new AmazonCognitoIdentity.CognitoUserPool(poolData);

						var attributeList = [];
						
						var dataName = {
							Name : 'name', 
							Value : name, //get from form field
						};
						var dataEmail = {
							Name : 'email', 
							Value : email, //get from form field
						};
						var dataPhone = {
							Name : 'phone', 
							Value : phone, //get from form field
						};
						var hospital_id = {
							Name : 'custom:hospital_id',
							Value : hospitalID,
						};
						var hospital_name = {
							Name : 'custom:hospital_name',
							Value : hospitalName,
						};
						var sub_domain = {
							Name : 'custom:sub_domain',
							Value : subDomain,
						};
						var user_role = {
							Name : 'custom:user_role',
							Value : groupType,
						};
						
						var attributePersonalName = new AmazonCognitoIdentity.CognitoUserAttribute(dataName);
						var attributeEmail = new AmazonCognitoIdentity.CognitoUserAttribute(dataEmail);
						var attributePhone = new AmazonCognitoIdentity.CognitoUserAttribute(dataPhone);
						var attributehospitalID = new AmazonCognitoIdentity.CognitoUserAttribute(hospital_id);
						var attributehospitalName = new AmazonCognitoIdentity.CognitoUserAttribute(hospital_name);
						var attributeSubDomain = new AmazonCognitoIdentity.CognitoUserAttribute(sub_domain);
						var attributeUserRole = new AmazonCognitoIdentity.CognitoUserAttribute(user_role);
						
						attributeList.push(dataName);
						attributeList.push(attributeEmail);
						//attributeList.push(attributePhone);
						attributeList.push(attributehospitalID);
						attributeList.push(attributehospitalName);
						attributeList.push(attributeSubDomain);
						attributeList.push(attributeUserRole);

						userPool.signUp(email, password, attributeList, null, function(err, result){
							if (err) {
								//alert(err.message || JSON.stringify(err));
								return;
							}
							cognitoUser = result.user;
							location.reload();
						});
					}
					//SAVE DATA IN COGNITO
				}
			});
		}
	});
});
</script>