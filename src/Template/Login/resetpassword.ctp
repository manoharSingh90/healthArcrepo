
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
					<h2>CHANGE PASSWORD</h2>
					<form>
						<input autocomplete="off" type="hidden" name="email" class="email" id="email">
						<div class="label">Verification Code<span class="starClass"> *</span></div>
						<input autocomplete="off" type="text" name="verificationcode" class="verificationcode" id="verificationcode">
						<span class="errorClass verificationCodeErrorClass">Field Required</span>
						<br>
						<div class="label">Password<span class="starClass"> *</span></div>
						<input autocomplete="off" type="password" name="password" class="password" id="password">
						<span class="errorClass passwordErrorClass">Field Required</span>
						<br>
						<div class="label">Confirm Password<span class="starClass"> *</span></div>
						<input autocomplete="off" type="password" name="confirmpassword" class="confirmpassword" id="confirmpassword">
						<span class="errorClass confirmPasswordErrorClass">Field Required</span>
						<br><br>
						<span class="errorClass cognitoMsg"></span>
						<span class="loaderImage" style="display:none; width:55%; left:45px; top:54%; bottom:20%;"><img src="<?php echo IMAGE_PATH."loader.gif"; ?>"></span><br>
						<span class="msgClass" style="display:none; color:green;">Verification Code has been sent to <p class="insertEmail"></p></span><br>
						<input type="button" name="submit" value="Submit" class="checkValidation">
					</form>
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
	
	$(".email").val('<?php echo $this->request->getSession()->read("email") ?>');
	$(".insertEmail").text('<?php echo $this->request->getSession()->read("email") ?>');
	$(".msgClass").show().delay(3000).fadeOut();
	
	$(document).keypress(function(event){
		var keycode = (event.keyCode ? event.keyCode : event.which);
		if(keycode == '13'){
			$(".checkValidation").click();   
		}
	});
	
	$("body").on("blur",".verificationcode",function()
	{
		$(".verificationCodeErrorClass").css("display","none");
	});
	
	$("body").on("blur",".password",function()
	{
		$(".passwordErrorClass").css("display","none");
		
		if($(this).val()!="")
		{
			var regex = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,15}$/;
			if(regex.test($(this).val()) == false)
			{
				$(".passwordErrorClass").text("Password should contain atleast one lower case, atleast one upper case, atleast one digit, atleast 8 from the mentioned characters").css("display","block");
				return false;
			}
			else
			{
				$(".passwordErrorClass").css("display","none");
			}
		}
	});
	
	$("body").on("blur",".confirmpassword",function()
	{
		$(".confirmPasswordErrorClass").css("display","none");
		
		if($(this).val()!="")
		{
			if($(this).val()!=$(".password").val())
			{
				$(".confirmPasswordErrorClass").text("Password not match").css("display","block");
			}
			else
			{
				$(".confirmPasswordErrorClass").css("display","none");
			}
		}
	});
	
	$("body").on("click",".checkValidation",function()
	{
		if($(".verificationcode").val()=="")
		{
			$(".verificationCodeErrorClass").css("display","block");
		}
		else
		{
			$(".verificationCodeErrorClass").css("display","none");
		}
		
		if($(".password").val()=="")
		{
			$(".passwordErrorClass").text("Field Required").css("display","block");
		}
		else if(/^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,15}$/.test($(".password").val()) == false)
		{
			$(".passwordErrorClass").text("Password should contain atleast one lower case, atleast one upper case, atleast one digit, atleast 8 from the mentioned characters").css("display","block");
		}
		else
		{
			$(".passwordErrorClass").css("display","none");
		}
		
		if($(".confirmpassword").val()=="")
		{
			$(".confirmPasswordErrorClass").css("display","block");
		}
		else if($(".confirmpassword").val()!=$(".password").val())
		{
			$(".confirmPasswordErrorClass").text("Password not match").css("display","block");
		}
		else
		{
			$(".confirmPasswordErrorClass").css("display","none");
		}
		
		if($('.verificationCodeErrorClass').css('display')=='block' || $('.passwordErrorClass').css('display')=='block' || $('.confirmPasswordErrorClass').css('display')=='block')
		{
			return false;
		}
		else
		{
			$(".loaderImage").css("display","block");
			
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
			
			//cognitoUser.confirmPassword($(".verificationcode").val(), "Abcde@123", this);
			
			cognitoUser.confirmPassword($(".verificationcode").val(), $(".password").val(), {
			onSuccess: (result) => {
				
				$(".msgClass").text("Password successfully changed").css("display","block");
				
				$.ajax({
					url: '<?php echo $this->Url->build(["controller"=>"Login", "action"=>"updatepasswordfield"]); ?>',
					data: {"email":$(".email").val(), "password":$(".password").val()},
					type: 'POST',
					success: function(data)
					{
						$(".loaderImage").css("display","none");
						window.location.href = '<?php echo $this->Url->build(["controller"=>"Login", "action"=>"index"]); ?>';
					}
				});
			},
			onFailure: (err) => {
				$(".cognitoMsg").text(err.message || JSON.stringify(err)).css("display","block");
				$(".loaderImage").css("display","none");
			}
			});
			
		}
	});
});
</script>

</body>

