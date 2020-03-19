<!DOCTYPE HTML>
<html lang="en">
<head>
<title>HealthNode | Dashboard</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet">
</head>

<body class="dashboard">
	<!-- HEADER -->
    <?php echo $this->element("header"); ?>
	<!-- HEADER -->
			
	<section class="data-details">
		<!-- LEFT PANEL -->
		<?php echo $this->element("left_panel"); ?>
		<!-- LEFT PANEL -->
				
		<div class="right-cont">
			<div class="click"><span><img src="<?php echo IMAGE_PATH."toggle.png"; ?>"></span></div>
			<section class="upper-form-panel lightblue-bg float-left w-100">
				<ul class="breadcrumb">
					<li><a href="#">Home</a></li>
					<li class="active"><a href="#">dashboard</a></li>
				</ul>
				
				<section class="filter-box">
					<span class="show-tog-btn"></span>
					<section class="panel-top float-left w-100">
						<section class="form-panel float-left w-100">
							<section class="row">
								<div class="col-md-3 col-sm-6 my-1">
									<select class="populationFilter">
										<option value="">All Population</option>
										<option value="1">Male</option>
										<option value="2">Female</option>
									</select>
								</div>
								<div class="col-md-3 col-sm-6 my-1">
									<select class="conditionFilter">
										<option value="">All Chronic Conditions</option>
										<?php
										if(isset($conditionsData) && !empty(conditionsData)) {
										foreach($conditionsData as $key => $value) { ?>
											<option value="<?php echo $value["condition_id"]; ?>"><?php echo $value["condition_name"]; ?></option>
										<?php } } ?>
									</select>
								</div>
								<div class="col-md-3 col-sm-6 my-1">
									<select class="payerFilter">
										<option value="">All Payers</option>
										<option value="1">Medicare</option>
										<option value="2">Commercial</option>
									</select>
								</div>
								<div class="col-md-3 col-sm-6 my-1">
									<select class="providerFilter">
										<option value="">All Providers</option>
										<?php
										if(isset($doctorsData) && !empty(doctorsData)) {
										foreach($doctorsData as $key => $value) { ?>
											<option value="<?php echo $value["hospital_user_id"]; ?>"><?php echo $value["name"]; ?></option>
										<?php } } ?>
									</select>
								</div>
								<div class="col-md-3 col-sm-6 my-1">
									<select class="complianceFilter">
										<option value="">All Compliance Levels</option>
										<option value="1">< 20% </option>
										<option value="2">20-40%</option>
										<option value="3">40-60%</option>
										<option value="4">60-80%</option>
										<option value="5">> 80%</option>
									</select>
								</div>
								<div class="col-md-3 col-sm-6 my-1">
									<!--<input type="text" name="location" placeholder="Location">-->
									<select class="locationFilter">
										<option value="">All Locations</option>
										<?php
										if(isset($locationData) && !empty(locationData)) {
										foreach($locationData as $key => $value) { ?>
											<option value="<?php echo $value["hospital_location_id"]; ?>"><?php echo $value["location_name"].", ".$value["city"]; ?></option>
										<?php } } ?>
									</select>
								</div>
								<div class="col-md-3 col-sm-6 my-1">
									<select class="programDurationFilter">
										<option value="">All Program Duration</option>
										<option value="1">< 15 days</option>
										<option value="2">15-30 days</option>
										<option value="3">30-60 days</option>
										<option value="4">60-90 days</option>
										<option value="5">90-120 days</option>
										<option value="6">120+ days</option> 	
									</select>
								</div>
								<div class="col-md-3 col-sm-6 my-1">
									<select class="alertFilter">
										<option value="">All Alert</option>
										<option value="1">Normal</option>
										<option value="2">Warning</option>
										<option value="3">Emergency</option>
									</select>
								</div>
							</section>
						</section>
					</section>
							
					<section class="panel-bottom float-left w-100">
							<div class="row">
								<div class="col-md-12">
									<label class="sortby float-none d-inline-block align-middle">Sort By:-</label>
									<div class="col-md-3 col-sm-5 float-none d-inline-block align-middle">
										<select class="sortingOrder">
											<option value="">Sort</option>
											<option value="1">Patient Name</option>
											<option value="2">Program Duration</option>
										</select>
									</div>
									<div class="col-md-3 col-sm-5 float-none d-inline-block align-middle">
										<div class="check-item">
											<label class="switch">
												<input type="checkbox" checked="">
												<span class="slider round"></span>
											</label>
											All Time Viewed
										</div>
									</div>
								</div>
							</div>
					</section>
				</section>
			</section>

			<section class="patient-filters">
				<section class="filter-top-cont">
					<section class="col-md-12">
						<h2>Select Active Filters And Apply To Filter The Patients</h2>
						<div class="btn-panel">
							<input type="reset" name="clear" value="Clear All" class="btn btn-secondary clearFilters">
							<input type="submit" name="submit" value="Apply" class="btn btn-primary ml-2 applyFilters">
						</div>
					</section>
				</section>

				<section class="filter-bottom-cont">
					<div class="col-md-12">
						<section class="pagination-panel text-center mb-3">
							<section class="numberofpages text-white records"><?php echo $pageinfo; ?></section>
							<section class="page-links">
								<ul class="pagination mb-0">
									<!--<li class="page-item"><a class="page-link border-left-0 first" href="#" >First</a></li>
									<li class="page-item"><a class="page-link" href="#">Previous</a></li>
									<li class="page-item"><a class="page-link active" href="#">1</a></li>
									<li class="page-item"><a class="page-link" href="#">2</a></li>
									<li class="page-item"><a class="page-link" href="#">3</a></li>
									<li class="page-item"><a class="page-link" href="#">Next</a></li>
									<li class="page-item"><a class="page-link border-right-0 last" href="#">Last</a></li>-->
									<?php echo $this->element("pagination"); ?>
								</ul>
							</section>
							<section class="page-filter">
								<label>Page Size</label>
								<select>
									<option>10</option>
									<option>30</option>
									<option>50</option>
									<option>100</option>
								</select>
							</section>
						</section>

						<section class="patient-filter-list float-left w-100" id="filterData">
							<?php echo $this->element("Dashboard/allpatients"); ?>
						</section>
					</div>
				</section>
			</section>

			<section class="icn-list">
				<ul class="list mb-0">
					<li><span class="icn"><img src="<?php echo IMAGE_PATH."phn-icn.png"; ?>" alt="icn"></span><span class="txt">Phone</span></li>
					<li><span class="icn"><img src="<?php echo IMAGE_PATH."office-icn.png"; ?>" alt="icn"></span><span class="txt">Office Visit Request</span></li>
					<li><span class="icn"><img src="<?php echo IMAGE_PATH."heart-icn.png"; ?>" alt="icn"></span><span class="txt">Heart Rate</span></li>
					<li><span class="icn"><img src="<?php echo IMAGE_PATH."bp-icn.png"; ?>" alt="icn"></span><span class="txt">Blood Pressur</span>e</li>
					<li><span class="icn"><img src="<?php echo IMAGE_PATH."glucose-icn.png"; ?>" alt="icn"></span><span class="txt">Glucose</span></li>
					<li><span class="icn"><img src="<?php echo IMAGE_PATH."cholesterol-icn.png"; ?>" alt="icn"></span><span class="txt">Spo2</span></li>
					<li><span class="icn"><img src="<?php echo IMAGE_PATH."weight-icn.png"; ?>" alt="icn"></span><span class="txt">Weight</span></li>
					<li><span class="icn"><img src="<?php echo IMAGE_PATH."calender-icn.png"; ?>" alt="icn"></span><span class="txt">Calender</span></li>
					<li><span class="icn"><img src="<?php echo IMAGE_PATH."calender-icn.png"; ?>" alt="icn"></span><span class="txt">Reading this month</span></li>
					<li><span class="icn"><img src="<?php echo IMAGE_PATH."check-list-icn.png"; ?>" alt="icn"></span><span class="txt">Phone</span></li>
					<li><span class="icn"><img src="<?php echo IMAGE_PATH."notify-icn.png"; ?>" alt="icn"></span><span class="txt">Reminder</span></li>
				</ul>
			</section>
			
		</div>	
	</section>
  

  
  <!-- The Modal -->
  <div class="modal notes" id="notify">
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


    <!-- The Modal -->
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


	   <!-- The Modal -->
	<div class="modal notes" id="ph-off-request">
		<div class="modal-dialog">
		  <div class="modal-content">
	  
			<!-- Modal Header -->
			<div class="modal-header">
			  <h4 class="modal-title text-uppercase">Confirmation</h4>
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
	  
			<!-- Modal body -->
			<div class="modal-body">
				<h5 class="float-left w-100 mx-y">Do you want to reset this request?</h5>
				<input type="submit" class="btn btn-primary" value="Yes">
				<input type="reset" class="btn btn-primary" value="No">
			</div>
	  
			
		  </div>
		</div>
	  </div>
  


	



<script>
$(document).ready(function(){
	
	var csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;
	
	var bodyGIF = '<?php echo IMAGE_PATH."Preloader_2.gif"; ?>';
	function overlayShow()
	{  
		$('#loading_overlay').show();
		$('#loading_overlay').children().show();
	}
	function overlayHide()
	{
		$('#loading_overlay').hide();
		$('#loading_overlay').children().hide();
	}
	$('body').append('<div id="loading_overlay" style="display:none"><div class="loading_message round_bottom" style="display:none"><img alt="loading" src="'+bodyGIF+'"></div></div>');
	
	setInterval(function()
	{
		$.ajax({
			url: '<?php echo $this->Url->build(["controller"=>"Dashboard", "action"=>"refreshdata"]); ?>',
			type: "POST",
			headers:
			{
				'X-CSRF-Token': csrfToken    
			},
			data: {"populationFilter":$(".populationFilter").val(), "conditionFilter":$(".conditionFilter").val(), "payerFilter":$(".payerFilter").val(), "providerFilter":$(".providerFilter").val(), "complianceFilter":$(".complianceFilter").val(), "locationFilter":$(".locationFilter").val(), "programDurationFilter":$(".programDurationFilter").val(), "alertFilter":$(".alertFilter").val(), "sortingOrder":$(".sortingOrder").val()},
			success: function(data)
			{
				$("#filterData").html(data);
			}
		});
	}, 5000);
	
	setInterval(function()
	{
		$.ajax({
			url: '<?php echo $this->Url->build(["controller"=>"Dashboard", "action"=>"patientdata"]); ?>',
			type: 'POST',
			success: function(data)
			{
			}
		});
	}, 18000);
	
	$("body").on("click",".pagination a",function(e)
	{
		e.preventDefault();
		var href = $(this).attr("href");
		var pieces = href.split("page");
		if(pieces[1]!=undefined)
		{
			var pageNo = '/page'+pieces[1];
		}
		else if(pieces[1]==undefined)
		{
			var pageNo = '';
		}
		
		$.ajax({
			type : 'POST',
			url : 'http://localhost/web-portal/dashboard/applyFilters'+pageNo,
			data : {'pageNo':pageNo},
			dataType : 'json',
			success :function(response)
			{
				pageNo = '';
				if($.trim(response.message) === 'error')
				{   
					var html = '<tr><td colspan="11" align="center">No records Found</td></tr>';
					$('.pagination').hide();
					$('.records').html('');
				}
				else if($.trim(response.message) === 'success')
				{
					$('.pagination').html(response.pagination);
					$('#filterData').html(response.html);
					$('.records').html(response.records);
				   
				}
			}
		});
	});
	
	$("body").on("click",".save",function()
	{
		var patientID = $(this).attr("id");
		
		var form = $('#additionalData')[0]; 
		var data = new FormData(form);
		
		$(".save").prop("disabled",true);
		overlayShow();
		$.ajax({
			url: '<?php echo $this->Url->build(["controller"=>"Dashboard", "action"=>"saveadditionaldetails"]); ?>',
			data: data,
			processData: false,
			contentType: false,
			type: "POST",
			headers:
			{
				'X-CSRF-Token': csrfToken    
			},
			success: function(data)
			{
				$(".save").prop("disabled",false);
				$(".close").trigger("click");
				overlayHide();
				
				var obj = $.parseJSON(data);
				if(obj.notes!="")
				{
					$(".patientNotes_"+patientID).text(obj.notes);
				}
				
				if(obj.doctorName!="")
				{
					$(".patientPlaceholder_"+patientID).attr("placeholder",obj.doctorName);
				}
				else
				{
					$(".patientPlaceholder_"+patientID).attr("placeholder","No Provider Assign");
				}
			}
		});
	});
	
	$("body").on("click",".clearFilters",function()
	{
		location.reload();
	});
	
	$("body").on("click",".applyFilters",function()
	{
		overlayShow();
		$.ajax({
			url: '<?php echo $this->Url->build(["controller"=>"Dashboard", "action"=>"applyFilters"]); ?>',
			type: "POST",
			headers:
			{
				'X-CSRF-Token': csrfToken    
			},
			data: {"populationFilter":$(".populationFilter").val(), "conditionFilter":$(".conditionFilter").val(), "payerFilter":$(".payerFilter").val(), "providerFilter":$(".providerFilter").val(), "complianceFilter":$(".complianceFilter").val(), "locationFilter":$(".locationFilter").val(), "programDurationFilter":$(".programDurationFilter").val(), "alertFilter":$(".alertFilter").val(), "sortingOrder":$(".sortingOrder").val()},
			success: function(data)
			{
				overlayHide();
				$("#filterData").html(data);
			},
			error: function()
			{
				overlayHide();
			}
		});
	});
	
	$("body").on("click",".modalButton",function()
	{
		$(".patient_id").val($(this).attr("id"));
		$(".save").attr("id",$(this).attr("id"));
	});
	
	
  $(".click").click(function(){
    $(".sidebar").toggleClass("intro");
	$(".right-cont").toggleClass("full");
	$(".click").toggleClass("pos");
	$(".breadcrumb").toggleClass("mid");
	$(".upper-cont").toggleClass("mid");
	
  });
});
</script>

<script>
$('#provider').change(function(){
    if($(this).is(":checked")) {
        $('.provider-form').addClass('active');
    } else {
        $('.provider-form').removeClass('active');
    }
});
</script>


<script>
	$('#reminder').change(function(){
		if($(this).is(":checked")) {
			$('.reminder-form').addClass('active');
		} else {
			$('.reminder-form').removeClass('active');
		}
	});
</script>



<script>
	$(document).ready(function(){
			
		// Hide modal on button click
		$("#mark-complete").click(function(){
			$("#notify").modal('hide');
		});
	});
</script>
	

<script>
$(".show-tog-btn").click(function(){
	$(".panel-top ").toggleClass("active");
});

$(".show-tog-btn").click(function(){
	$(".panel-bottom ").toggleClass("active");
});  

$(".show-tog-btn").click(function(){
	$(".show-tog-btn ").toggleClass("active");
});
</script>	





</body>
</html>

