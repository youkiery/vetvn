<!-- BEGIN: main -->
<link rel="stylesheet" href="/modules/news/src/jquery-ui.min.css">
<style>
  .text-red {
    font-weight: bold;
    font-size: 1.2em;
    color: red;
  }

  .thumb {
    height: 100px;
    width: 100px;
    text-align: center;
    display: inline-block;
    margin: 10px;
  }

  .thumb img {
    max-height: 100px;
    width: auto;
  }

  .btn { min-height: unset; }
</style>

{modal}

<div class="container">
  <div id="msgshow"></div>
  <a href="/">
    <img src="/themes/default/images/banner.png" style="width: 200px;">
  </a>

  <div style="float: right;">
    <a href="/{module_file}/logout"> Đăng xuất </a>
  </div>

  <div style="clear: both;"></div>

  <div class="form-group">
    <a href="/news/login">
      Trở về
    </a>
  </div>
  <div class="form-group rows">
    <form>
      <input type="hidden" name="nv" value="news">
      <input type="hidden" name="op" value="sendinfo">
      <div class="col-4">
        <input type="text" class="form-control" name="keyword" value="{keyword}" placeholder="Nhập tên thú cưng...">
      </div>
      <div class="col-4">
        <select name="status" class="form-control">
          <option value="0" {status0}> Tất cả </option>
          <option value="1" {status1}> Đợi cấp </option>
          <option value="2" {status2}> Đã cấp </option>
        </select>
      </div>
      <div class="col-4">
        <button class="btn btn-info">
          Tìm kiếm
        </button>
      </div>
    </form>
  </div>

  <div style="clear: both;"></div>

  <div class="form-group" style="text-align: right;">
    <button class="btn btn-success" onclick="sendinfoModal()">
      Thêm yêu cầu
    </button>
  </div>

  <div style="clear: both;"></div>

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
  var metadata = {
    contentType: 'image/jpeg',
  };

  var global = {
    id: 0,
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
    'name': 'Nhập tên thú cưng trước khi gửi',
    'birthtime': 'Chọn ngày sinh trước khi gửi',
    'species': 'Chọn giống loài trước khi gửi',
    'color': 'Chọn màu lông trước khi gửi',
    'type': 'Chọn kiểu lông trước khi gửi',
    'owner': 'Nhập thông tin chủ nuôi trước khi gửi'
  }
  var sex_data = ['Đực', 'Cái']
  var image_data = []

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
      <div class="thumb">
        <button type="button" class="close insert" onclick="removeImage(`+ index + `)">&times;</button>
        <img src="`+ item + `">
      </div>`
    })
    $("#image-list").html(html)
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
      console.log(global['pet']);

      $("#father").val(data['data']['fathername'])
      $("#mother").val(data['data']['mothername'])
      $("#name").val(data['data']['name'])
      $("[name=sex][value=" + data['data']['sex'] + "]").prop('checked', true)
      $("#birthtime").val(data['data']['birthtime'])
      $("#species2").val(data['data']['species'])
      $("#color").val(data['data']['color'])
      $("#type").val(data['data']['type'])
      $("#breeder").val(data['data']['breeder'])
      $("#owner").val(data['data']['owner'])
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
      breeder: $("#breeder").val(),
      owner: $("#owner").val(),
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
      upload('image').then(list => {
        vhttp.checkelse('', { action: 'send-info', data: sdata, image: list }).then(data => {
          $("#content").html(data['html'])
          $("#sendinfo-modal").modal('hide')
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