<script type="text/javascript">
	$base = '<?=$base?>';
	$profile_id = '<?=$profile->getId()?>';
</script>
<!-- Modal -->
<div id="file-preview" class="modal fade" role="dialog">
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

    <!-- Timeline content -->
    <div class="container">

        <?php include $this->partPath("profile-parts/heading");?>

	    <div class="row">
	    	<div class="col-md-offset-1 col-md-10 no-paddin-xs">
	    		<?php include($file2);?>
	    	</div>
	    </div>   
    </div>


