<!DOCTYPE HTML>
<html lang="en">
<head>
<title>Inbox | Healthnode</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet">
</head>

<body>
    <!-- HEADER -->
    <?php echo $this->element("header"); ?>
	<!-- HEADER -->

    <section class="data-details">
        <!-- LEFT PANEL -->
		<?php echo $this->element("left_panel"); ?>
		<!-- LEFT PANEL -->

        <section class="right-cont">
            <div class="click"><span><img src="<?php echo IMAGE_PATH."toggle.png"; ?>"></span></div>
            <section class="inbox-panel">
                <h2>Inbox</h2>
                <section class="al-msg-box float-left w-100 pr-2 mb-4">
                    <section class="row">
                        <section class="col-md-7">
                           <section class="select-opt">
                               <select name="carlist" form="carform">
                                  <option value="text">all message(164)</option>
                                  <option value="text">all message(150)</option>
                                  <option value="text">all message(16)</option>
                                  <option value="text">all message(140)</option>
                                </select>
                                <input class="inbox-search" type="search" placeholder="">
                           </section>
                        </section>
                        <section class="col-md-5">
                            <a href="#" class="btn-primary rounded  float-right" id="addSendbird">New message</a>
                        </section>
                    </section>
                </section>

                <section class="chat-panel float-left w-100 pb-4">
					<section class="row">
                        <section class="col-md-7">
                            <section class="lft-box">
                                <section class="active float-left w-100">
                                    <section class="left float-left  w-100 ">
                                        <select class="active-select"><option>Active</option></select>
                                        <select class="today-select"><option>Today</option></select>
                                    </section>
                                    <section class="chat-list float-left w-100 pl-3 pr-3 pt-3 pb-3 " id="listUser">
                                        <section class="bg-white mb-2 float-left  w-100 pl-4 pr-4 pt-2 pb-2 chat-box" id="ravi">
                                            <h5 class="float-left text-capitalize w-100 mb-0">ravi</h5>
                                            <p class="float-left text-capitalize w-100 mb-0">each patient carriers his own doctor inside his</p>
                                        </section>
                                        <section class="bg-white mb-2 float-left  w-100 pl-4 pr-4 pt-2 pb-2 chat-box" id="jon">
                                            <h5 class="float-left text-capitalize w-100 mb-0" >jon</h5>
                                            <p class="float-left text-capitalize w-100 mb-0">Before you examine the body of a patient</p>
                                        </section>
                                        <section class="bg-white mb-2 float-left  w-100 pl-4 pr-4 pt-2 pb-2 chat-box" id="gav">
                                            <h5 class="float-left text-capitalize w-100 mb-0 " >gavy</h5>
                                            <p class="float-left text-capitalize w-100 mb-0">Before you examine the body of a patient</p>
                                        </section>
                                        <section class="bg-white mb-2 float-left  w-100 pl-4 pr-4 pt-2 pb-2 chat-box">
                                            <h5 class="float-left text-capitalize w-100 mb-0 text-gray">ravi</h5>
                                            <p class="float-left text-capitalize w-100 mb-0">each patient carriers his own doctor inside his</p>
                                        </section>
                                        <section class="bg-white mb-2 float-left  w-100 pl-4 pr-4 pt-2 pb-2 chat-box">
                                            <h5 class="float-left text-capitalize w-100 mb-0 text-gray">harry</h5>
                                            <p class="float-left text-capitalize w-100 mb-0">each patient carriers his own doctor inside his</p>
                                        </section>
                                        <section class="bg-white mb-2 float-left  w-100 pl-4 pr-4 pt-2 pb-2 chat-box">
                                            <h5 class="float-left text-capitalize w-100 mb-0 text-gray">ali</h5>
                                            <p class="float-left text-capitalize w-100 mb-0">each patient carriers his own doctor inside his</p>
                                        </section>
                                    </section>
                                </section>
                            </section>
                        </section>
                        <section class="col-md-5 chat-room-boxx">
                            <section class="chat float-left w-100 pr-4">
                                <section class="right-bx">
                                    <section class="botm-border float-left w-100 top-panel">
                                        <h5>interested in your contract</h5>
                                    </section> 
                                    <section class="chat-room" id="chat_room">
                                        <section class="float-left w-100 mb-2">
                                            <section class="lft-chat float-left w-100">
                                                <h4 class="expend">ravi kumar</h4>
                                                <img src="<?php echo IMAGE_PATH."pic01.png"; ?>" alt="ravi">
                                                <h6>hello</h6>
                                            </section>
                                        </section>

                                        <section class="float-left w-100 mb-2">
                                            <section class="ryt-chat float-right">
                                                <h4>sam deo</h4>
                                                <img src="<?php echo IMAGE_PATH."pic02.png"; ?>" alt="ravi">
                                                <h6>hello</h6>
                                            </section>
                                        </section>


                                        <section class="float-left w-100 mb-2">
                                                <section class="lft-chat float-left w-100">
                                                    <h4 class="expend">ravi kumar</h4>
                                                    <img src="<?php echo IMAGE_PATH."pic01.png"; ?>" alt="ravi">
                                                    <h6>Lorem ipsum dolor sit amet, consectetur</h6>
                                                </section>
                                            </section>

                                            <section class="float-left w-100 mb-2">
                                                <section class="ryt-chat float-right">
                                                    <h4>sam deo</h4>
                                                    <img src="<?php echo IMAGE_PATH."pic02.png"; ?>" alt="ravi">
                                                    <h6>In faucibus erat finibus, malesuada dolor non</h6>
                                                </section>
                                            </section>
                                        </section>
                                    </section>
                                    
                                    <section class="text-filed">
                                        <textarea placeholder="message" id="message" name="message"></textarea>
                                    </section>                                     
                                    <section class="file">
                                        <!--<div class="file-attach"><input type="file" name="pic" accept="image/*"></div>
                                        <label>attachment</label>-->
                                        <div class="file-attach"><input type='file'name='attachment'>
                                            <span class='button'><img src="<?php echo IMAGE_PATH."attachment.png"; ?>" alt="attachment"></span>
                                            <span class='label' data-js-label>attachment</label>
                                         </div>
  
                                        <input type="submit" id="chatMsgSend" class="btn btn-primary float-right">
                                    </section>
                                    
                                </section>
                        </section>
                    </section>
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
    </script>
	
 <script>	
	$(document).ready(function () {
    $("#jon").click(function () {
        $(".expend").text('Jon'); 
    })
	
	$("#gav").click(function () {
        $(".expend").text('Gavy'); 
    })
	
	$("#ravi").click(function () {
        $(".expend").text('Ravi'); 
    })
});
 </script>
<script type="text/javascript">
    var csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;
    var inputs = document.querySelectorAll('.file-attach')

    for (var i = 0, len = inputs.length; i < len; i++) {
      customInput(inputs[i])
    }
    function customInput (el) {
      const  fileAttach = el.querySelector('[type="file"]')
      const label = el.querySelector('[data-js-label]')
      
      fileAttach.onchange =
      fileAttach.onmouseout = function () {
        if (!fileAttach.value) return
        
        var value = fileAttach.value.replace(/^.*[\\\/]/, '')
        el.className += ' -chosen'
        label.innerText = value
      }
    }
</script>

<!--<script>
	$(".chat-box").click(function(){
        $(".chat-room-boxx").toggleClass("active");
      });

	  
</script>-->

<script type="text/javascript">
	$(function(){

		userList();
		function userList(){
			$('#listUser').html('');
			$.ajax({
				url:'<?php echo $this->Url->build(["controller"=>"Chats", "action"=>"userList"]); ?>',
				type:'POST',
				dataType:'json',
				headers:
				{
					'X-CSRF-Token': csrfToken,
				},
				success: function(res)
				{
					//console.log(res.users);
					//$('#listUser').html('');
					$.each(res.users, function(i, v) {
					    //alert(v.user_id)
					    let offline = '';
					    if(v.is_active==0){
					    	offline = 'text-gray';
					    }
					    var html = '<section class="bg-white mb-2 float-left  w-100 pl-4 pr-4 pt-2 pb-2 chat-box" id="'+v.user_id+'"><h5 class="float-left text-capitalize w-100 mb-0" '+offline+'>'+v.nickname+'</h5><p class="float-left text-capitalize w-100 mb-0">each patient carriers his own doctor inside his</p></section>';
					    $('#listUser').append(html);
					  });

					
				}
			})
		}

	    $(document).on('click','#createGroupChannel', function(e){
	        e.preventDefault();
	        var msg = $('#message').val();
	        if(msg==''){
	            return false;
	        }
	        $.ajax({
	            url: '<?php echo $this->Url->build(["controller"=>"Chats", "action"=>"sendbird"]); ?>',            
	            type: "POST",
	            dataType:'json',
	            headers:
	            {
	                'X-CSRF-Token': csrfToken,                
	            },
	            data: {"msg":msg,},
	            success: function(data)
	            {
	                //
	            }
	        })
	        
	    })

	    $(document).on('click','#addSendbird',function(e){
	    	$.ajax({
	    		url:'<?php echo $this->Url->build(["controller"=>"Chats", "action"=>"addUserSendbird"]); ?>',
	    		type:"POST",
	    		dataType:'json',
	    		headers:
	    		{
	    			'X-CSRF-Token': csrfToken,
	    		},
	    		//data{"adduser":'user'},
	    		success: function(data)
	    		{
	    			//
	    		}
	    	});
	    })

	    $(document).on('click','#chatMsgSend',function(e){
	    	e.preventDefault();
	    	var msg = $('#message').val();
	        if(msg==''){
	            return false;
	        }
	        $.ajax({
	            url: '<?php echo $this->Url->build(["controller"=>"Chats", "action"=>"sendMessage"]); ?>',            
	            type: "POST",
	            dataType:'json',
	            headers:
	            {
	                'X-CSRF-Token': csrfToken,                
	            },
	            data: {"msg":msg},
	            success: function(data)
	            {
	                //console.log(data);
	                if(data.message_id !='')
	                {
	                	$('#message').val('');
	                	var chatData = '<section class="float-left w-100 mb-2"><section class="ryt-chat float-right"><h4>sam deo</h4><img src="/web-portal/images/pic02.png" alt="ravi"><h6>'+data.message+'</h6></section></section>';
	                	$('#chat_room').append(chatData);

	                }
	                /*$.ajax({
	                	url:'<?php echo $this->Url->build(["controller"=>"Chats", "action"=>"getMessage"]); ?>',
	                	type:'json',
	                	headers:
	                	{
	                		'X-CSRF-Token':csrfToken,
	                	},
	                	data: {"message_id":data.message_id},
	                	success:function(res)
	                	{
	                		console.log(res);
	                	}
	                })*/
	            }
	        })

    	})
    })
</script>

</body>
</html>