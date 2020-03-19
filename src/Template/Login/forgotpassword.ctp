
<?php echo $this->Html->script(["awsCognito/amazon-cognito-auth.min.js","awsCognito/amazon-cognito-identity.min.js","awsCognito/config.js"]); ?>

<body id="cover">
	<section class="start login-form-bg">
		<div class="container h-100">
			<div class="row h-100">
			
				<div class="col-xs-12 col-sm-12 col-md-6 h-100">
					<section class="row h-100 justify-content-start align-items-center m-0">
						<div class="portal">
							<a href="#"><img src="<?php echo IMAGE_PATH."HealthArc-Text-Logo-(Coloured).png"; ?>"></a>
							
							<div class="sub-logo">
								<span class="mini"><img src="<?php echo IMAGE_PATH."HealthArc-Logo-Icon-(White).png"; ?>"></span>
								<h1 class="text-uppercase">Welcome to our Provider Portal</h1>
							</span>
							
							</div>
						</div>
					</section>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-6  h-100">
					<section class="row h-100 justify-content-start align-items-center m-0">
						<div class="form login-form verification-form forgot">
						
						<div style="margin:20px;">
							<h6 class="text-purple pb-2">Forgot your Password?</h6>
							<p>Tell us your email address, and we'll get you back on track in no time.</p>
							<label>Email address</label>
							<input autocomplete="off" type="email" name="forgot" id="email" class="email" placeholder="">
							<span class="errorClass emailErrorClass">Field Required</span><br>
							<span class="errorClass cognitoMsg"></span><br>
							<span class="loaderImage" style="display:none; width:55%; left:30px; top:45%; bottom:20%;"><img src="<?php echo IMAGE_PATH."loader.gif"; ?>"></span><br>
							<section class="btn-panel float-left w-100">
								<input type="button" class="btn btn-primary text-uppercase sendButton" value="send" name="send">
							</section>
						</div>
							
						
						</div>
					</section>
				</div>
			</div>
		</div>
	</section>
</body>

<script>
$(document).ready(function()
{
	var csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;
	
	$(document).keypress(function(event){
		var keycode = (event.keyCode ? event.keyCode : event.which);
		if(keycode == '13'){
			$(".sendButton").click();   
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
		}
	});
	
	$("body").on("click",".sendButton",function()
	{
		if($(".email").val()=="")
		{
			$(".email").next(".errorClass").css("display","block");
			$(".emailErrorClass").text("Field Required");
			return false;
		}
		else if(/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/.test($(".email").val()) == false)
		{
			$(".email").next(".errorClass").css("display","block");
			$(".emailErrorClass").text("Enter Valid Email");
			return false;
		}
		else
		{
			$(".email").next(".errorClass").css("display","none");
			$(".loaderImage").css("display","block");
			$.ajax({
				url: '<?php echo $this->Url->build(["controller"=>"Login", "action"=>"checkcognitouser"]); ?>',
				data: {"email":$(".email").val()},
				type: 'POST',
				success: function(data)
				{
					if($.trim(data)==1)
					{
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
						
						cognitoUser.forgotPassword({
							inputVerificationCode() {
								window.location.href = '<?php echo $this->Url->build(["controller"=>"Login", "action"=>"resetpassword"]); ?>';
							}
						});
					}
					else
					{
						$(".cognitoMsg").text("Invalid User").css("display","block");
						$(".loaderImage").css("display","none");
					}
				}
			});
		}
	});
});
</script>

