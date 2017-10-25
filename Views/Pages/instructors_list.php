<div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="index.html">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Instructors list</li>
      </ol>
      <script>
        function createNew()
        {
          $('#admin_form').slideToggle();
          $('#admin_form').attr('action','<?=$base?>admin/addInstructor');
          $('#btnCreate').css('display','block');
          $('#btnEdit').css('display','none');
          $('input').val('');
        }
      </script>
      <div class="col-sm-12" style="border-bottom: 2px solid gray;margin-bottom:10px;padding-bottom: 5px;">
      <button class="btn " onclick="createNew();" style="margin-bottom:20px;">Add a New Instructor</button>
        <form class='row' id='admin_form' method='POSt' action='<?=$base?>admin/<?php echo !isset($instructor)?"addInstructor":"editInstructor"; ?>' <?php echo !isset($instructor)?"style='display: none;'":""; ?>>
          <input type="hidden" name="role" value="insert">
          <div class='col-sm-6'>

            <div class="form-group">
              <label>First Name</label>
              <input class="form-control" type="text" name='first_name' <?php if(isset($instructor)):?> value="<?=$instructor['first_name']?>" <?php endif;?> placeholder="Enter instructor's first name">
            </div>

            <div class="form-group">
              <label>Last Name</label>
              <input class="form-control" type="text" name='last_name' <?php if(isset($instructor)):?> value="<?=$instructor['last_name']?>" <?php endif;?> placeholder="Enter instructor's last name">
            </div>

            <div class="form-group">
              <label>Selects Instructor's Department</label>
              <select class="form-control" name='department_id'>
              <?php foreach ($departments as $dep) { ?>
                <option value='<?=$dep['id']?>' <?php if (isset($instructor)&&$instructor['department_id']==$dep['id']) echo 'selected' ?> ><?=$dep['name']?></option>
              <?php }?>
              </select>
            </div>
          

          </div>

          <div class="col-sm-6">

            <div class="form-group">
              <label>Email</label>
              <input class="form-control"  name='email'   type="email" <?php if(isset($instructor)):?> readonly="readonly" value="<?=$instructor['email']?>" <?php else: echo "required";endif;?>  placeholder="Enter instructor's email">
            </div>

            <div class="form-group" style="margin-bottom:45px;">
              <label>Password</label>
              <input class="form-control"  name='password' <?php if(!isset($instructor)):?> required<?php endif;?> type="password"   autocomplete="new-password" >
            </div>

            
            <?php if(isset($instructor)):?>
            <button type="submit"  id='btnEdit' class="btn btn-primary col-12" > Edit </button> 
            <button type="submit"  id='btnCreate' style="display:none;" class="btn btn-success col-12" > Create </button>
 
          <?php else :?>
            <button type="submit"  id='btnCreate' class="btn btn-success col-12" > Create </button>
          <?php endif;?>



          </div>

         
        </form>



      </div>
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i> Instructors in the system</div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>id</th>
                  <th>First name</th>
                  <th>Last Name</th>
                  <th>Email</th>
                  <th>Department</th>
                  <th>created at</th>
                </tr>
              </thead>
        
              <tbody>
              <?php foreach ($instructors as $instructor) {?>

                <tr>
                  <td><a href="<?=$base.'admin/instructorsList/'.$instructor['user_id']?>"><?=$instructor['user_id']?></a></td>
                  <td><?=$instructor['first_name']?></td>
                  <td><?=$instructor['last_name']?></td>
                  <td><?=$instructor['email']?></td>
                  <td><?=$instructor['department']?></td>
                  <td><?=$instructor['created_at']?></td>
                </tr>
                <?php }?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
      </div>
    </div>