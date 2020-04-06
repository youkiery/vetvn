<!-- BEGIN: main -->
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.js"></script> 
<link rel="stylesheet" href="/themes/default/src/glyphicons.css">

<style>
  label {
    width: 100%;
  }
</style>

<div class="container">
  <div id="msgshow"></div>
  <div id="remove-pet" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-body text-center">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <p>
            Xác nhận xóa?
          </p>
          <button class="btn btn-danger" onclick="removePetSubmit()">
            Xóa
          </button>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-sm-8">
      <input type="text" class="form-control" id="keyword" placeholder="Nhập từ khóa">
    </div>
    <div class="col-sm-4">
      <select class="form-control" id="limit">
        <option value="10"> 10 </option>
        <option value="20"> 20 </option>
        <option value="50"> 50 </option>
        <option value="75"> 75 </option>
        <option value="100"> 100 </option>
      </select>
    </div>
  </div>
  <label> <input type="radio" name="status" class="status" id="status-0" checked> Toàn bộ </label>
  <label> <input type="radio" name="status" class="status" id="status-1"> Chưa xác nhận </label>
  <label> <input type="radio" name="status" class="status" id="status-2"> Đã xác nhận </label>
  <button class="btn btn-info" onclick="filter()">
    <span class="glyphicon glyphicon-filter"></span>
  </button>
  <div id="content">
    {content}
  </div>
</div>

<script>
  var global = {
    url: '{origin}',
    page: 1
  }

  var content = $("#content")
  var keyword = $("#keyword")
  var limit = $("#limit")
  var cstatus = $(".status")

  function checkFilter() {
    var temp = cstatus.filter((index, item) => {
      return item.checked
    })
    var value = 0
    if (temp[0]) {
      value = splipper(temp[0].getAttribute('id'), 'user-status')
    }
    return {
      keyword: keyword.val(),
      page: global['page'],
      limit: limit.val(),
      status: value
    }
  }

  function checkUser(id) {
    $.post(
      global['url'],
      {action: 'check-user', id: id, filter: checkFilter()},
      (response, status) => {
        checkResult(response, status).then(data => {
          content.html(data['html'])
        }, () => {})
      }
    )
  }
</script>
<!-- END: main -->
