<div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="index.html">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Other Pages Section</li>
      </ol>
</div>



<div class="container-fluid" style="border: 2px solid gray; border-radius:20px; width:80%;margin:15px auto;padding-bottom: 5px;">
    <form class='row' id='admin_form' method='POST' action='<?=$base?>admin/enrollUser/'>
        <input type="hidden" name="page_id" value="<?=$course['page_id']?>">
        <input type="hidden" name="course_id" value="<?=$course['id']?>">

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

    <form class='row' id='admin_form' method='POST' action='<?=$base?>admin/registerAdmin/'>
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

</script>

<div class="card mb-3">
        <div class="card-header"  >
        	<i class="fa fa-table tabtn selected" > Pages in the system </i>
        </div>
        <div class="card-body">
          <div class="table-responsive" id="dataTable1Div">
            <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>id</th>
                  <th>Name</th>
                  <th width="50%">About</th>
                  <th width="10%">Status</th>
                </tr>
              </thead>
        
              <tbody>
              <?php foreach ($pages as $page) {?>

                <tr>
                
                  <td><a href="<?=$base.'admin/instructorsList/'.$page['id']?>"><?=$page['id']?></a></td>
                  <td><?=$page['name']?></td>
                  <td><?=$page['about']?></td>
                  <td><?=$user['active']?></td>
                </tr>
                <?php }?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
      </div>
      