<!-- BEGIN: main -->
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.js"></script>
<link rel="stylesheet" href="/themes/default/src/glyphicons.css">
<style>
  .cell-center {
    vertical-align: inherit !important;
  }
  .select {
    background: rgb(223, 223, 223);
    border: 2px solid deepskyblue;
  }
</style>

<div class="container">
  <div id="msgshow"></div>
  <a href="/">
    <img src="/themes/default/images/banner.png" style="width: 200px;">
  </a>

  <a style="margin: 8px 0px; display: block;" href="javascript:history.go(-1)">
    <span class="glyphicon glyphicon-chevron-left">  </span> Trở về </a>
  </a>
  <div style="clear: both;"></div>

  <div id="modal-owner" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-body text-center">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <p> Điền thông tin chủ trại </p>
          <label class="row">
            <div class="col-sm-3">
              Tên
            </div>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="owner-name">
            </div>
          </label>

          <label class="row">
            <div class="col-sm-3">
              Số điện thoại
            </div>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="owner-mobile">
            </div>
          </label>

          <label class="row">
            <div class="col-sm-3">
              Địa chỉ
            </div>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="owner-address">
            </div>
          </label>

          <label class="row">
            <div class="col-sm-3">
              CMND
            </div>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="owner-politic">
            </div>
          </label>

          <div class="text-center">
            <button class="btn btn-success" onclick="editSubmit()">
              Thêm khách hàng
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal" id="modal-contact" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <p class="text-center">
            Danh sách thú cưng
          </p>

          <div id="contact-content" style="max-height: 400px; overflow-y: scroll;">
            
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="content">
    {content}
  </div>
</div>

<script>
  var content = $("#content")
  var global = {
    page: 1,
    page2: 1,
    user: 0
  }

  function checkFilter() {
    return {
      page: global['page'],
      limit: 10,
    }
  }

  function checkOpfilter() {
    return {
      page: global['page2'],
      limit: 10,
    }
  }

  function filter(e) {
    e.preventDefault()
    goPage(1)
  }

  function goPage(page) {
    global['page'] = page
    $.post(
      "",
      { action: 'gopage', filter: checkFilter() },
      (response, status) => {
        checkResult(response, status).then(data => {
          content.html(data['html'])
        }, () => { })
      }
    )
  }

  function goPage2(page) {
    global['page2'] = page
    $.post(
      "",
      { action: 'filter2', id: global['user'], filter: checkOpfilter() },
      (response, status) => {
        checkResult(response, status).then(data => {
          $("#contact-content").html(data['html'])
        }, () => { })
      }
    )
  }

  function view(id) {
    global['page2'] = 1
    $.post(
      "",
      { action: 'view', id: id, filter: checkOpfilter() },
      (response, status) => {
        checkResult(response, status).then(data => {
          $("#contact-content").html(data['html'])
          $("#modal-contact").modal('show')
          global['user'] = id
        }, () => { })
      }
    )
  }

  function takeback(id) {
    $.post(
      "",
      { action: 'takeback', id: id, user: global['user'], filter: checkOpfilter() },
      (response, status) => {
        checkResult(response, status).then(data => {
          $("#contact-content").html(data['html'])
        }, () => { })
      }
    )
  }

  function edit(id) {
    $.post(
      global['url'],
      {action: 'get-owner', id: id},
      (response, status) => {
        checkResult(response, status).then(data => {
          global['id'] = id
          $("#owner-name").val(data['data']['name'])
          $("#owner-address").val(data['data']['address'])
          $("#owner-mobile").val(data['data']['mobile'])
          $("#owner-politic").val(data['data']['politic'])
          $("#modal-owner").modal('show')
        })
      }
    )
  }

  function checkOwnerData() {
    return {
      name: $("#owner-name").val(),
      address: $("#owner-address").val(),
      mobile: $("#owner-mobile").val(),
      politic: $("#owner-politic").val()
    }
  }
  
  function editSubmit() {
    $.post(
      global['url'],
      {action: 'update-owner', id: global['id'], data: checkOwnerData(), filter: checkFilter()},
      (response, status) => {
        checkResult(response, status).then(data => {
          content.html(data['html'])
          $("#modal-owner").modal('hide')
        })
      }
    )
  }
</script>
<!-- END: main -->
