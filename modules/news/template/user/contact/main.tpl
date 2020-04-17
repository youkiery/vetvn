<!-- BEGIN: main -->
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.js"></script>
<style>
  .cell-center {
    vertical-align: inherit !important;
  }
  .select {
    background: rgb(223, 223, 223);
    border: 2px solid deepskyblue;
  }

  .btn-xs {
    min-height: unset;
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

  {modal}

  <form>
  <div class="form-group input-group">
      <input type="text" class="form-control" name="keyword" placeholder="Tìm kiếm khách hàng...">
      <div class="input-group-btn">
        <button class="btn btn-info">
          Tìm kiếm
        </button>
      </div>
    </div>
  </form>

  <div id="content">
    {content}
  </div>
</div>

<script src="/modules/core/vhttp.js"></script>
<script>
  var content = $("#content")
  var global = {
    page: 1,
    page2: 1,
    user: 0
  }

  function update(id) {
    vhttp.checkelse('', {action: 'get-info', id: id}).then(data => {
      global['id'] = id
      $("#user-name").val(data['data']['fullname'])
      $("#user-address").val(data['data']['address'])
      $("#user-mobile").val(data['data']['mobile'])
      $("#user-politic").val(data['data']['politic'])
      $("#user-modal").modal('show')
    })
  }

  function checkOwnerData() {
    return {
      name: $("#user-name").val(),
      address: $("#user-address").val(),
      mobile: $("#user-mobile").val(),
      politic: $("#user-politic").val()
    }
  }
  
  function updateSubmit() {
    vhttp.checkelse('', {action: 'update-info', id: global['id'], data: checkOwnerData() }).then(data => {
      content.html(data['html'])
      $("#user-modal").modal('hide')
    })
  }
</script>
<!-- END: main -->
