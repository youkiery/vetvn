<!-- BEGIN: main -->
<link rel="stylesheet" href="/modules/news/src/jquery-ui.min.css">
<link rel="stylesheet" href="/modules/news/src/style.css">
<link rel="stylesheet" href="/modules/news/src/glyphicons.css">
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
</style>
<div class="container">
  <div id="msgshow"></div>
</div>

{modal}

<div id="content">
  {content}
</div>

<script src="/modules/core/vhttp.js"></script>
<script src="/modules/core/vimage.js"></script>
<script src="/modules/core/vremind-5.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.js"></script>
<script src="/modules/news/src/jquery.ui.datepicker-vi.js"></script>
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

  function edit(id) {
    vhttp.checkelse('', { action: 'get-info', id: id }).then(data => {
      global['id'] = id
      global['pet'] = {
        0: data['data']['father'],
        1: data['data']['mother']
      }
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

  function done(id) {
    global['id'] = id
    $("#done-modal").modal('show')
  }

  function doneSubmit() {
    vhttp.checkelse('', { action: 'done', id: global['id'], micro: $("#done-micro").val() }).then(data => {
      $("#content").html(data['html'])
    })
  }
</script>
<!-- END: main -->