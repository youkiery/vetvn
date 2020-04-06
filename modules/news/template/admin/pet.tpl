<!-- BEGIN: main -->
<link rel="stylesheet" href="/themes/default/src/glyphicons.css">
<link rel="stylesheet" href="/themes/default/src/jquery-ui.min.css">
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.js"></script> 
<script type="text/javascript" src="/themes/default/src/jquery.ui.datepicker-vi.js"></script>

<style>
  label {
    width: 100%;
  }
  .btn {
    min-height: 32px !important;
  }
  .select {
    background: rgb(223, 223, 223);
    border: 2px solid deepskyblue;
  }
</style>

<div class="container">
  <div id="msgshow"></div>
  <div id="remove-pet" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-body text-center">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <p>
            Xác nhận xóa?
          </p>
          <button class="btn btn-danger" onclick="removePetSubmit()">
            Xóa
          </button>
        </div>
      </div>
    </div>
  </div>

  <div id="modal-ceti" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-body text-center">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <p>
            Nhập số tiền thu?
          </p>
          <input type="text" class="form-control" id="ceti-price">
          <button class="btn btn-info" onclick="cetiSubmit()">
            Lưu
          </button>
          <button class="btn btn-danger" onclick="removeCetiSubmit()">
            Xóa
          </button>
        </div>
      </div>
    </div>
  </div>

  <div id="modal-owner" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-body">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <div class="text-center">
            <p>
              Chọn chủ cho thú cưng
            </p>
            <div class="input-group">
              <input type="text" class="form-control" id="owner-key" placeholder="Số điện thoại">
              <div class="input-group-btn">
                <button class="btn btn-success" onclick="insertUser()"> <span class="glyphicon glyphicon-plus">  </span> </button>
              </div>
            </div>

            <button class="btn btn-info" onclick="filterOwner()">
              Tìm kiếm
            </button>
          </div>
          <div id="owner-list" style="max-height: 400px; overflow-y: scroll;">

          </div>
        </div>
      </div>
    </div>
  </div>

    <div id="insert-user" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-body text-center">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <p>
            Chỉnh sửa thông tin
          </p>
          <form onsubmit="insertUserSubmit(event)">
            <div class="row">
              <label>
                <div class="col-sm-8">
                  Tên đăng nhập
                </div>
                <div class="col-sm-16">
                  <input type="text" class="form-control" id="username" autocomplete="off">
                </div>
              </label>
            </div>

            <div class="row">
              <label>
                <div class="col-sm-8">
                  Họ và tên
                </div>
                <div class="col-sm-16">
                  <input type="text" class="form-control" id="fullname" autocomplete="off">
                </div>
              </label>
            </div>

            <div class="row">
              <label>
                <div class="col-sm-8">
                  Số CMND
                </div>
                <div class="col-sm-16">
                  <input type="text" class="form-control" id="politic" autocomplete="off">
                </div>
              </label>
            </div>

            <div class="row">
              <label>
                <div class="col-sm-8">
                  Điện thoại
                </div>
                <div class="col-sm-16">
                  <input type="text" class="form-control" id="phone" autocomplete="off">
                </div>
              </label>
            </div>

            <div class="row">
              <label>
                <div class="col-sm-8">
                  Tỉnh
                </div>
                <div class="col-sm-16">
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
                <div class="col-sm-8">
                  Quận/Huyện/Thành phố
                </div>
                <div class="col-sm-16">
                  <!-- BEGIN: l2 -->
                  <select class="form-control al2" id="al2{l1id}" style="display: {active}">
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
                <div class="col-sm-8">
                  Xã/Phường/Thị trấn
                </div>
                <div class="col-sm-16">
                  <input type="text" class="form-control" id="al3" autocomplete="off">
                </div>
              </label>
            </div>

            <div class="row">
              <label>
                <div class="col-sm-8">
                  Địa chỉ
                </div>
                <div class="col-sm-16">
                  <input type="text" class="form-control" id="address" autocomplete="off">
                </div>
              </label>
            </div>

            <div class="text-center">
              <button class="btn btn-info" id="button">
                Chỉnh sửa thông tin
              </button>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>

  <!-- <div id="modal-parent" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <div style="clear: both;"></div>
          <div class="row">
            <div class="col-sm-12">
              <div class="input-group">
                <input type="text" class="form-control" id="parent-key" placeholder="Người dùng theo số điện thoại">
                <div class="input-group-btn">
                  <button class="btn btn-info" onclick="parentFilter()">
                    Tìm kiếm
                  </button>
                </div>
              </div>
              <div id="parent-list" style="max-height: 400px; overflow-y: scroll;">

              </div>
            </div>
            <div class="col-sm-12">
              <div class="input-group">
                <input type="text" class="form-control" id="pet-key" placeholder="Tên, giống loài thú cưng">
                <div class="input-group-btn">
                  <button class="btn btn-info" onclick="petFilter()">
                    Tìm kiếm
                  </button>
                </div>
              </div>
              <div id="pet-list" style="max-height: 400px; overflow-y: scroll;">

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div> -->

  <div id="insert-pet" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-body">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <p class="text-center"> <b>  </b> </p>

          <label class="row">
            <div class="col-sm-6">
              Tên thú cưng
            </div>
            <div class="col-sm-18">
              <input type="text" class="form-control" id="pet-name">
            </div>
          </label>

          <label class="row">
            <div class="col-sm-6">
              Ngày sinh
            </div>
            <div class="col-sm-18">
              <input type="text" class="form-control" id="pet-dob" value="{today}">
            </div>
          </label>

          <label class="row">
            <div class="col-sm-6">
              Giống
            </div>
            <div class="col-sm-18 relative">
              <input type="text" class="form-control" id="species">
              <div class="suggest" id="species-suggest"></div>
            </div>
          </label>

          <label class="row">
            <div class="col-sm-6">
              Loài
            </div>
            <div class="col-sm-18 relative">
              <input type="text" class="form-control" id="breed-pet">
              <div class="suggest" id="breed-suggest-pet"></div>
            </div>
          </label>

          <label class="row">
            <div class="col-sm-6">
              Giới tính
            </div>
            <div class="col-sm-18">
              <label>
                <input type="radio" name="sex" id="pet-sex-0" checked> Đực
              </label>
              <label>
                <input type="radio" name="sex" id="pet-sex-1"> Cái
              </label>
            </div>
          </label>

          <label class="row">
            <div class="col-sm-6">
              Màu sắc
            </div>
            <div class="col-sm-18">
              <input type="text" class="form-control" id="pet-color">
            </div>
          </label>

          <label class="row">
            <div class="col-sm-6">
              Microchip
            </div>
            <div class="col-sm-18">
              <input type="text" class="form-control" id="pet-microchip">
            </div>
          </label>

          <label class="row">
            <div class="col-sm-6">
              Xăm tai
            </div>
            <div class="col-sm-18">
              <input type="text" class="form-control" id="pet-miear">
            </div>
          </label>

          <label class="row">
            <div class="col-sm-6">
              Xuất xứ
            </div>
            <div class="col-sm-18">
              <input type="text" class="form-control" id="origin-pet">
            </div>
          </label>

          <div class="row" id="pet-parent-m">
            <div class="col-sm-12">
              Chó cha
              <div class="relative">
                <div class="input-group">
                  <input class="form-control" id="parent-m" type="text" autocomplete="off">
                  <input class="form-control" id="parent-m-s" type="hidden">
                  <div class="input-group-btn">
                    <button class="btn btn-success" style="min-height: 32px;" onclick="addParent('m')">
                      <span class="glyphicon glyphicon-plus"></span>
                    </button>
                  </div>
                </div>
                <div class="suggest" id="parent-suggest-m"></div>
              </div>
            </div>

            <div class="col-sm-12" id="pet-parent-f">
              Chó mẹ
              <div class="relative">
                <div class="input-group">
                  <input class="form-control" id="parent-f" type="text" autocomplete="off">
                  <input class="form-control" id="parent-f-s" type="hidden">
                  <div class="input-group-btn relative">
                    <button class="btn btn-success" style="min-height: 32px;" onclick="addParent('f')">
                      <span class="glyphicon glyphicon-plus"></span>
                    </button>
                  </div>
                </div>
                <div class="suggest" id="parent-suggest-f"></div>
              </div>
            </div>
          </div>

          <label class="row">
            <div class="col-sm-6">
              Hình ảnh
            </div>
            <div class="col-sm-18">
              <div>
                <img class="img-responsive" id="pet-preview"
                  style="display: inline-block; width: 128px; height: 128px; margin: 10px;">
              </div>
              <input type="file" class="form-control" id="user-image" onchange="onselected(this, 'pet')">
            </div>
          </label>

          <div class="text-center">
            <button class="btn btn-success" id="ibtn" onclick="insertPetSubmit()">
              Thêm thú cưng
            </button>
            <button class="btn btn-success" id="ebtn" onclick="editPetSubmit()" style="display: none;">
              Chỉnh sửa
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  
  <div id="insert-parent" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-body">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <p class="text-center"> <b> Thêm cha mẹ </b> </p>
          <label class="row">
            <div class="col-sm-6">
              Tên thú cưng
            </div>
            <div class="col-sm-18">
              <input type="text" class="form-control" id="parent-name">
            </div>
          </label>

          <label class="row">
            <div class="col-sm-6">
              Ngày sinh
            </div>
            <div class="col-sm-18">
              <input type="text" class="form-control" id="parent-dob">
            </div>
          </label>

          <label class="row">
            <div class="col-sm-6">
              Giống
            </div>
            <div class="col-sm-18 relative">
              <input type="text" class="form-control" id="species-parent">
              <div class="suggest" id="species-parent-suggest"></div>
            </div>
          </label>

          <label class="row">
            <div class="col-sm-6">
              Loài
            </div>
            <div class="col-sm-18 relative">
              <input type="text" class="form-control" id="breed-parent">
              <div class="suggest" id="breed-suggest-parent"></div>
            </div>
          </label>

          <label class="row">
            <div class="col-sm-6">
              Giới tính
            </div>
            <div class="col-sm-18">
              <label>
                <input type="radio" name="psex" id="parent-sex-0" checked> Đực
              </label>
              <label>
                <input type="radio" name="psex" id="parent-sex-1"> Cái
              </label>
            </div>
          </label>

          <label class="row">
            <div class="col-sm-6">
              Màu sắc
            </div>
            <div class="col-sm-18">
              <input type="text" class="form-control" id="parent-color">
            </div>
          </label>

          <label class="row">
            <div class="col-sm-6">
              Microchip
            </div>
            <div class="col-sm-18">
              <input type="text" class="form-control" id="parent-microchip">
            </div>
          </label>

          <label class="row">
            <div class="col-sm-6">
              Xăm tai
            </div>
            <div class="col-sm-18">
              <input type="text" class="form-control" id="parent-miear">
            </div>
          </label>

          <label class="row">
            <div class="col-sm-6">
              Hình ảnh
            </div>
            <div class="col-sm-18">
              <div>
                <img class="img-responsive" id="parent-preview"
                  style="display: inline-block; width: 128px; height: 128px; margin: 10px;">
              </div>
              <input type="file" class="form-control" id="user-image" onchange="onselected(this, 'parent')">
            </div>
          </label>

          <div class="text-center">
            <button class="btn btn-success" onclick="insertParentSubmit()">
              Thêm thú cưng
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <form onsubmit="filterE(event)">
    <div>
      <div style="float: right; width: 30%;">
        <select class="form-control" id="limit">
          <option value="10"> 10 </option>
          <option value="20"> 20 </option>
          <option value="50"> 50 </option>
          <option value="75"> 75 </option>
          <option value="100"> 100 </option>
        </select>
        <br>
        <label> <input type="radio" name="status" class="status" id="status-0" checked> Toàn bộ </label>
        <label> <input type="radio" name="status" class="status" id="status-1"> Chưa xác nhận </label>
        <label> <input type="radio" name="status" class="status" id="status-2"> Đã xác nhận </label>
      </div>

      <div style="float: left; width: 60%;">
        <input type="text" class="form-control" id="filter-owner" placeholder="Tên chủ">
        <input type="text" class="form-control" id="filter-mobile" placeholder="Số điện thoại">
        <input type="text" class="form-control" id="filter-name" placeholder="Tên thú cưng">
        <input type="text" class="form-control" id="filter-species" placeholder="Giống">
        <input type="text" class="form-control" id="filter-breed" placeholder="Loài">
        <input type="text" class="form-control" id="filter-micro" placeholder="Microchip">
        <input type="text" class="form-control" id="filter-miear" placeholder="Xăm tai">
      </div>
    </div>
    <div class="text-center" style="clear: both;">
    <button class="btn btn-info">
      Lọc danh sách thú cưng
    </button>
    </div>
  </form>
  <div style="clear: both;"></div>

  <button class="btn btn-success" style="float: right;" onclick="addPet()">
    <span class="glyphicon glyphicon-plus">  </span>
  </button>
  <button class="btn btn-info" style="float: right;" onclick="selectRow(this)">
    <span class="glyphicon glyphicon-unchecked"></span>
  </button>
  <button class="btn btn-danger select-button" style="float: right;" onclick="removeUserList()" disabled>
    <span class="glyphicon glyphicon-trash"></span>
  </button>
  <button class="btn btn-warning select-button" style="float: right;" onclick="deactiveUserList()" disabled>
    <span class="glyphicon glyphicon-arrow-down"></span>
  </button>
  <button class="btn btn-info select-button" style="float: right;" onclick="activeUserList()" disabled>
    <span class="glyphicon glyphicon-arrow-up"></span>
  </button>
      
  <div id="pet-list">
    {list}
  </div>
</div>

<script src="https://www.gstatic.com/firebasejs/6.0.2/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/5.7.0/firebase-storage.js"></script>
<script>
  var global = {
    login: 1,
    text: ['Đăng ky', 'Đăng nhập'],
    url: '{origin}',
    page: 1,
    parent: 'm',
    id: -1,
    userid: -1,
    owner: {},
    petid: 0,
    parentid: 0,
    user_parent: 0
  }
  var user = {
    username: $("#username"),
    fullname: $("#fullname"),
    politic: $("#politic"),
    al1: $("#al1"),
    al2: $("#al2"),
    al3: $("#al3"),
    mobile: $("#phone"),
    address: $("#address")
  }

  var pet = {
    name: $("#pet-name"),
    dob: $("#pet-dob"),
    species: $("#species"),
    breed: $("#breed-pet"),
    sex0: $("#pet-sex-0"),
    sex1: $("#pet-sex-1"),
    color: $("#pet-color"),
    microchip: $("#pet-microchip"),
    miear: $("#pet-miear"),
    origin: $("#origin-pet"),
    parentm: $("#parent-m-s"),
    parentf: $("#parent-f-s")
  }
  var parent = {
    name: $("#parent-name"),
    dob: $("#parent-dob"),
    sex0: $("#parent-sex-0"),
    sex1: $("#parent-sex-1"),
    color: $("#parent-color"),
    microchip: $("#parent-microchip"),
    miear: $("#pet-miear"),
    species: $("#species-parent"),
    breed: $("#breed-parent")
  }

  var politic = $("#politic")
  var error = $("#error")

  var al1 = $("#al1")
  var al2 = $("#al2")
  var al3 = $("#al3")

  var position = JSON.parse('{position}')

  var remind = JSON.parse('{remind}')
  var transferOwner = $("#pet-owner")
  var insertParent = $("#insert-parent")
  var keyword = $("#keyword")
  var limit = $("#limit")
  var cstatus = $(".status")
  var insertPet = $("#insert-pet")
  var removetPet = $("#remove-pet")
  var petList = $("#pet-list")
  var tabber = $(".tabber")
  var ibtn = $("#ibtn")
  var ebtn = $("#ebtn")
  var petPreview = $("#pet-preview")
  var maxWidth = 512
  var maxHeight = 512
  var imageType = ["jpeg", "jpg", "png", "bmp", "gif"]
  var metadata = {
    contentType: 'image/jpeg',
  };
  var file, filename
  var uploadedUrl = ''
  uploaded = {}

  var firebaseConfig = {
    apiKey: "AIzaSyAgxaMbHnlYbUorxXuDqr7LwVUJYdL2lZo",
    authDomain: "petcoffee-a3cbc.firebaseapp.com",
    databaseURL: "https://petcoffee-a3cbc.firebaseio.com",
    projectId: "petcoffee-a3cbc",
    storageBucket: "petcoffee-a3cbc.appspot.com",
    messagingSenderId: "351569277407",
    appId: "1:351569277407:web:8ef565047997e013"
  };
  
  firebase.initializeApp(firebaseConfig);

  var storage = firebase.storage();
  var storageRef = firebase.storage().ref();

  $("#pet-dob, #parent-dob").datepicker({
    format: 'dd/mm/yyyy',
    changeMonth: true,
    changeYear: true
  });

  var thumbnail
  var canvas = document.createElement('canvas')

  var thumbnailImage = new Image()
  thumbnailImage.src = '/themes/default/images/thumbnail.jpg'
  thumbnailImage.onload = (e) => {
    var context = canvas.getContext('2d')
    var width = thumbnailImage.width
    var height = thumbnailImage.height
    var x = width
    if (height > width) {
      x = height
    }
    var rate = 256 / x
    canvas.width = rate * width
    canvas.height = rate * height

    context.drawImage(thumbnailImage, 0, 0, width, height, 0, 0, canvas.width, canvas.height)
    thumbnail = canvas.toDataURL("image/jpeg")
  }

  $(this).ready(() => {
    installRemind('m', 'parent')
    installRemind('f', 'parent')
    // installRemindv2('pet', 'species')
    installRemindv2('pet', 'breed')
    installRemindv2('pet', 'origin')
    // installRemindv2('parent', 'species')
    installRemindv2('parent', 'breed')
    installRemindOwner('pet-owner')
    installRemindSpecies('species')
    installRemindSpecies('species-parent')
    installSelect()
  })

  function installSelect() {
    $("tbody").click((e) => {
      var current = e.currentTarget
      if (global['select']) {
        if (current.className == 'select') {
          global['select'].forEach((element, index) => {
            if (element == current) {
              global['select'].splice(index, 1)
            }
          });
          current.className = ''
        }
        else {
          global['select'].push(current)
          current.className = 'select'
        }
      }
    })
  }

  function lock(id, type) {
    $.post(
      global['url'],
      {action: 'lock', id: id, type: type, filter: checkFilter()},
      (response, status) => {
        checkResult(response, status).then(data => {
          petList.html(data['html'])
        }, () => {})
      }
    )
  }

  function selectRow(button) {
    if (global['select']) {
      button.children[0].className = 'glyphicon glyphicon-unchecked'
      $(".select-button").prop('disabled', true)
      global['select'].forEach(item => {
        item.className = ''
      })
      global['select'] = false
    }
    else {
      button.children[0].className = 'glyphicon glyphicon-check'
      $(".select-button").prop('disabled', false)
      global['select'] = []
    }
  }

  function removeUserList() {
    if (global['select'].length) {
      var list = []
      global['select'].forEach((item, index) => {
        list.push(item.getAttribute('id'))
      })
      freeze()
      $.post(
        global['url'],
        {action: 'remove-user-list', list: list.join(', '), filter: checkFilter()},
        (response, status) => {
          checkResult(response, status).then(data => {
            installSelect()
            petList.html(data['html'])
          }, () => {})
        }
      )
    }    
  }

  function activeUserList() {
    if (global['select'].length) {
      var list = []
      global['select'].forEach((item, index) => {
        list.push(item.getAttribute('id'))
      })
      freeze()
      $.post(
        global['url'],
        {action: 'active-user-list', list: list.join(', '), filter: checkFilter()},
        (response, status) => {
          checkResult(response, status).then(data => {
            installSelect()
            petList.html(data['html'])
          }, () => {})
        }
      )
    }    
  }

  function deactiveUserList() {
    if (global['select'].length) {
      var list = []
      global['select'].forEach((item, index) => {
        list.push(item.getAttribute('id'))
      })
      freeze()
      $.post(
        global['url'],
        {action: 'deactive-user-list', list: list.join(', '), filter: checkFilter()},
        (response, status) => {
          checkResult(response, status).then(data => {
            installSelect()
            petList.html(data['html'])
          }, () => {})
        }
      )
    }    
  }

  function push(id) {
    $.post(
      global['url'],
      {action: 'push', id: id},
      (response, status) => {
        checkResult(response, status).then(data => {
          console.log('success');          
        }, () => {})
      }
    )
  }

  function pickOwner(id, userid, mobile) {
    global['petid'] = id
    global['userid'] = userid
    $("#owner-key").val(mobile)
    $("#modal-owner").modal('show')
  }

  function filterOwner() {
    $.post(
      global['url'],
      {action: 'filter-owner', key: $("#owner-key").val()},
      (response, status) => {
        checkResult(response, status).then(data => {
          $("#owner-list").html(data['html'])
        }, () => {})
      }
    )
  }  

  function thisOwner(id) {
    $.post(
      global['url'],
      {action: 'change-owner', userid: id, id: global['petid'], filter: checkFilter()},
      (response, status) => {
        checkResult(response, status).then(data => {
          petList.html(data['html'])
          $("#modal-owner").modal('hide')
          // $("#owner-list").html(data['html'])
        }, () => {})
      }
    )
  }

  function onselected(input, previewname) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      var fullname = input.files[0].name
      var name = Math.round(new Date().getTime() / 1000) + '_' + fullname.substr(0, fullname.lastIndexOf('.'))
      var extension = fullname.substr(fullname.lastIndexOf('.') + 1)
      uploaded[previewname] = {}
      filename = name + '.' + extension

      reader.onload = function (e) {
        var type = e.target["result"].split('/')[1].split(";")[0];
        if (["jpeg", "jpg", "png", "bmp", "gif"].indexOf(type) >= 0) {
          var image = new Image();
          image.src = e.target["result"];
          image.onload = (e2) => {
            var c = document.createElement("canvas")
            var ctx = c.getContext("2d");
            var ratio = 1;
            if (image.width > maxWidth)
              ratio = maxWidth / image.width;
            else if (image.height > maxHeight)
              ratio = maxHeight / image.height;
            c.width = image["width"];
            c.height = image["height"];
            ctx.drawImage(image, 0, 0);
            var cc = document.createElement("canvas")
            var cctx = cc.getContext("2d");
            cc.width = image.width * ratio;
            cc.height = image.height * ratio;
            cctx.fillStyle = "#fff";
            cctx.fillRect(0, 0, cc.width, cc.height);
            cctx.drawImage(c, 0, 0, c.width, c.height, 0, 0, cc.width, cc.height);
            file = cc.toDataURL("image/jpeg")
            $("#" + previewname + "-preview").attr('src', file)
            file = file.substr(file.indexOf(',') + 1);
            uploaded[previewname] = {
              url: '',
              file: file,
              name: filename              
            }
          }
        };
      };

      if (imageType.indexOf(extension) >= 0) {
        reader.readAsDataURL(input.files[0]);
      }
    }
  }

  function deletePet(id) {
    global['id'] = id
    removetPet.modal('show')
  }

  function removePetSubmit() {
    $.post(
      global['url'],
      {action: 'remove', id: global['id'], filter: checkFilter()},
      (response, status) => {
        checkResult(response, status).then(data => {
          petList.html(data['html'])
          removetPet.modal('hide')
        }, () => {})
      }
    )
  }

  function editPet(id) {
    $.post(
      global['url'],
      { action: 'get', id: id },
      (response, status) => {
        checkResult(response, status).then(data => {
          global['id'] = id
          parseInputSet(data['data'], pet)
          $("#pet-owner").val(data['more']['username'])
          $("#parent-f").val(data['more']['f'])
          $("#parent-m").val(data['more']['m'])
          $("#pet-sex-" + data['more']['sex']).prop('checked', true)
          if (data['more']['userid']) {
            global['user_parent'] = data['more']['userid']
            $("#pet-parent-m").show()
            $("#pet-parent-f").show()
          }
          else {
            global['user_parent'] = 0
            $("#pet-parent-m").hide()
            $("#pet-parent-f").hide()
          }
          var image = new Image()
          image.src = data['image']
          petPreview.attr('src', thumbnail)
          image.addEventListener('load', (e) => {
            petPreview.attr('src', image.src)
          })

          ibtn.hide()
          ebtn.show()
          insertPet.modal('show')
        }, () => { })
      }
    )
  }

  function deleteImage(url) {
    return new Promise((resolve) => {
      if (!url) {
        resolve()
      }
      url = url.substr(0, url.search(/\?alt=/))
      var xref = storage.refFromURL(url);

      xref.delete().then(function() {
        resolve()        
      }).catch(function(error) {
        resolve()        
      });
    })
  }

  function editPetSubmit() {
    freeze()
    uploader('pet').then((imageUrl) => {
      $.post(
        global['url'],
        { action: 'editpet', id: global['id'], data: checkPetData(), image: imageUrl, filter: checkFilter(), tabber: global['tabber'] },
        (response, status) => {
          checkResult(response, status).then(data => {
            deleteImage(data['image']).then(() => {
              uploaded['pet'] = {}
              petList.html(data['html'])
              clearInputSet(pet)
              file = false
              filename = ''
              $("#parent-m").val('')
              $("#parent-f").val('')
              petPreview.val('')
              remind = JSON.parse(data['remind'])
              insertPet.modal('hide')
            })
          }, () => { })
        }
      )
    })
  }

  function checkPetData() {
    var data = checkInputSet(pet)
    data['breeder'] = $("#pet-breeder").prop('checked')
    data['sex0'] = pet['sex0'].prop('checked')
    data['sex1'] = pet['sex1'].prop('checked')
    return data
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

  function checkFilter() {
    var temp = cstatus.filter((index, item) => {
      return item.checked
    })
    var value = 0
    if (temp[0]) {
      value = splipper(temp[0].getAttribute('id'), 'status')
    }
    var data = {
      owner: $("#filter-owner").val(),
      mobile: $("#filter-mobile").val(),
      name: $("#filter-name").val(),
      species: $("#filter-species").val(),
      breed: $("#filter-breed").val(),
      micro: $("#filter-micro").val(),
      miear: $("#filter-miear").val(),
      page: global['page'],
      limit: limit.val(),
      status: value
    }
    return data
  }

  function goPage(page) {
    global['page'] = page
    $.post(
      global['url'],
      {action: 'filter', filter: checkFilter()},
      (response, status) => {
        checkResult(response, status).then(data => {
          petList.html(data['html'])
        }, () => {})
      }
    )
  }

  function filterE(e) {
    e.preventDefault()
    goPage(1)
  }

  function check(id, type) {
    $.post(
      global['url'],
      {action: 'check', id: id, type: type, filter: checkFilter()},
      (response, status) => {
        checkResult(response, status).then(data => {
          petList.html(data['html'])
        }, () => {})
      }
    )
  }

  function addPet() {
    ibtn.show()
    ebtn.hide()
    insertPet.modal('show')
    clearInputSet(pet)
    // $("#pet-dob").val(mostly['pet']['dob'])
    $("#pet-parent-m").hide()
    $("#pet-parent-f").hide()
    $("#parent-m").val('')
    $("#parent-f").val('')
    petPreview.attr('src', thumbnail)
  }

  function insertPetSubmit() {
    freeze()
    uploader('pet').then(imageUrl => {
      $.post(
        global['url'],
        { action: 'insertpet', data: checkPetData(), filter: checkFilter(), tabber: global['tabber'], image: imageUrl },
        (response, status) => {
          checkResult(response, status).then(data => {
            uploaded['pet'] = {}
            petList.html(data['html'])
            file = false
            filename = ''
            clearInputSet(pet)
            $("#parent-m").val('')
            $("#parent-f").val('')
            $("#pet-breeder").prop('checked', true)
            petPreview.val('')
            remind = JSON.parse(data['remind'])
            insertPet.modal('hide')
            pickOwner(data['id'], 0, '')
          }, () => { })
        }
      )
    })
  }

  function clearInputSet(dataSet) {
    for (const dataKey in dataSet) {
      if (dataSet.hasOwnProperty(dataKey)) {
        dataSet[dataKey].val('')
      }
    }
  }

  function checkInputSet(dataSet) {
    var data = {}

    for (const dataKey in dataSet) {
      if (dataSet.hasOwnProperty(dataKey)) {
        const cell = dataSet[dataKey];

        data[dataKey] = cell.val()
      }
    }

    return data
  }

  function parseInputSet(dataSet, inputSet) {
    for (const dataKey in dataSet) {
      if (dataSet.hasOwnProperty(dataKey)) {
        inputSet[dataKey].val(dataSet[dataKey])
      }
    }
  }

  function uploader(name) {
    return new Promise(resolve => {
      if (!uploaded[name] || !uploaded[name]['file']) {
        resolve('')
      }
      else if (uploaded[name]['url']) {
        resolve(uploaded[name]['url'])
      }
      else {
        var uploadTask = storageRef.child('images/' + uploaded[name]['filename'] + '?t=' + new Date().getTime() / 1000).putString(uploaded[name]['file'], 'base64', metadata);
        uploadTask.on(firebase.storage.TaskEvent.STATE_CHANGED, // or 'state_changed'
          function(snapshot) {
            var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
            console.log('Upload is ' + progress + '% done');
            switch (snapshot.state) {
              case firebase.storage.TaskState.PAUSED: // or 'paused'
                console.log('Upload is paused');
                break;
              case firebase.storage.TaskState.RUNNING: // or 'running'
                console.log('Upload is running');
                break;
            }
          }, function(error) {
            resolve('')
            switch (error.code) {
              case 'storage/unauthorized':
                // User doesn't have permission to access the object
              break;
              case 'storage/canceled':
                // User canceled the upload
              break;
              case 'storage/unknown':
                // Unknown error occurred, inspect error.serverResponse
              break;
            }
          }, function() {
            // Upload completed successfully, now we can get the download URL
            uploadTask.snapshot.ref.getDownloadURL().then(function(downloadURL) {
            uploaded[name]['url'] = downloadURL
            resolve(downloadURL)
            console.log('File available at', downloadURL);
          });
        });
      }
    })
	}

  function checkPet(id, type) {
    $.post(
      global['url'],
      {action: 'checkpet', id: id, type: type, filter: checkFilter()},
      (response, status) => {
        checkResult(response, status).then(data => {
          petList.html(data['html'])
        }, () => {})
      }
    )
  }

  // function editPetSubmit() {
  //   $.post(
  //     global['url'],
  //     {action: 'editpet', id: global['id'], data: checkInputSet(pet)},
  //     (response, status) => {
  //       checkResult(response, status).then(data => {
  //         petList.html(data['html'])
  //         clearInputSet(user)
  //         insertUser.modal('hide')
  //       }, () => {})
  //     }
  //   )
  // }
  
  function insertParentSubmit() {
    freeze()
    uploader('parent').then((imageUrl) => {
      $.post(
        global['url'],
        { action: 'insert-parent', id: global['id'], userid: global['user_parent'], data: checkInputSet(parent), image: imageUrl, filter: checkFilter(), tabber: global['tabber'] },
        (response, status) => {
          checkResult(response, status).then(data => {
            uploaded['parent'] = {}
            petList.html(data['html'])
            clearInputSet(parent)
            file = false
            filename = ''
            $("#parent-preview").attr('src', thumbnail)
            remind = JSON.parse(data['remind'])
            insertParent.modal('hide')
            $("#parent-breeder").prop('checked', true)
            $("#parent-" + global['parent']).val(data['name'])
            $("#parent-" + global['parent'] + '-s').val(data['id'])
          }, () => { })
        }
      )
    })
  }

  function addParent(name) {
    insertParent.modal('show')
    global['parent'] = name
    clearInputSet(parent)
    petPreview.val('')
    $("#parent" + global['parent']).val('')
    $("#parent" + global['parent' + '-s']).val(0)
  }


  function selectRemindv2(name, type, value) {
    $("#" + type + "-" + name).val(value)
  }

  function pickParent(e, name, id) {
    var idp = splipper(e.parentNode.getAttribute('id'), 'parent-suggest')
    $('#parent-' + idp + '-s').val(id)
    $('#parent-' + idp).val(name)
  }

  function pickSpecies(name, id) {
    if (($("#insert-parent").data('bs.modal') || {}).isShown) {
      $("#species-parent").val(name)
    }
    else {
      $("#species").val(name)
    }
  }

  function installRemindOwner(section) {
    var timeout
    var input = $("#" + section)
    var suggest = $("#" + section + "-suggest")
    console.log("#" + section + "-suggest", suggest);

    input.keyup(() => {
      clearTimeout(timeout)
      timeout = setTimeout(() => {
        var key = paintext(input.val())
        var html = ''

        $.post(
          global['url'],
          { action: 'parent2', keyword: key },
          (response, status) => {
            checkResult(response, status).then(data => {
              suggest.html(data['html'])
            }, () => { })
          }
        )

        suggest.html(html)
      }, 200);
    })
    input.focus(() => {
      suggest.show()
    })
    input.blur(() => {
      setTimeout(() => {
        suggest.hide()
      }, 200);
    })
  }

  function installRemindSpecies(section) {
    var timeout
    var input = $("#" + section)
    var suggest = $("#" + section + "-suggest")    

    input.keyup(() => {
      clearTimeout(timeout)
      timeout = setTimeout(() => {
        var key = paintext(input.val())
        var html = ''

        $.post(
          global['url'],
          { action: 'species', keyword: key },
          (response, status) => {
            checkResult(response, status).then(data => {
              suggest.html(data['html'])
            }, () => { })
          }
        )

        suggest.html(html)
      }, 200);
    })
    input.focus(() => {
      suggest.show()
    })
    input.blur(() => {
      setTimeout(() => {
        suggest.hide()
      }, 200);
    })
  }

  function ceti(petid, price) {
    global['petid'] = petid
    $("#ceti-price").val(price)
    $("#modal-ceti").modal('show')
  }

  function cetiSubmit() {
    $.post(
      global['url'],
      { action: 'ceti', price: $("#ceti-price").val(), petid: global['petid'], filter: checkFilter() },
      (response, status) => {
        checkResult(response, status).then(data => {
          petList.html(data['html'])
          $("#modal-ceti").modal('hide')
        }, () => { })
      }
    )
  }

  function removeCetiSubmit() {
    $.post(
      global['url'],
      { action: 'remove-ceti', petid: global['petid'], filter: checkFilter() },
      (response, status) => {
        checkResult(response, status).then(data => {
          petList.html(data['html'])
          $("#modal-ceti").modal('hide')
        }, () => { })
      }
    )
  }

  function installRemind(name, type) {
    var timeout
    var input = $("#" + type + "-" + name)
    var suggest = $("#" + type + "-suggest-" + name)

    input.keyup(() => {
      clearTimeout(timeout)
      timeout = setTimeout(() => {
        var key = paintext(input.val())
        var html = ''

        $.post(
          global['url'],
          { action: 'parent', keyword: key },
          (response, status) => {
            checkResult(response, status).then(data => {
              suggest.html(data['html'])
            }, () => { })
          }
        )

        suggest.html(html)
      }, 200);
    })
    input.focus(() => {
      suggest.show()
    })
    input.blur(() => {
      setTimeout(() => {
        suggest.hide()
      }, 200);
    })
  }

  function installRemindv2(name, type) {
    var timeout
    var input = $("#" + type + "-" + name)
    var suggest = $("#" + type + "-suggest-" + name)

    input.keyup(() => {
      clearTimeout(timeout)
      timeout = setTimeout(() => {
        var key = paintext(input.val())
        var html = ''

        for (const index in remind[type]) {
          if (remind[type].hasOwnProperty(index)) {
            const element = paintext(remind[type][index]['name']);

            if (element.search(key) >= 0) {
              html += '<div class="suggest_item" onclick="selectRemindv2(\'' + name + '\', \'' + type + '\', \'' + remind[type][index]['name'] + '\')"><p class="right-click">' + remind[type][index]['name'] + '</p></div>'
            }
          }
        }
        suggest.html(html)
      }, 200);
    })
    input.focus(() => {
      suggest.show()
    })
    input.blur(() => {
      setTimeout(() => {
        suggest.hide()
      }, 200);
    })
  }

  function insertUser() {
    $("#insert-user").modal('show')
  }

  function insertUserSubmit(e) {
    e.preventDefault()
    $.post(
      global['url'],
      {action: 'insert-user', data: checkEdit()},
      (response, status) => {
        checkResult(response, status).then(data => {
          clearInputSet(user)
          $("#owner-key").val(data['mobile'])
          $("#insert-user").modal('hide')
          thisOwner(data['id'])
        }, () => {})
      }
    )
  }

  function checkEdit() {
    var check = true
    var data = checkInputSet(user)

    data['a1'] = position[user['al1'].val()]['name']
    data['a2'] = position[user['al1'].val()]['district'][$("#al2" + user['al1'].val()).val()]
    data['a3'] = al3.val()
    delete data['al1']
    delete data['al2']
    delete data['al3']

    return data
  }

  function searchPosition(area = '') {
    result = 0
    position.forEach((item, index) => {
      if (item['name'] == area) {
        result = index
      }
    })
    return result
  }

  function searchPosition2(areaname, district = '') {
    if (areaname < 0) {
      areaname = 0
    }
    result = 0
    position[areaname]['district'].forEach((item, index) => {
      if (item == district) {
        result = index
      }
    })
    return result
  }

  function l1(e) {
    var value = e.value

    $(".al2").hide()
    $("#al2" + value).show()
  }

</script>
<!-- END: main -->
