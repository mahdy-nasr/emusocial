
			        	function image()
				        {
				        	$('#progress').slideDown();
				        	$('#imageupload').trigger('click');
				        	return false;
				        }
				        function video()
				        {
				        	$('#progress').slideDown();
				        	$('#videoupload').trigger('click');
				        	return false;
				        }
				        function file()
				        {
				        	$('#progress').slideDown();
				        	$('#fileupload').trigger('click');
				        	return false;
				        }



				        ////////////////////////////////
				        /////////////////////////////////

				        function remove(array, element) {
						    return array.filter(e => e != element);
						}

						function removeFile(elem,id)
						{
							$(elem).parent().remove();

							fileArray = JSON.parse($('#file').val());
							fileArray = remove(fileArray,id);
							$('#file').val(JSON.stringify(fileArray));


							if ($('#file').val()=='[]') {
				        		$('#file-container').css('display','none');
							}

							removedArray = JSON.parse($('#deleted').val());
							removedArray.push(id);
							$('#deleted').val(JSON.stringify(removedArray));


							return false;
						}
				        
				        function htmlElement(name,input,id)
				        {
				        	return "<p class='file-element'> "+input+" : "+name+"  &nbsp;<a href='#' onclick="+'"'+"return removeFile(this,"+id+");"+'"'+" > remove</a></p>";
				        }

				        function putFiles(e, data,input){
				        	//console.log(data.result.hasOwnProperty('errors'));
				        	if (data.result.hasOwnProperty('errors')) {
				        		failAction();
				        		return;
				        	}
				        	$('#file-container').css('display','block');
				        	$('#progress').slideUp();
				        	$('#progress .bar').css('width',"0%");

				        	fileArray = JSON.parse($('#file').val());

				        	html_res = $('#file-container').html();
				        	$.each(data.result.records, function (index, file) {
							    html_res +=htmlElement(file.name,input,file.id);
							    fileArray.push(file.id);
							});

							$('#file').val(JSON.stringify(fileArray));
				        	 $('#file-container').html(html_res);
				        }

				        function failAction(e,data)
				        {
				        	$('#progress').slideUp();
				    		alert('error in uploading');
				        	$('#progress .bar').css('width',"0%");
				        }
				        function progress(e, data) {
					        var progress = parseInt(data.loaded / data.total * 100, 10);
					        $('#progress .bar').css(
					            'width',
					            progress + '%'
					        );
					    }

						///////////////////////////
						//////////////////////////
			        	

			        	$(function () {
			        		$('#imageupload').fileupload({
						        dataType: 'json',
						        done: function (e,data){putFiles(e,data,'image')},
						        progressall: progress,
						        fail: failAction
						        });
						    $('#videoupload').fileupload({
						        dataType: 'json',
						        done: function (e,data){putFiles(e,data,'video')},
						        progressall: progress,
						        fail: failAction
						        });

						    $('#fileupload').fileupload({
						        dataType: 'json',
						        done: function (e,data){putFiles(e,data,'file')},
						        progressall: progress,
						        fail: failAction
						        });
						});



						//////////////////////////////////
						/////////////////////////////////
						///
						///
						///
						//////////////////////////////////
						/////////////////////////////////
						

						function doDate()
			        	{
			        		$('#event-div').slideToggle();
			        		//$('#time-div').slideToggle();
			        		return false;
			        	}
			        	function announce(elem)
			        	{
			        		console.log($(elem).attr('class'));
			        		$(elem).toggleClass('announcement-selected');
			        		$(elem).toggleClass('announcement-not-selected');
			        		if ($('#announcement').val() == '0')
			        			$('#announcement').val('1');
			        		else
			        			$('#announcement').val('0');
			        		return false;
			        		
			        	}
			        	function submitForm()
			        	{
			        		sessionStorage.setItem('Page2Visited', 'True'); document.getElementById('post_post').submit();
			        	}

			        	$('[data-toggle="datepicker"]').datepicker({
			        		autoHide:true,
			        		date: new Date(),
			        		startDate: new Date(),
			        		trigger:'#basic-addon1'
			        	});