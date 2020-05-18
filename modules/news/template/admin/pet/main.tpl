<!-- BEGIN: main -->
<link rel="stylesheet" href="/modules/core/src/jquery-ui.min.css">
<link rel="stylesheet" href="/modules/core/src/style.css">
<link rel="stylesheet" href="/modules/core/src/glyphicons.css">
<style>
  label {
    width: 100%;
  }

  .btn {
    min-height: 32px;
  }

  .btn-xs {
    min-height: unset;
  }

  .select {
    background: rgb(223, 223, 223);
    border: 2px solid deepskyblue;
  }

  #middle {
    height: fit-content;
  }

  .thumb {
    margin: 2px;
    width: 100px;
    height: 100px;
    line-height: 100px;
  }

  .thumb img {
    max-width: 100px;
    max-height: 100px;
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

  .fc-icon {
    display: inline-block;
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

{modal}

<div class="container">
  <div id="msgshow"></div>

  <form>
    <input type="hidden" name="nv" value="news">
    <input type="hidden" name="op" value="pet">
    <div class="rows">
      <div class="col-4">
        <input type="text" class="form-control form-group" name="username" value="{username}" placeholder="Tài khoản">
        <input type="text" class="form-control form-group" name="owner" value="{owner}" placeholder="Tên chủ nuôi">
        <input type="text" class="form-control form-group" name="mobile" value="{mobile}" placeholder="SĐT chủ nuôi">
      </div>
      <div class="col-4">
        <input type="text" class="form-control form-group" name="name" value="{name}" placeholder="Tên thú cưng">
        <input type="text" class="form-control form-group" name="species" value="{species}" placeholder="Giống loài">
        <input type="text" class="form-control form-group" name="mc" value="{micro}" placeholder="Microchip">
      </div>
      <div class="col-4">
        <select class="form-control form-group" name="limit">
          <option value="10"> 10 </option>
          <option value="20"> 20 </option>
          <option value="50"> 50 </option>
          <option value="75"> 75 </option>
          <option value="100"> 100 </option>
        </select>
        <select class="form-control form-group" name="status">
          <option value="0" {status0}> Toàn bộ </option>
          <option value="1" {status1}> Chưa xác nhận</option>
          <option value="2" {status2}> Đã xác nhận </option>
        </select>
      </div>
    </div>
    <div class="text-center" style="clear: both;">
      <button class="btn btn-info">
        Lọc danh sách thú cưng
      </button>
    </div>
  </form>
  <div style="clear: both;"></div>

  <button class="btn btn-success" style="float: right;" onclick="sendinfoModal()">
    <span class="glyphicon glyphicon-plus"> </span>
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

  <div id="content">
    {list}
  </div>
</div>

<script src="/modules/core/vhttp.js"></script>
<script src="/modules/core/vimage.js"></script>
<script src="/modules/core/vremind-5.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.js"></script>
<script src="/modules/core/src/jquery.ui.datepicker-vi.js"></script>
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
    owner: 0,
    breeder: 0,
    petuser: 0,
    petid: 0,
    parentid: 0,
    user_parent: 0,
    pet: {
      0: 0,
      1: 0
    },
    petobj: {
      0: 'father',
      1: 'mother'
    }
  }
  var notify = {
    'petuser': 'Chọn chủ tài khoản trước khi gửi',
    'name': 'Nhập tên thú cưng trước khi gửi',
    'birthtime': 'Chọn ngày sinh trước khi gửi',
    'species': 'Chọn giống loài trước khi gửi',
    'color': 'Chọn màu lông trước khi gửi',
    'type': 'Chọn kiểu lông trước khi gửi'
  }
  var sex_data = ['Đực', 'Cái']
  var image_data = []
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
    vimage.install('image', 640, 640, (list) => {
      refreshImage(list)
    })
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
      { action: 'lock', id: id, type: type },
      (response, status) => {
        checkResult(response, status).then(data => {
          $("#content").html(data['html'])
        }, () => { })
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
        { action: 'remove-user-list', list: list.join(', ') },
        (response, status) => {
          checkResult(response, status).then(data => {
            installSelect()
            $("#content").html(data['html'])
          }, () => { })
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
        { action: 'active-user-list', list: list.join(', ') },
        (response, status) => {
          checkResult(response, status).then(data => {
            installSelect()
            $("#content").html(data['html'])
          }, () => { })
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
        { action: 'deactive-user-list', list: list.join(', ') },
        (response, status) => {
          checkResult(response, status).then(data => {
            installSelect()
            $("#content").html(data['html'])
          }, () => { })
        }
      )
    }
  }

  function push(id) {
    $.post(
      global['url'],
      { action: 'push', id: id },
      (response, status) => {
        checkResult(response, status).then(data => {
          console.log('success');
        }, () => { })
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
      { action: 'filter-owner', key: $("#owner-key").val() },
      (response, status) => {
        checkResult(response, status).then(data => {
          $("#owner-list").html(data['html'])
        }, () => { })
      }
    )
  }

  function thisOwner(id) {
    $.post(
      global['url'],
      { action: 'change-owner', userid: id, id: global['petid'] },
      (response, status) => {
        checkResult(response, status).then(data => {
          $("#content").html(data['html'])
          $("#modal-owner").modal('hide')
          // $("#owner-list").html(data['html'])
        }, () => { })
      }
    )
  }

  function deletePet(id) {
    global['id'] = id
    removetPet.modal('show')
  }

  function removePetSubmit() {
    $.post(
      global['url'],
      { action: 'remove', id: global['id'] },
      (response, status) => {
        checkResult(response, status).then(data => {
          $("#content").html(data['html'])
          removetPet.modal('hide')
        }, () => { })
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

      xref.delete().then(function () {
        resolve()
      }).catch(function (error) {
        resolve()
      });
    })
  }

  function editPetSubmit() {
    freeze()
    uploader('pet').then((imageUrl) => {
      $.post(
        global['url'],
        { action: 'editpet', id: global['id'], data: checkPetData(), image: imageUrl, tabber: global['tabber'] },
        (response, status) => {
          checkResult(response, status).then(data => {
            deleteImage(data['image']).then(() => {
              uploaded['pet'] = {}
              $("#content").html(data['html'])
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
      { action: 'filter' },
      (response, status) => {
        checkResult(response, status).then(data => {
          $("#content").html(data['html'])
        }, () => { })
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
      { action: 'check', id: id, type: type },
      (response, status) => {
        checkResult(response, status).then(data => {
          $("#content").html(data['html'])
        }, () => { })
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
        { action: 'insertpet', data: checkPetData(), tabber: global['tabber'], image: imageUrl },
        (response, status) => {
          checkResult(response, status).then(data => {
            uploaded['pet'] = {}
            $("#content").html(data['html'])
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
          }, function () {
            // Upload completed successfully, now we can get the download URL
            uploadTask.snapshot.ref.getDownloadURL().then(function (downloadURL) {
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
      { action: 'checkpet', id: id, type: type },
      (response, status) => {
        checkResult(response, status).then(data => {
          $("#content").html(data['html'])
        }, () => { })
      }
    )
  }

  // function editPetSubmit() {
  //   $.post(
  //     global['url'],
  //     {action: 'editpet', id: global['id'], data: checkInputSet(pet)},
  //     (response, status) => {
  //       checkResult(response, status).then(data => {
  //         $("#content").html(data['html'])
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
        { action: 'insert-parent', id: global['id'], userid: global['user_parent'], data: checkInputSet(parent), image: imageUrl, tabber: global['tabber'] },
        (response, status) => {
          checkResult(response, status).then(data => {
            uploaded['parent'] = {}
            $("#content").html(data['html'])
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

  // function ceti(petid, price) {
  //   global['petid'] = petid
  //   $("#ceti-price").val(price)
  //   $("#modal-ceti").modal('show')
  // }

  // function cetiSubmit() {
  //   $.post(
  //     global['url'],
  //     { action: 'ceti', price: $("#ceti-price").val(), petid: global['petid'] },
  //     (response, status) => {
  //       checkResult(response, status).then(data => {
  //         $("#content").html(data['html'])
  //         $("#modal-ceti").modal('hide')
  //       }, () => { })
  //     }
  //   )
  // }

  function cetiSubmit(petid) {
    $.post(
      global['url'],
      { action: 'ceti', petid: petid },
      (response, status) => {
        checkResult(response, status).then(data => {
          $("#content").html(data['html'])
        }, () => { })
      }
    )
  }

  // function removeCetiSubmit() {
  //   $.post(
  //     global['url'],
  //     { action: 'remove-ceti', petid: global['petid'] },
  //     (response, status) => {
  //       checkResult(response, status).then(data => {
  //         $("#content").html(data['html'])
  //         $("#modal-ceti").modal('hide')
  //       }, () => { })
  //     }
  //   )
  // }

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
      { action: 'insert-user', data: checkEdit() },
      (response, status) => {
        checkResult(response, status).then(data => {
          clearInputSet(user)
          $("#owner-key").val(data['mobile'])
          $("#insert-user").modal('hide')
          thisOwner(data['id'])
        }, () => { })
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
        vhttp.checkelse('', { action: 'get-user', keyword: input, type: 'breeder', id: global['petuser'] }).then(data => {
          resolve(data['html'])
        })
      })
    }, 500, 300)
    vremind.install('#owner', '#owner-suggest', (input) => {
      return new Promise(resolve => {
        vhttp.checkelse('', { action: 'get-user', keyword: input, type: 'owner', id: global['petuser'] }).then(data => {
          resolve(data['html'])
        })
      })
    }, 500, 300)
    vremind.install('#father', '#father-suggest', (input) => {
      return new Promise(resolve => {
        vhttp.checkelse('', { action: 'get-pet', type: 0, keyword: input, id: global['petuser'] }).then(data => {
          resolve(data['html'])
        })
      })
    }, 500, 300)
    vremind.install('#mother', '#mother-suggest', (input) => {
      return new Promise(resolve => {
        vhttp.checkelse('', { action: 'get-pet', type: 1, keyword: input, id: global['petuser'] }).then(data => {
          resolve(data['html'])
        })
      })
    }, 500, 300)
    vremind.install('#petuser', '#petuser-suggest', (input) => {
      return new Promise(resolve => {
        vhttp.checkelse('', { action: 'get-petuser', keyword: input }).then(data => {
          resolve(data['html'])
        })
      })
    }, 500, 300)
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

  function selectPetuser(id, fullname, mobile) {
    global['petuser'] = id
    $("#petuser-mobile").text(mobile)
    $("#petuser-name").text(fullname)
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
    $("#micro").val('')
    $("#regno").val('')
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

      parseUser('petuser', data['data']['petuser'])
      parseUser('breeder', data['data']['breeder'])
      parseUser('owner', data['data']['owner'])

      $("#micro").val(data['data']['micro'])
      $("#regno").val(data['data']['regno'])
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
      petuser: global['petuser'],
      micro: $("#micro").val(),
      regno: $("#regno").val(),
      name: $("#name").val(),
      sex: $("[name=sex]:checked").val(),
      birthtime: $("#birthtime").val(),
      species: $("#species2").val(),
      color: $("#color").val(),
      type: $("#type").val(),
      breeder: global['breeder'],
      owner: global['owner'],
      father: global['pet'][0],
      mother: global['pet'][1]
    }

    for (const key in notify) {
      if (notify.hasOwnProperty(key)) {
        if (!String(data[key]).length) return key
      }
    }
    return data
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

  function sendInfo() {
    sdata = checkData()
    if (!sdata['name']) textError(sdata)
    else {
      upload('image').then(list => {
        vhttp.checkelse('', { action: 'send-info', data: sdata, image: list }).then(data => {
          $("#content").html(data['html'])
          $("#sendinfo-modal").modal('hide')
        })
      })
    }
  }

  function clearUser(name) {
    global[name] = 0
    $("#" + name).val('')
    $("#" + name + "-suggest").html('')
    $("#" + name + '-name').text('')
    $("#" + name + '-mobile').text('')
  }

  function parseUser(name, data) {
    $("#" + name).val('')
    if (data['id']) {
      global[name] = data['id']
      $("#" + name + "-name").text(data['fullname'])
      $("#" + name + "-mobile").text(data['mobile'])
    }
    else {
      global[name] = 0
      $("#" + name + "-name").text(global['user']['name'])
      $("#" + name + "-mobile").text(global['user']['mobile'])
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
    vhttp.checkelse('', { action: 'insert-user2', data: sdata, id: global['petuser'] }).then(data => {
      global[global['modal']] = data['id']
      $("#" + global['modal'] + "").val('')
      $("#" + global['modal'] + "-name").text(sdata['name'])
      $("#" + global['modal'] + "-mobile").text(sdata['mobile'])
      $("#user-modal").modal('hide')
    })
  }

  function textError(label) {
    $("#" + label + "-error").text(notify[label])
    $("#" + label + "-error").show()
    $("#" + label + "-error").fadeOut(3000)
    $('html, body').animate({
      scrollTop: $("#" + label + "-error").offset().top
    }, 1000);
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