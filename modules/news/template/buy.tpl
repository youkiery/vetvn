<!-- BEGIN: main -->
<div class="container">
  <div class="modal" id="modal-contact" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <p class="text-center">
            Gửi thông tin cho người đăng tin
          </p>

          <label class="row">
            <div class="col-sm-3">
              Tên
            </div>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="contact-fullname" value="{fullname}" autocomplete="off">
            </div>
          </label>

          <label class="row">
            <div class="col-sm-3">
              Địa chỉ
            </div>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="contact-address" value="{address}" autocomplete="off">
            </div>
          </label>

          <label class="row">
            <div class="col-sm-3">
              Số điện thoại
            </div>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="contact-mobile" value="{mobile}" autocomplete="off">
            </div>
          </label>

          <label class="row">
            <div class="col-sm-3">
              Lời nhắn
            </div>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="contact-note" autocomplete="off">
            </div>
          </label>

          <div id="contact-error" style="color: red;"></div>

          <div class="text-center">
            <button class="btn btn-info" onclick="sendContactSubmit()">
              Gửi liên hệ
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="msgshow"></div>
  <div style="float: right;">
    {FILE "heading.tpl"}
  </div>
  <div style="clear: right;"></div>
  <a href="/">
    <img src="/themes/default/images/banner.png" style="float: left; width: 200px;">
  </a>
  <form onsubmit="filter(event)" style="width: 60%; float: right;">
    <div class="row">
      <div class="col-sm-5">
        <input type="text" class="form-control" id="species" placeholder="Loài: chó, mèo,...">
        <!-- <select name="species" class="form-control" id="species">
          {species}
        </select> -->
      </div>
      <div class="col-sm-6">
        <div class="input-group">
          <input type="text" class="form-control" id="breed" placeholder="Giống: husky, alaska,...">
          <div class="input-group-btn">
            <button class="btn btn-info"> Tìm kiếm </button>
          </div>
        </div>
        <!-- <select name="breed" class="form-control" id="breed">
          {breed}
        </select> -->
      </div>
    </div>
  </form>
  <div style="clear: both;"></div>

  <div id="content">
    {content}
  </div>
</div>
<script>
  var global = {
    id: 0,
    'url': '{url}',
    'page': 1
  }
  var content = $("#content")

  function sendContact(id) {
    global['id'] = id
    $("#modal-contact").modal('show')
  }

  function checkContactData() {
    return {
      fullname: $("#contact-fullname").val(),
      address: $("#contact-address").val(),
      mobile: $("#contact-mobile").val(),
      note: $("#contact-note").val()
    }
  }

  function sendContactSubmit() {
    var data = checkContactData()
    if (!data['fullname'].length || !data['address'].length || !data['mobile'].length) {
      $("#contact-error").text('Các trường không được để trống')
    }
    else {
      $("#contact-error").text('')
      $.post(
        global['url'],
        {action: 'send-contact', data: data, id: global['id']},
        (response, status) => {
          checkResult(response, status).then(data => {
            $("#modal-contact").modal('show')
            $("#contact-note").val('')
          }, () => { })
        }
      )
    }
  }

  function checkFilter() {
    return {
      page: global['page'],
      limit: 12,
      species: $("#species").val(),
      breed: $("#breed").val()
    }
  }

  function filter(e) {
    e.preventDefault()
    goPage(1)
  }

  function goPage(page) {
    global['page'] = page
    $.post(
      global['url'],
      {action: 'filter', filter: checkFilter()},
      (response, status) => {
        checkResult(response, status).then(data => {
          content.html(data['html'])
        })
      }
    )
  }
</script>
<!-- END: main -->
