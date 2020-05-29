<!-- BEGIN: main -->
<link rel="stylesheet" href="/modules/contest/src/style.css">
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.css">
<script src="/modules/core/js/vhttp.js">

</script>
<div id="msgshow"></div>
<style>
  .form-group { clear: both; }
</style>

{modal}

<div class="form-group row">
  <div class="col-sm-8">
    <label> Từ khóa </label>
    <input type="text" class="form-control" id="filter-keyword" value="{keyword}" placeholder="Nhập tên người, SĐT">
  </div>
  <div class="col-sm-8">
    <label> Khóa học </label>
    <select class="form-control" id="filter-court">
      <option value="0"> Tất cả </option>
      <!-- BEGIN: court -->
      <option value="{id}" {selected}> {name} </option>
      <!-- END: court -->
    </select>
  </div>
  <div class="col-sm-8">
    <label> Trạng thái </label>
    <select class="form-control" id="filter-active">
      <option value="0" {active_0}> Tất cả </option>
      <option value="1" {active_1}> Chưa xác nhận </option>
      <option value="2" {active_2}> Đã xác nhận </option>
    </select>
  </div>
</div>
<div class="form-group text-center">
  <button class="btn btn-info" onclick="filter()">
    Lọc danh sách
  </button>
</div>

<div id="content">
  {content}
</div>

<script>
  var global = {
    id: 0,
    type: {0: 'btn btn-info', 1: 'btn btn-warning'}
  }

  function filter() {
    window.location.replace(window.location.origin + window.location.pathname + '?nv=' + nv_module_name + '&keyword=' + $("#filter-keyword").val() + '&court=' + $("#filter-court").val() + '&active=' + $("#filter-active").val())
  }

  function activeSubmit(id, type) {
    vhttp.checkelse('', { action: 'active', id: id, type: type}).then((data) => {
      $("#content").html(data['html'])
    })
  }

  function remove(id) {
    global['id'] = id
    $("#remove-modal").modal('show')
  }

  function removeSubmit() {
    vhttp.checkelse('', { action: 'remove', id: global['id']}).then((data) => {
      // $("#edit-modal").modal('show')
      $("#content").html(data['html'])
      $("#remove-modal").modal('hide')
    })
  }

  function edit(id) {
    global['id'] = id
    vhttp.checkelse('', { action: 'get-info', id: id}).then((data) => {
      // $("#edit-modal").modal('show')
      $("#signup-name").val(data['data']['name'])
      $("#signup-address").val(data['data']['address'])
      $("#signup-mobile").val(data['data']['mobile'])
      $("#edit-modal").modal('show')
    })
  }

  function signupPresubmit() {
    data = checkSignupData()
    if (!data['name']) notify(data)
    else {
      vhttp.checkelse('', { action: 'edit', id: global['id'], data: data }).then(data => {
        $("#content").html(data['html'])
        $("#edit-modal").modal('hide')
      })
    }
  }

  function checkSignupData() {
    name = $("#signup-name").val()
    address = $("#signup-address").val()
    mobile = $("#signup-mobile").val()
    if (!name.length) return 'Nhập tên người dùng'
    if (!mobile.length) return 'Số điện thoại không được để trống'
    return {
      name: name,
      address: address,
      mobile: mobile
    }
  }

  function notify(text) {
    $("#notify").show()
    $("#notify").text(text)
    $("#notify").delay(1000).fadeOut(1000)
  }

</script>
<!-- END: main -->
