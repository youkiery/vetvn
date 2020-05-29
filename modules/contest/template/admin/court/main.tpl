<!-- BEGIN: main -->
<link rel="stylesheet" href="/modules/contest/src/style.css">
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.css">
<script src="/modules/core/js/vhttp.js"> </script>
<div id="msgshow"></div>
<style>
  .form-group { clear: both; }
</style>

{modal}

<div class="form-group" style="float: right;">
  <button class="btn btn-success" onclick="insert()">
    Thêm khóa học
  </button>
</div>

<div style="clear: both;"></div>

<div id="content">
  {content}
</div>

<script>
  var global = {
    id: 0,
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

  function fillInsertForm(data) {
    $("#insert-name").val(data['name'])
    $("#insert-price").val(data['price'])
    $("#insert-intro").val(data['intro'])
    $("#insert-parent").val(data['parent'])
    // $(".performer").prop('checked', false)
    // data['performer'].forEach(item => {
    //   if (item) $("#" + item).prop('checked', true)
    // })
  }

  function insert() {
    fillInsertForm({
      name: '',
      price: 0,
      intro: '',
      parent: 0,
      // performer: []
    })
    $(".insert-modal").hide()
    $("#insert-btn").show()
    $("#insert-modal").modal('show')
  }

  function update(id) {
    vhttp.checkelse('', { action: 'get-info', id: id}).then((data) => {
      global['id'] = id
      $(".insert-modal").hide()
      $("#update-btn").show()
      // data['data']['performer'] = data['data']['performer'].split(',')
      fillInsertForm(data['data'])
      $("#insert-price").val(format(data['data']['price']))
      $("#insert-modal").modal('show')
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

  function insertSubmit() {
    vhttp.checkelse('', { action: 'insert', data: checkData()}).then((data) => {
      $("#insert-modal").modal('hide')
      $("#content").html(data['html'])
    })
  }

  function updateSubmit() {
    vhttp.checkelse('', { action: 'update', id: global['id'], data: checkData()}).then((data) => {
      $("#insert-modal").modal('hide')
      $("#content").html(data['html'])
    })
  }
</script>
<!-- END: main -->
