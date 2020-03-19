<!DOCTYPE HTML>
<html lang="en">
<head>
<title>Patient-list-view | Healthnode</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet">

<?php
echo $this->Html->css(["patient/fullcalendar"]);
echo $this->Html->script(["patient/jquery-1.10.2.js","patient/jquery-ui.custom.min.js","patient/fullcalendar.js"]);
?>

<style>
  .tab-pane {  display: block !important;}
 </style>
 <script>
 
   $(document).ready(function() {
       var date = new Date();
     var d = date.getDate();
     var m = date.getMonth();
     var y = date.getFullYear();
 
     /*  className colors
 
     className: default(transparent), important(red), chill(pink), success(green), info(blue)
 
     */
 
 
     /* initialize the external events
     -----------------------------------------------------------------*/
 
     $('#external-events div.external-event').each(function() {
 
       // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
       // it doesn't need to have a start or end
       var eventObject = {
         title: $.trim($(this).text()) // use the element's text as the event title
       };
 
       // store the Event Object in the DOM element so we can get to it later
       $(this).data('eventObject', eventObject);
 
       // make the event draggable using jQuery UI
       $(this).draggable({
         zIndex: 999,
         revert: true,      // will cause the event to go back to its
         revertDuration: 0  //  original position after the drag
       });
 
     });
 
 
     /* initialize the calendar
     -----------------------------------------------------------------*/
 
     var calendar =  $('#calendar').fullCalendar({
       header: {
         left: 'title',
         center: 'agendaDay,agendaWeek,month',
         right: 'prev,next today'
       },
       editable: true,
       firstDay: 0, //  1(Monday) this can be changed to 0(Sunday) for the USA system
       selectable: true,
       defaultView: 'month',
 
       axisFormat: 'h:mm',
       columnFormat: {
                 month: 'ddd',    // Mon
                 week: 'ddd d', // Mon 7
                 day: 'dddd M/d',  // Monday 9/7
                 agendaDay: 'dddd d'
             },
             titleFormat: {
                 month: 'MMMM yyyy', // September 2009
                 week: "MMMM yyyy", // September 2009
                 day: 'MMMM yyyy'                  // Tuesday, Sep 8, 2009
             },
       allDaySlot: false,
       selectHelper: true,
       select: function(start, end, allDay) {
         var title = prompt('Event Title:');
         if (title) {
           calendar.fullCalendar('renderEvent',
             {
               title: title,
               start: start,
               end: end,
               allDay: allDay
             },
             true // make the event "stick"
           );
         }
         calendar.fullCalendar('unselect');
       },
       droppable: true, // this allows things to be dropped onto the calendar !!!
       drop: function(date, allDay) { // this function is called when something is dropped
 
         // retrieve the dropped element's stored Event Object
         var originalEventObject = $(this).data('eventObject');
 
         // we need to copy it, so that multiple events don't have a reference to the same object
         var copiedEventObject = $.extend({}, originalEventObject);
 
         // assign it the date that was reported
         copiedEventObject.start = date;
         copiedEventObject.allDay = allDay;
 
         // render the event on the calendar
         // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
         $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);
 
         // is the "remove after drop" checkbox checked?
         if ($('#drop-remove').is(':checked')) {
           // if so, remove the element from the "Draggable Events" list
           $(this).remove();
         }
 
       },
 
       
     });
     
     var calendar =  $('#calendar-one').fullCalendar({
       header: {
         left: 'title',
         center: 'agendaDay,agendaWeek,month',
         right: 'prev,next today'
       },
       editable: true,
       firstDay: 0, //  1(Monday) this can be changed to 0(Sunday) for the USA system
       selectable: true,
       defaultView: 'month',
 
       axisFormat: 'h:mm',
       columnFormat: {
                 month: 'ddd',    // Mon
                 week: 'ddd d', // Mon 7
                 day: 'dddd M/d',  // Monday 9/7
                 agendaDay: 'dddd d'
             },
             titleFormat: {
                 month: 'MMMM yyyy', // September 2009
                 week: "MMMM yyyy", // September 2009
                 day: 'MMMM yyyy'                  // Tuesday, Sep 8, 2009
             },
       allDaySlot: false,
       selectHelper: true,
       select: function(start, end, allDay) {
         var title = prompt('Event Title:');
         if (title) {
           calendar.fullCalendar('renderEvent',
             {
               title: title,
               start: start,
               end: end,
               allDay: allDay
             },
             true // make the event "stick"
           );
         }
         calendar.fullCalendar('unselect');
       },
       droppable: true, // this allows things to be dropped onto the calendar !!!
       drop: function(date, allDay) { // this function is called when something is dropped
 
         // retrieve the dropped element's stored Event Object
         var originalEventObject = $(this).data('eventObject');
 
         // we need to copy it, so that multiple events don't have a reference to the same object
         var copiedEventObject = $.extend({}, originalEventObject);
 
         // assign it the date that was reported
         copiedEventObject.start = date;
         copiedEventObject.allDay = allDay;
 
         // render the event on the calendar
         // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
         $('#calendar-one').fullCalendar('renderEvent', copiedEventObject, true);
 
         // is the "remove after drop" checkbox checked?
         if ($('#drop-remove').is(':checked')) {
           // if so, remove the element from the "Draggable Events" list
           $(this).remove();
         }
 
       },
 
       
     });
     
     var calendar =  $('#calendar-two').fullCalendar({
       header: {
         left: 'title',
         center: 'agendaDay,agendaWeek,month',
         right: 'prev,next today'
       },
       editable: true,
       firstDay: 0, //  1(Monday) this can be changed to 0(Sunday) for the USA system
       selectable: true,
       defaultView: 'month',
 
       axisFormat: 'h:mm',
       columnFormat: {
                 month: 'ddd',    // Mon
                 week: 'ddd d', // Mon 7
                 day: 'dddd M/d',  // Monday 9/7
                 agendaDay: 'dddd d'
             },
             titleFormat: {
                 month: 'MMMM yyyy', // September 2009
                 week: "MMMM yyyy", // September 2009
                 day: 'MMMM yyyy'                  // Tuesday, Sep 8, 2009
             },
       allDaySlot: false,
       selectHelper: true,
       select: function(start, end, allDay) {
         var title = prompt('Event Title:');
         if (title) {
           calendar.fullCalendar('renderEvent',
             {
               title: title,
               start: start,
               end: end,
               allDay: allDay
             },
             true // make the event "stick"
           );
         }
         calendar.fullCalendar('unselect');
       },
       droppable: true, // this allows things to be dropped onto the calendar !!!
       drop: function(date, allDay) { // this function is called when something is dropped
 
         // retrieve the dropped element's stored Event Object
         var originalEventObject = $(this).data('eventObject');
 
         // we need to copy it, so that multiple events don't have a reference to the same object
         var copiedEventObject = $.extend({}, originalEventObject);
 
         // assign it the date that was reported
         copiedEventObject.start = date;
         copiedEventObject.allDay = allDay;
 
         // render the event on the calendar
         // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
         $('#calendar-two').fullCalendar('renderEvent', copiedEventObject, true);
 
         // is the "remove after drop" checkbox checked?
         if ($('#drop-remove').is(':checked')) {
           // if so, remove the element from the "Draggable Events" list
           $(this).remove();
         }
 
       },
 
       
     });
     
     var calendar =  $('#calendar-three').fullCalendar({
       header: {
         left: 'title',
         center: 'agendaDay,agendaWeek,month',
         right: 'prev,next today'
       },
       editable: true,
       firstDay: 0, //  1(Monday) this can be changed to 0(Sunday) for the USA system
       selectable: true,
       defaultView: 'month',
 
       axisFormat: 'h:mm',
       columnFormat: {
                 month: 'ddd',    // Mon
                 week: 'ddd d', // Mon 7
                 day: 'dddd M/d',  // Monday 9/7
                 agendaDay: 'dddd d'
             },
             titleFormat: {
                 month: 'MMMM yyyy', // September 2009
                 week: "MMMM yyyy", // September 2009
                 day: 'MMMM yyyy'                  // Tuesday, Sep 8, 2009
             },
       allDaySlot: false,
       selectHelper: true,
       select: function(start, end, allDay) {
         var title = prompt('Event Title:');
         if (title) {
           calendar.fullCalendar('renderEvent',
             {
               title: title,
               start: start,
               end: end,
               allDay: allDay
             },
             true // make the event "stick"
           );
         }
         calendar.fullCalendar('unselect');
       },
       droppable: true, // this allows things to be dropped onto the calendar !!!
       drop: function(date, allDay) { // this function is called when something is dropped
 
         // retrieve the dropped element's stored Event Object
         var originalEventObject = $(this).data('eventObject');
 
         // we need to copy it, so that multiple events don't have a reference to the same object
         var copiedEventObject = $.extend({}, originalEventObject);
 
         // assign it the date that was reported
         copiedEventObject.start = date;
         copiedEventObject.allDay = allDay;
 
         // render the event on the calendar
         // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
         $('#calendar-three').fullCalendar('renderEvent', copiedEventObject, true);
 
         // is the "remove after drop" checkbox checked?
         if ($('#drop-remove').is(':checked')) {
           // if so, remove the element from the "Draggable Events" list
           $(this).remove();
         }
 
       },
 
       
     });
 
 
   });
 
 </script>


</head>

<body>
  <!-- HEADER -->
    <?php echo $this->element("header"); ?>
  <!-- HEADER -->

    <section class="data-details">
        <!-- LEFT PANEL -->
    <?php echo $this->element("left_panel"); ?>
    <!-- LEFT PANEL -->

        <section class="right-cont patient-list-view-bx">
            <div class="click"><span><img src="<?php echo IMAGE_PATH."toggle.png"; ?>"></span></div>
            <section class="patient-list-view">
        <ul class="breadcrumb">
          <li><a href="#">Patient Dashboard</a></li>
          <li><a href="#">Patient Details</a></li>
          <li class="active"><a href="#"> <?php if(isset($patientsData[0]['name'])) echo $patientsData[0]['name'];?></a></li>
                </ul>
                <section class="view float-left w-100 mt-5">
                    <a href="#" class="btn btn-primary btn-patient-date">Download Patient Data</a>
                    <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" data-toggle="tab" href="#patient-detail">Patient Detail</a>
            </li>
                        <li class="nav-item">
              <a class="nav-link " data-toggle="tab" href="#home">Pulse Oximeter</a>
                        </li>
                        <li class="nav-item">
              <a class="nav-link" data-toggle="tab" href="#menu1">Body Weight</a>
                        </li>
                        <li class="nav-item">
              <a class="nav-link" data-toggle="tab" href="#menu2">Glucose</a>
                        </li>
                        <li class="nav-item">
              <a class="nav-link" data-toggle="tab" href="#menu3">Blood Pressure</a>
            </li>
          </ul>
                    
          <div class="tab-content float-left w-100 lightblue-bg p-4">
            <div id="patient-detail" class="tab-pane fade  active show">
              <section class="patient-details float-left w-100 mt-0">
                <div class="tab-content float-left w-100 lightblue-bg p-4">
                  <div class="bg-wite float-left w-100 bg-white p-4 mb-4">
                     <div class="row ">
                       <div class="col-md-4">
                        <img src="<?php echo isset($patientsData[0]['image_url']) && $patientsData[0]['image_url']!='' ? 'j' : IMAGE_PATH.'default_profile.png'; ?>" alt="profile" class="float-left  mr-2">
                         <p class="blue pb-1 pt-1"><?php if(isset($patientsData[0]['name'])) echo $patientsData[0]['name'];?> </p><?php
                          $currentYear = date("Y");
                          $dob = isset($patientsData[0]["dob"]) && !empty($patientsData[0]["dob"]) ? explode("/",date("d/m/Y",strtotime($patientsData[0]["dob"]))) : "";
                          ?>
                         <p><?php echo !empty($dob) ? $dob[0]."/".$dob[1]."/".$dob[2] : ""; ?> <?php echo ($currentYear - $dob[2])==0 ? "" : "(".($currentYear - $dob[2]).")" ; ?><br> <?php if(isset($patientsData[0]['mrn_no'])) echo $patientsData[0]['mrn_no'];?> </p>
                       </div>
                       <div class="col-md-4">
                         <div class="mdl pt-2">
                           <p>Chronic Conditions: <?php if(isset($patientsData[0]['condition_name'])) echo $patientsData[0]['condition_name'];?><br>Email: <a href="#"><?php if(isset($patientsData[0]['email'])) echo $patientsData[0]['email'];?></a> <br>Phone: <?php if(isset($patientsData[0]['mobile'])) echo $patientsData[0]['mobile'];?></p>
                         </div>
                       </div>
                       <div class="col-md-4">
                         <div class="lst">
                           <p class="top pb-2">Provider: <?php if(isset($patientsData[0]['prviderName'])) echo $patientsData[0]['prviderName'];?><br>Provider Phone: <?php if(isset($patientsData[0]['prviderPhone'])) echo $patientsData[0]['prviderPhone'];?></p>
                           <p class="botom">Caregiver: <?php if(isset($patientsData[0]['caregiverName'])) echo $patientsData[0]['caregiverName'];?> <br>Caregiver: Phone: <?php if(isset($patientsData[0]['caregiverPhone'])) echo $patientsData[0]['caregiverPhone'];?></p>
                         </div>
                       </div>
                     </div>
                  </div>
       
                  <div class="main-betwen">
                    <div class="row">
                      <div class="col-md-9">
                        <div class="main-betwen-lft mb-4">
                          <h4>Previous Notes</h4>
                          <ul class="ryt">
                             <?php echo $this->element("Patients/allpatientNotes"); ?>
                          </ul>
                        </div>
                        <div class="note-list">
                          <h4>Notes</h4>
                          <div class="note-pragh">
                            <textarea id="notes"></textarea>
                            <span class="errorClass notesErrorClass">Field Required</span>
                            <a href="javaScript:void(0)" class="btn-primary rounded mt-4" id="addNotes">Add Notes</a>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-3 right">
                           <h5>Patient Care Plan</h5>
                           <ul class="ryt-bar">
                              <?php 
                               $vitalBp=array();if($patientVitalsData):foreach($patientVitalsData as $vitals):
                               echo  "<li>".$vitals[0]['vitalmaster']['vital_name'].":<br>";
                                if($vitals[0]['vital_id']=='1'):
                                echo "SYS Normal: ".$vitals[0]['normal_max']."/".$vitals[0]['normal_min']."<br> Diastolic Normal: ".$vitals[1]['normal_max']."/".$vitals[1]['normal_min']."<br>SYS Warning: ".$vitals[0]['warning_max']."/".$vitals[0]['warning_min']."<br>Diastolic Warning: ".$vitals[1]['warning_max']."/".$vitals[1]['warning_min']."<br>SYS Emergency: ".$vitals[0]['emergency_max']."/".$vitals[0]['emergency_min']."<br> Diastolic Emergency: ".$vitals[1]['emergency_max']."/".$vitals[1]['emergency_min']."<br></li>"; 
                                else :
                                echo "Normal: ".$vitals[0]['normal_max']."/".$vitals[0]['normal_min']."<br>"."Warning: ".$vitals[0]['warning_max']."/".$vitals[0]['warning_min']."<br>Emegency: ".$vitals[0]['emergency_max']."/".$vitals[0]['emergency_min']."<br></li>";
                                endif;
                                echo "<li>Interventions:<br>".$vitals[0]['intervention_notes']."</li>";
                                endforeach;endif;?>

                               <li>Payer:<br> <?=$patientsData[0]['payer_type']?><br> <?=$patientsData[0]['payer_details']?></li>
                               <li>Device Provided:
                               <?php if($patientDeviceData):
                               foreach($patientDeviceData as $devices): ?> 
                               <br> <?=$devices['devicemaster']['device_model']?>  Sr. No. <?=$devices['serial_no']?>
                               <?php  endforeach;
                               endif;?>
                               </li>
                           </ul>
                       </div>
                    </div>
                  </div>
                </div>
              </section>
            </div>

            <div id="home" class="tab-pane fade m-width-1200">
              <section class="btn-panel float-right w-100 text-right">
                <a href="pulse-oximeter-graph-view.html" class="btn btn-primary">Graph View</a>
              </section>
              <section class="row">
                <section class="col-md-4">
                  <section class="images float-left w-100">
                    <div id='wrap'>
                      <div id='calendar'></div>
                    </div>
                    </section>
                    <section class="summery-list mt-3 bg-white">
                        <h4>Summary</h4>
                        <ul>
                          <li class="mb-3"><span class="float-left">In Last 30 Days</span> <span class="float-right">29</span></li>
                          <li><span class="float-left">>2019</span> <span class="float-right">1500</span></li>
                          <li><span class="float-left">>2018</span> <span class="float-right">1500</span></li>
                          <li><span class="float-left">>2017</span> <span class="float-right">1500</span></li>
                          <li><span class="float-left">>2016</span> <span class="float-right">1500</span></li>
                          <li><span class="float-left">>2015</span> <span class="float-right">1500</span></li>
                          <li><span class="float-left">>2014</span> <span class="float-right">1500</span></li>
                        </ul>
                    </section>
                </section>
                <section class="col-md-8 pl-5">
                  <span class="meter-img"><img class="w-100" src="<?php echo IMAGE_PATH."meter.png"; ?>" alt="meter"></span>
                    <section class="table-responsive">
                      <table class="table bg-white graph-table">
                        <thead>
                        <tr>
                          <th>Reading Time</th>
                          <th>Remote</th>
                          <th>SpO2</th>
                          <th>Pulse Rate</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                          <td>2019-11-05 13:20</td>
                          <td>-</td>
                          <td>92%</td>
                          <td>89</td>
                        </tr>
                        <tr>
                          <td>2019-11-05 13:20</td>
                          <td>-</td>
                          <td>86%</td>
                          <td>56</td>
                        </tr>
                        <tr>
                          <td>2019-11-05 13:20</td>
                          <td>-</td>
                          <td>86%</td>
                          <td>56</td>
                        </tr>
                        <tr>
                          <td>2019-11-05 13:20</td>
                          <td>-</td>
                          <td>86%</td>
                          <td>56</td>
                        </tr>
                        <tr>
                          <td>2019-11-05 13:20</td>
                          <td>-</td>
                          <td>86%</td>
                          <td>56</td>
                        </tr>
                        <tr>
                          <td>2019-11-05 13:20</td>
                          <td>-</td>
                          <td>86%</td>
                          <td>56</td>
                        </tr>
                      </tbody>
                    </table>
                  </section>
                </section>
              </section>
          </div>

          <div id="menu1" class="tab-pane fade m-width-1200">
              <section class="btn-panel float-right w-100 text-right">
                <a href="body-weight-graph-view.html" class="btn btn-primary">Graph View</a>
              </section>
              
              <section class="row">
                <section class="col-md-4">
                  <section class="images float-left w-100">
                    <div id='wrap'>
                      <div id='calendar-one'></div>
                    </div>
                  </section>
                  <section class="summery-list mt-3 bg-white">
                    <h4>Summary</h4>
                    <ul>
                      <li class="mb-3"><span class="float-left">In Last 30 Days</span> <span class="float-right">29</span></li>
                      <li><span class="float-left">>2019</span> <span class="float-right">1500</span></li>
                      <li><span class="float-left">>2018</span> <span class="float-right">1500</span></li>
                      <li><span class="float-left">>2017</span> <span class="float-right">1500</span></li>
                      <li><span class="float-left">>2016</span> <span class="float-right">1500</span></li>
                      <li><span class="float-left">>2015</span> <span class="float-right">1500</span></li>
                      <li><span class="float-left">>2014</span> <span class="float-right">1500</span></li>
                    </ul>
                  </section>
                </section>
                <section class="col-md-8 pl-5">
                  <span class="meter-img"><img class="w-100" src="<?php echo IMAGE_PATH."meter.png"; ?>" alt="meter"></span>

                  <section class="table-responsive">
                    <table class="table bg-white graph-table">
                      <thead>
                        <tr>
                        <th>Reading Time</th>
                        <th>Remote</th>
                        <th>SpO2</th>
                        <th>Pulse Rate</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                        <td>2019-11-05 13:20</td>
                        <td>-</td>
                        <td>92%</td>
                        <td>89</td>
                        </tr>
                        <tr>
                        <td>2019-11-05 13:20</td>
                        <td>-</td>
                        <td>86%</td>
                        <td>56</td>
                        </tr>
                        <tr>
                        <td>2019-11-05 13:20</td>
                        <td>-</td>
                        <td>86%</td>
                        <td>56</td>
                        </tr>
                        <tr>
                        <td>2019-11-05 13:20</td>
                        <td>-</td>
                        <td>86%</td>
                        <td>56</td>
                        </tr>
                        <tr>
                        <td>2019-11-05 13:20</td>
                        <td>-</td>
                        <td>86%</td>
                        <td>56</td>
                        </tr>
                        <tr>
                        <td>2019-11-05 13:20</td>
                        <td>-</td>
                        <td>86%</td>
                        <td>56</td>
                        </tr>
                      </tbody>
                      </table>
                  </section>
                </section>
              </section>
                        </div>
            
                        <div id="menu2" class="tab-pane fade m-width-1200">
              <section class="btn-panel float-right w-100 text-right">
                <a href="glucose-graph-view.html" class="btn btn-primary">Graph View</a>
              </section>

              <section class="row">
                <section class="col-md-4">
                  <section class="images float-left w-100">
                    <div id='wrap'>
                    <div id='calendar-two'></div>
            
                    </div>
                  </section>
                  <section class="summery-list mt-3 bg-white">
                    <h4>Summary</h4>
                    <ul>
                      <li class="mb-3"><span class="float-left">In Last 30 Days</span> <span class="float-right">29</span></li>
                      <li><span class="float-left">>2019</span> <span class="float-right">1500</span></li>
                      <li><span class="float-left">>2018</span> <span class="float-right">1500</span></li>
                      <li><span class="float-left">>2017</span> <span class="float-right">1500</span></li>
                      <li><span class="float-left">>2016</span> <span class="float-right">1500</span></li>
                      <li><span class="float-left">>2015</span> <span class="float-right">1500</span></li>
                      <li><span class="float-left">>2014</span> <span class="float-right">1500</span></li>
                    </ul>
                  </section>
                </section>

                <section class="col-md-8 pl-5">
                  <span class="meter-img"><img class="w-100" src="<?php echo IMAGE_PATH."meter.png"; ?>" alt="meter"></span>

                  <section class="table-responsive">
                    <table class="table bg-white graph-table">
                      <thead>
                        <tr>
                        <th>Reading Time</th>
                        <th>Remote</th>
                        <th>SpO2</th>
                        <th>Pulse Rate</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                        <td>2019-11-05 13:20</td>
                        <td>-</td>
                        <td>92%</td>
                        <td>89</td>
                        </tr>
                        <tr>
                        <td>2019-11-05 13:20</td>
                        <td>-</td>
                        <td>86%</td>
                        <td>56</td>
                        </tr>
                        <tr>
                        <td>2019-11-05 13:20</td>
                        <td>-</td>
                        <td>86%</td>
                        <td>56</td>
                        </tr>
                        <tr>
                        <td>2019-11-05 13:20</td>
                        <td>-</td>
                        <td>86%</td>
                        <td>56</td>
                        </tr>
                        <tr>
                        <td>2019-11-05 13:20</td>
                        <td>-</td>
                        <td>86%</td>
                        <td>56</td>
                        </tr>
                        <tr>
                        <td>2019-11-05 13:20</td>
                        <td>-</td>
                        <td>86%</td>
                        <td>56</td>
                        </tr>
                      </tbody>
                      </table>
                  </section>
                </section>
              </section>
                        </div>
                        <div id="menu3" class="tab-pane fade m-width-1200">
              <section class="btn-panel float-right w-100 text-right">
                <a href="blood-pressure-graph-view.html" class="btn btn-primary">Graph View</a>
              </section>

              <section class="row">
                <section class="col-md-4">
                  <section class="images float-left w-100">
                    <div id='wrap'>
                    <div id='calendar-three'></div>
            
                    </div>
                  </section>
                  <section class="summery-list mt-3 bg-white">
                    <h4>Summary</h4>
                    <ul>
                      <li class="mb-3"><span class="float-left">In Last 30 Days</span> <span class="float-right">29</span></li>
                      <li><span class="float-left">>2019</span> <span class="float-right">1500</span></li>
                      <li><span class="float-left">>2018</span> <span class="float-right">1500</span></li>
                      <li><span class="float-left">>2017</span> <span class="float-right">1500</span></li>
                      <li><span class="float-left">>2016</span> <span class="float-right">1500</span></li>
                      <li><span class="float-left">>2015</span> <span class="float-right">1500</span></li>
                      <li><span class="float-left">>2014</span> <span class="float-right">1500</span></li>
                    </ul>
                  </section>
                </section>

                <section class="col-md-8 pl-5">
                  <span class="meter-img"><img class="w-100" src="<?php echo IMAGE_PATH."meter.png"; ?>" alt="meter"></span>

                  <section class="table-responsive">
                    <table class="table bg-white graph-table">
                      <thead>
                        <tr>
                        <th>Reading Time</th>
                        <th>Remote</th>
                        <th>SpO2</th>
                        <th>Pulse Rate</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                        <td>2019-11-05 13:20</td>
                        <td>-</td>
                        <td>92%</td>
                        <td>89</td>
                        </tr>
                        <tr>
                        <td>2019-11-05 13:20</td>
                        <td>-</td>
                        <td>86%</td>
                        <td>56</td>
                        </tr>
                        <tr>
                        <td>2019-11-05 13:20</td>
                        <td>-</td>
                        <td>86%</td>
                        <td>56</td>
                        </tr>
                        <tr>
                        <td>2019-11-05 13:20</td>
                        <td>-</td>
                        <td>86%</td>
                        <td>56</td>
                        </tr>
                        <tr>
                        <td>2019-11-05 13:20</td>
                        <td>-</td>
                        <td>86%</td>
                        <td>56</td>
                        </tr>
                        <tr>
                        <td>2019-11-05 13:20</td>
                        <td>-</td>
                        <td>86%</td>
                        <td>56</td>
                        </tr>
                      </tbody>
                      </table>
                  </section>
                </section>
              </section>
                        </div>
                    </div>
                </section>
            </section>

        </section>
    </section>



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
        $("body").on("click","#addNotes",function()
        {
          if($("#notes").val()==''){
                $(".notesErrorClass").css("display","block");
                return false;
            }
            else
            {
              $(".notesErrorClass").css("display","none");
              var csrfToken = "<?= json_encode($this->request->getParam('_csrfToken')) ?>";
          
              $.ajax({
                url: '<?php echo $this->url->build(["controller"=>"Patients", "action"=>"savePatientNotes"]); ?>',
                type: "POST",
                headers:
                {
                  'X-CSRF-Token': csrfToken    
                },
                data: {'notes':$("#notes").val(),'patientID':"<?php echo $patientsData[0]['patient_id'];?>"},
                success: function(data)
                {
                  $(".ryt").html(data);
                }   
              });
            }
          
        });
    </script>
</body>
</html>