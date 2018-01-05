<div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="index.html">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Courses and Departments</li>
      </ol>
      <script>
        function createNew()
        {
          $('#admin_form').slideToggle();
          $('#admin_action_form').slideUp();
          $('#admin_form').attr('action','<?=$base?>admin/addCourse');
          $('#btnCreate').css('display','block');
          $('#btnEdit').css('display','none');
          $('#btnDelete').css('display','none');
          $('#newCourseInst').css('display','block');
          $('#existCourseInst').css('display','none');
          $('input.clr').val('');
        }
        function actionNew()
        {
        	$('#admin_form').slideUp();
        	$('#admin_action_form').slideToggle();

        }
        function changePerm(value) 
        {
        	window.location.href = "<?=$base.'admin/coursePermission/'?>"+value;
        }
        
      </script>
      <div class="col-sm-12" style="border-bottom: 2px solid gray;margin-bottom:10px;padding-bottom: 5px;">
      <button class="btn " onclick="createNew();" style="margin-bottom:20px;">Add a New Course</button>
      <button class="btn " onclick="actionNew();" style="margin-bottom:20px;">Action in All Courses</button>

        <form class='row' id='admin_form' method='POST' action='<?=$base?>admin/<?php echo !isset($course)?"addCourse":"editCourse"; ?>' <?php echo !isset($course)?"style='display: none;'":""; ?>>
          	<input type="hidden" name="id"  <?php if(isset($course)):?> value="<?=$course['id']?>" <?php endif;?>>
          	<div class='col-sm-6'>

          		<div class="form-group">
	              <label>Course Code</label>
	              <input class="form-control clr" type="text" name='code' <?php if(isset($course)):?> value="<?=$course['code']?>" <?php endif;?> placeholder="Enter Course's Code">
	            </div>
	            <div class="form-group">
	              <label>Name</label>
	              <input class="form-control clr" type="text" name='name' <?php if(isset($course)):?> value="<?=$course['name']?>" <?php endif;?> placeholder="Enter Course's name">
	            </div>


	            <div class="form-group">
	              <label>Selects course's Department</label>
	              <select class="form-control" name='department_id'>
	              <?php foreach ($departments as $dep) { ?>
	                <option value='<?=$dep['id']?>' <?php if (isset($course)&&$course['department_id']==$dep['id']) echo 'selected' ?> ><?=$dep['name']?></option>
	              <?php }?>
	              </select>
	            </div>

              <div class="form-group" style="margin:0">
                <input type="checkbox" name="is_department" value="is_department" <?php if(isset($course) && $course['is_department']==1):?> checked="checked" <?php endif;?> > <label>As Department</label>
              </div>

	            

          	</div>

        	<div class="col-sm-6">
	        	<div class="form-group">
	              <label>Semester</label>
	              <select class="form-control" name='semester'>
	                <option value='FALL' <?php if (isset($course)&&$course['semester']=="FALL") echo 'selected' ?> >Fall</option>
	                <option value='SPRING' <?php if (isset($course)&&$course['semester']=="SPRING") echo 'selected' ?> >Spring</option>
	                <option value='SUMMER' <?php if (isset($course)&&$course['semester']=="SUMMER") echo 'selected' ?> >Summer</option>
	              </select>
	            </div>

	            <div class="form-group">
	              <label>Year</label>
	              <input class="form-control clr" type="text" name='year' <?php if(isset($course)):?> value="<?=$course['year']?>" <?php endif;?> placeholder="YYYY" >
	            </div>
              <div class="form-group col-12">
                <label class="col-12">Course Instructors</label>
                <div id="newCourseInst"<?php if (isset($course)) echo "style='display:none'";?>>
                  <select  <?php if (!isset($course)) echo 'required="required"'; ?> class='col-12'  id='multiselect' multiple='multiple' name="instructors[]" >
                  <?php foreach ($instructors as $inst) { ?>
                 
                          <option value="<?=$inst['id']?>"><?=$inst['first_name'].' '.$inst['last_name']?></option>
                      
                  <?php }?>
                  </select>
                </div>
                <select  id="existCourseInst" <?php if (!isset($course)) echo "style='display:none'";?> class='form-control col-12'   name="instructor" >
                <?php foreach ($course['instructors'] as $inst) { ?>
               
                        <option value="<?=$inst['id']?>"><?=$inst['name']?></option>
                    
                <?php }?>
                </select>

                
              </div>
	            <?php if(isset($course)):?>
            		<button type="submit"  id='btnEdit' class="btn btn-primary col-12" style="margin-bottom:5px;" > Edit </button> 
            		<a  id='btnDelete' class="btn btn-danger col-12" href="<?=$base?>admin/deleteCourse/<?=$course['id']?>" > Delete </a> 
            		<button type="submit"  id='btnCreate' style="display:none;" class="btn btn-success col-12" > Create </button>
 
          		<?php else :?>
            		<button type="submit"  id='btnCreate' class="btn btn-success col-12" > Create </button>
          		<?php endif;?>
        

          </div>
         
        </form>
        <form class="row" method="post" id ="admin_action_form" action="<?=$base?>admin/allCoursesPermission" style='display: none;'>
        	<div class="form-group col-6">
	            <label>Semester</label>
	            <select class="form-control" name='semester'>
	                <option value='FALL' <?php if (isset($course)&&$course['semester']=="FALL") echo 'selected' ?> >Fall</option>
	                <option value='SPRING' <?php if (isset($course)&&$course['semester']=="SPRING") echo 'selected' ?> >Spring</option>
	                <option value='SUMMER' <?php if (isset($course)&&$course['semester']=="SUMMER") echo 'selected' ?> >Summer</option>
	            </select>
	        </div>

	        <div class="form-group col-6">
	            <label>Year</label>
	            <input class="form-control" type="text" name='year' <?php if(isset($course)):?> value="<?=$course['year']?>" <?php endif;?> placeholder="YYYY">
	        </div>

	        <div class="form-group col-6">
	            <label>Action</label>
	            <select class="form-control" name='action'>
	                <option value='readonly' >Readonly</option>
	                <option value='readwrite'  >Read and Write</option>
	            </select>
	        </div>
	        <button type="submit"  class="btn btn-info col-6"  style="padding:0; height:40px;margin-top: 30px;"> submit </button>
        </form>

      </div>
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i> Courses in the system</div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>id</th>
                  <th>Department</th>
                  <th>Code</th>
                  <th>Name</th>
                  <th>groups</th>
                  <th>Semester</th>
                  <th>Action</th>
                </tr>
              </thead>
        
              <tbody>
              <?php foreach ($courses as $course) {?>

                <tr>
                  <td><a href="<?=$base.'admin/allCourses/'.$course['id']?>"><?=$course['id']?></a></td>
                  <td><?=$course['department']?></td>
                  <td><?=$course['code']?></td>
                  <td><?=$course['name']?></td>
                  <td>
                    <select class="form-control">
                    <?php foreach ($course['instructors'] as $inst) {?>
                      <option value=""><?=$inst['name']?></option>
                    <?php } ?>
                    </select>

                  </td>
                  <td><?=$course['semester'].' '.$course['year']?></td>
                  <td>
	                  <select class="form-control" name="drp" onchange="changePerm(this.value)">
	                  	<option value="<?=$course['id']?>" <?php if ($course['readonly'] == 1) echo "selected = 'selected'"?> >Readonly</option>
	                  	<option value="<?=$course['id']?>" <?php if ($course['readonly'] == 0) echo "selected = 'selected'"?> >Open</option>
	                  </select>

                  </td>
                </tr>
                <?php }?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
      </div>
    </div>