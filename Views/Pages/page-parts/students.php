<!-- Modal -->
<div id="example_excel" class="modal fade" role="dialog">
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
    div.std-div{
        margin:10px 0;
        border:1px solid var(--main-color);
        padding: 5px;
        box-shadow: 0 0 10px gray;
    }
     div.std-div img{
        width: 70%;
        border-radius: 50%;
        border:1px solid gray;
        margin: 0 auto;
        display: block;
    }
    div.std-div h5{
        text-align: center;;
    }
    div.std-div > a{
        text-align: center;;
        display: block;
        padding: 4px;
        margin: 5px 0;
        border:1px solid gray;
        color:#fff;
        background: var(--main-color);
    }
</style>


<?php if(count($course->getStudents())):?>


<div class="container" style="box-shadow: 0 0 10px gray; width:100%;" >
    <?php foreach ($course->getStudents() as $id => $std){?>

    <div class="col-sm-4 " style='padding: 0 10px;'>
        <div class='std-div'>
            <img src="<?=$base.$std->getProfilePicture();?>" >
            <h5><a href="<?=$base."profile/?id={$std->getId()}"?>"><?=$std->getFullName();?></a></h5>
            <a href="#"><i class="fa fa-paper-plane-o" aria-hidden="true"></i>&nbsp;Message</a>
        </div>
    </div>



    <?php }?>
</div>



<?php else:?>
<div class="row">
    <h5 style="text-align:center;">No Students Registered on this page/h5>
</div>
<?php endif;?>

<script type="text/javascript">
  
</script>











