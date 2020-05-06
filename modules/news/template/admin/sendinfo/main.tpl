<!-- BEGIN: main -->
<link rel="stylesheet" href="/modules/core/src/jquery-ui.min.css">
<link rel="stylesheet" href="/modules/core/src/style.css">
<link rel="stylesheet" href="/modules/core/src/glyphicons.css">
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

  .btn {
    min-height: unset;
  }

  .btn-xs {
    margin-top: 5px;
  }

  #middle {
    height: fit-content;
  }
</style>
<div id="msgshow"></div>

{modal}

<div class="form-group rows">
  <form>
    <input type="hidden" name="nv" value="news">
    <input type="hidden" name="op" value="sendinfo">
    <div class="col-4">
      <input type="text" class="form-control" name="keyword" value="{keyword}"
        placeholder="Nhập tên thú cưng, chủ nuôi, SĐT...">
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

<div class="form-group" style="float: right;">
  <button class="btn btn-info" onclick="signModal()"> Danh sách chữ ký </button>
</div>

<div style="clear: both;"></div>


<div id="content">
  {content}
</div>

<script src="/modules/core/vhttp.js"></script>
<script src="/modules/core/vimage.js"></script>
<script src="/modules/core/vremind-5.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.js"></script>
<script src="/modules/core/src/jquery.ui.datepicker-vi.js"></script>
<script>
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
    'type': 'Chọn kiểu lông trước khi gửi'
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
    vremind.install('#breeder', '#breeder-suggest', (input) => {
      return new Promise(resolve => {
        vhttp.checkelse('', { action: 'get-user', keyword: input, type: 'breeder', id: global['id'] }).then(data => {
          resolve(data['html'])
        })
      })
    }, 500, 300)
    vremind.install('#owner', '#owner-suggest', (input) => {
      return new Promise(resolve => {
        vhttp.checkelse('', { action: 'get-user', keyword: input, type: 'owner', id: global['id'] }).then(data => {
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

  function remove(id) {
    global['id'] = id
    $("#remove-modal").modal('show')
  }

  function removeSubmit() {
    vhttp.checkelse('', { action: 'remove-info', id: global['id'] }).then(data => {
      $("#content").html(data['html'])
      $("#remove-modal").modal('hide')
    })
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
        if (!data[key].length) return key
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

  function textError(label) {
    $("#" + label + "-error").text(notify[label])
    $("#" + label + "-error").show()
    $("#" + label + "-error").fadeOut(3000)
    $('html, body').animate({
      scrollTop: $("#" + label + "-error").offset().top
    }, 1000);
  }

  function done(id, regno, micro) {
    global['id'] = id
    $("#done-regno").val(regno)
    $("#done-micro").val(micro)
    $("#done-modal").modal('show')
  }

  function doneSubmit() {
    vhttp.checkelse('', { action: 'done', id: global['id'], micro: $("#done-micro").val(), regno: $("#done-regno").val(), sign: $("#done-sign").val() }).then(data => {
      $("#content").html(data['html'])
      $("#done-modal").modal('hide')
    })
  }

  function signModal() {
    $("#sign-modal").modal('show')
  }

  function insertSign() {
    vhttp.checkelse('', { action: 'insert-sign', name: $("#sign-name").val() }).then(data => {
      $("#sign-content").html(data['html'])
    })
  }

  function updateSign(id) {
    vhttp.checkelse('', { action: 'update-sign', id: id, name: $("#sign-" + id).val() }).then(data => {
      alert_msg('Đã cập nhật')
      $("#sign-content").html(data['html'])
    })
  }

  function removeSign(id) {
    vhttp.checkelse('', { action: 'remove-sign', id: id, name: $("#sign-name").val() }).then(data => {
      $("#sign-content").html(data['html'])
    })
  }
</script>
<!-- END: main -->