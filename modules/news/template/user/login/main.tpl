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

    <form method="post">
      <div class="row">
        <label>
          <div class="col-sm-4">
            Tên đăng nhập 
          </div>
          <div class="col-sm-8">
            <input type="text" class="form-control" name="username" id="username" value="{username}" autocomplete="off">
          </div>
        </label>
      </div>

      <div class="row">
        <label>
          <div class="col-sm-4">
            Mật khẩu 
          </div>
          <div class="col-sm-8">
            <input type="password" class="form-control" name="password" id="password">
          </div>
        </label>
      </div>

      <div class="text-center">
        <button class="btn btn-info">
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
</script>
<!-- END: main -->
