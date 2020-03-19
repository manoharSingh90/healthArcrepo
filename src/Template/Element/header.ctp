<header>
	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-12 col-sm-3 col-md-3">
				<a href="javaScript:void(0)">
					<!-- LOGO IMAGE -->
					<img src="<?php echo $this->request->getSession()->read("hospital_logo_url") && !empty($this->request->getSession()->read("hospital_logo_url")) ? ADMIN_PATH."/".$this->request->getSession()->read("hospital_logo_url") : IMAGE_PATH."HealthArc-Logo-Icon-(White).png"; ?>" style="max-height:50px; max-width:30%; margin:10px;">
					
					<!-- HOSPITAL NAME -->
					<?php if($this->request->getSession()->read("hospital_name") && !empty($this->request->getSession()->read("hospital_name"))) { ?>
						<!--<div class="d-inline" style="color:#ffffff; font-size:40px;" ><?php echo $this->request->getSession()->read("hospital_name"); ?></div>-->
					<?php }
					else { ?>
						<!--<img src="<?php echo IMAGE_PATH."HealthArc-Text-Logo-(White).png"; ?>" style="max-width:50%;">-->
					<?php } ?>
				</a>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-9">
				<div class="btn-grp">
					<a class="help" href="javaScript:void(0)"><img src="<?php echo IMAGE_PATH."que.png"; ?>">  help</a>
					<a class="mine" href="javaScript:void(0)"><img src="<?php echo IMAGE_PATH."user.png"; ?>">Hello <?php echo $this->request->getSession()->read("fname") ? $this->request->getSession()->read("fname") : ""; ?></a>
					<a class="mine" href="<?php echo $this->Url->build(["controller"=>"Login","action"=>"logout"]); ?>">Logout</a>
				</div>
			</div>
		</div>
	</div>
</header>