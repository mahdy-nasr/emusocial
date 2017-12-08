<script type="text/javascript">
	function chnageCourse(id)
	{
		window.location.href = "<?=$base.'admin/courseRegistration/'?>"+id;
	}
</script>
<div class="container-fluid">
      <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="index.html">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Course Registration</li>
    </ol>
    <div class="row" style="padding: 5px 0 15px 10px;">
      	<h5 class="col-6"><?=$course['code']?> - <?=$course['name']?></h5>
        
	    <select class="form-control col-4" onchange="chnageCourse(this.value)">
	        <?php foreach ($courses as $crs) {?>
		         <option value="<?=$crs['id']?>"  <?php if ($course['id']==$crs['id']) echo "selected" ?> ><?=$crs['code'].' :: '.$crs['name']?></option>
	        <?php } ?>
		</select>
    </div>
</div>


<div class="container-fluid" style="border: 2px solid gray; border-radius:20px; width:80%;margin:15px auto;padding-bottom: 5px;">
    <form class='row' id='admin_form' method='POST' action='<?=$base?>admin/enrollUser/'>
        <input type="hidden" name="page_id" value="<?=$course['page_id']?>">
        <input type="hidden" name="course_id" value="<?=$course['id']?>">
        <div class="col-12">
          <div class="form-group"> 

                <label class="col-12">Course Group</label>
              
                <select  id="existCourseInst" required="required" class='form-control col-12'   name="instructor" >
                <?php foreach ($course['instructors'] as $inst) { ?>
               
                        <option value="<?=$inst['id']?>"><?=$inst['name']?></option>
                    
                <?php }?>
                </select>

          </div>
        </div>
        <div class='col-sm-6'>
          	<div class="form-group">
            	<label>User Identification</label>
            	<input class="form-control" type="text" name='identification' placeholder="student's number or email ">
            </div>
        </div>

       	<div class="col-sm-6" style="padding-top: 30px;">
       		<button type="submit"  id='btnCreate' class="btn btn-success col-12" > Enroll </button>
       	</div>
    </form>

    <form class='row' id='admin_form' method='POST' style="border-top: 2px solid gray;padding-top:5px;" action='<?=$base?>admin/registerAdmin/'>
        <input type="hidden" name="page_id" value="<?=$course['page_id']?>">
        <input type="hidden" name="course_id" value="<?=$course['id']?>">

        <div class='col-sm-6'>
          	<div class="form-group">
            	<label>Admin Identification </label>
            	<input class="form-control" type="text" name='identification' placeholder="student's number or email">
            </div>
        </div>

       	<div class="col-sm-6" style="padding-top: 30px;">
       		<button type="submit"  id='btnCreate' class="btn btn-success col-12" > Register Admin </button>
       	</div>
    </form>
</div>

<style>
	.tabtn
	{
		margin-right: 15px;
		transition: font-size 0.5s;
		display:inline;
		
	}
	.selected{color: #0b59b0;font-weight: bold;}
	.tabtn:hover
	{
		font-size: 18px;
		font-weight: bold;;
		cursor: pointer;
	}
</style>
<script type="text/javascript">
	function clickTab(choose,elem)
	{

		$(elem).addClass("selected");
		if(choose=="students") {
			$('#dataTable2Div').fadeOut(0);
			$("#dataTable1Div").fadeIn(1500);
			$(elem).next().removeClass("selected");

		} else {
			$("#dataTable1Div").fadeOut(0);
			$('#dataTable2Div').fadeIn(1500);

			$(elem).prev().removeClass("selected");

			//$('.tabtn').first().removeClass("selected");
			
		}
	}

</script>

<div class="card mb-3">
        <div class="card-header"  >
        	<i class="fa fa-table tabtn selected" onclick="clickTab('students',this)" > Students in the Course </i>
        	<i class="fa fa-table tabtn" onclick="clickTab('instructors',this)"> Admins in the Course</i>
        </div>
        <div class="card-body">
          <div class="table-responsive" id="dataTable1Div">
            <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>id</th>
                  <th>Identification</th>
                  <th>Name</th>
                  <th>Department</th>
                  <th>Action</th>
                </tr>
              </thead>
        
              <tbody>
              <?php foreach ($users as $user) {?>

                <tr>
                <?php if (isset($user['student_number']) && !empty($user['student_number'])):?>
                  <td><a href="<?=$base.'admin/studentsList/'.$user['id']?>"><?=$user['id']?></a></td>
                  <td><?=$user['student_number']?></td>
                <?php else : ?>
                  <td><a href="<?=$base.'admin/instructorsList/'.$user['id']?>"><?=$user['id']?></a></td>
                  <td><?=$user['email']?></td>
                <?php endif;?>
                  <td><?=$user['first_name'].' '.$user['last_name']?></td>
                  <td><?=$user['department']?></td>
                  <td>
	                  <a class="btn btn-danger" href="<?=$base?>admin/removeUserCourse/<?=$user['id'].'/'.$course['page_id']?>">
	                  	Remove	
	                  </a>
                  </td>
                </tr>
                <?php }?>
              </tbody>
            </table>
          </div>
          <div class="table-responsive" id="dataTable2Div" style="display:none;">
            <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>id</th>
                  <th>Admin ID</th>
                  <th>Name</th>
                  <th>Department</th>
                  <th>Action</th>
                </tr>
              </thead>
        
              <tbody>
              <?php foreach ($admins as $admin) {?>

                <tr>

                <?php if (isset($admin['student_number']) && !empty($admin['student_number'])):?>
                  <td><a href="<?=$base.'admin/studentsList/'.$admin['id']?>"><?=$admin['id']?></a></td>
                  <td><?=$admin['student_number']?></td>
                <?php else : ?>
                  <td><a href="<?=$base.'admin/instructorsList/'.$admin['id']?>"><?=$admin['id']?></a></td>
                  <td><?=$admin['email']?></td>
                <?php endif;?>
                  <td><?=$admin['first_name'].' '.$admin['last_name']?></td>
                  <td><?=$admin['department']?></td>
                  <td>
	                  <a class="btn btn-danger" href="<?=$base?>admin/removeAdminCourse/<?=$admin['id'].'/'.$course['page_id']?>">
	                  	Remove	
	                  </a>
                  </td>
                </tr>
                <?php }?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
      </div>
      