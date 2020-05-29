<!-- BEGIN: main -->
<style>
  .child {
    margin-left: 5px;
    padding-left: 5px;
    border-left: 2px solid green;
  }
  .red {
      color: red;
  }
  .form-group {
    clear: both;
  }
  .box-bordered {
    margin: auto; border: 1px solid lightgray; border-radius: 10px; padding: 10px;
  }

  .vetleft,
  .vetright {
    position: absolute;
    top: 0px;
    width: 135px;
    text-align: center;
  }

  .vetleft {
    left: 0px;
  }

  .vetright {
    right: 0px;
  }

  .vetleft img,
  .vetright img {
    width: 75px !important;
  }

  label {
    font-weight: normal;
  }

  .banner {
    width: 100%;
  }

  .vblock {
    top: 80px;
  }

  @media screen and (max-width: 992px) {
    .p_left { display: none; }

    .vetleft,
    .vetright {
      position: unset;
      display: inline-block;
      width: auto;
    }

    .vetright_block {
      display: block;
    }
  }

  @media screen and (max-width: 768px) {
    .checkbox input[type=checkbox] {
      position: inherit;
      margin-left: inherit;
    }
  }

  @media screen and (max-width: 600px) {
    .vetleft img,
    .vetright img {
      width: 50px !important;
    }

    .hideout {
      display: none;
    }
  }
</style>
<div class="container" style="margin-top: 20px;">
  <div id="msgshow"></div>

  <div id="content" style="position: relative;">
    <div class="text-center">
      <div class="vetleft">
        <img src="/assets/images/1.jpg">
      </div>
      <div class="vetleft vblock">
        <p class="p_left" style="font-weight: bold; margin: 14px; font-size: 1.25em; color: deepskyblue; text-shadow: 2px 2px 6px;"> Đăng ký khóa học thú y</p>
      </div>
      <div class="vetright">
        <img src="/assets/images/2.jpg">
      </div>
      <div class="vetright vetright_block vblock">
        <p style="font-weight: bold; margin: 14px; font-size: 1.25em; color: deepskyblue; text-shadow: 2px 2px 6px;"> Đăng ký khóa học thú y</p>
      </div>
    </div>
    <div>
      <div class="box-bordered" style="max-width: 500px;">
        <div class="text-center" style="font-size: 1.5em; color: green; margin-bottom: 20px;"> <b> Mẫu đăng ký </b>
        </div>
        <div class="form-group">
          <label class="label-control"> Họ và tên </label>
          <div>
            <input type="text" class="form-control" id="signup-name">
          </div>
        </div>
        <div class="form-group">
          <label class="label-control"> Địa chỉ </label>
          <div>
            <input type="text" class="form-control" id="signup-address">
          </div>
        </div>
        <div class="form-group">
          <label class="label-control"> Số điện thoại </label>
          <div class="relative">
            <input type="text" class="form-control" id="signup-mobile">
          </div>
        </div>
        <div class="form-group">
          <label class="label-control"> Môn học đăng ký </label><br>
          <!-- BEGIN: court -->
          <label>
            <input type="checkbox" class="primary" rel="{id}" name="court" value="{id}"> {court} <br>
          </label>
          <div class="child">
            <!-- BEGIN: child -->
            <label>
              <input type="checkbox" class="sub" rel="{id}" name="court" value="{id2}"> {court2} <br>
            </label>
            <!-- END: child -->
          </div>
          <!-- END: court -->
        </div>
        <div style="clear: both;"></div>
        <div class="text-center">
          <button class="btn btn-success" onclick="signupPresubmit()">
            Đăng ký
          </button>
          <div id="notify" style="color: red; font-size: 1.3em; font-weight: bold;"> </div>
        </div>
      </div>
      <div></div>
    </div>
    <br>
    <div class="box-bordered" style="max-width: 500px;">
        <div class="text-center">
          <img class="banner" src="/assets/images/banner.jpg">
          <p style="color: green; font-size: 1.2em;"> <b> BỆNH VIỆN THÚ CƯNG THANH XUÂN </b> </p>
        </div>
      <p>Địa chỉ: 12-14 Lê Đại Hành, Buôn Ma Thuột</p>
      <p>Số điện thoại: 02626.290.609</p>
    </div>
  </div>
  <div class="box-bordered" id="notify-content" style="display: none;">
    <p>Bạn đã đăng ký thành công <span id="regiesting"></span>, chúng tôi sẽ liên hệ với bạn theo số điện thoại cung cấp để thông báo về lịch học cùng các vấn đề liên quan</p>
    <p>
      Các khóa học bạn đã đăng ký: <span id="regiested"></span>
    </p>
    <p class="text-center">
      Bạn có thể muốn: <br>
      <a href="/contest"> Đăng ký thêm </a> |
      <a href="/contest/home"> Trở về trang chủ </a>
    </p>
  </div>
</div>
<script>
  $(document).ready(() => {
    $(".primary").change(e => {
      id = e.currentTarget.getAttribute('rel')
      $(".sub[rel="+ id +"]").prop('checked', false)
    })

    $(".sub").change(e => {
      id = e.currentTarget.getAttribute('rel')
      $(".primary[rel="+ id +"]").prop('checked', false)
    })
  })

  function signupPresubmit() {
    data = checkSignupData()
    if (!data['name']) {
      notify(data)
    }
    else {
      $.post(
        '',
        { action: 'signup', data: data },
        (response, status) => {
          checkResult(response, status).then(data => {
            // hiển thị thông báo liên hệ
            $("#regiesting").html(data['data']['no'].join(', '))
            $("#regiested").html(data['data']['list'].join(', '))
            $("#content").hide()
            $("#notify-content").show()
          })
        }
      )
    }
  }

  function checkSignupData() {
    name = $("#signup-name").val()
    address = $("#signup-address").val()
    mobile = $("#signup-mobile").val()
    court = []
    $("[name=court]:checked").each((index, item) => {
      console.log(item);
      court.push(item.value)
    })
    if (!name.length) return 'Nhập tên người dùng'
    if (!mobile.length) return 'Số điện thoại không được để trống'
    if (!court.length) return 'Chọn ít nhất 1 khóa học'
    return {
      name: name,
      address: address,
      mobile: mobile,
      court: court,
    }
  }

  function notify(text) {
    $("#notify").show()
    $("#notify").text(text)
    $("#notify").delay(1000).fadeOut(1000)
  }
</script>
<!-- END: main -->
