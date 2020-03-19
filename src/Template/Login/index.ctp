
<?php echo $this->Html->script(["awsCognito/amazon-cognito-auth.min.js","awsCognito/amazon-cognito-identity.min.js","awsCognito/config.js"]); ?>

<body id="cover">
<section class="start login-form-bg">
	<div class="container h-100">
		<div class="row h-100">
			<div class="col-xs-12 col-sm-12 col-md-6 h-100">
				<section class="row h-100 justify-content-start align-items-center m-0">
					<div class="portal">
						<a href="javaScript:void(0)"><img src="<?php echo IMAGE_PATH."HealthArc-Text-Logo-(Coloured).png"; ?>"></a>
						
						<div class="sub-logo">
							<span class="mini"><img src="<?php echo IMAGE_PATH."HealthArc-Logo-Icon-(White).png"; ?>"></span>
							<h1 class="text-uppercase">Welcome to our Provider Portal</h1>
						</span>
						
						</div>
					</div>
				</section>
			</div>
		
			<div class="col-xs-12 col-sm-12 col-md-6 h-100">
				<section class="row h-100 justify-content-start align-items-center m-0">
					<div class="form login-form">
					<h2>LOG IN</h2>
					<form id="loginForm">
						<div class="label">Email<span class="starClass"> *</span></div>
						<input autocomplete="off" type="text" name="email" class="email" id="email" value="<?php echo isset($_COOKIE["email"]) ? $_COOKIE["email"] : ""; ?>">
						<span class="errorClass emailErrorClass">Field Required</span>
						<br>
						<div class="label">Password<span class="starClass"> *</span></div>
						<input autocomplete="off" type="password" name="password" class="password" id="password">
						<span class="errorClass passwordErrorClass">Field Required</span>
						<br><br>
						<div class="position-relative d-inline-block w-100">
						<span class="loaderImage" style="display:none;"><img src="<?php echo IMAGE_PATH."loader.gif"; ?>"></span><br>
						<input type="button" name="login" value="log in" class="checkValidation">
						<span class="errorClass loginErrorClass"></span><br>
						</div>
						<label class="contain">remember me
							<input type="checkbox" name="remember_me" class="remember_me" value="1" <?php echo isset($_COOKIE["remember_me"]) ? "checked" : ""; ?>>
							<span class="checkmark"></span>
						</label>
						<a href="<?php echo $this->Url->build(["controller" => "Login", "action" => "forgotpassword"]); ?>" class="forgot">forget password</a>
					</form>

						<section class="login-description float-left w-100">
							<p>By using this service, or permitting any other person or other entity to use this service on your behalf, you acknowledge that you have read these <a href="javaScript:void(0)">Terms & Conditions</a> and that you accept and will bound by the terms thereof</p>
						</section>
					</div>
				</section>
			</div>
		</div>
	</div>
</section>

<script>
$(document).ready(function()
{
	var csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;
	
	$(document).keypress(function(event){
		var keycode = (event.keyCode ? event.keyCode : event.which);
		if(keycode == '13'){
			$(".checkValidation").click();   
		}
	});
	
	$("body").on("blur",".password",function()
	{
		$(this).next(".errorClass").css("display","none");
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
		}
	});
	
	$("body").on("click",".checkValidation",function()
	{
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
		
		if($(".password").val()=="")
		{
			$(".password").next(".errorClass").css("display","block");
		}
		else
		{
			$(".password").next(".errorClass").css("display","none");
		}
		
		if($('.emailErrorClass').css('display')=='block' || $('.passwordErrorClass').css('display')=='block')
		{
			return false;
		}
		else
		{
			$(".loaderImage").css("display","block");
			
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
							
							getCurrentUser.getUserAttributes(function(err, result) {
								if (err) {
									$(".loaderImage").css("display","none");
									$(".loginErrorClass").text(err.message || JSON.stringify(err)).css("display","block");
									//console.log(err);
									return;
								}
								
								$.ajax({
									url: '<?php echo $this->Url->build(["controller"=>"Login", "action"=>"checklogin"]); ?>',
									data: {"sub_domain":result[2].getValue(), "hospital_id":result[5].getValue(), "email":result[7].getValue(), "remember_me":$(".remember_me").val()},
									type: 'POST',
									success: function(data)
									{
										$(".loaderImage").css("display","none");
										var obj = $.parseJSON(data);
										if(obj.is_active==0)
										{
											$(".loaderImage").css("display","none");
											$(".loginErrorClass").text("User not active").css("display","block");
										}
										else if(obj.is_password_changed==0)
										{
											cognitoUser.forgotPassword({
												inputVerificationCode() {
												}
											});
											window.location.href = '<?php echo $this->Url->build(["controller"=>"Login", "action"=>"resetpassword"]); ?>';
										}
										else if(obj.role_id==1)
										{
											$(".loginErrorClass").css("display","none");
											window.location.href = '<?php echo $this->Url->build(["controller"=>"Users", "action"=>"index"]); ?>';
										}
										else if(obj.role_id==2 || obj.role_id==3 || obj.role_id==4)
										{
											window.location.href = '<?php echo $this->Url->build(["controller"=>"Patients", "action"=>"listing"]); ?>';
										}
										else
										{
											$(".loaderImage").css("display","none");
											$(".loginErrorClass").text("Invalid Details").css("display","block");
										}
									}
								});
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
			
			/* var form = $('#loginForm')[0]; 
			var data = new FormData(form);

			$.ajax({
				url: '<?php echo $this->Url->build(["controller"=>"Login", "action"=>"checklogin"]); ?>',
				data: data,
				processData: false,
				contentType: false,
				type: 'POST',
				success: function(data)
				{
					if(data==1)
					{
						$(".loginErrorClass").css("display","none");
						window.location.href = '<?php echo $this->Url->build(["controller"=>"Users", "action"=>"index"]); ?>';
					}
					else if(data==2 || data==3 || data==4)
					{
						window.location.href = '<?php echo $this->Url->build(["controller"=>"Patients", "action"=>"listing"]); ?>';
					}
					else
					{
						$(".loginErrorClass").css("display","block");
					}
				}
			}); */
			//CHECK EMAIL PASSWORD FROM COGNITO
		}
	});
});
</script>

</body>

