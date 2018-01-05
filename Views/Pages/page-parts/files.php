<link rel="stylesheet" type="text/css" href="<?=$base?>vendor/datatables/jquery.dataTables.min.css">
<script type="text/javascript" src="<?=$base?>vendor/datatables/jquery.dataTables.js"></script>
<style type="text/css">

</style>
<div class="table-responsive">
    <table class="table" id="dataTable" width="100%" cellspacing="0">
      <thead>
        <tr>
          <th>Id</th>
          <th>Type</th>
          <th>Name</th>
          <th>Post Id</th>
          <th>user</th>
          <th>date</th>
        </tr>
      
      </thead>

      <tbody>
      <?php $i=count($files);
      		if($i)
      			foreach ($files as $file) {
      	?>
      <?php 
      		$style = "style='font-size: 26px;'";

      		$element = "<li $style class='fa fa-file-o'></li>";
      		if ($file['type'] == 'image')
      			$element = "<li  $style class='fa fa-file-image-o'></li>";
      		else if($file['type'] == 'video')
      			$element = "<li  $style class='fa fa-file-video-o'></li>";
       ?>

        <tr>
          <td width='10%'><?=$id?></td>
          <td><?=$element?></td>
          <td><a href="<?=$base.$file['link']?>" download='download'><?=$file['name']?></a></td>
          <td><a href="<?=$base."page/viewPost/?page_id={$post_page_id}&post_id=".$file['post_id']?>" >post <?=$file['post_id']?></a></td>
          <td><a href="<?=$base.'profile?id='.$file['user_id']?>" ><?=$file['username']?></a></td>
          <td><?=substr($file['created_at'],0,10)?></td>
        </tr>
        <?php }?>
      </tbody>
    </table>
</div>


<script type="text/javascript">
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