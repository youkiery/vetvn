<!-- BEGIN: main -->
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.js"></script> 
<link rel="stylesheet" href="/themes/default/src/glyphicons.css">

<style>
  label {
    width: 100%;
  }
  .select {
    background: rgb(223, 223, 223);
    border: 2px solid deepskyblue;
  }
</style>

<div class="container">
  <div id="msgshow"></div>


  <div class="modal" id="user-pass" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <p class="text-center">
            Đổi mật khẩu
          </p>

          <label class="row">
            <div class="col-sm-6">
              Mật khẩu mới
            </div>
            <div class="col-sm-18">
              <input type="text" class="form-control" id="pass-v1" autocomplete="off">
            </div>
          </label>

          <label class="row">
            <div class="col-sm-6">
              Xác nhận mật khẩu
            </div>
            <div class="col-sm-18">
              <input type="text" class="form-control" id="pass-v2" autocomplete="off">
            </div>
          </label>

          <div id="pass-error" style="color: red; font-weight: bold;"></div>

          <div class="text-center">
            <button class="btn btn-info" onclick="changePasswordSubmit()">
              Đổi mật khẩu
            </button>
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
          <form onsubmit="editUserSubmit(event)">
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

            <label class="row">
              <div class="col-sm-6">
                Hình ảnh
              </div>
              <div class="col-sm-18">
                <div>
                  <img class="img-responsive" id="user-preview"
                    style="display: inline-block; width: 128px; height: 128px; margin: 10px;">
                </div>
                <input type="file" class="form-control" id="user-image" onchange="onselected(this, 'user')">
              </div>
            </label>

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

  <div id="remove-user" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-body text-center">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <p>
            Xác nhận xóa?
          </p>
          <button class="btn btn-danger" onclick="removeUserSubmit()">
            Xóa
          </button>
        </div>
      </div>
    </div>
  </div>

  <form onsubmit="filterE(event)">
    <div>
      <div style="float: right; width: 30%;">
        <select class="form-control" id="user-limit">
          <option value="10"> 10 </option>
          <option value="20"> 20 </option>
          <option value="50"> 50 </option>
          <option value="75"> 75 </option>
          <option value="100"> 100 </option>
        </select>
        <br>
        <label> <input type="radio" name="user-status" class="user-status" id="user-status-0" checked> Toàn bộ </label>
        <label> <input type="radio" name="user-status" class="user-status" id="user-status-1"> Chưa xác nhận </label>
        <label> <input type="radio" name="user-status" class="user-status" id="user-status-2"> Đã xác nhận </label>
      </div>

      <div style="float: left; width: 60%;">
        <input type="text" class="form-control" id="user-username" placeholder="Tên tài khoản">
        <input type="text" class="form-control" id="user-fullname" placeholder="Họ và tên">
        <input type="text" class="form-control" id="user-address" placeholder="Địa chỉ">
        <input type="text" class="form-control" id="user-mobile" placeholder="Số điện thoại">
      </div>
    </div>
    <div class="text-center" style="clear: both;">
    <button class="btn btn-info">
      Lọc danh sách người dùng
    </button>
    </div>
  </form>
  <div style="clear: both;"></div>

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
  <div id="user-list">
    {userlist}
  </div>
</div>

<script src="https://www.gstatic.com/firebasejs/6.0.2/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/5.7.0/firebase-storage.js"></script>
<script>
  var global = {
    login: 1,
    text: ['Đăng ky', 'Đăng nhập'],
    url: '{origin}',
    id: -1,
    page: 1,
    select: false
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
  var uploadedUrl = ''
  var userImage = $("#user-image")
  var userPreview = $("#user-preview")
  var username = $("#username")
  var password = $("#password")
  var vpassword = $("#vpassword")
  var fullname = $("#fullname")
  var phone = $("#phone")
  var address = $("#address")
  var keyword = $("#keyword")
  var button = $("#button")
  var ibtn = $("#ibtn")
  var ebtn = $("#ebtn")

  var politic = $("#politic")
  var error = $("#error")

  var al1 = $("#al1")
  var al2 = $("#al2")
  var al3 = $("#al3")

  var position = JSON.parse('{position}')

  var insertUser = $("#insert-user")
  var removetUser = $("#remove-user")
  var userList = $("#user-list")
  var tabber = $(".tabber")
  var maxWidth = 512
  var maxHeight = 512
  var imageType = ["jpeg", "jpg", "png", "bmp", "gif"]
  var metadata = {
    contentType: 'image/jpeg',
  };
  var file, filename

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

  tabber.click((e) => {
    var className = e.currentTarget.getAttribute('class')
    global[login] = Number(splipper(className, 'tabber'))
    // button.text(global['text'][global['login']])
  })

  $("#pet-dob").datepicker({
    format: 'dd/mm/yyyy',
    changeMonth: true,
    changeYear: true
  });

  $(this).ready(() => {
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
        {action: 'remove-user-list', list: list.join(', '), filter: checkUserFilter()},
        (response, status) => {
          checkResult(response, status).then(data => {
            installSelect()
            userList.html(data['html'])
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
        {action: 'active-user-list', list: list.join(', '), filter: checkUserFilter()},
        (response, status) => {
          checkResult(response, status).then(data => {
            installSelect()
            userList.html(data['html'])
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
        {action: 'deactive-user-list', list: list.join(', '), filter: checkUserFilter()},
        (response, status) => {
          checkResult(response, status).then(data => {
            installSelect()
            userList.html(data['html'])
          }, () => {})
        }
      )
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

  function l1(e) {
    var value = e.value

    $(".al2").hide()
    $("#al2" + value).show()
  }

  function changePassword(id) {
    global['userid'] = id
    $("#user-pass").modal('show')
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
        {action: 'change-pass', npass: pass1, userid: global['userid']},
        (response, status) => {
          checkResult(response, status).then(data => {
            $("#user-pass").modal('hide')
          }, () => { })
        }
      )
    }
  }

  function onselected(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      var fullname = input.files[0].name
      var name = Math.round(new Date().getTime() / 1000) + '_' + fullname.substr(0, fullname.lastIndexOf('.'))
      var extension = fullname.substr(fullname.lastIndexOf('.') + 1)
      uploadedUrl = ''
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
            if(image.width > maxWidth)
              ratio = maxWidth / image.width;
            else if(image.height > maxHeight)
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
            userPreview.attr('src', file)
            file = file.substr(file.indexOf(',') + 1);
          }
        };
      };

      if (imageType.indexOf(extension) >= 0) {
        reader.readAsDataURL(input.files[0]);
      }
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

  function editUser(id) {
    $.post(
      global['url'],
      {action: 'getuser', id: id},
      (response, status) => {
        checkResult(response, status).then(data => {
          global['id'] = id
          parseInputSet(data['data'], user)
          var index = searchPosition(data['data']['al1'])
          var index2 = searchPosition2(index, data['data']['al2'])
          $("#al1").val(index)
          $("#al2" + index).val(index2)
          var image = new Image()
          image.src = data['image']
          image.addEventListener('load', (e) => {
            userPreview.attr('src', image.src)
          })
          insertUser.modal('show')
        }, () => {})
      }
    )
  }

  function editUserSubmit(e) {
    e.preventDefault()
    uploader().then((imageUrl) => {
      $.post(
        global['url'],
        {action: 'edituser', data: checkEdit(), image: imageUrl, id: global['id'], filter: checkUserFilter()},
        (response, status) => {
          checkResult(response, status).then(data => {
            deleteImage(data['image']).then(() => {
              userList.html(data['html'])
              clearInputSet(user)
              insertUser.modal('hide')
            }, () => {})
          }, () => {})
        }
      )
    })
  }

  function uploader() {
    return new Promise(resolve => {
      if (uploadedUrl) {
        resolve(uploadedUrl)
      }
      else if (!(file || filename)) {
        resolve('')
      }
      else {
        var uploadTask = storageRef.child('images/' + filename).putString(file, 'base64', metadata);
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
            uploadedUrl = downloadURL
            resolve(downloadURL)
            console.log('File available at', downloadURL);
          });
        });
      }
    })
	}

  function checkUserFilter() {
    var temp = $(".user-status").filter((index, item) => {
      return item.checked
    })
    var value = 0
    if (temp[0]) {
      value = splipper(temp[0].getAttribute('id'), 'user-status')
    }
    var data = {
      username: $("#user-username").val(),
      fullname: $("#user-fullname").val(),
      address: $("#user-address").val(),
      mobile: $("#user-mobile").val(),
      limit: $("#user-limit").val(),
      page: global['page'],
      status: value
    }
    return data
  }

  function goPage(page) {
    global['page'] = page
    $.post(
      global['url'],
      {action: 'filteruser', filter: checkUserFilter()},
      (response, status) => {
        checkResult(response, status).then(data => {
          userList.html(data['html'])
        }, () => {})
      }
    )
  }

  function deleteUser(id) {
    global['id'] = id
    removetUser.modal('show')
  }

  function removeUserSubmit() {
    $.post(
      global['url'],
      {action: 'removeuser', id: global['id'], filter: checkUserFilter()},
      (response, status) => {
        checkResult(response, status).then(data => {
          userList.html(data['html'])
          removetUser.modal('hide')
        }, () => {})
      }
    )
  }

  function checkUser(id, type) {
    $.post(
      global['url'],
      {action: 'checkuser', id: id, type: type, filter: checkUserFilter()},
      (response, status) => {
        checkResult(response, status).then(data => {
          userList.html(data['html'])
        }, () => {})
      }
    )
  }

  function filterE(e) {
    e.preventDefault()
    filterUser()
  }

  function filterUser() {
    global['page'] = 1
    $.post(
      global['url'],
      {action: 'filteruser', filter: checkUserFilter()},
      (response, status) => {
        checkResult(response, status).then(data => {
          userList.html(data['html'])
        }, () => {})
      }
    )
  }
</script>
<!-- END: main -->
