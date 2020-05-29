<!-- BEGIN: main -->
<link rel="stylesheet" href="/modules/contest/src/style.css">
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.css">
<script src="/modules/core/js/vhttp.js">

</script>
<div id="msgshow"></div>
<style>
  .form-group { clear: both; }
  [class*="col-"] {
    float: left;
    padding: 15px;
  }

  .col-1 {width: 8.33%;}
  .col-2 {width: 16.66%;}
  .col-3 {width: 25%;}
  .col-4 {width: 33.33%;}
  .col-5 {width: 41.66%;}
  .col-6 {width: 50%;}
  .col-7 {width: 58.33%;}
  .col-8 {width: 66.66%;}
  .col-9 {width: 75%;}
  .col-10 {width: 83.33%;}
  .col-11 {width: 91.66%;}
  .col-12 {width: 100%;}
</style>

{modal}

<div class="form-group" style="float: right;" onclick="courtModal()">
  <button class="btn btn-info">
    Danh sách khóa học
  </button>
</div>
<div style="clear: both;"></div>

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
    type: {0: 'btn btn-info', 1: 'btn btn-warning'},
    prv: ''
  }
  var formatter = new Intl.NumberFormat('vi-VI', {
    style: 'currency',
    currency: 'VND',
  });

  function format(number) {
    if (Number(number)) {
      return String(formatter.format(number)).replace(' ₫', '').replace(/\./g, ',')
    }
    return 0
  }

  $(document).ready(() => {
    $("#insert-price").keyup((e) => {
      value = Number(e.currentTarget.value.replace(/,/g, ''))
      if (!isNaN(value)) {
        $("#insert-price").val(format(value))
      }
      else $("#insert-price").val(global['prv'])
    })

    $("#insert-price").keydown((e) => {
      global['prv'] = e.currentTarget.value
    })
  })

  function courtModal() {
    $("#court-modal").modal('show')
  }

  function insertCourtModal() {
    $("#insert-court-modal").modal('show')
    fillInsertForm({
      name: '',
      price: 0,
      intro: '',
      parent: 0,
      // performer: []
    })
    $(".insert-modal").hide()
    $("#insert-btn").show()
    $("#insert-court-modal").modal('show')
  }

  function fillInsertForm(data) {
    $("#insert-name").val(data['name'])
    $("#insert-price").val(data['price'])
    $("#insert-intro").val(data['intro'])
    $("#insert-parent").val(data['parent'])
  }

  function updateCourt(id) {
    vhttp.checkelse('', { action: 'get-court', id: id}).then((data) => {
      global['id'] = id
      $(".insert-modal").hide()
      $("#update-btn").show()
      // data['data']['performer'] = data['data']['performer'].split(',')
      fillInsertForm(data['data'])
      $("#insert-price").val(format(data['data']['price']))
      $("#insert-court-modal").modal('show')
    })
  }

  function checkData() {
    // performer = []
    // $(".performer:checked").each((index, item) => {
    //   performer.push(item.getAttribute('id'))
    // })
    return {
      name: $("#insert-name").val(),
      price: $("#insert-price").val().replace(/\,/g, ''),
      intro: $("#insert-intro").val(),
      parent: $("#insert-parent").val()
      // performer: performer
    }
  }

  function insertCourtSubmit() {
    vhttp.checkelse('', { action: 'insert-court', data: checkData()}).then((data) => {
      $("#insert-court-modal").modal('hide')
      $("#court-content").html(data['html'])
    })
  }

  function updateCourtSubmit() {
    vhttp.checkelse('', { action: 'update-court', id: global['id'], data: checkData()}).then((data) => {
      $("#insert-court-modal").modal('hide')
      $("#court-content").html(data['html'])
    })
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
