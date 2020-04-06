<!-- BEGIN: main -->
<link rel="stylesheet" href="/themes/default/src/glyphicons.css">
<link rel="stylesheet" href="/themes/default/src/jquery-ui.min.css">
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.js"></script> 
<script type="text/javascript" src="/themes/default/src/jquery.ui.datepicker-vi.js"></script>
<div id="msgshow"></div>

<form class="row">
  <div class="col-sm-6">
    <input type="text" class="form-control" id="filter-from">
  </div>
  <div class="col-sm-6">
    <input type="text" class="form-control" id="filter-end">
  </div>
  <button class="btn btn-info" onclick="filter(event)">
    Lọc theo thời gian
  </button>
</form>

<div id="content">
  {content}
</div>

<script>
  var content = $("#content")

  $(this).ready(() => {
    $("#filter-from, #filter-end").datepicker({
      format: 'dd/mm/yyyy',
      changeMonth: true,
      changeYear: true
    });
  })

  function filter(e) {
    e.preventDefault()
    $.post(
      strHref,
      {action: 'filter', filter: {from: $("#filter-from").val(), end: $("#filter-end").val()}},
      (response, status) => {
        checkResult(response, status).then(data => {
          content.html(data['html'])
        })
      }
    )
  }
</script>
<!-- END: main -->
