<!-- Modal -->
<div id="msg_show" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<style type="text/css">
  .title-div,.msg-div
  {
    margin:5px 0;
  }
</style>
<?php if($user_role == 'i'):?>
<div class="content" style="box-shadow:0 0 10px  gray; padding:20px; border-radius:5px; margin-bottom:30px;" >
    <form action="<?=$base?>broadcast/postBroadcast" method="post">
        <input type="hidden" name='page_id' value="<?=$post_page_id?>">
        <input type="hidden" name='referer' value="<?=$referer?>">
        <input type="hidden" id='user_id' name="user_id" value="<?=$user->getId()?>">
        <div class="row input-group no-padding title-div" style="width:100%;" >
          <input type="text" placeholder="Broadcast Title" required="required" name="title" class="form-control" style="width:100%;">
        </div>
        <div class="row input-group no-padding msg-div ">
          <textarea name='msg' cols="80%" rows="4" class="form-control" placeholder="write the Broadcast details"></textarea>
        </div>
        <input type="submit" class="btn btn-primary" style="width: 100%;" value="Submit Broadcast">
    </form>
</div>
<?php endif;?>



<style type="text/css">
  #table_grade{
    margin:10px 0;
  }
  #table_grade tbody tr:nth-child(odd) {
    background: #fff;
    color:#000;
  }

  #table_grade tbody tr:nth-child(even) {
    background: #e5e5e5;
    color:#000;
  }
</style>
<?php if(count($broadcasts)):?>
<link rel="stylesheet" type="text/css" href="<?=$base?>vendor/datatables/jquery.dataTables.min.css">
<script type="text/javascript" src="<?=$base?>vendor/datatables/jquery.dataTables.js"></script>
<div class="table-responsive" style="margin:30px 0; box-shadow: 0 0 10px gray; padding:20px;">
    <table class="table" id="dataTable" width="100%" >
      <thead>
        <tr>
          <th width="10%">No</th>
          <th width="45%">Title</th>
          <th width="30%">From</th>
          <th  width="10%">message</th>
          <?php if($user_role != 's'):?>
          <th>Action</th>
          <?php endif;?>
        </tr>
      
      </thead>

      <tbody>
      <?php  $i=0;foreach ($broadcasts as $broadcast) {$i++;?>
        <tr>
          <td><?=$i?></td>
          <td><?=$broadcast['title']?></td>
          <td><a href="<?=$base.'profile?id='.$broadcast['user_id']?>" ><?=$broadcast['username']?></a></td>          
          <td><a class='open_msg' msg="<?=$broadcast['msg']?>"  title="<?=$broadcast['title']?>"  href="#" >open</a></td>
          <?php if($user_role != 's'):?>
          <td><a href='<?=$base."broadcast/deleteBroadcast/?page_id=$post_page_id&broadcast_id={$broadcast['id']}"?>' > delete</a></td>
          <?php endif;?>
        </tr>
        <?php }?>
      </tbody>

      
    </table>
</div>
<?php else:?>
  <div class="row">
    <h5 style="text-align:center;">No Broadcasts for this page</h5>
  </div>
<?php endif;?>

<script type="text/javascript">

$(document).off('click', 'a.open_msg').on('click', 'a.open_msg', function(){
  $('#msg_show h4.modal-title').html($(this).attr('title'));
  $('#msg_show div.modal-body').html($(this).attr('msg'));
  $('#msg_show').modal('show');
  return false;
    
});
$(document).ready(function() {
  $('#dataTable').DataTable(
    {
        "paging":   true,
        "ordering": false,
        "info":     true
    }
    );
 
});

</script>











