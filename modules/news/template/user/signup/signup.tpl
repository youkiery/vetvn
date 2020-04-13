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

    <form onsubmit="signup(event)">

      <div class="row">
        <label>
          <div class="col-sm-4">
            Tên đăng nhập <span style="color: red;" class="glyphicon glyphicon-afterisk"> * </span>
          </div>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="username" autocomplete="off">
          </div>
        </label>
      </div>

      <div class="row">
        <label>
          <div class="col-sm-4">
            Mật khẩu <span style="color: red;" class="glyphicon glyphicon-afterisk"> * </span>
          </div>
          <div class="col-sm-8">
            <input type="password" class="form-control" id="password">
          </div>
        </label>
      </div>

      <div class="row">
        <label>
          <div class="col-sm-4">
            Xác nhận mật khẩu <span style="color: red;" class="glyphicon glyphicon-afterisk"> * </span>
          </div>
          <div class="col-sm-8">
            <input type="password" class="form-control" id="vpassword">
          </div>
        </label>
      </div>

      <div class="row">
        <label>
          <div class="col-sm-4">
            Họ và tên <span style="color: red;" class="glyphicon glyphicon-afterisk"> * </span>
          </div>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="fullname" autocomplete="off">
          </div>
        </label>
      </div>

      <div class="row">
        <label>
          <div class="col-sm-4">
            Số CMND <span style="color: red;" class="glyphicon glyphicon-afterisk"> * </span>
          </div>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="politic" autocomplete="off">
          </div>
        </label>
      </div>

      <div class="row">
        <label>
          <div class="col-sm-4">
            Điện thoại <span style="color: red;" class="glyphicon glyphicon-afterisk"> * </span>
          </div>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="phone" autocomplete="off">
          </div>
        </label>
      </div>

      <div class="row">
        <label>
          <div class="col-sm-4">
            Tỉnh
          </div>
          <div class="col-sm-8">
            <select class="form-control" id="al1" onchange="l1(this)">
              <!-- BEGIN: l1 -->
              <option value="{l1id}"> {l1name} </option>
              <!-- END: l1 -->
            </select>
          </div>
        </label>
      </div>

      <div class="row">
        <label>
          <div class="col-sm-4">
            Quận/Huyện/Thành phố
          </div>
          <div class="col-sm-8">
            <!-- BEGIN: l2 -->
            <select class="form-control al2" id="al2{l1id}" {active}>
              <!-- BEGIN: l2c -->
              <option value="{l2id}"> {l2name} </option>
              <!-- END: l2c -->
            </select>
            <!-- END: l2 -->
          </div>
        </label>
      </div>

      <div class="row">
        <label>
          <div class="col-sm-4">
            Xã/Phường/Thị trấn 
          </div>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="al3" autocomplete="off">
          </div>
        </label>
      </div>

      <div class="row">
        <label>
          <div class="col-sm-4">
            Địa chỉ <span style="color: red;" class="glyphicon glyphicon-afterisk"> * </span>
          </div>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="address" autocomplete="off">
          </div>
        </label>
      </div>

      <div class="text-center">
        <button class="btn btn-info" id="button">
          Đăng ký
        </button>
      </div>
    </form>
    <div id="error"></div>
    <br>
    Đã có tài khoản? <a href="/{module_file}/login"> Đăng nhập ngay!</a>
  </div>
</div>
<script>
  var global = {
    url: '{origin}'
  }
  var username = $("#username")
  var password = $("#password")
  var vpassword = $("#vpassword")
  var fullname = $("#fullname")
  var phone = $("#phone")
  var politic = $("#politic")
  var address = $("#address")
  var error = $("#error")

  var al1 = $("#al1")
  var al2 = $("#al2")
  var al3 = $("#al3")

  var position = JSON.parse('{position}')

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

    if (data['username'] && data['password']) {
      return data
    }
    return false
  }

  function l1(e) {
    var value = e.value

    $(".al2").hide()
    $("#al2" + value).show()
  }

  function checkSignup() {
    var check = true
    var data = {
      username: username.val().trim(),
      password: password.val().trim(),
      vpassword: vpassword.val().trim(),
      fullname: fullname.val().trim(),
      phone: phone.val().trim(),
      politic: politic.val().trim(),
      address: address.val().trim(),
    }

    if (!/^[A-Za-z0-9_]{3,16}$/.test(data['username'])) {
      displayError('Tên người dùng phải từ 3 - 16 ký tự chứa chữ, số, hoặc dấu gạch dưới')
      return false
    }
    else if (data['password'].length < 6) {
      displayError('Mật khẩu không được ngắn hơn 6 ký tự')
      return false
    }
    else if (!(data['password'] == data['vpassword'])) {
      displayError('Mật khẩu không trùng nhau')
      return false
    }
    else {
      for (const key in data) {
        if (data.hasOwnProperty(key)) {
          const element = data[key];

          if (!element) {
            check = false
          }
        }
      }
    }
    data['al1'] = position[al1.val()]['name']
    data['al2'] = position[al1.val()]['district'][$("#al2" + al1.val()).val()]
    data['al3'] = al3.val()

    if (check) {
      return data
    }
    displayError('Chưa điền đủ các thông tin')
    return false
  }

  function signup(e) {
    e.preventDefault()
    if (signupData = checkSignup()) {
      freeze()
      $.post(
          global['url'],
          {action: 'signup', data: signupData},
          (response, status) => {
        checkResult(response, status).then(data => {
          window.location.reload();
        }, (data) => {
          displayError(data['error'])
        })
      }
      )
    }
  }

</script>
<!-- END: main -->
