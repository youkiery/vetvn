<!-- BEGIN: main -->
<style>
  .label {
    display: block;
    min-width: 150px;
    padding: 5px 10px;
    line-height: 20px;
    text-align: center;
    border: 2px solid #eee9dc;
    border-radius: 5px;
    position: absolute;
    left: 0;
    top: 50%;
    margin-top: -15px;
    color: black;
    height: 54px;
    font-weight: normal;
    font-size: inherit;
  }
  .btn {
    min-height: 22px;
  }
</style>
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
  <form style="width: 60%; float: right;">
    <label class="input-group">
      <input type="hidden" name="nv" value="{module_file}">
      <input type="hidden" name="op" value="list">
      <input type="text" class="form-control" name="keyword" value="{keyword}" id="keyword" placeholder="Nhập tên hoặc mã số">
      <div class="input-group-btn">
        <button class="btn btn-info"> Tìm kiếm </button>
      </div>
    </label>
  </form>
  <div style="clear: both;"></div>
  <a style="margin: 8px 0px; display: block;" href="javascript:history.go(-1)">
    <span class="glyphicon glyphicon-chevron-left">  </span> Trở về </a>
  </a>
  <div style="clear: both;"></div>

  <div class="row">
    <div class="col-sm-4 thumbnail" id="avatar" style="width: 240px; height: 240px; overflow: hidden;">
    </div>
    <div class="col-sm-8">
      <p> Chủ nuôi: {owner} </p>
      <p> CMND: {politic} </p>
      <p> Tên: {name} </p>
      <p> Ngày sinh: {dob} </p>
      <p> Giống: {species} </p>
      <p> Loài: {breed} </p>
      <p> Giới tính: {sex} </p>
      <p> Màu sắc: {color} </p>
      <p> Microchip: {microchip} </p>
      <button class="btn btn-info" onclick="sendContact()">
        Liên hệ
      </button>
    </div>
  </div>

  <h2> Gia phả </h2>

  <div id="wrapper">
    <span class="label" style="line-height: 40px;"> {name} </span>
    <div class="branch lv1">
      <div class="entry">
        <span class="label"> 
          Bố <br> {papa} 
          <div class="igleft">
            <button class="btn btn-sm btn-info after-hack ipopover" style="right: 23px;" data-html="true"  data-toggle="popover" data-content="{igpapa}"><span class="glyphicon glyphicon-info-sign"></span></button>  
          </div>
          <div class="igright">
            <button class="btn btn-sm btn-success after-hack" id="igrandon" onclick="toggleX('igrand')"><span class="glyphicon glyphicon-arrow-right"></span></button>  
            <button class="btn btn-sm btn-warning after-hack" id="igrandoff" style="display: none;" onclick="toggleX('igrand')"><span class="glyphicon glyphicon-arrow-left"></span></button>  
          </div>
        </span>
        <div class="branch lv2" id="igrand" style="display: none;">
          <div class="entry">
            <span class="label"> Ông nội <br> {grandpa} 
              <div class="igleft">
                <button class="btn btn-sm btn-info after-hack ipopover" style="right: 23px;" data-html="true"  data-toggle="popover" data-content="{igigrandpa}"><span class="glyphicon glyphicon-info-sign"></span></button>  
              </div>
            </span>
          </div>
          <div class="entry">
            <span class="label">
              Bà nội <br> {igrandma}
              <div class="igleft">
                <button class="btn btn-sm btn-info after-hack ipopover" style="right: 23px;" data-html="true"  data-toggle="popover" data-content="{igigrandma}"><span class="glyphicon glyphicon-info-sign"></span></button>  
              </div>
            </span>
          </div>
        </div>
      </div>
      <div class="entry">
        <span class="label">
          Mẹ <br> {mama} 
          <div class="igleft">
            <button class="btn btn-sm btn-info after-hack ipopover" style="right: 23px;" data-html="true"  data-toggle="popover" data-content="{igmama}"><span class="glyphicon glyphicon-info-sign"></span></button>  
          </div>
          <div class="igright">
            <button class="btn btn-sm btn-success after-hack" id="egrandon" onclick="toggleX('egrand')"><span class="glyphicon glyphicon-arrow-right"></span></button>  
            <button class="btn btn-sm btn-warning after-hack" id="egrandoff" style="display: none;" onclick="toggleX('egrand')"><span class="glyphicon glyphicon-arrow-left"></span></button>  
          </div>
        </span>
        <div class="branch lv2" id="egrand" style="display: none;">
          <div class="entry">
            <span class="label">
              Ông ngoại <br> {egrandpa}
              <div class="igleft">
                <button class="btn btn-sm btn-info after-hack ipopover" style="right: 23px;" data-html="true"  data-toggle="popover" data-content="{igegrandpa}"><span class="glyphicon glyphicon-info-sign"></span></button>  
              </div>
            </span>
          </div>
          <div class="entry">
            <span class="label"> Bà ngoại <br> {egrandma}
              <div class="igleft">
                <button class="btn btn-sm btn-info after-hack ipopover" style="right: 23px;" data-html="true"  data-toggle="popover" data-content="{igegrandma}"><span class="glyphicon glyphicon-info-sign"></span></button>  
              </div>
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div style="margin: 20px;"></div>

  <div class="panel panel-primary">
    <div class="panel-heading"> Sơ yếu lý lịch </div>
    <div class="panel-body"> {graph} </div>
  </div>


<script>
  var global = {
    id: '{id}',
    url: '{url}'
  }
  var avatar = $("#avatar")

  loadImage('{image}', 'avatar')

  function sendContact() {
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

  function toggleX(name) {
    var target = $("#" + name)
    if (target.css('display') == 'block') {
      $("#" + name + "on").show()
      $("#" + name + "off").hide()
    }
    else {
      $("#" + name + "on").hide()
      $("#" + name + "off").show()
    }
    target.toggle()
  }

  function goback() {
    window.history.back();
  }

  function splipper(text, part) {
    var pos = text.search(part + '-')
    var overleft = text.slice(pos)
    if (number = overleft.search(' ') >= 0) {
      overleft = overleft.slice(0, number)
    }
    var tick = overleft.lastIndexOf('-')
    var result = overleft.slice(tick + 1, overleft.length)

    return result
  }

  $(document).ready(function(){
    $('[data-toggle="popover"]').popover({
      placement: 'left',
    });

    $('[data-toggle="popover"]').click(function (e) {
      e.stopPropagation();
      var name = e.currentTarget.children[0].className
      // var className = splipper(name, 'glyphicon')
      // if (className == 'open') {
      //   e.currentTarget.children[0].className = 'glyphicon glyphicon-eye-close'
      // }
      // else {
      //   e.currentTarget.children[0].className = 'glyphicon glyphicon-info-sign'
      // }
    });
  });

  $(document).click(function (e) {
      if (($('.popover').has(e.target).length == 0) || $(e.target).is('.close')) {
        $('[data-toggle="popover"]').popover('hide');

        // var name = e.currentTarget.children[0].className
        // var className = splipper(name, 'glyphicon')
        // if (className == 'open') {
        //   e.currentTarget.children[0].className = 'glyphicon glyphicon-eye-close'
        // }
        // else {
        //   e.currentTarget.children[0].className = 'glyphicon glyphicon-info-sign'
        // }

      }
  });
</script>
<!-- END: main -->
