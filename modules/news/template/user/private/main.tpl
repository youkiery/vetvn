<!-- Cá nhân -->
<!-- BEGIN: main -->
<link rel="stylesheet" href="/themes/default/images/glyphicons.css">
<style>
  .modal {
    overflow-y: auto;
  }
  
  .text-red {
    color: red;
    font-size: 1.2em;
    font-weight: bold;
  }

  .image-box {
    margin: 5px;
    float: left;
    width: auto;
  }
  
  .image-content {
    width: 100px;
    height: 100px;
    background: white;
  }

  .image-content img {
    max-width: 100px;
    max-height: 100px;
  }

  .image-function {
    margin: auto;
    width: 100px;
    margin-top: 5px;
  }

  .icon {
    width: 20px;
    height: 20px;
    float: left;
    margin: 0px 5px;
  }
</style>

<div class="container">
  <div id="loading">
    <div class="black-wag"> </div>
    <img class="loading" src="/themes/default/images/loading.gif">
  </div>
  <div id="msgshow"></div>

  {modal}

  <a href="/">
    <img src="/themes/default/images/banner.png" style="width: 200px;">
  </a>

  <div style="float: right;">
    <a href="/{module_file}/logout"> Đăng xuất </a>
  </div>

  <h2> Thông tin cá nhân </h2>
  <div style="float: left; width: 250px; height: 250px; overflow: hidden;" class="thumbnail" id="avatar">
  </div>
  <div style="float: left; margin-left: 10px;">
    <div class="form-group"> Tên: {fullname} </div>
    <div class="form-group"> Điện thoại: {mobile} </div>
    <div class="form-group"> Địa chỉ: {address} </div>

    <div class="form-group">
      <button class="btn btn-info" onclick="editUser({userid})">
        Chỉnh sửa thông tin
      </button>
      <!-- <button class="btn btn-info" onclick="centerConfirm()">
        Đăng ký trại
      </button> -->
    </div>

    <div class="form-group">
      <button class="btn btn-info" onclick="changeMail()">
        Email
      </button>
      <button class="btn btn-info" onclick="changePassword()">
        Đổi mật khẩu
      </button>
    </div>

    <div class="form-group">
      <a class="btn btn-info" href="/news/sendinfo"> Yêu cầu cấp chứng nhận </a>
    </div>
  </div>
  <div style="clear: left;"></div>
  <p> <a href="/{module_file}/trading"> Quản lý mua, bán, phối</a> <span style="font-weight: bold; color: red;">{intro_count}</span></p>
  <p> <a href="/{module_file}/transfer"> Danh sách chuyển nhượng <span style="font-weight: bold; color: red;">{transfer_count}</span> </a> </p>
  <p> <a href="/{module_file}/reserve"> Danh sách bán, mất</a> </p>
  <p> <a href="/{module_file}/contact"> Danh sách khách hàng </a> </p>
  <!-- BEGIN: xter -->
  <p> <a href="/{module_file}/statistic"> Danh sách thu chi</a> </p>
  <!-- END: xter -->
  <h2> Danh sách thú cưng </h2>

  <form>
    <div class="form-group rows">
      <div class="col-3">
        <input type="text" class="form-control" name="keyword" placeholder="Từ khóa">
      </div>
      <div class="col-3">
        <select class="form-control" name="limit">
          <option value="10">10</option>
          <option value="20">20</option>
          <option value="50">50</option>
          <option value="100">100</option>
        </select>
      </div>
      <div class="col-3">
        <button class="btn btn-info">
          Tìm kiếm
        </button>
      </div>
    </div>
  </form>

  <div class="form-group" style="text-align: right;">
    <button class="btn btn-success" onclick="sendinfoModal()">
      Thêm thú cưng
    </button>
  </div>

  <div style="clear: both;"></div>
  <div></div>

  <div id="content">
    {content}
  </div>
</div>

<script src="/modules/core/vhttp.js"></script>
<script src="/modules/core/vimage.js"></script>
<script src="/modules/core/vremind-5.js"></script>
<script src="/modules/core/src/jquery.ui.datepicker-vi.js"></script>
<script src="https://www.gstatic.com/firebasejs/6.0.2/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/5.7.0/firebase-storage.js"></script>
<script>
  var global = {
    login: 1,
    text: ['Đăng ky', 'Đăng nhập'],
    url: '{origin}',
    id: -1,
    parent: 'm',
    tabber: [{tabber}],
    page: 1,
    request: -1,
    type: 0,
    pet: {
      0: 0,
      1: 0
    },
    petobj: {
      0: 'father',
      1: 'mother'
    },
    user: {
      name: '{fullname}',
      mobile: '{mobile}'
    },
    breeder: 0,
    owner: 0
  }
  var notify = {
    'name': 'Nhập tên thú cưng trước khi gửi',
    'birthtime': 'Chọn ngày sinh trước khi gửi',
    'species': 'Chọn giống loài trước khi gửi',
    'color': 'Chọn màu lông trước khi gửi',
    'type': 'Chọn kiểu lông trước khi gửi'
  }
  var sex_data = ['Đực', 'Cái']
  var image_data = []

  var vaccine = {
    type: $("#vaccine-type"),
    time: $("#vaccine-time"),
    recall: $("#vaccine-recall")
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
  var user = {
    username: $("#username"),
    fullname: $("#fullname"),
    politic: $("#politic"),
    mobile: $("#phone"),
    address: $("#address")
  }
  var position = JSON.parse('{position}')
  var al1 = $("#al1")
  var al2 = $("#al2")
  var al3 = $("#al3")
  var owner = {
    fullname: $("#owner-name"),
    mobile: $("#owner-mobile"),
    address: $("#owner-address"),
    politic: $("#owner-politic")
  }
  var mostly = {
    pet: {
      dob: '{today}',
      species: '{most_species}',
      breeder: '{most_breeder}',
      origin: '{most_oringin}'
    }
  }
  var vaccine = {
    type: $("#vaccine-type"),
    time: $("#vaccine-time"),
    recall: $("#vaccine-recall")
  }

  var uploadedUrl = ''
  var vaccineContent = $("#vaccine-content")
  var insertDiseaseSuggest = $("#insert-disease-suggest")
  var userImage = $("#user-image")
  var userPreview = $("#user-preview")
  var petPreview = $("#pet-preview")
  var username = $("#username")
  var password = $("#password")
  var vpassword = $("#vpassword")
  var fullname = $("#fullname")
  var phone = $("#phone")
  var address = $("#address")
  var keyword = $("#keyword")
  var cstatus = $(".status")
  var button = $("#button")
  var searchLimit = $("#search-limit")
  var searchKeyword = $("#search-keyword")
  var ibtn = $("#ibtn")
  var ebtn = $("#ebtn")

  var transferPet = $("#transfer-pet")
  var transferOwner = $("#transfer-owner")
  var insertOwner = $("#insert-owner")
  var insertPet = $("#insert-pet")
  var insertParent = $("#insert-parent")
  var petVaccine = $("#pet-vaccine")
  var requestContent = $("#request-content")
  var requestDetail = $("#request-detail")
  var removetPet = $("#remove-pet")
  var removetUser = $("#remove-user")
  var petList = $("#pet-list")
  var userList = $("#user-list")
  var tabber = $(".tabber")
  var maxWidth = 512
  var maxHeight = 512
  var imageType = ["jpeg", "jpg", "png", "bmp", "gif"]
  var metadata = {
    contentType: 'image/jpeg',
  };
  var file, filename
  var uploaded = {}
  remind = JSON.parse('{remind}')
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

  tabber.click((e) => {
    var className = e.currentTarget.getAttribute('class')
    global[login] = Number(splipper(className, 'tabber'))
    // button.text(global['text'][global['login']])
  })

  $("#pet-dob, #parent-dob, #vaccine-time, #vaccine-recall").datepicker({
    format: 'dd/mm/yyyy',
    changeMonth: true,
    changeYear: true
  });

  loadImage('{image}', 'avatar')

  $(this).ready(() => {
    installRemind('m', 'parent')
    installRemind('f', 'parent')
    // installRemindv2('pet', 'species')
    installRemindv2('buy', 'breed')
    installRemindv2('buy', 'species')
    installRemindv2('pet', 'breed')
    installRemindv2('pet', 'origin')
    // installRemindv2('parent', 'species')
    installRemindv2('parent', 'breed')
    installRemindOwner('transfer-owner')
    installRemindSpecies('species')
    installRemindSpecies('species-parent')
  })

  function doneSubmit() {
    freeze()
    $.post(
      global['url'],
      {action: 'done', id: global['id'], filter: checkFilter(), tabber: global['tabber']},
      (response, status) => {
        checkResult(response, status).then(data => {
          petList.html(data['html'])
          $("#transfer-pet").modal('hide')
        }, () => {})
      }
    )    
  }

  function buy() {
    $("#buy-sex-0").prop('checked', true)
    $("#buy-age-check").prop('checked', true)
    $("#buy-age").prop('disabled', true)
    $("#user-buy").modal('show')
  }

  $("#buy-age-check").change(() => {
    if ($("#buy-age-check").prop('checked')) {
      $("#buy-age").prop('disabled', true)
      $("#buy-age").val('')
    }
    else {
      $("#buy-age").prop('disabled', false)
      $("#buy-age").val('1')
    }
  })

  $("#buy-price-check").change(() => {
    if ($("#buy-price-check").prop('checked')) {
      $("#buy-price-from").prop('disabled', true)
      $("#buy-price-end").prop('disabled', true)
      $("#buy-price").text('')
    }
    else {
      $("#buy-price-from").prop('disabled', false)
      $("#buy-price-end").prop('disabled', false)
      $("#buy-price").text(checkPrice())
    }
  })

  $("#buy-price-from, #buy-price-end").change(() => {
    $("#buy-price").text(checkPrice())
  })

  function checkPrice() {
    var from = $("#buy-price-from").val()
    var end = $("#buy-price-end").val()

    if (end - from < 0) {
      $("#buy-price-from").val(end)
      $("#buy-price-end").val(from)
      temp = from
      from = end
      end = temp
    }

    return 'Từ ' + parseCurrency(from * 100000) + ' đến ' + parseCurrency(end * 100000)
  }

  function checkBuyData() {
    var sex = splipper($("[name=sex4]:checked").attr('id'), 'buy-sex-')
    sex.length ? '' : sex = 0
    var age = $("#buy-age").val()
    if ($("#buy-age-check").prop('checked')) {
      age = 0
    }
    var price = $("#buy-price-check").prop('checked')
    if (!price) {
      var from = $("#buy-price-from").val()
      var end = $("#buy-price-end").val()
      price = from + '-' + end
    }
    else price = 0
    return {
      species: $("#species-buy").val(),
      breed: $("#breed-buy").val(),
      sex: sex,
      age: age,
      price: price,
      note: $("#buy-note").val()
    }
  }

  function buySubmit() {
    data = checkBuyData()
    freeze()
    $.post(
      global['url'],
      {action: 'buy', data: data},
      (response, status) => {
        checkResult(response, status).then(data => {
          $("#user-buy").modal('hide')
        }, () => {})
      }
    )    
  }

  function sellSubmit() {
    freeze()
    $.post(
      global['url'],
      {action: 'sell', id: global['id']},
      (response, status) => {
        checkResult(response, status).then(data => {
          $("#market-content").html(data['html'])
        }, () => {})
      }
    )    
  }

  function unsellSubmit() {
    freeze()
    $.post(
      global['url'],
      {action: 'unsell', id: global['id']},
      (response, status) => {
        checkResult(response, status).then(data => {
          $("#market-content").html(data['html'])
        }, () => {})
      }
    )    
  }

  function breedingSubmit() {
    freeze()
    $.post(
      global['url'],
      {action: 'breeding', id: global['id']},
      (response, status) => {
        checkResult(response, status).then(data => {
          $("#market-content").html(data['html'])
        }, () => {})
      }
    )    
  }

  function unbreedingSubmit() {
    freeze()
    $.post(
      global['url'],
      {action: 'unbreeding', id: global['id']},
      (response, status) => {
        checkResult(response, status).then(data => {
          $("#market-content").html(data['html'])
        }, () => {})
      }
    )    
  }

  function changeMail() {
    $("#user-mail").modal('show')
  }

  function changeMailSubmit() {
    var mail = $("#imail").val().trim()
    if (!/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(mail)) {
      $("#mail-error").text('Không đúng định dạng')
    }
    else {
      $("#mail-error").text('')
      freeze()
      $.post(
        global['url'],
        {action: 'change-mail', mail: mail},
        (response, status) => {
          checkResult(response, status).then(data => {
            $("#mail-error").text(data['error'])
            $("#user-mail").modal('hide')
          }, () => { })
        }
      )
    }
  }

  function changePassword() {
    $("#user-pass").modal('show')
  }

  function changePasswordSubmit() {
    var pass1 = $("#pass-v1").val().trim(), pass2 = $("#pass-v2").val().trim(), pass3 = $("#pass-v3").val().trim()
    if (!pass1 || !pass2 || !pass3) {
      $("#pass-error").text('Các trường không được trống')
    }
    else if (pass3!== pass2) {
      $("#pass-error").text('Mật khẩu không trùng nhau')
    }
    else {
      $("#pass-error").text('')
      freeze()
      $.post(
        global['url'],
        {action: 'change-pass', opass: pass1, npass: pass3},
        (response, status) => {
          checkResult(response, status).then(data => {
            $("#user-pass").modal('hide')
          }, () => { })
        }
      )
    }
  }

  function centerConfirm() {
    $("#center-confirm").modal('show')
  }

  function pickSpecies(name, id) {
    if (($("#insert-parent").data('bs.modal') || {}).isShown) {
      $("#species-parent").val(name)
    }
    else {
      $("#species").val(name)
    }
  }

  function transfer(id) {
    freeze()
    $.post(
      global['url'],
      {action: 'get-sell', id: id},
      (response, status) => {
        checkResult(response, status).then(data => {
          global['id'] = id
          $("#market-content").html(data['html'])
          transferPet.modal('show')
        }, () => {})
      }
    )    
  }

  function transferPetSubmit() {
    freeze()
    $.post(
      global['url'],
      { action: 'transfer-owner', petid: global['id'], ownerid: global['owner'], type: global['type'], filter: checkFilter(), tabber: global['tabber'] },
      (response, status) => {
        checkResult(response, status).then(data => {
          $("#transfer-owner").val('')
          transferPet.modal('hide')
          petList.html(data['html'])
        }, () => { })
      }
    )
  }

  function addOwner() {
    insertOwner.modal('show')
  }

  function insertOwnerSubmit() {
    freeze()
    $.post(
      global['url'],
      { action: 'insert-owner', data: checkInputSet(owner) },
      (response, status) => {
        checkResult(response, status).then(data => {
          transferOwner.val(data['name'])
          global['owner'] = data['id']
          global['type'] = 2
          insertOwner.modal('hide')
          clearInputSet(owner)
        }, () => { })
      }
    )
  }

  function pickOwner(name, id, type) {
    transferOwner.val(name)
    global['owner'] = id
    global['type'] = type
  }

  function installRemindOwner(section) {
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

  function request(id) {
    freeze()
    $.post(
      global['url'],
      { action: 'get-request', id: id },
      (response, status) => {
        checkResult(response, status).then(data => {
          global['request'] = id
          requestContent.html(data['html'])
          requestDetail.modal('show')
        }, () => { })
      }
    )
  }

  function newRequestSubmit() {
    freeze()
    $.post(
      global['url'],
      { action: 'new-request', name: $("#request-other").val(), id: global['request'] },
      (response, status) => {
        checkResult(response, status).then(data => {
          requestContent.html(data['html'])
          // requestDetail.modal('hide')
        }, () => { })
      }
    )
  }

  function center() {
    freeze()
    $.post(
      global['url'],
      { action: 'center' },
      (response, status) => {
        checkResult(response, status).then(data => {
          window.location.reload()
        }, () => { })
      }
    )
  }

  function requestSubmit(id, value, type) {
    freeze()
    $.post(
      global['url'],
      { action: 'request', id: id, type: type, value: value },
      (response, status) => {
        checkResult(response, status).then(data => {
          requestContent.html(data['html'])
        }, () => { })
      }
    )
  }

  function cancelSubmit(id, value, type) {
    freeze()
    $.post(
      global['url'],
      { action: 'cancel', id: id, type: type, value: value },
      (response, status) => {
        checkResult(response, status).then(data => {
          requestContent.html(data['html'])
        }, () => { })
      }
    )
  }

  function addVaccine(id) {
    global['id'] = id
    petVaccine.modal('show')
  }

  function insertVaccineSubmit() {
    freeze()
    $.post(
      global['url'],
      { action: 'insert-vaccine', data: checkVaccineData(), id: global['id'] },
      (response, status) => {
        checkResult(response, status).then(data => {
          window.location.href = '/{module_name}/info/?id=' + global['id'] + '&target=vaccine'
          petVaccine.modal('hide')
        }, () => { })
      }
    )
  }

  function addParent(name) {
    insertParent.modal('show')
    global['parent'] = name
    clearInputSet(parent)
    petPreview.val('')
    $("#parent" + global['parent']).val('')
    $("#parent" + global['parent' + '-s']).val(0)
  }

  function insertParentSubmit() {
    if (data = checkParentData()) {
      freeze()
      uploader('parent').then((imageUrl) => {
        $.post(
          global['url'],
          { action: 'insert-parent', id: global['id'], data: data, image: imageUrl, filter: checkFilter(), tabber: global['tabber'] },
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
              $("#parent-error").text('')
              $("#parent-breeder").prop('checked', true)
              $("#parent-" + global['parent']).val(data['name'])
              $("#parent-" + global['parent'] + '-s').val(data['id'])
            }, () => { })
          }
        )
      })
    }
  }

  function pickParent(e, name, id) {
    var idp = splipper(e.parentNode.getAttribute('id'), 'parent-suggest')
    $('#parent-' + idp + '-s').val(id)
    $('#parent-' + idp).val(name)
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

  function selectRemindv2(name, type, value) {
    $("#" + type + "-" + name).val(value)
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
    freeze()
    $.post(
      global['url'],
      { action: 'remove', id: global['id'], filter: checkFilter() },
      (response, status) => {
        checkResult(response, status).then(data => {
          global['page'] = 1
          petList.html(data['html'])
          removetPet.modal('hide')
        }, () => { })
      }
    )
  }

  function editPet(id) {
    freeze()
    $.post(
      global['url'],
      { action: 'get', id: id },
      (response, status) => {
        checkResult(response, status).then(data => {
          global['id'] = id
          parseInputSet(data['data'], pet)
          $("#parent-f").val(data['more']['f'])
          $("#parent-m").val(data['more']['m'])
          $("#pet-sex-" + data['more']['sex']).prop('checked', true)
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

  function checkPetData() {
    var data = checkInputSet(pet)
    data['breeder'] = $("#pet-breeder").prop('checked')
    data['sex0'] = pet['sex0'].prop('checked')
    data['sex1'] = pet['sex1'].prop('checked')
    if (!data['name'].trim().length || !data['dob'].trim().length || !data['species'].trim().length || !data['breed'].trim().length) {
      $("#pet-error").text('Các trường không được để trống')
      defreeze()
      return false
    }

    return data
  }

  function checkParentData() {
    var data = checkInputSet(parent)
    data['breeder'] = $("#parent-breeder").prop('checked')
    data['sex0'] = parent['sex0'].prop('checked')
    data['sex1'] = parent['sex1'].prop('checked')
    if (!data['name'].trim().length || !data['dob'].trim().length || !data['species'].trim().length || !data['breed'].trim().length) {
      $("#parent-error").text('Các trường không được để trống')
      defreeze()
      return false
    }
    return data
  }

  function deleteImage(url) {
    return new Promise((resolve) => {
      if (!url) {
        resolve()
      }
      url = url.substr(0, url.search(/\?alt=/))
      var xref = storage.refFromURL(url);
      console.log(xref);
      
      resolve()

      // xref.delete().then(function() {
      //   resolve()        
      // }).catch(function(error) {
      //   resolve()        
      // });
    })
  }

  function editPetSubmit() {
    if (data = checkPetData()) {
      freeze()
      uploader('pet').then((imageUrl) => {
        $.post(
          global['url'],
          { action: 'editpet', id: global['id'], data: data, image: imageUrl, filter: checkFilter(), tabber: global['tabber'] },
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
                $("#pet-error").text('')
                petPreview.val('')
                remind = JSON.parse(data['remind'])
                insertPet.modal('hide')
              })
            }, () => { })
          }
        )
      })
    }
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
    var data = {
      page: global['page'],
      limit: searchLimit.val(),
      keyword: searchKeyword.val(),
      // status: value
    }
    return data
  }

  function goPage(page) {
    global['page'] = page
    filter()
  }

  function filter() {
    freeze()
    $.post(
      global['url'],
      { action: 'filter', filter: checkFilter(), tabber: global['tabber'] },
      (response, status) => {
        checkResult(response, status).then(data => {
          petList.html(data['html'])
        }, () => { })
      }
    )
  }

  function filterS(e) {
    e.preventDefault()
    global['page'] = 1
    filter()
  }

  function addPet() {
    ibtn.show()
    ebtn.hide()
    insertPet.modal('show')
    clearInputSet(pet)
    $("#pet-dob").val(mostly['pet']['dob'])
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
            $("#pet-error").text('')
            petPreview.val('')
            remind = JSON.parse(data['remind'])
            insertPet.modal('hide')
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

  function editUser(id) {
    freeze()
    $.post(
      global['url'],
      {action: 'getuser', id: id},
      (response, status) => {
        checkResult(response, status).then(data => {
          global['id'] = id
          parseInputSet(data['data'], user)
          var index = searchPosition(data['more']['al1'])
          var index2 = searchPosition2(index, data['more']['al2'])
          $("#al1").val(index)
          $("#al2" + index).val(index2)
          var image = new Image()
          image.src = data['image']
          image.addEventListener('load', (e) => {
            userPreview.attr('src', image.src)
          })
          $("#insert-user").modal('show')
        }, () => {})
      }
    )
  }

  function editUserSubmit(e) {
    e.preventDefault()
    freeze()
    if (data = checkEdit()) {
      uploader('user').then((imageUrl) => {
        $.post(
          global['url'],
          {action: 'edituser', data: data, image: imageUrl, id: global['id']},
          (response, status) => {
            checkResult(response, status).then(data => {
              uploaded['user'] = {}
              deleteImage(data['image']).then(() => {
                window.location.reload()
              })
            }, () => {})
          }
        )
      })
    }
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

  function checkEdit() {
    $("#user-error").text('')
    var check = true
    var data = checkInputSet(user)
    for (const row in data) {
      if (data.hasOwnProperty(row)) {
        if (!data[row].trim().length) {
          $("#user-error").text('Các trường không được bỏ trống')
          defreeze()
          return false
        }
      }
    }

    data['a1'] = position[al1.val()]['name']
    data['a2'] = position[al1.val()]['district'][$("#al2" + al1.val()).val()]
    data['a3'] = al3.val()

    return data
  }

  function insertDiseaseSuggestSubmit() {
    freeze()
    $.post(
      global['url'],
      { action: 'insert-disease-suggest', disease: $('#disease-suggest').val() },
      (response, status) => {
        checkResult(response, status).then(data => {
          insertDiseaseSuggest.modal('hide')
          vaccine['type'].html(data['html'])
        }, () => { })
      }
    )
  }

  function addDiseaseSuggest() {
    insertDiseaseSuggest.modal('show')
  }

  function checkDiseaseData() {
    return {
      treat: diseaseTreat.val(),
      treated: diseaseTreated.val(),
      disease: diseaseDisease.val(),
      note: diseaseNote.val(),
    }
  }

  function checkVaccineData() {
    var type = vaccine['type'].val().split('-')
    return {
      type: type['0'],
      val: type['1'],
      time: vaccine['time'].val(),
      recall: vaccine['recall'].val()
    }
  }

  function parentToggle(id) {
    $(".i" + id).fadeToggle()
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

  $(document).ready(() => {
    $(".date").datepicker()
    vremind.install('#species2', '#species2-suggest', (input) => {
      return new Promise(resolve => {
        vhttp.checkelse('', { action: 'get-remind', keyword: input, type: 'species2' }).then(data => {
          resolve(data['html'])
        })
      })
    }, 500, 300)
    vremind.install('#color', '#color-suggest', (input) => {
      return new Promise(resolve => {
        vhttp.checkelse('', { action: 'get-remind', keyword: input, type: 'color' }).then(data => {
          resolve(data['html'])
        })
      })
    }, 500, 300)
    vremind.install('#type', '#type-suggest', (input) => {
      return new Promise(resolve => {
        vhttp.checkelse('', { action: 'get-remind', keyword: input, type: 'type' }).then(data => {
          resolve(data['html'])
        })
      })
    }, 500, 300)
    vremind.install('#breeder', '#breeder-suggest', (input) => {
      return new Promise(resolve => {
        vhttp.checkelse('', { action: 'get-user', keyword: input, type: 'breeder' }).then(data => {
          resolve(data['html'])
        })
      })
    }, 500, 300)
    vremind.install('#owner', '#owner-suggest', (input) => {
      return new Promise(resolve => {
        vhttp.checkelse('', { action: 'get-user', keyword: input, type: 'owner' }).then(data => {
          resolve(data['html'])
        })
      })
    }, 500, 300)
    vremind.install('#father', '#father-suggest', (input) => {
      return new Promise(resolve => {
        vhttp.checkelse('', { action: 'get-pet', type: 0, keyword: input, id: global['id'] }).then(data => {
          resolve(data['html'])
        })
      })
    }, 500, 300)
    vremind.install('#mother', '#mother-suggest', (input) => {
      return new Promise(resolve => {
        vhttp.checkelse('', { action: 'get-pet', type: 1, keyword: input, id: global['id'] }).then(data => {
          resolve(data['html'])
        })
      })
    }, 500, 300)
    vimage.install('image', 640, 640, (list) => {
      refreshImage(list)
    })
  })

  function refreshImage(list) {
    html = ''
    list.forEach((item, index) => {
      html += `
      <div class="image-box">
        <div class="image-content">
          <img src="`+ item + `" style="width: 100%">
        </div>
        <div class="image-function">
          <img class="insert icon" src="/assets/images/left.jpg" onclick="rotateImage(`+ index + `, -90)">
          <img class="insert icon" src="/assets/images/right.jpg" onclick="rotateImage(`+ index + `, 90)">
          <img class="insert icon" src="/assets/images/close.jpg" onclick="removeImage(`+ index + `)">
        </div>
      </div>`
    })
    $("#image-list").html(html)
  }

  function rotateImage(index, angle) {
    var image = new Image();
    image.src = vimage.data['image'][index];
    image.onload = (e) => {
      var canvas = document.createElement('canvas')
      var context = canvas.getContext('2d')
      var max = (image.width > image.height ? image.width : image.height)
      canvas.width = max
      canvas.height = max

      context.save()
      context.fillStyle = '#fff'
      context.fillRect(0, 0, max, max)
      context.translate(max / 2, max / 2)
      context.rotate(angle * Math.PI / 180)
      context.drawImage(image, -max / 2 + (max - image.width) / 2, -max / 2 + (max - image.height) / 2, image.width, image.height)
      context.restore()

      url = canvas.toDataURL('image/jpeg')
      vimage.data['image'][index] = url
      refreshImage(vimage.data['image'])
    }
  }

  function removeImage(remove_index) {
    vimage.data['image'] = vimage.data['image'].filter((item, index) => {
      return index !== remove_index
    })
    refreshImage(vimage.data['image'])
  }

  function selectRemind(name, id) {
    $("#" + id).val(name)
  }

  function selectPet(name, type, id) {
    $("#" + global['petobj'][type]).val(name)
    global['pet'][type] = id
  }

  function sendinfoModal() {
    $(".insert").show()
    $(".edit").hide()
    global['pet'] = {
      0: 0,
      1: 0
    }
    $("#father").val('')
    $("#mother").val('')
    $("#name").val('')
    $("[name=sex][value=0]").prop('checked', true)
    $("#birthtime").val('')
    $("#species2").val('')
    $("#color").val('')
    $("#type").val('')
    $("#breeder").val('')
    $("#owner").val('')
    vimage.data['image'] = []
    refreshImage(vimage.data['image'])
    $("#sendinfo-modal").modal('show')
  }

  function edit(id) {
    vhttp.checkelse('', { action: 'get-info', id: id }).then(data => {
      global['id'] = id
      global['pet'] = {
        0: data['data']['father'],
        1: data['data']['mother']
      }

      parseUser('breeder', data['data']['breeder'])
      parseUser('owner', data['data']['owner'])

      $("#micro").val(data['data']['micro'])
      $("#father").val(data['data']['fathername'])
      $("#mother").val(data['data']['mothername'])
      $("#name").val(data['data']['name'])
      $("[name=sex][value=" + data['data']['sex'] + "]").prop('checked', true)
      $("#birthtime").val(data['data']['birthtime'])
      $("#species2").val(data['data']['species'])
      $("#color").val(data['data']['color'])
      $("#type").val(data['data']['type'])
      vimage.data['image'] = data['data']['image']
      refreshImage(vimage.data['image'])
      $(".insert").hide()
      $(".edit").show()
      $("#sendinfo-modal").modal('show')
    })
  }

  function checkData() {
    data = {
      name: $("#name").val(),
      sex: $("[name=sex]:checked").val(),
      birthtime: $("#birthtime").val(),
      species: $("#species2").val(),
      color: $("#color").val(),
      type: $("#type").val(),
      micro: $("#micro").val(),
      breeder: global['breeder'],
      owner: global['owner'],
      father: global['pet'][0],
      mother: global['pet'][1]
    }

    for (const key in notify) {
      if (notify.hasOwnProperty(key)) {
        if (!data[key].length) return key
      }
    }
    return data
  }

  function sendInfo() {
    sdata = checkData()
    if (!sdata['name']) textError(sdata)
    else {
      freeze()
      upload('image').then(list => {
        vhttp.checkelse('', { action: 'send-info', data: sdata, image: list }).then(data => {
          $("#content").html(data['html'])
          $("#sendinfo-modal").modal('hide')
          defreeze()
        })
      })
    }
  }

  function editInfo() {
    sdata = checkData()
    if (!sdata['name']) textError(sdata)
    else {
      vhttp.checkelse('', { action: 'edit-info', data: sdata, id: global['id'] }).then(data => {
        $("#content").html(data['html'])
        $("#sendinfo-modal").modal('hide')
      })
    }
  }

  function textError(label) {
    $("#" + label + "-error").text(notify[label])
    $("#" + label + "-error").show()
    $("#" + label + "-error").fadeOut(3000)
    $('html, body').animate({
      scrollTop: $("#" + label + "-error").offset().top
    }, 1000);
  }

  function clearUser(name) {
    global[name] = 0
    $("#" + name).val('')
    $("#" + name + "-suggest").html('')
    $("#" + name + '-name').text(global['user']['name'])
    $("#" + name + '-mobile').text(global['user']['mobile'])
  }

  function parseUser(name, data) {
    $("#"+ name).val('')
    if (data['id']) {
      global[name] = data['id']
      $("#"+ name +"-name").text(data['fullname'])
      $("#"+ name +"-mobile").text(data['mobile'])
    }
    else {
      global[name] = 0
      $("#"+ name +"-name").text(global['user']['name'])
      $("#"+ name +"-mobile").text(global['user']['mobile'])
    }
  }

  function selectUser(name, id, fullname, mobile) {
    global[name] = id
    $("#" + name).val('')
    $("#" + name + '-name').text(fullname)
    $("#" + name + '-mobile').text(mobile)
  }

  function insertUser(name) {
    global['modal'] = name
    $("#user-name").val('')
    $("#user-mobile").val('')
    $("#user-address").val('')
    $("#user-politic").val('')
    $("#user-modal").modal('show')
  }

  function preview(id) {
    vhttp.checkelse('', { action: 'get-preview', id: id }).then(data => {
      $("#info-image").attr('src', data['data']['image'])
      $("#info-name").text(data['data']['name'])
      $("#info-sex").text(data['data']['sex'])
      $("#info-birthtime").text(data['data']['birthtime'])
      $("#info-species").text(data['data']['species'])
      $("#info-color").text(data['data']['color'])
      $("#info-type").text(data['data']['type'])
      $("#info-breeder").text(data['data']['breeder'])
      $("#info-owner").text(data['data']['owner'])
      $("#info-status").text(data['data']['status'])
      $("#info-modal").modal('show')
    })
  }

  function checkUserData() {
    data = {
      name: $("#user-name").val(),
      mobile: $("#user-mobile").val(),
      address: $("#user-address").val(),
      politic: $("#user-politic").val(),
    }
    return data
  }

  function insertUserSubmit() {
    sdata = checkUserData()
    vhttp.checkelse('', { action: 'insert-user', data: sdata }).then(data => {
      global[global['modal']] = data['id']
      $("#"+ global['modal'] +"").val('')
      $("#"+ global['modal'] +"-name").text(sdata['name'])
      $("#"+ global['modal'] +"-mobile").text(sdata['mobile'])
      $("#user-modal").modal('hide')
    })
  }

  function upload(id) {
    return new Promise((resolve) => {
      source = vimage.data[id]
      limit = source.length
      index = 0
      checker = 0
      image_data = []
      if (!source.length) resolve([])
      source.forEach(item => {
        index++
        name = index + '-' + Math.floor((new Date()).getTime() / 1000)
        file = item.substr(item.indexOf(',') + 1);

        var uploadTask = storageRef.child('images/' + name).putString(file, 'base64', metadata);
        uploadTask.on(firebase.storage.TaskEvent.STATE_CHANGED, // or 'state_changed'
          function (snapshot) {
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
          }, function (error) {
            console.log(error);
            checker++
            if (checker == limit) {
              defreeze()
              resolve(image_data)
            }
          }, function () {
            uploadTask.snapshot.ref.getDownloadURL().then(function (downloadURL) {
              image_data.push(downloadURL)
              checker++
              if (checker == limit) {
                resolve(image_data)
              }
            });
          });
      });
    })
  }
</script>
<!-- END: main -->