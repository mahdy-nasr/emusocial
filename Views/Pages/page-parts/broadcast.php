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
  #table_grade{
    margin:10px 0;
  }
  #table_grade tbody tr:nth-child(even) {
    background: #fff;
    color:#000;
  }
  #table_grade thead tr , #table_grade tfoot tr{
    background: var(--main-color);
    color:#fff;
  }
  #table_grade tbody tr:nth-child(odd) {
    background: #c9c9c9;
    color:#000;
  }
</style>
<?php $broadcasts=[];if(count($broadcasts)):?>
<div class="table-responsive" >
    <table class="table" id="table_grade" width="100%" >
      <thead>
        <tr>
          <th>No</th>
          <th>Title</th>
          <th>Weight</th>
          <th width="60%"></th>
          <th width="10%">Grade</th>
        </tr>
      
      </thead>

      <tbody>
      <?php  $i=0;foreach ($grades['grades'] as $grade) {$i++;?>
        <tr>
          <td><?=$i?></td>
          <td><?=$grade['grade_title']?></td>
          <td><?=$grade['grade_reference']?>%</td>
          <td></td>
          <td><?=round($grade['grade'],2)?>%</td>
        </tr>
        <?php }?>
      </tbody>

      <tfoot>
        <tr>
          <td></td>
          <td>Total</td>
          <td><?=$grades['total']['grade_reference']?>%</td>
          <td></td>
          <td><?=round($grades['total']['grade'],2)?>%</td>
        </tr>
      </tfoot>

    </table>
</div>
<?php else:?>
  <div class="row">
    <h5 style="text-align:center;">No BroadCasts for this page</h5>
  </div>
<?php endif;?>

<script type="text/javascript">
  
</script>











