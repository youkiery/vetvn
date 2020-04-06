<!-- BEGIN: main -->
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.js"></script>
<link rel="stylesheet" href="/themes/default/src/glyphicons.css">
<style>
  .cell-center {
    vertical-align: inherit !important;
  }
  .select {
    background: rgb(223, 223, 223);
    border: 2px solid deepskyblue;
  }
</style>

<div id="msgshow"></div>

<div id="send-back" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <p class="text-center"> <b> Xác gửi trả kết quả </b> </p>

        <textarea class="form-control" id="note" rows="3">Thông tin chưa đầy đủ, xin vui lòng thử lại sau</textarea>

        <div class="text-center">
          <button class="btn btn-warning" onclick="sendbackSubmit()">
            Trả về
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="remove" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <p class="text-center"> <b> Xác nhận xóa yêu cầu </b> </p>

        <div class="text-center">
          <button class="btn btn-danger" onclick="removeSubmit()">
            Xóa
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="insert-pet" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <p class="text-center"> <b> Thêm thú cưng </b> </p>
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

        <div class="row">
          <div class="col-sm-12">
            Chó cha
            <div class="relative">
              <div class="input-group">
                <input class="form-control" id="parent-m" type="text" autocomplete="off">
                <input class="form-control" id="parent-m-s" type="hidden">
                <div class="input-group-btn">
                  <button class="btn btn-success" style="height: 34px;" onclick="addParent('m')">
                    <span class="glyphicon glyphicon-plus"></span>
                  </button>
                </div>
              </div>
              <div class="suggest" id="parent-suggest-m"></div>
            </div>
          </div>

          <div class="col-sm-12">
            Chó mẹ
            <div class="relative">
              <div class="input-group">
                <input class="form-control" id="parent-f" type="text" autocomplete="off">
                <input class="form-control" id="parent-f-s" type="hidden">
                <div class="input-group-btn relative">
                  <button class="btn btn-success" style="height: 34px;" onclick="addParent('f')">
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
          <button class="btn btn-success" id="ebtn" onclick="editPetSubmit()">
            Chỉnh sửa
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
      <br>
      <br>
      <label> <input type="radio" name="type" class="type" id="type-0" checked> Toàn bộ </label>
      <label> <input type="radio" name="type" class="type" id="type-1"> Cần bán </label>
      <label> <input type="radio" name="type" class="type" id="type-2"> Cần phối </label>
    </div>
    <div style="float: left; width: 60%;">
      <input type="text" class="form-control" id="filter-owner" placeholder="Tên chủ">
      <input type="text" class="form-control" id="filter-mobile" placeholder="Số điện thoại">
      <input type="text" class="form-control" id="filter-mobile" placeholder="Địa chỉ">
      <input type="text" class="form-control" id="filter-name" placeholder="Tên thú cưng">
      <input type="text" class="form-control" id="filter-species" placeholder="Giống">
      <input type="text" class="form-control" id="filter-breed" placeholder="Loài">
    </div>
  </div>
  <div class="text-center" style="clear: both;">
  <button class="btn btn-info">
    Lọc danh sách thú cưng
  </button>
  </div>
</form>
<div style="clear: both;"></div>

<button class="btn btn-info" style="float: right;" onclick="selectRow(this)">
  <span class="glyphicon glyphicon-unchecked"></span>
</button>
<button class="btn btn-danger select-button" style="float: right;" onclick="removeList()" disabled>
  <span class="glyphicon glyphicon-trash"></span>
</button>
<button class="btn btn-warning select-button" style="float: right;" onclick="sendbackx()" disabled>
  <span class="glyphicon glyphicon-share-alt"></span>
</button>
<button class="btn btn-warning select-button" style="float: right;" onclick="deactiveList()" disabled>
  <span class="glyphicon glyphicon-arrow-down"></span>
</button>
<button class="btn btn-info select-button" style="float: right;" onclick="activeList()" disabled>
  <span class="glyphicon glyphicon-arrow-up"></span>
</button>

<div id="content">
  {content}
</div>

<script src="https://www.gstatic.com/firebasejs/6.0.2/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/5.7.0/firebase-storage.js"></script>
<script>
  var content = $("#content")
  var keyword = $("#keyword")
  var limit = $("#limit")
  var atime = $("#atime")
  var ztime = $("#ztime")
  var cstatus = $(".status")
  var global = {
    page: 1
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
  var imageType = ["jpeg", "jpg", "png", "bmp", "gif"]
  var metadata = {
    contentType: 'image/jpeg',
  };
  var uploadedUrl = ''
  var maxWidth = 512
  var maxHeight = 512
  var petPreview = $("#pet-preview")
  var file, filename
  var remind = JSON.parse('{remind}')
  var thumbnail
  var canvas = document.createElement('canvas')
  var insertPet = $("#insert-pet")
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

  function removeList() {
    if (global['select'].length) {
      var list = []
      global['select'].forEach((item, index) => {
        list.push(item.getAttribute('id'))
      })
      freeze()
      $.post(
        global['url'],
        {action: 'remove-list', list: list.join(', '), filter: checkFilter()},
        (response, status) => {
          checkResult(response, status).then(data => {
            installSelect()
            content.html(data['html'])
          }, () => {})
        }
      )
    }    
  }

  function activeList() {
    if (global['select'].length) {
      var list = []
      global['select'].forEach((item, index) => {
        list.push(item.getAttribute('id'))
      })
      freeze()
      $.post(
        global['url'],
        {action: 'active-list', list: list.join(', '), filter: checkFilter()},
        (response, status) => {
          checkResult(response, status).then(data => {
            installSelect()
            content.html(data['html'])
          }, () => {})
        }
      )
    }    
  }

  function deactiveList() {
    if (global['select'].length) {
      var list = []
      global['select'].forEach((item, index) => {
        list.push(item.getAttribute('id'))
      })
      freeze()
      $.post(
        global['url'],
        {action: 'deactive-list', list: list.join(', '), filter: checkFilter()},
        (response, status) => {
          checkResult(response, status).then(data => {
            installSelect()
            content.html(data['html'])
          }, () => {})
        }
      )
    }    
  }

  function sendbackList() {
    if (global['select'].length) {
      var list = []
      global['select'].forEach((item, index) => {
        list.push(item.getAttribute('id'))
      })
      freeze()
      $.post(
        global['url'],
        {action: 'sendback-list', list: list.join(', '), note: $("#note").val(), filter: checkFilter()},
        (response, status) => {
          checkResult(response, status).then(data => {
            $("#send-back").modal('hide')
            content.html(data['html'])
          }, () => {})
        }
      )
    }    
  }

  function getChecked(name) {
    var temp = $("." + name).filter((index, item) => {
      return item.checked
    })
    var value = 0
    if (temp[0]) {
      value = splipper(temp[0].getAttribute('id'), name)
    }

    return value    
  }

  function checkFilter() {
    return {
      owner: $("#filter-owner").val(),
      mobile: $("#filter-mobile").val(),
      mobile: $("#filter-mobile").val(),
      name: $("#filter-name").val(),
      species: $("#filter-species").val(),
      breed: $("#filter-breed").val(),
      page: global['page'],
      limit: 10,
      status: getChecked('status'),
      type: getChecked('type')
    }
  }

  function filterE(e) {
    e.preventDefault()
    goPage(1)
  }

  function goPage(page) {
    global['page'] = page
    $.post(
      strHref,
      { action: 'filter', filter: checkFilter() },
      (response, status) => {
        checkResult(response, status).then(data => {
          content.html(data['html'])
        }, () => { })
      }
    )
  }

  function check(id) {
    $.post(
      strHref,
      { action: 'check', id: id, filter: checkFilter() },
      (response, status) => {
        checkResult(response, status).then(data => {
          content.html(data['html'])
        }, () => { })
      }
    )
  }

  function uncheck(id) {
    $.post(
      strHref,
      { action: 'uncheck', id: id, filter: checkFilter() },
      (response, status) => {
        checkResult(response, status).then(data => {
          content.html(data['html'])
        }, () => { })
      }
    )
  }

  function sendback(id) {
    global['id'] = id
    $("#send-back").modal('show')
  }
  
  function sendbackx() {
    $("#send-back").modal('show')
  }
  
  function sendbackSubmit() {
    if (global['select']) {
      sendbackList()
    }
    else {
      $.post(
        strHref,
        { action: 'sendback', id: global['id'], note: $("#note").val(), filter: checkFilter() },
        (response, status) => {
          checkResult(response, status).then(data => {
            content.html(data['html'])
            $("#send-back").modal('hide')
          }, () => { })
        }
      )
    }
  }

  function remove(id) {
    global['id'] = id
    $("#remove").modal('show')
  }

  function removeSubmit() {
    $.post(
      strHref,
      { action: 'remove', id: global['id'], filter: checkFilter() },
      (response, status) => {
        checkResult(response, status).then(data => {
          content.html(data['html'])
          $("#remove").modal('hide')
        }, () => { })
      }
    )
  }

  function edit(id) {
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
    return data
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
    uploader().then((imageUrl) => {
      $.post(
        global['url'],
        { action: 'editpet', id: global['id'], data: checkPetData(), image: imageUrl, filter: checkFilter() },
        (response, status) => {
          checkResult(response, status).then(data => {
            deleteImage(data['image']).then(() => {
              content.html(data['html'])
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

    function onselected(input, previewname) {
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
          }
        };
      };

      if (imageType.indexOf(extension) >= 0) {
        reader.readAsDataURL(input.files[0]);
      }
    }
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
</script>
<!-- END: main -->