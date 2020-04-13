<!-- BEGIN: main -->
<style>
  label {
    width: 100%;
  }

  .col-sm-4 {
    text-align: left;
  }
</style>

<div class="container">
  <div id="msgshow"></div>
  <div class="text-center start-content"
    style="max-width: 450px; margin: auto; padding-top: 50px; border: 1px solid lightgray; padding: 15px; border-radius: 20px;">
    <a href="/">
      <img src="/themes/default/images/banner.png" style="width: 200px; margin: 20px 20px;">
    </a>

    <div style="margin-top: 20px;"></div>

    <div class="modal" id="recover-pass" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <p class="text-center">
              Nhập tên đăng nhập hoặc email, mail chứa thông tin đăng nhập sẽ được gửi tới tài khoản
            </p>

            <label class="row">
              <div class="col-sm-3">
                Nhập tên đăng nhập hoặc email:
              </div>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="keyword" autocomplete="off">
              </div>
            </label>

            <div id="recover" style="color: red; font-weight: bold;"></div>

            <div class="text-center">
              <button class="btn btn-info" onclick="recoverPassSubmit()">
                Lấy lại mật khẩu
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- BEGIN: checking -->
    <!-- <form onsubmit="return checkingSubmit(event)"> -->
    <label class="row">
      <div class="col-sm-3">
        Nhập mã xác nhận
      </div>
      <div class="col-sm-9">
        <input type="text" class="form-control" id="checking-key" autocomplete="off">
      </div>
    </label>
    <div id="checking-error" style="color: red;"></div>
    <button class="btn btn-info" onclick="checkingSubmit()">
      Xác nhận
    </button>
    <!-- </form> -->
    <!-- END: checking -->

    <!-- BEGIN: checked -->
    <!-- <form> -->
    <label class="row">
      <div class="col-sm-3">
        Mật khẩu mới
      </div>
      <div class="col-sm-9">
        <input type="text" class="form-control" id="pass-v1" autocomplete="off">
      </div>
    </label>

    <label class="row">
      <div class="col-sm-3">
        Xác nhận mật khẩu
      </div>
      <div class="col-sm-9">
        <input type="text" class="form-control" id="pass-v2" autocomplete="off">
      </div>
    </label>
    <div id="pass-error" style="color: red; font-weight: bold;"></div>

    <div class="text-center">
      <button class="btn btn-info" onclick="changePasswordSubmit()">
        Đổi mật khẩu
      </button>
    </div>
    <!-- </form> -->
    <!-- END: checked -->
    <!-- BEGIN: nonchecked -->
    <div></div>
    <button class="btn btn-info btn-sm" onclick="recoverPass()"> Lấy lại ngay </button>
    <div></div>
    <!-- END: nonchecked -->
    <!-- BEGIN: end -->
    Đường link đã hết hiệu lực, xin hãy gửi yêu cầu khác
    <!-- END: end -->
    <p>
      <a href="/news/login"> Đăng nhập ngay! </a>
    </p>
  </div>
</div>

<script>
  var global = {
    url: '{origin}'
  }

  function recoverPass() {
    $("#recover-pass").modal('show')
  }

  function recoverPassSubmit() {
    var keyword = $("#keyword").val().trim()

    if (keyword.length) {
      freeze()
      $.post(
        global['url'],
        { action: 'recover', keyword: keyword },
        (response, status) => {
          if (status == 'success') {
            window.location.reload()
          }
        }
      )
    }
    else {
      $("#recover").text('Các trường không được trống')
    }
  }

  function changePasswordSubmit() {
    var pass1 = $("#pass-v1").val().trim(), pass2 = $("#pass-v2").val().trim()
    if (!pass1 || !pass2) {
      $("#pass-error").text('Các trường không được trống')
    }
    else if (pass1 !== pass2) {
      $("#pass-error").text('Mật khẩu không trùng nhau')
    }
    else {
      $("#pass-error").text('')
      freeze()
      $.post(
        global['url'],
        { action: 'change-pass', npass: pass1 },
        (response, status) => {
          window.location.reload()
        }
      )
    }
  }

  function checkingSubmit() {
    // e.preventDefault()
    $("#checking-error").text("")
    var keyword = $("#checking-key").val().trim()
    if (keyword.length) {
      freeze()
      $.post(
        global['url'],
        { action: 'checking-key', keyword: keyword },
        (response, status) => {
          checkResult(response, status).then(data => {
            window.location.reload()
          }, () => {
            $("#checking-error").text("Mã xác nhận sai");
          })
        }
      )
    }
    else {
      $("#checking-error").text('Các trường không được trống');
    }
  }
</script>
<!-- END: main -->