<!-- BEGIN: main -->
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.js"></script> 
<link rel="stylesheet" href="/themes/default/src/glyphicons.css">

<div id="msgshow"></div>
<div class="form-group">
  Tự động duyệt đăng ký:
  <input type="checkbox" class="form-control" id="user" {user}>
</div>
<div class="form-group">
  Tự động duyệt thú cưng:
  <input type="checkbox" class="form-control" id="pet" {pet}>
</div>
<div class="form-group">
  Tự động duyệt bán, phối:
  <input type="checkbox" class="form-control" id="trade" {trade}>
</div>
<div class="form-group">
  Tự động duyệt mua:
  <input type="checkbox" class="form-control" id="buy" {buy}>
</div>
<div class="form-group">
  Tự động duyệt liên hệ:
  <input type="checkbox" class="form-control" id="info" {info}>
</div>
<button class="btn btn-info" onclick="save()">
  Lưu cấu hình
</button>
<script>
  global = {
    page: 1
  }

  function checkData() {
    return {
      user: checkBool($("#user").prop('checked')),
      pet: checkBool($("#pet").prop('checked')),
      trade: checkBool($("#trade").prop('checked')),
      buy: checkBool($("#buy").prop('checked')),
      info: checkBool($("#info").prop('checked'))
    }
  }

  function checkBool(tick) {
    if (tick) {
      return 1
    }
    return 0
  }

  function save() {
    $.post(
      strHref,
      {action: 'save', data: checkData()},
      (response, status) => {
        checkResult(response, status).then(data => {
          console.log('saved');
        }, () => {})
      }
    )
  }
</script>
<!-- END: main -->
