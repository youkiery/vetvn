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
  <div id="modal-remove" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-body">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <p class=" text-center"> Xác nhận xóa? </p>
          <div class="text-center">
            <button class="btn btn-danger" onclick="removeSubmit()">
              Xóa bản ghi
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="modal-edit" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-body">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <p class=" text-center"> Chỉnh sửa thông tin </p>
          <label class="row">
            <div class="col-sm-8">
              Tên
            </div>
            <div class="col-sm-16">
              <input type="text" class="form-control" id="edit-name">
            </div>
          </label>
          <label class="row">
            <div class="col-sm-8">
              Loại
            </div>
            <div class="col-sm-16">
              <select class="form-control" id="edit-value">
                <!-- BEGIN: sele -->
                <option value="{name}"> {value} </option>
                <!-- END: sele -->
              </select>
            </div>
          </label>
          <div class="text-center">
            <button class="btn btn-info" id="btn-insert" onclick="insertSubmit()">
              Thêm thông tin
            </button>
            <button class="btn btn-info" id="btn-edit" onclick="editSubmit()">
              Sửa thông tin
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

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

  <form onsubmit="filterE(event)">
    <div class="row">
      <div class="col-sm-8">
        <input type="text" class="form-control" id="keyword" placeholder="Nhập từ khóa">
      </div>
      <div class="col-sm-4">
        <select class="form-control" id="limit">
          <option value="10"> 10 </option>
          <option value="20"> 20 </option>
          <option value="50"> 50 </option>
          <option value="75"> 75 </option>
          <option value="100"> 100 </option>
        </select>
      </div>
      <div class="col-sm-6">
        <select class="form-control" id="type">
          <!-- BEGIN: sel -->
          <option value="{name}"> {value} </option>
          <!-- END: sel -->
        </select>
      </div>
    </div>
    <label> <input type="radio" name="status" class="status" id="status-0" checked> Toàn bộ </label>
    <label> <input type="radio" name="status" class="status" id="status-1"> Chưa xác nhận </label>
    <label> <input type="radio" name="status" class="status" id="status-2"> Đã xác nhận </label>
    <button class="btn btn-info">
      Lọc
    </button>
  </form>
  <button class="btn btn-success" onclick="insert()">
    <span class="glyphicon glyphicon-plus"></span>
  </button>

  <button class="btn btn-info" style="float: right;" onclick="selectRow(this)">
    <span class="glyphicon glyphicon-unchecked"></span>
  </button>
  <button class="btn btn-danger select-button" style="float: right;" onclick="removeList()" disabled>
    <span class="glyphicon glyphicon-trash"></span>
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
</div>

<script src="/modules/{module_file}/src/script-a.js"></script>
<script>
  var global = {
    url: '{origin}',
    page: 1,
    id: 0
  }
  var reversal = JSON.parse('{reversal}')

  var modalEdit = $("#modal-edit")
  var modalRemove = $("#modal-remove")

  var btnInsert = $("#btn-insert")
  var btnEdit = $("#btn-edit")

  var content = $("#content")
  var keyword = $("#keyword")
  var limit = $("#limit")
  var type = $("#type")
  var cstatus = $(".status")

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

  function remove(id) {
    global['id'] = id
    modalRemove.modal('show')
  }  

  function removeSubmit() {
    $.post(
      global['url'],
      {action: 'remove', id: global['id'], filter: checkFilter()},
      (response, status) => {
        checkResult(response, status).then(data => {
          content.html(data['html'])
          modalRemove.modal('hide')
        }, () => {})
      }
    )
  }

  function checkData() {
    return {
      name: $("#edit-name").val(),
      value: $("#edit-value").val()
    }
  }

  function insert() {
    btnInsert.show()
    btnEdit.hide()
    modalEdit.modal('show')
  }

  function insertSubmit() {
    $.post(
      global['url'],
      {action: 'insert', filter: checkFilter(), data: checkData()},
      (response, status) => {
        checkResult(response, status).then(data => {
          content.html(data['html'])
          $("#edit-name").val('')
          $("#edit-value").val('')
          modalEdit.modal('hide')
        }, () => {})
      }
    )
  }

  function edit(id) {
    global['id'] = id
    $("#edit-name").val($("#name-" + id).text())
    $("#edit-value").val(reversal[trim($("#value-" + id).text())])
    btnInsert.hide()
    btnEdit.show()
    modalEdit.modal('show')
  }

  function editSubmit() {
    $.post(
      global['url'],
      {action: 'edit', id: global['id'], filter: checkFilter(), data: checkData()},
      (response, status) => {
        checkResult(response, status).then(data => {
          content.html(data['html'])
          $("#edit-name").val('')
          $("#edit-value").val('')
          modalEdit.modal('hide')
        }, () => {})
      }
    )
  }

  function goPage(page) {
    global['page'] = page
    filter()
  }

  function filterE(event) {
    event.preventDefault()
    global['page'] = 1
    filter()
  }

  function filter() {
    $.post(
      global['url'],
      {action: 'filter', filter: checkFilter()},
      (response, status) => {
        checkResult(response, status).then(data => {
          content.html(data['html'])
        }, () => {})
      }
    )
  }

  function checkFilter() {
    var temp = cstatus.filter((index, item) => {
      return item.checked
    })
    var value = 0
    if (temp[0]) {
      value = splipper(temp[0].getAttribute('id'), 'user-status')
    }
    return {
      keyword: keyword.val(),
      page: global['page'],
      limit: limit.val(),
      type: type.val(),
      status: value
    }
  }

  function check(id) {
    $.post(
      global['url'],
      {action: 'check', id: id, filter: checkFilter()},
      (response, status) => {
        checkResult(response, status).then(data => {
          content.html(data['html'])
        }, () => {})
      }
    )
  }

  function nocheck(id) {
    $.post(
      global['url'],
      {action: 'no-check', id: id, filter: checkFilter()},
      (response, status) => {
        checkResult(response, status).then(data => {
          content.html(data['html'])
        }, () => {})
      }
    )
  }
</script>
<!-- END: main -->
