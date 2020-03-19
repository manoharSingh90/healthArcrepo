<body class="p-manage">
	<!-- HEADER -->
    <?php echo $this->element("header"); ?>
	<!-- HEADER -->
			
	<section class="data-details">
		<!-- LEFT PANEL -->
		<?php echo $this->element("left_panel"); ?>
		<!-- LEFT PANEL -->
				
		<section class="right-cont">
			<div class="click"><span><img src="<?php echo IMAGE_PATH."toggle.png"; ?>"></span></div>
					 
			<section class="patient-management-upr lightblue-bg">
				<ul class="breadcrumb">
					<li><a href="#">Home</a></li>
					<li class="active"><a href="#">Patient Management</a></li>
				</ul>
				<span class="show-tog-btn"></span>
				<section class="patient-filter-box">
					<section class="form-panel">
						<div class="check-panel">
							<input type="checkbox" id="reminder" name="reminder" value="reminder">
							<label class="check-billing">Billing Eligible Only</label>
						</div>

						<ul class="mid-form">
							<li><input type="date"  name="formDate"  data-placeholder="From" required aria-required="true"></li>
							<li><input type="date" name="toDate" id="toDate"  data-placeholder="To" required aria-required="true"></li>
							<li><input type="reset" class="btn btn-secondary" value="Clear All"></li>
							<li><input type="reset" class="btn btn-primary" value="Apply"></li>
						</ul>

						<input type="search" class="search-patient" placeholder="Search by patient name">
					</section>

					<section class="bottom-form-panel">
						<label class="mr-3"> <input type="radio" name="radio" checked="checked"> 99457 <span class="radiobtn"></span></label>
						<label class="mr-3"> <input type="radio" name="radio" checked="checked"> 99457 <span class="radiobtn"></span></label>
						<span class="float-none d-inline-block align-middle mr-3">OR</span>
						<label> <input type="radio" name="radio" checked="checked"> Both <span class="radiobtn"></span></label>
					</section>
					
					<section class="bottom-form-panel">
						<label class="mr-3"> MONITORING STATUS :</label>
						<label class="mr-3"> <input type="radio" value="1" name="is_monitored" checked="checked" class="is_monitored"> Active<span class="radiobtn"></span></label>
						<label class="mr-3"> <input type="radio" value="0" name="is_monitored" class="is_monitored"> Non Active<span class="radiobtn"></span></label>
						<label><input type="radio" name="is_monitored" value="2" class="is_monitored"> Both <span class="radiobtn"></span></label>
					</section>
					
					<section class="bottom-form-panel">
						<label class="mr-3"> USERS :</label>
						<label class="mr-3"> <input type="radio" value="1" name="is_active" checked="checked" class="is_active"> Registered<span class="radiobtn"></span></label>
						<label class="mr-3"> <input type="radio" value="0" name="is_active" class="is_active"> Unregistered<span class="radiobtn"></span></label>
						<label><input type="radio" name="is_active" value="2" class="is_active"> Both <span class="radiobtn"></span></label>
					</section>
				</section>
			</section>
					
			<section class="managment-first lightblue-bg mt-3">
				<div class="upr">
					<h3>Patient Management</h3>
					<div class="btn-panel">
						<a href="#" id="zip" class="btn btn-primary">ZIP Download - All Billable Patients</a>
						<a href="<?php echo $this->Url->build(["controller"=>"Patients","action"=>"index"]); ?>" class="btn btn-primary">Add Patient</a>
					</div>
				</div>
						
				<section class="table-responsive">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>Patient Name <span class="caret"></span></th>
								<th>Notifications <span class="caret"></span></th>
								<th>Health Data</th>
								<th>Time Spent <span class="caret"></span></th>
								<th>Readings This Month</th>
								<th>Billing Eligible Code <span class="caret"></span></th>
								<th>Actions icons</th>
							</tr>
						</thead>
						<tbody id="allPatients" >
							<?php echo $this->element("Patients/allpatients"); ?>
						</tbody>
					</table>
				</section>	  
			</section>

			<section class="pagination-panel float-left w-100 mt-4">
				<ul class="pagination">
					<li class="page-item"><a class="page-link" href="#">Previous</a></li>
					<li class="page-item"><a class="page-link" href="#">1</a></li>
					<li class="page-item"><a class="page-link" href="#">2</a></li>
					<li class="page-item"><a class="page-link" href="#">3</a></li>
					<li class="page-item"><a class="page-link" href="#">Next</a></li>
				</ul>
			</section>
			
		</section>	
	</section>

	
	<!-- The Modal -->
	<div class="modal notes" id="patient-reminder-one">
		<div class="modal-dialog">
		  <div class="modal-content">
	  
			<!-- Modal Header -->
			<div class="modal-header">
			  <h4 class="modal-title text-uppercase">Add Notes</h4>
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
	  
			<!-- Modal body -->
			<div class="modal-body">
				<ul class="form-list">
					
					<li>
						<input type="checkbox" id="reminder" name="reminder" value="reminder" >
						<label class="check">Add Reminder</label class="check">
						
					 </li>
					 <li class="mb-4">
						 
						 <section class="row">
							<div class="col-md-6">
								<form action="/action_page.php">
									
									<span class="date-pick"><input type="date" placeholder="Date" name="bday"></span>
									
								</form>
							</div>
	
							<div class="col-md-6">
								<input type="text" placeholder="Time">
							</div>
							<div class="col-md-12"><textarea class="mt-3" placeholder="Reminder Notes"></textarea></div>
						 </section>
					 </li>
					 <li class="mb-4">
						 <label>Add Extra Time</label>
						 <select  class="w-auto">
							<option value="" disabled="" selected="">Min</option>
							<option>1-30 mins</option>
							<option>2-30 mins</option>
							<option>3-30 mins</option>
							
						 </select>
					 </li>
	
					
					<li>
						<input type="submit" value="Save">
					</li>
				  </ul>
			</div>
	  
			
		  </div>
		</div>
	  </div>

	  <div class="modal notes" id="patient-reminder-two">
		<div class="modal-dialog">
		  <div class="modal-content">
	  
			<!-- Modal Header -->
			<div class="modal-header">
			  <h4 class="modal-title text-uppercase">Reminder</h4>
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
	  
			<!-- Modal body -->
			<div class="modal-body">
			  <div class="upperbody float-left w-100">
				<h3>Due At</h3>
				<p>Date : 05/12/19</p>
				<p>Time : 12:30</p>
			  </div>
			  <div class="upperbody bottombody float-left w-100">
				<h3>Reminder Notes</h3>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
				<div class="btn-panel float-left w-100 mt-3">
					<a href="#" class="btn btn-primary" data-toggle="modal" data-target="#notify-two" data-dismiss="modal">Edit</a>
					<a href="#" id="mark-complete" class="btn btn-primary">Mark Complete</a>
				</div>
			  </div>
	
			</div>
	  
			
	  
		  </div>
		</div>
	  </div>

	  <div class="modal notes" id="notify-two">
		<div class="modal-dialog">
		  <div class="modal-content">
	  
			<!-- Modal Header -->
			<div class="modal-header">
			  <h4 class="modal-title text-uppercase">Reminder</h4>
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
	  
			<!-- Modal body -->
			<div class="modal-body">
				<ul class="form-list">
					
					<li>
						<input type="checkbox" id="reminder" name="reminder" value="reminder" >
						<label class="check">Add Reminder</label class="check">
						
					 </li>
					 <li class="mb-4">
						 
						 <section class="row">
							<div class="col-md-6">
								<form action="/action_page.php">
									
									<span class="date-pick"><input type="date" placeholder="Date" name="bday"></span>
									
								</form>
							</div>
	
							<div class="col-md-6">
								<input type="text" placeholder="Time">
							</div>
							<div class="col-md-12"> <textarea class="mt-3" placeholder="Reminder Notes"></textarea> </div>
						 </section>
					 </li>
					 <li class="mb-4">
						 <label>Add Extra Time</label>
						 <select  class="w-auto">
							<option value="" disabled="" selected="">Min</option>
							<option>1-30 mins</option>
							<option>2-30 mins</option>
							<option>3-30 mins</option>
							
						 </select>
					 </li>
	
					
					<li>
						<input type="submit" value="Save">
					</li>
				  </ul>
			</div>
	  
			
		  </div>
		</div>
	  </div>
	

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

$(".show-tog-btn").click(function(){
	$(".patient-filter-box").toggleClass("active");
});

$(".show-tog-btn").click(function(){
	$(".show-tog-btn ").toggleClass("active");
});

$("body").on("click",".is_monitored",function()
{
	var csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;
	
	$.ajax({
		url: '<?php echo $this->url->build(["controller"=>"Patients", "action"=>"filterPatients"]); ?>',
		type: "POST",
		headers:
		{
			'X-CSRF-Token': csrfToken    
		},
		data: {'is_monitored':$(this).val(), 'is_active':$("input[name='is_active']:checked").val()},
		success: function(data)
		{
			$("#allPatients").html(data);
		}   
	});
});

$("body").on("click",".is_active",function()
{
	var csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;
	
	$.ajax({
		url: '<?php echo $this->url->build(["controller"=>"Patients", "action"=>"filterPatients"]); ?>',
		type: "POST",
		headers:
		{
			'X-CSRF-Token': csrfToken    
		},
		data: {'is_active':$(this).val(), 'is_monitored':$("input[name='is_monitored']:checked").val()},
		success: function(data)
		{
			$("#allPatients").html(data);
		}   
	});
});

$("body").on("click",".resendCode",function()
{
	var csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;
	
	var patientID = $(this).attr("id");
	var mobile = $(this).attr("data-mobile");
	
	$.ajax({
		url: '<?php echo $this->url->build(["controller"=>"Patients", "action"=>"resendCode"]); ?>',
		type: "POST",
		headers:
		{
			'X-CSRF-Token': csrfToken    
		},
		data: {'patient_id':patientID, 'mobile':mobile},
		success: function(data)
		{
			$(".codeSent_"+patientID).show().delay(1000).fadeOut();
		}
	});
});

</script>

</body>

