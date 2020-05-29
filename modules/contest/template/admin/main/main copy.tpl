<div class="form-group form-inline">
  Giống loài
  <label class="checkbox" style="margin-right: 20px"> <input type="checkbox" id="species-check-all" index="{id}" checked> tất cả </label>
  <!-- BEGIN: species2 -->
  <label class="checkbox" style="margin-right: 10px"> <input type="checkbox" class="species-checkbox" index="{id}" checked> {species} </label>
  <!-- END: species2 -->
</div>

<!-- BEGIN: main -->
<link rel="stylesheet" href="/modules/contest/src/style.css">
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.css">
<div id="msgshow"></div>
<style>
  .form-group { clear: both; }
</style>

{modal_contest}
{modal_test}
{remove_contest_modal}
{remove_all_contest_modal}

<div style="float: right; margin: 10px 0px;">
  <button class="btn btn-success" onclick="testModal()">
    Danh sách phần thi
  </button>
  <button class="btn btn-success" onclick="excel()">
    Xuất Excel
  </button>
</div>

<div style="float: left; margin: 10px 0px;">
  <button class="btn btn-warning" id="show-yes" style="display: {show_yes};" onclick="toggleContent(0)">
    <span class="glyphicon glyphicon-eye-open"> </span>
  </button>
  <button class="btn btn-info" id="show-no" style="display: {show_no};" onclick="toggleContent(1)">
    <span class="glyphicon glyphicon-eye-close"> </span>
  </button>
</div>

<div style="clear: both;"></div>

<div class="form-group form-inline">
  <div class="input-group">
    <input type="text" class="form-control" id="filter-limit" value="10">
    <div class="input-group-btn">
      <button class="btn btn-info" onclick="goPage(1)">
        Hiển thị
      </button>
    </div>
  </div>
  <select class="form-control" id="filter-species">
    <option value="0" checked> Toàn bộ </option>
    <!-- BEGIN: species -->
    <option value="{id}" checked> {species} </option>
    <!-- END: species -->
  </select>
</div>
<div class="form-group form-inline">
  Danh sách phần thi
  <label class="checkbox" style="margin-right: 20px"> <input type="checkbox" id="filter-check-all" index="{id}" checked> tất cả </label>
  <!-- BEGIN: contest -->
  <label class="checkbox" style="margin-right: 10px"> <input type="checkbox" class="filter-contest filter-checkbox" index="{id}" checked> {contest} </label>
  <!-- END: contest -->
</div>
<div class="form-group text-center">
  <button class="btn btn-info" onclick="goPage(1)">
    Lọc danh sách
  </button>
</div>

<div id="content">
  {content}
</div>
<button class="btn btn-info" onclick="confirmAllSubmit(1)">
  Duyệt các mục đã chọn
</button>
<button class="btn btn-warning" onclick="confirmAllSubmit(0)">
  Bỏ duyệt các mục đã chọn
</button>
<button class="btn btn-danger" onclick="removeAllRow()">
  Xóa các mục đã chọn
</button>


<script src="/modules/contest/src/script.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/language/jquery.ui.datepicker-{NV_LANG_INTERFACE}.js"></script>
<script>
  var global = {
    id: 0,
    page: 1,
    'species': JSON.parse('{species}')
  }

  $(document).ready(() => {
    installCheckbox('test')
    // installCheckbox('species')
    installCheckbox('contest')
    installCheckbox('filter')
    installSuggest('signup', 'species')
  })

  function checkFilter() {
    limit = $("#filter-limit")
    if (!(limit > 10)) limit = 10

    contest = []
    $(".filter-contest").each((index, item) => {
      if (item.checked) contest.push(item.getAttribute('index'))
    })
    return {
      page: global['page'],
      limit: limit,
      species: $("#filter-species").val(),
      contest: contest
    }
  }

  function excel() {
    contest = []
    $(".filter-contest").each((index, item) => {
      if (item.checked) contest.push(item.getAttribute('index'))
    })
    $.post(
      '',
      { action: 'excel', contest: contest },
      (response, status) => {
        checkResult(response, status).then(data => {
          window.open(strHref +'&download=1')
        })
      }
    )
  }

  function getContest(id) {
    $.post(
      '',
      { action: 'get-contest', id: id },
      (response, status) => {
        checkResult(response, status).then(data => {
          global['id'] = id
          $("#modal-contest").modal('show')
          $("#signup-name").val(data['data']['name'])
          $("#signup-petname").val(data['data']['petname'])
          $("#signup-species").val(data['data']['species'])
          $("#signup-address").val(data['data']['address'])
          $("#signup-mobile").val(data['data']['mobile'])
          $("[name=contest]").each((index, item) => {
            item.checked = false
          })
          data['data']['test'].forEach(id => {
            $("[name=contest][index="+ id +"]").each((index, item) => {
              item.checked = true
            })
          });
        })
      }
    )
  }

  function checkSignupData() {
    test = []
    name = $("#signup-name").val()
    petname = $("#signup-petname").val()
    address = $("#signup-address").val()
    mobile = $("#signup-mobile").val()
    species = $("#signup-species").val()
    if (!name.length) return 'Tên người/đơn vị không được để trống'
    if (!petname.length) return 'Tên thú cưng không được để trống'
    if (!species.length) return 'Giống loài không được để trống'
    if (!address.length) return 'Địa chỉ không được để trống'
    if (!mobile.length) return 'Số điện thoại không được để trống'
    $("[name=contest]").each((index, item) => {
      indexkey = item.getAttribute('index')
      if (item.checked) test.push(indexkey)
    })
    if (!test.length) return 'Chọn ít nhất 1 phần thi'
    return {
      name: name,
      petname: petname,
      species: species,
      address: address,
      mobile: mobile,
      test: test
    }
  }

  function editSubmit() {
    data = checkSignupData()
    if (!data['name']) {
      alert_msg(data)
    }
    else {
      $.post(
        '',
        { action: 'edit-contest', filter: checkFilter(), id: global['id'], data: data },
        (response, status) => {
          checkResult(response, status).then(data => {
            $("#content").html(data['html'])
            $("#modal-contest").modal('hide')
          })
        }
      )
    }
  }

  function toggleContent(type) {
    $.post(
      '',
      { action: 'toggle-content', type: type },
      (response, status) => {
        checkResult(response, status).then(data => {
          if (type) {
            $("#show-yes").show()
            $("#show-no").hide()
          }
          else {
            $("#show-no").show()
            $("#show-yes").hide()
          }
        })
      }
    )
  }

  function goPage(page) {
    global['page'] = page
    $.post(
      '',
      { action: 'filter', filter: checkFilter() },
      (response, status) => {
        checkResult(response, status).then(data => {
          $('#content').html(data['html'])
        })
      }
    )
  }

  function testModal() {
    $("#modal-test").modal('show')
  }

  function toggleTestSubmit(id, type) {
    $.post(
      '',
      { action: 'toggle-test', id: id, type: type },
      (response, status) => {
        checkResult(response, status).then(data => {
          $("#test-content").html(data['html'])
          installCheckbox('test')
        })
      }
    )
  }

  function updateTestSubmit(id) {
    name = $("#test-name-" + id).val()
    if (!name.length) alert_msg('Điền nội dung trước khi cập nhật')
    else {
      $.post(
        '',
        { action: 'update-test', name: name, id: id },
        (response, status) => {
          checkResult(response, status).then(data => {
            // do nothing
          })
        }
      )
    }
  }

  function updateTestAllSubmit() {
    data = {}
    $(".test-name").each((index, item) => {
      id = trim(item.getAttribute('id').replace('test-name-', ''))
      data[id] = item.value
    })
    if (!Object.keys(data).length) {
      alert_msg('Thêm ít nhất 1 mục trước khi cập nhật')      
    }
    else {
      $.post(
        '',
        { action: 'update-test-all', data: data },
        (response, status) => {
          checkResult(response, status).then(data => {
            // do nothing
          })
        }
      )
    }
  }

  function testInsertSubmit() {
    name = $("#test-input").val()
    if (!name.length) {
      alert_msg('Nhập nội dung trước khi thêm')
    }
    else {
      $.post(
        '',
        { action: 'insert-test', name: name },
        (response, status) => {
          checkResult(response, status).then(data => {
            $("#test-content").html(data['html'])
            installCheckbox('test')
          })
        }
      )
    }
  }

  function installCheckbox(name) {
    $("#" + name + "-check-all").change(e => {
      checked = e.currentTarget.checked
      $("." + name + "-checkbox").each((index, item) => {
        item.checked = checked
      })
    })
  }

  function removeRow(id) {
    global['id'] = id
    $("#remove-contest-modal").modal('show')
  }

  function removeAllRow() {
    list = []
    $('.contest-checkbox').each((index, item) => {
      indexkey = item.getAttribute('index')
      if (item.checked) list.push(indexkey)
    })
    if (!list.length) alert_msg('Chọn ít nhất 1 mục để xóa')
    else $("#remove-all-contest-modal").modal('show')
  }

  function confirmSubmit(id, type) {
    $.post(
      '',
      { action: 'confirm-contest', filter: checkFilter(), id: id, type: type },
      (response, status) => {
        checkResult(response, status).then(data => {
          global['id'] = 0
          $("#content").html(data['html'])
          installCheckbox('contest')
        })
      }
    )
  }

  function confirmAllSubmit(type) {
    list = []
    $('.contest-checkbox').each((index, item) => {
      indexkey = item.getAttribute('index')
      if (item.checked) list.push(indexkey)
    })
    if (!list.length) alert_msg('Chọn ít nhất 1 mục để duyệt')
    else {
      $.post(
        '',
        { action: 'done-all-contest', filter: checkFilter(), list: list, type: type },
        (response, status) => {
          checkResult(response, status).then(data => {
            $("#content").html(data['html'])
            installCheckbox('contest')
          })
        }
      )
    }
  }

  function removeRowSubmit() {
    if (!global['id']) {
      alert_msg('Mục chọn không tồn tại')
    }
    else {
      $.post(
        '',
        { action: 'remove-contest', filter: checkFilter(), id: global['id'] },
        (response, status) => {
          checkResult(response, status).then(data => {
            global['id'] = 0
            $("#remove-contest-modal").modal('hide')
            $("#content").html(data['html'])
            installCheckbox('contest')
          })
        }
      )
    }
  }

  function removeAllRowSubmit() {
    list = []
    $('.contest-checkbox').each((index, item) => {
      indexkey = item.getAttribute('index')
      if (item.checked) list.push(indexkey)
    })
    if (!list.length) alert_msg('Chọn ít nhất 1 mục để xóa')
    else {
      $.post(
        '',
        { action: 'remove-all-contest', filter: checkFilter(), list: list },
        (response, status) => {
          checkResult(response, status).then(data => {
            $("#remove-all-contest-modal").modal('hide')
            $("#content").html(data['html'])
            installCheckbox('contest')
          })
        }
      )
    }
  }

  function selectKey(name, type, key) {
    input = $("#"+ name +"-"+ type)
    input.val(key)
  }
  
  function installSuggest(name, type) {
    input = $("#"+ name +"-"+ type)
    suggest = $("#"+ name +"-"+ type + "-suggest")
    
    input.keyup((e) => {
      keyword = e.currentTarget.value.toLowerCase()
      html = ''
      count = 0

      global[type].forEach(item => {
        if (count < 30 && item.toLowerCase().search(keyword) >= 0) {
          count ++
          html += `
            <div class="suggest-item" onclick="selectKey('`+ name +`', '`+ type +`', '`+ item +`')">
              `+ item +`
            </div>`
        }
      })
      
      if (!html.length) {
        html = 'Không có kết quả'
      }
      
      suggest.html(html)
    })
    input.focus(() => {
      suggest.show()
    })
    input.blur(() => {
      setTimeout(() => {
        suggest.hide()
      }, 300);
    })
  }
</script>
<!-- END: main -->
