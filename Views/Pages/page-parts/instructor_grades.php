<!-- Modal -->
<div id="example_excel" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Spreadsheet Example Format</h4>
      </div>
      <div class="modal-body">
        <img style="display:black;margin:0 auto; max-width:100%;border:1px solid gray;" src="<?=$base?>img/excel.png">
        <h5 style="color:black;"> - example of grade header: grade:midterm:20 </h5>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<?php $error_grades = \App\Helpers\Session::flash('error_grades'); if ($error_grades) : ?>
<div class="error-div-fixed" >
  <p class="error-p" style="margin:0;">You Have Errors!! <a href='#' onclick="$(this).parent().parent().slideUp();return 0;" >x</a></p>
  <p class="error-d">
    <?php echo $error_grades;?>
  </p>
</div>
 <?php endif;?>

<div class="content" style="box-shadow:0 0 10px  gray; padding:20px; border-radius:5px;" >
  <div class="row" style="border:1px solid #dbdbdb; border-radius:5px; max-width:100%;margin:0;">
    <p style="text-align:center; color:green;"><?=$file_name?><a style="margin-left:30px;" href='#' onclick="return deleteGrades();" >x</a></p>
  </div>
    <div id="progress" class="row" style="max-width:100%;margin:0;" >
      <div class="bar" style="width: 0%;"></div>
    </div>

    <div class="row" style="max-width:100%;margin:0;">
        <p style="color:black;" id="file_name"></p>
    </div>

    <div class="row" style="max-width:100%;margin:0;">
      <div class="col-xs-8" style="padding-left:0;">
          <input id="fileupload" type="file" name="postfile[]" accept=".ods, .xlsx, .xls, .HTML, .CSV" value="sdfsdfsdfsd" data-url="<?=$base?>api/upload/file/" class='form-control' style="width:100%;"/>
      </div>
      <div class="col-xs-4" style="padding:0;">
          <form action="<?=$base?>grades/postGrades" method="post">
              <input type="hidden" name='page_id' value="<?=$post_page_id?>">
              <input type="hidden" name='referer' value="<?=$referer?>">
              <input type="hidden" id='uplaoded' name="file_id" value="">
              <input type="submit" class="btn btn-primary" style="width: 100%;">
          </form>
      </div>
    </div>
    <div class="row" style="max-width:100%;margin:5px 0;">
        <a style="color:black;" href="#example_excel" data-toggle="modal" data-target="#example_excel"><i class="fa fa-info-circle"></i> Fromat Example</a>
    </div>
    
    
  </div>

    

<script type="text/javascript">
base = "<?=$base?>";
page_id = "<?=$post_page_id?>";
function deleteGrades() {
  if (confirm('Are you sure?')) {
    window.location = base+'grades/'+"deleteGrades/?page_id="+page_id;
  }
  return false;
}
function putFiles(e, data,input){
    //console.log(data.result.hasOwnProperty('errors'));
    $('#progress .bar').css('width',"0%");
    
    if (data.result.hasOwnProperty('errors')) {
        alert('error in uploading');
      return;
    }
    $('#uplaoded').val(data.result.records[0].id);
    $('#file_name').html(data.result.records[0].name);
    console.log(data.result.records[0].id+" : "+data.result.records[0].name);
   
}



function failAction(e,data)
{
  $('#progress').slideUp();
  alert('error in uploading');
  $('#progress .bar').css('width',"0%");
}
function progress(e, data) {
    var progress = parseInt(data.loaded / data.total * 100, 10);
    $('#progress .bar').css(
        'width',
        progress + '%'
    );
}

$(function () {
  $('#fileupload').fileupload({
      dataType: 'json',
      done: function (e,data){putFiles(e,data,'file')},
      progressall: progress,
      fail: failAction
      });
 });
</script>
<?php if(count($students)) :?>
<link rel="stylesheet" type="text/css" href="<?=$base?>vendor/datatables/jquery.dataTables.min.css">
<script type="text/javascript" src="<?=$base?>vendor/datatables/jquery.dataTables.js"></script>
<style type="text/css">

</style>
<div class="table-responsive" style="margin:30px 0; box-shadow: 0 0 10px gray; padding:20px;">
    <table class="table" id="dataTable" width="100%" cellspacing="0">
      <thead>
        <tr>
          <th>No</th>
          <th>std.id</th>
          <th>student name</th>
          <?php foreach ($students['headers'] as $header) {?>
            <th><?=$header['title']."({$header['ref']}%)"?></th>
          <?php } ?>
        </tr>
      
      </thead>

      <tbody>
      <?php foreach ($students['students'] as $student) {?>

        <tr>
          <td width='10%'><?=$student['no']?></td>
          <td><?=$student['std.id']?></td>
          <td><a href="<?=$base.'profile?id='.$student['user_id']?>" ><?=$student['username']?></a></td>
          <?php foreach ($student['grades'] as $grade) {?>
          <td><?=round($grade,2).'%'?></td>
          <?php }?>
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

<?php endif;?>