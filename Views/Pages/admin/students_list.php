<div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="index.html">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Students list</li>
      </ol>
      <script>
        function createNew()
        {
          $('#admin_form').slideToggle();
          $('#admin_form').attr('action','<?=$base?>admin/addStudent');
          $('#btnCreate').css('display','block');
          $('#btnEdit').css('display','none');
          $('#btnDelete').css('display','none');
          $('input').val('');
        }
      </script>
      <div class="col-sm-12" style="border-bottom: 2px solid gray;margin-bottom:10px;padding-bottom: 5px;">
      <button class="btn " onclick="createNew();" style="margin-bottom:20px;">Add a New Student</button>
        <form class='row' id='admin_form' method='POSt' action='<?=$base?>admin/<?php echo !isset($student)?"addStudent":"editStudent"; ?>' <?php echo !isset($student)?"style='display: none;'":""; ?>>
          <input type="hidden" name="role" value="insert">
          <div class='col-sm-6'>

            <div class="form-group">
              <label>First Name</label>
              <input class="form-control" type="text" name='first_name' <?php if(isset($student)):?> value="<?=$student['first_name']?>" <?php endif;?> placeholder="Enter student's first name">
            </div>

            <div class="form-group">
              <label>Last Name</label>
              <input class="form-control" type="text" name='last_name' <?php if(isset($student)):?> value="<?=$student['last_name']?>" <?php endif;?> placeholder="Enter student's last name">
            </div>

            <div class="form-group">
              <label>Selects student's Department</label>
              <select class="form-control" name='department_id'>
              <?php foreach ($departments as $dep) { ?>
                <option value='<?=$dep['id']?>' <?php if (isset($student)&&$student['department_id']==$dep['id']) echo 'selected' ?> ><?=$dep['name']?></option>
              <?php }?>
              </select>
            </div>
          

          </div>

          <div class="col-sm-6">
          <?php 
          /*
            <div class="form-group">
              <label>Email</label>
              <input class="form-control"  name='email'   type="email" <?php if(isset($student)):?> readonly="readonly" value="<?=$student['email']?>" <?php else: echo "required";endif;?>  placeholder="Enter student's email">
            </div>
            */
          ?>

            <div class="form-group" >
              <label>Password</label>
              <input class="form-control"  name='password' <?php if(!isset($student)):?> required<?php endif;?> type="password"   autocomplete="new-password" >
            </div>

            <div class="form-group" style="">
              <label>Student ID</label>
              <input class="form-control"  name='student_number'   type="text" <?php if(isset($student)):?> value="<?=$student['student_number']?>"  readonly="readonly"  <?php else: echo "required";endif;?>  placeholder="Enter student's ID">
            </div>

             <div class="form-group">
              <label>Selects student's gender</label>
              <select class="form-control" name='gender'>
                <option value='male' <?php if (isset($student)&&$student['gender']=='male') echo 'selected' ?>>male</option>
                <option value='female' <?php if (isset($student)&&$student['gender']=='female') echo 'selected' ?>>female</option>
              </select>
            </div>
            
            <?php if(isset($student)):?>
            <button type="submit"  id='btnEdit' class="btn btn-primary col-12" style="margin-bottom:5px;" > Edit </button> 
            <a  id='btnDelete' class="btn btn-danger col-12" href="<?=$base?>admin/deleteStudent/<?=$student['id']?>" > Delete </a> 
            <button type="submit"  id='btnCreate' style="display:none;" class="btn btn-success col-12" > Create </button>
 
          <?php else :?>
            <button type="submit"  id='btnCreate' class="btn btn-success col-12" > Create </button>
          <?php endif;?>



          </div>

         
        </form>



      </div>
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i> Students in the system</div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>id</th>
                  <th>First name</th>
                  <th>Last Name</th>
                  <th>Student ID</th>
                  <th>Department</th>
                  <th>created at</th>
                </tr>
              </thead>
        
              <tbody>
              <?php foreach ($students as $student) {?>

                <tr>
                  <td><a href="<?=$base.'admin/studentsList/'.$student['id']?>"><?=$student['id']?></a></td>
                  <td><?=$student['first_name']?></td>
                  <td><?=$student['last_name']?></td>
                  <td><?=$student['student_number']?></td>
                  <td><?=$student['department']?></td>
                  <td><?=substr($student['created_at'],0,10)?></td>
                </tr>
                <?php }?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
      </div>
    </div>