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
  <div class="text-center start-content" style="max-width: 450px; margin: auto; padding-top: 50px; border: 1px solid lightgray; padding: 15px; border-radius: 20px;">
    <a href="/">
      <img src="/themes/default/images/banner.png" style="width: 200px; margin: 20px 20px;">
    </a>

    <div style="margin-top: 20px;"></div>

    <form>
      <div class="row">
        <label>
          <div class="col-sm-4">
            Tên đăng nhập 
          </div>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="username" autocomplete="off">
          </div>
        </label>
      </div>

      <div class="row">
        <label>
          <div class="col-sm-4">
            Mật khẩu 
          </div>
          <div class="col-sm-8">
            <input type="password" class="form-control" id="password">
          </div>
        </label>
      </div>

      <div class="text-center">
        <button class="btn btn-info" onclick="login()">
          Đăng nhập
        </button>
      </div>
    </form>
    <div id="error"> {error} </div>
    <br>
    Quên mật khẩu? <a href="/{module_name}/losspass"> Lấy lại ngay </a>
    <br>
    Chưa có tài khoản? <a href="/{module_name}/signup"> Đăng ký ngay!</a>
  </div>
</div>

<script>
  var global = {
    url: '{origin}'
  }
  var username = $("#username")
  var password = $("#password")
  var error = $("#error")

  function displayError(errorText) {
    var text = ''
    
    if (errorText) {
      text = errorText
    }

    error.text(text)
  }

  function checkLogin() {
    var data = {
      username: username.val(),
      password: password.val()
    }

    if (data['username']) {
      return data
    }
    return false
  }

  function login() {
    if (loginData = checkLogin()) {
      freeze()
      $.post(
        global['url'],
        {action: 'login', data: loginData},
        (response, status) => {
          checkResult(response, status).then(data => {
            if (data['error']) {
              displayError(data['error'])
            }
            else {
              window.location.reload() 
            }
          }, () => {  })
        }
      )
    }
    else {
      displayError('Chưa điền đủ thông tin')
    }
  }
</script>
<!-- END: main -->
