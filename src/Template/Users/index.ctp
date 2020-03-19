<body>
<!-- HEADER -->
<?php echo $this->element("header"); ?>
<!-- HEADER -->

<?php echo $this->Html->script(["awsCognito/amazon-cognito-auth.min.js","awsCognito/amazon-cognito-identity.min.js","awsCognito/config.js"]); ?>

<script src="https://sdk.amazonaws.com/js/aws-sdk-2.7.16.min.js"></script>

<section class="data-details">
	<!-- LEFT PANEL -->
	<?php echo $this->element("left_panel"); ?>
	<!-- LEFT PANEL -->

	<section class="right-cont users-panel-bx">
		<div class="click"><span><img src="<?php echo IMAGE_PATH."toggle.png"; ?>"></span></div>
		<ul class="breadcrumb">	
			<li><a href="javaScript:void(0)">Home</a></li>
			<li><a href="javaScript:void(0)">Administration</a></li>
			<li class="active"><a href="javaScript:void(0)"> Users</a></li>
		</ul>  

		<section class="users-panel">
			<h2 class="text-left">Users</h2>
			<section class="table-responsive">
				<table class="table lightblue-bg mb-0">
					<thead class="thead-light">
						<tr>
							<th>Name</th>
							<th>Email</th>
							<th>Phone</th>
							<th>Type</th>
							<th>Location</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody id="allUsers">
						<?php echo $this->element("Users/allusers"); ?>
					</tbody>
				</table>
			</section> 
			
			<!--<section class="form-extand lightblue-bg mt-2 mb-2 p-4 form-extand-edit" >
				<h2>Edit Users</h2>
				<section class="row add-user-form">
					<div class="col-md-6 my-2">
						<label>First Name<span class="starClass"> *</span></label>
						<input autocomplete="off" type="text" name="fiame" value="John">
					</div>
					<div class="col-md-6 my-2">
						<label>Last Name<span class="starClass"> *</span></label>
						<input autocomplete="off" type="text" name="lname" value="Deo">
					</div>
					<div class="col-md-6 my-2">
						<label>Email<span class="starClass"> *</span></label>
						<input autocomplete="off" type="email" name="email" value="Email">
					</div>
					<div class="col-md-6 my-2">
						<label>Phone<span class="starClass"> *</span></label>
						<input autocomplete="off" type="tel" name="phone" value="+1 568-7898-585">
					</div>
					<div class="col-md-6 my-2">
						<label>Group Type<span class="starClass"> *</span></label>
						<select name="role_id">
							<option>Nurse</option>
						</select>
					</div>
					<div class="col-md-6 my-2">
						<label>Location<span class="starClass"> *</span></label>
						<select name="location">
							<option>New York</option>
						</select>
					</div>
					<div class="col-md-6 my-2">
						<input type="submit" value="Save" class="btn btn-primary save">
					</div>
				</section>
			</section>-->

			<section class="btn-panel my-5 text-left">
				<a href="javaScript:void(0)" class="btn btn-primary ad-user-btn addUserHTML">Add Users</a>
			</section>
			
			
			<form id="usersForm">
			</form>
			
		</section>

	</section>    
</section>

<div class="modal u-cont" id="myModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- Modal body -->
			<div class="modal-body">
				<b class="mb-4">are you sure want to delete it.</b>
				<a class="btn btn-primary deleteUser" href="javaScript:void(0)" id="" class="close" data-dismiss="modal">Yes</a>
				<a class="btn btn-secondary" href="javaScript:void(0)" class="close" data-dismiss="modal">no</a>
			</div> 
		</div>
	</div>
</div>

<script>
$(document).ready(function()
{
	var csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;
	
	$(".click").click(function()
	{
		$(".sidebar").toggleClass("intro");
        $(".right-cont").toggleClass("full");
        $(".click").toggleClass("pos");
        $(".breadcrumb").toggleClass("mid");
        $(".upper-cont").toggleClass("mid");
        $("#s").toggleClass("midd");
	});
      
	/* $(".edit").click(function()
	{
		$(".form-extand-edit").toggleClass("active");
	});

	$(".save").click(function()
	{
		$(".form-extand-edit").removeClass("active");
	});

	$(".edit").click(function()
	{
		$(".btn-panel").toggleClass("remove");
	});
      

	$(".save").click(function()
	{
		$(".btn-panel").removeClass("remove");
	});

	$(".ad-user-btn").click(function()
	{ 
		$(".ad-users-form").addClass("active");
	});

	$(".edit").click(function()
	{
		$(".ad-users-form").removeClass("active");
	}); */
	
	
	$("body").on("blur",".fname, .lname",function()
	{
		$(this).next(".errorClass").css("display","none");
		
		if($(this).val()!="")
		{
			var regex = /^([a-zA-Z' ])+$/;
			if(regex.test($(this).val()) == false)
			{
				$(this).next(".errorClass").text("Field should be alphabetic").css("display","block");
				return false;
			}
		}
	});
	
	var regExp = /[0-9]/;
	$("body").on("keydown keyup",".phone",function(e)
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
				url: '<?php echo $this->Url->build(["controller"=>"Users", "action"=>"checkemail"]); ?>',
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
	
	$("body").on("change",".groupType, .location",function()
	{
		$(this).next(".errorClass").css("display","none");
	});
	
	$("body").on("click",".checkValidation",function()
	{
		if($(".fname").val()=="" || /^([a-zA-Z' ])+$/.test($(".fname").val()) == false)
		{
			$(".fname").next(".errorClass").css("display","block");
		}
		else
		{
			$(".fname").next(".errorClass").css("display","none");
		}
		
		if($(".lname").val()=="" || /^([a-zA-Z' ])+$/.test($(".lname").val()) == false)
		{
			$(".lname").next(".errorClass").css("display","block");
		}
		else
		{
			$(".lname").next(".errorClass").css("display","none");
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
		
		if($(".phone").val()=="")
		{
			$(".phoneErrorClass").css("display","block");
		}
		else
		{
			$(".phoneErrorClass").css("display","none");
		}
		
		if($(".groupType").val()=="")
		{
			$(".groupType").next(".errorClass").css("display","block");
		}
		else
		{
			$(".groupType").next(".errorClass").css("display","none");
		}
		
		if($(".location").val()=="")
		{
			$(".location").next(".errorClass").css("display","block");
		}
		else
		{
			$(".location").next(".errorClass").css("display","none");
		}
		
		if($('.fnameErrorClass').css('display')=='block' || $('.lnameErrorClass').css('display')=='block' || $('.emailErrorClass').css('display')=='block' || $('.phoneErrorClass').css('display')=='block' || $('.groupTypeErrorClass').css('display')=='block' || $('.locationErrorClass').css('display')=='block')
		{
			return false;
		}
		else
		{
			var form = $('#usersForm')[0]; 
			var data = new FormData(form);
			
			$(this).attr("disabled", true);
			
			var groupType = document.getElementById("groupType");
			var groupTypeTEXT = groupType.options[groupType.selectedIndex].text;
			
			var phoneValue = document.getElementById("phone_code").value + document.getElementById("phone").value;
			
			$.ajax({
				url: '<?php echo $this->Url->build(["controller"=>"Users", "action"=>"register"]); ?>',
				data: data,
				processData: false,
				contentType: false,
				type: 'POST',
				success: function(data)
				{
					$(".ad-users-form").removeClass("active");
					$("#allUsers").html(data);
					$(".btn-panel").removeClass("remove");
					
					//SAVE DATA IN COGNITO
					if($(".hospital_user_id").val()=="")
					{
						name =  document.getElementById("fname").value;	
						email = document.getElementById("email").value;
						phone = phoneValue;
						hospitalID = document.getElementById("hospitalID").value;
						hospitalName = document.getElementById("hospitalName").value;
						subDomain = document.getElementById("subDomain").value;
						groupType = groupTypeTEXT;
						//password = name + "@" + document.getElementById("phone").value;
						password = "Sahil@123";
						
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
							
						});
					}
					//SAVE DATA IN COGNITO
					
					//UPDATE DATA IN COGNITO
					if($(".hospital_user_id").val()!="")
					{
						//CHECK EMAIL PASSWORD FROM COGNITO
						var authenticationData = {
							Username : document.getElementById("email").value,
							Password : document.getElementById("password").value,
						};
						
						var authenticationDetails = new AmazonCognitoIdentity.AuthenticationDetails(authenticationData);
						
						var poolData = {
							UserPoolId : _config.cognito.userPoolId, // Your user pool id here
							ClientId : _config.cognito.clientId, // Your client id here
						};
						
						var userPool = new AmazonCognitoIdentity.CognitoUserPool(poolData);
						
						var userData = {
							Username : document.getElementById("email").value,
							Pool : userPool,
						};
						
						var cognitoUser = new AmazonCognitoIdentity.CognitoUser(userData);
			
						cognitoUser.authenticateUser(authenticationDetails, {
							onSuccess: function (result) {
								var accessToken = result.getAccessToken().getJwtToken();
								//console.log(accessToken);
								
								//CHECK DATA FROM COGNITO
								var getCurrentUser = userPool.getCurrentUser();
								if (getCurrentUser != null) {
									getCurrentUser.getSession(function(err, session) {
										if (err) {
											//alert(err);
											return;
										}
										//console.log('session validity: ' + session.isValid());
										
										var attributeList = [];
										var dataName = {
											Name : 'name', 
											Value : document.getElementById("fname").value, //get from form field
										};
										var dataPhone = {
											Name : 'phone', 
											Value : phoneValue, //get from form field
										};
										var user_role = {
											Name : 'custom:user_role',
											Value : groupTypeTEXT,
										};
										
										var attributePersonalName = new AmazonCognitoIdentity.CognitoUserAttribute(dataName);
										var attributePhone = new AmazonCognitoIdentity.CognitoUserAttribute(dataPhone);
										var attributeUserRole = new AmazonCognitoIdentity.CognitoUserAttribute(user_role);
										
										attributeList.push(dataName);
										//attributeList.push(attributePhone);
										attributeList.push(attributeUserRole);
										 
										cognitoUser.updateAttributes(attributeList, function(err, result) {
											if (err) {
												console.log(err);
												return;
											}
											console.log('call result: ' + result);
										});	
										
									});
								}
								//CHECK DATA FROM COGNITO
							},

							onFailure: function(err) {
								$(".loaderImage").css("display","none");
								$(".loginErrorClass").text(err.message || JSON.stringify(err)).css("display","block");
							},
						});
					}
					//UPDATE DATA IN COGNITO
				}
			});
		}
	});
	
	$("body").on("click",".addUserHTML",function()
	{
		$.ajax({
			url: '<?php echo $this->Url->build(["controller"=>"Users", "action"=>"adduserHtml"]); ?>',
			type: 'POST',
			success: function(data)
			{
				$("#usersForm").html(data);
				$(".ad-users-form").addClass("active");
			}
		});
	});
	
	$("body").on("click",".edit",function()
	{
		$.ajax({
			url: '<?php echo $this->Url->build(["controller"=>"Users", "action"=>"getUserDetails"]); ?>',
			type: 'POST',
			data: {"id":$(this).attr("id")},
			success: function(data)
			{
				$("#usersForm").html(data);
				$(".ad-users-form").addClass("active");
				$(".btn-panel").addClass("remove");
			}
		});
	});
	
	$("body").on("click",".deletePopup",function()
	{
		$(".deleteUser").attr("id",$(this).attr("id"));
	});
	
	$("body").on("click",".deleteUser",function()
	{
		var userID = $(this).attr("id");
		$.ajax({
			url: '<?php echo $this->Url->build(["controller"=>"Users", "action"=>"deleteUser"]); ?>',
			type: 'POST',
			data: {"id":userID},
			success: function(data)
			{
				$("#tr_"+userID).remove();
				$("#myModal"+userID).remove();
				$(".ad-users-form").removeClass("active");
				$(".btn-panel").removeClass("remove");
				if($(".trClass").length==0)
				{
					$("#allUsers").html("<tr><td>No Data Found</td></tr>");
				}
			}
		});
	});

});
</script>
  
</body>