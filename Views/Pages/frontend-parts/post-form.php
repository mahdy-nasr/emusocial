<!-- add post form-->
        			<script type="text/javascript">
						/*if (sessionStorage.getItem("Page2Visited")) {
						 	sessionStorage.removeItem("Page2Visited");
						 	window.location.reload(true); // force refresh page1
						}*/
					</script>

        			<div class="panel profile-info panel-success">
			          <form method='post' action="<?=$base?>post/create<?=ucfirst($type);?>Post/?>" id='post_post'>
			              <textarea class="form-control input-lg p-text-area" rows="4" name='text' placeholder="Whats in your mind today?"></textarea>
			              <div style="width:100%; display:none;margin:0;padding:0;" id='event-div'>

			              		<div class="col-xs-6 no-padding-margin">
			              			<div class="input-group no-padding-margin" style="width:100%;">
			              				<span class="input-group-addon icon-input" id="basic-addon4">
			              					<i class="fa fa-bookmark-o" aria-hidden="true"></i>
			              				</span>
			              			
			              				<input type="text" id='event_name' name='event_name' placeholder="Event's Title" value=''  class="form-control" style="margin:0;border-radius:0 !important;"  >
			              			</div>
			              		</div>
			              		<div class="col-xs-6 no-padding-margin">
			              			<div class="input-group no-padding-margin" style="width:100%;">

			              				<span class="input-group-addon icon-input" id="basic-addon5">
			              					<i class="fa fa-map-marker" aria-hidden="true"></i>
			              				</span>
			              				<input type="text" id='event_place' name='event_place' placeholder="Event's Place" value=''  class="form-control" style="margin:0;border-radius:0 !important;"  >
			              			</div>
			              		</div>
			              		<div class="col-xs-6 no-padding-margin">
						              <div class="input-group no-padding-margin" id='date-div' style="width:100%;">
										  <span class="input-group-addon icon-input" id="basic-addon1"> 
										  	<i class="fa fa-calendar" aria-hidden="true"></i>
										  </span>
										  <input type="text" id='date' name='event_date' placeholder="Choose Event's Date" value='' data-toggle="datepicker" class="form-control" style="border-radius:0 !important;"  >
									   </div>
								</div>
								<div class="col-xs-6 no-padding-margin" style="border-right:1px solid #bbb;">
								   <div class="input-group no-padding-margin" id='time-div' style="width:100%;">
									  <span class="input-group-addon icon-input" id="basic-addon2" >
									  	<i class="fa fa-clock-o" aria-hidden="true"></i>
									  </span>
									  <input type="time" name='event_time' class="form-control no-margin" placeholder="Choose Event's Time" style="border-radius:0 !important;width:100%;border-right:none;"  >
								   </div>
								</div>
								<div class="clearfix"></div>
						   </div>

			              
			              <input type="hidden" id='file' name='files' value='[]'>
			              <input type="hidden" id='deleted' name='deleted' value='[]'>

			              
			              <input type="hidden" id='announcement' name='announcement' value="0">
			          </form>
			          <div id="progress" style="display:none;">
						    <div class="bar" style="width: 0%;"></div>
						</div>
			          <div>
			          	<div  id="file-container" class="col-xs-12">
			          	</div>
			          </div>
			          	
			          <div class="panel-footer">
			              <button type="button" onclick="submitForm();" class="btn btn-primary pull-right">Post</button>
						
							              
						<ul class="nav nav-pills">
			                  <!--li><a href="#"><i class="fa fa-map-marker"></i></a></li-->
			                  <li><a href="#" onclick="return image();"><i class="fa fa-camera"></i></a></li>
			                  <li><a href="#" onclick="return video();"><i class=" fa fa-film"></i></a></li>
			                  <li><a href="#" onclick="return file();"><i class=" fa fa-file-o"></i></a></li>
			                  <?php if($type == 'course'):?>
			                  <li><a href="#" onclick="return doDate();"><i class=" fa fa-calendar"></i></a></li>
			                  <li><a href="#" class="announcement-not-selected" onclick="return announce(this);" ><i class=" fa fa-bullhorn"></i></a></li>
			              	  <?php endif;?>

			                  <!--li><a href="#"><i class="fa fa-microphone"></i></a></li-->
			              </ul>
			          </div>


			          <input id="videoupload" type="file" name="postfile[]"  accept="video/*,  video/x-m4v, video/webm, video/x-ms-wmv, video/x-msvideo, video/3gpp, video/flv, video/x-flv, video/mp4, video/quicktime, video/mpeg, video/ogv, .ts, .mkv" data-url="<?=$base?>api/upload/video/" multiple style="display:none;">	
						
						<input id="imageupload" type="file" name="postfile[]"  accept="image/*" data-url="<?=$base?>api/upload/image/" multiple style="display:none;" />	
						
						<input id="fileupload" type="file" name="postfile[]" data-url="<?=$base?>api/upload/file/" multiple style="display:none;" />	
			        </div><!-- end add post form-->
				

			        <script type="text/javascript" src="<?=$base?>js/post_form.js"></script>
			   
			    