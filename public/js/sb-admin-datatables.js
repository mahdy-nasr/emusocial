// Call the dataTables jQuery plugin
$(document).ready(function() {
  $('#dataTable').DataTable(
  	{
        "paging":   true,
        "ordering": false,
        "info":     true
    }
    );
  $('#dataTable1').DataTable(
  	{
        "paging":   true,
        "ordering": false,
        "info":     true
    }
    );
  $('#dataTable2').DataTable(
  	{
        "paging":   true,
        "ordering": false,
        "info":     true
    }
    );
});
