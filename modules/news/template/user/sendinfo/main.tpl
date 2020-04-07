<!-- BEGIN: main -->
<link rel="stylesheet" href="/modules/news/src/jquery-ui.min.css">
<style>
  .start-content {
    max-width: 450px;
    margin: auto;
    padding-top: 50px;
    border: 1px solid lightgray;
    padding: 15px;
    border-radius: 20px;
  }
  .text-red { font-weight: bold; font-size: 1.2em; color: red; }
  .thumb { height: 100px; width: 100px; text-align: center; display: inline-block; margin: 10px; }
  .thumb img { max-height: 100px; width: auto; }
</style>

<div class="container">
  <div id="msgshow"></div>
  <div style="text-align: right;">
    {FILE "../../heading.tpl"}
  </div>

  <div class="start-content">
    <div class="text-center">
      <a href="/">
        <img src="/themes/default/images/banner.png" style="width: 200px;">
      </a>
    </div>

    <div class="form-group rows">
      <div class="col-3"> Tên thú cưng </div>
      <div class="col-9"> <input type="text" class="form-control" id="name"> </div>
    </div>
    <p class="text-red" id="name-error"></p>

    <div class="form-group rows">
      <p class="col-3"> Giới tính </p>
      <div class="col-9">
        <label> <input type="radio" name="sex" value="0" checked> Đực </label>
        <label> <input type="radio" name="sex" value="1"> Cái </label>
      </div>
    </div>
    <p class="text-red" id="sex-error"></p>

    <div class="form-group rows">
      <div class="col-3"> Ngày sinh </div>
      <div class="col-9"> <input type="text" class="form-control date" id="birthtime"> </div>
    </div>
    <p class="text-red" id="birthtime-error"></p>

    <div class="form-group rows">
      <div class="col-3"> Giống loài </div>
      <div class="col-9 relative"> 
        <input type="text" class="form-control" id="species">  
        <div class="suggest" id="species-suggest"></div>
      </div>
    </div>
    <p class="text-red" id="species-error"></p>

    <div class="form-group rows">
      <div class="col-3"> Màu lông </div>
      <div class="col-3 relative"> 
        <input type="text" class="form-control" id="color">  
        <div class="suggest" id="color-suggest"></div>
      </div>
      <div class="col-3"> Kiểu lông </div>
      <div class="col-3 relative"> 
        <input type="text" class="form-control" id="type">  
        <div class="suggest" id="type-suggest"></div>
      </div>
    </div>
    <p class="text-red" id="color-error"></p>
    <p class="text-red" id="type-error"></p>

    <div class="form-group rows">
      <div class="col-3"> Người nhân giống </div>
      <div class="col-9"> <textarea class="form-control" id="breeder" rows="3"></textarea> </div>
    </div>
    <p class="text-red" id="breeder-error"></p>

    <div class="form-group rows">
      <div class="col-3"> Chủ nuôi </div>
      <div class="col-9"> <textarea class="form-control" id="owner" rows="3"></textarea> </div>
    </div>
    <p class="text-red" id="owner-error"></p>

    <div class="form-group"></div>
    <span id="image-list"></span>
    <label class="text-center thumb">
      <img style="width: 100px; height: 100px;" src="/assets/images/upload.jpg">
      <div style="width: 50px; height: 50px; display: none;" id="image"></div>
    </label>
    <div style="clear: both;"></div>

    <div class="text-center">
      <button class="btn btn-success" onclick="sendInfo()">
        Gửi thông tin
      </button>
    </div>
  </div>
</div>

<script src="/modules/core/vhttp.js"></script>
<script src="/modules/core/vimage.js"></script>
<script src="/modules/core/vremind-5.js"></script>
<script src="/modules/news/src/jquery.ui.datepicker-vi.js"></script>
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

  var notify = {
    'name': 'Nhập tên thú cưng trước khi gửi',
    'birthtime': 'Chọn ngày sinh trước khi gửi',
    'species': 'Chọn giống loài trước khi gửi',
    'color': 'Chọn màu lông trước khi gửi',
    'type': 'Chọn kiểu lông trước khi gửi',
    'owner': 'Nhập thông tin chủ nuôi trước khi gửi'
  }

  $(document).ready(() => {
    $(".date").datepicker()
    vremind.install('#species', '#species-suggest', (input) => {
      return new Promise(resolve => {
        vhttp.checkelse('', { action: 'get-remind', keyword: input, type: 'species' } ).then(data => {
          resolve(data['html'])
        })
      })
    }, 500, 300)
    vremind.install('#color', '#color-suggest', (input) => {
      return new Promise(resolve => {
        vhttp.checkelse('', { action: 'get-remind', keyword: input, type: 'color' } ).then(data => {
          resolve(data['html'])
        })
      })
    }, 500, 300)
    vremind.install('#type', '#type-suggest', (input) => {
      return new Promise(resolve => {
        vhttp.checkelse('', { action: 'get-remind', keyword: input, type: 'type' } ).then(data => {
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
        <button type="button" class="close" onclick="removeImage(`+ index +`)">&times;</button>
        <img src="`+ item +`">
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

  function checkData() {
    data = {
      name: $("#name").val(),
      sex: $("#sex").val(),
      birthtime: $("#birthtime").val(),
      species: $("#species").val(),
      color: $("#color").val(),
      type: $("#type").val(),
      breeder: $("#breeder").val(),
      owner: $("#owner").val()
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
      vhttp.install('', { action: 'send-info', data: sdata }).then(data => {
        $("#notify").show()
        $("#content").hide()
      })
    }
  }

  function textError(label) {
    $("#"+ label +"-error").text(notify[label])
    $("#"+ label +"-error").show()
    $("#"+ label +"-error").fadeOut(3000)
    $('html, body').animate({
        scrollTop: $("#"+ label +"-error").offset().top
    }, 1000);
  }
</script>
<!-- END: main -->
