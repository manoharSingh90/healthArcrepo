<ul class="sidebar">		
	<div class="m-left">main</div>
	
	<!-- ADMIN LEFT PANEL -->
	<?php if($this->request->getSession()->read("role_id")==1) { ?>
	<li><a href="<?php echo $this->Url->build(["controller"=>"Dashboard","action"=>"index"]); ?>"><img src="<?php echo IMAGE_PATH."desk.png"; ?>"> Dashboard</a></li>
	<li><a href="<?php echo $this->Url->build(["controller"=>"Chats","action"=>"index"]); ?>"><img src="<?php echo IMAGE_PATH."inbox-icn.png"; ?>"> Inbox</a></li>
	<li><a href="<?php echo $this->Url->build(["controller"=>"Patients","action"=>"listing"]); ?>"><img src="<?php echo IMAGE_PATH."mgmt.png"; ?>"> Patient Management</a></li>
	<li><a href="#"><img src="<?php echo IMAGE_PATH."admin-icn.png"; ?>"> Administration</a>
		<ul class="sub-menu">
			<li><a href="<?php echo $this->Url->build(["controller"=>"Users","action"=>"index"]); ?>">Users</a></li>
			<li><a href="template.html">Template</a></li>
		</ul>
	</li> 
	<?php } ?>
	<!-- ADMIN LEFT PANEL -->
	
	<!-- DOCTOR & NURSE LEFT PANEL -->
	<?php if($this->request->getSession()->read("role_id")==2 || $this->request->getSession()->read("role_id")==3) { ?>
	<li><a href="<?php echo $this->Url->build(["controller"=>"Dashboard","action"=>"index"]); ?>"><img src="<?php echo IMAGE_PATH."desk.png"; ?>"> Dashboard</a></li>
	<li><a href="<?php echo $this->Url->build(["controller"=>"Chats","action"=>"index"]); ?>"><img src="<?php echo IMAGE_PATH."inbox-icn.png"; ?>"> Inbox</a></li>
	<li><a href="<?php echo $this->Url->build(["controller"=>"Patients","action"=>"listing"]); ?>"><img src="<?php echo IMAGE_PATH."mgmt.png"; ?>"> Patient Management</a></li>
	<?php } ?>
	<!-- DOCTOR & NURSE LEFT PANEL -->
	
	<!-- BILLING LEFT PANEL -->
	<?php if($this->request->getSession()->read("role_id")==4) { ?>
	<li><a href="<?php echo $this->Url->build(["controller"=>"Patients","action"=>"listing"]); ?>"><img src="<?php echo IMAGE_PATH."mgmt.png"; ?>"> Patient Management</a></li>
	<?php } ?>
	<!-- BILLING LEFT PANEL -->
</ul>