<div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="index.html">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Admins list</li>
      </ol>
      <script>
        function createNew()
        {
          $('#admin_form').slideToggle();
          $('#admin_form').attr('action','<?=$base?>admin/addAdmin');
          $('#btnCreate').css('display','block');
          $('#btnEdit').css('display','none');
          $('input').val('');
          $('#rdsu').val('1');
          $('#rddp').val('2');
        }
      </script>
      <div class="col-sm-12" style="border-bottom: 2px solid gray;margin-bottom:10px;padding-bottom: 5px;">
      <button class="btn " onclick="createNew();" style="margin-bottom:20px;">Add a New Admin</button>
        <form class='row' id='admin_form' method='POSt' action='<?=$base?>admin/<?php echo !isset($admin)?"addAdmin":"editAdmin"; ?>' <?php echo !isset($admin)?"style='display: none;'":""; ?>>
          <input type="hidden" name="role" value="insert">
          <div class='col-sm-6'>

            <div class="form-group">
              <label>First Name</label>
              <input class="form-control" type="text" name='first_name' <?php if(isset($admin)):?> value="<?=$admin['first_name']?>" <?php endif;?> placeholder="Enter admin's first name">
            </div>

            <div class="form-group">
              <label>Last Name</label>
              <input class="form-control" type="text" name='last_name' <?php if(isset($admin)):?> value="<?=$admin['last_name']?>" <?php endif;?> placeholder="Enter admin's last name">
            </div>

            <div class="form-group">
              <label style="margin-right: 15px;">Admin Permission: </label>
                <div>
                  <label class="radio-inline" style="margin-right: 15px;">
                    <input type="radio" value = "1" name="permission" id='rdsu'  <?php if (isset($admin)&&$admin['permission']==1) echo 'checked' ?>  /> Super 
                  </label>
                </div>
                <div>
                  <label class="radio-inline">
                    <input type="radio" value = "2" name="permission" id='rddp' <?php if (isset($admin)&&$admin['permission']==2) echo 'checked' ?> /> Department
                  </label>
                </div>
        
            </div>
          

          </div>

          <div class="col-sm-6">

            <div class="form-group">
              <label>Email</label>
              <input class="form-control"  name='email'   type="email" <?php if(isset($admin)):?> readonly="readonly" value="<?=$admin['email']?>" <?php else: echo "required";endif;?>  placeholder="Enter admin's email">
            </div>

            <div class="form-group">
              <label>Password</label>
              <input class="form-control"  name='password' <?php if(!isset($admin)):?> required<?php endif;?> type="password"   autocomplete="new-password" >
            </div>

            <div class="form-group">
              <label>Selects Admin's Department</label>
              <select class="form-control" name='department_id'>
              <?php foreach ($departments as $dep) { ?>
                <option value='<?=$dep['id']?>' <?php if (isset($admin)&&$admin['department_id']==$dep['id']) echo 'selected' ?> ><?=$dep['name']?></option>
              <?php }?>
              </select>
            </div>
            <?php if(isset($admin)):?>
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
          <i class="fa fa-table"></i> Admins in the system</div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>id</th>
                  <th>First name</th>
                  <th>Last Name</th>
                  <th>Email</th>
                  <th>Permission</th>
                  <th>Department</th>
                </tr>
              </thead>
        
              <tbody>
              <?php foreach ($admins as $admin) {?>
                <tr>
                  <td><a href="<?=$base.'admin/adminsList?admin='.$admin['id']?>"><?=$admin['id']?></a></td>
                  <td><?=$admin['first_name']?></td>
                  <td><?=$admin['last_name']?></td>
                  <td><?=$admin['email']?></td>
                  <td><?php echo $admin['permission']==1 ? 'Super Admin':'Department\'s Admin';?></td>
                  <td><?=$admin['department']?></td>
                </tr>
                <?php }?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
      </div>
    </div>