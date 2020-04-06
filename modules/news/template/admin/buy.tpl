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
<div class="modal" id="user-buy" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal">&times;</button>

        <label class="row">
          <div class="col-sm-6">
            Loài
          </div>
          <div class="col-sm-18" style="text-align: right;">
            <input type="text" class="form-control" id="species-buy">
            <div class="suggest" id="species-suggest-buy" style="text-align: left;"></div>
          </div>
        </label>

        <label class="row">
          <div class="col-sm-6">
            Giống
          </div>
          <div class="col-sm-18" style="text-align: right;">
            <input type="text" class="form-control" id="breed-buy">
            <div class="suggest" id="breed-suggest-buy" style="text-align: left;"></div>
          </div>
        </label>

        <label class="row">
          <div class="col-sm-6">
            Giới tính
          </div>
          <div class="col-sm-18">
            <label>
              <input type="radio" name="sex4" id="buy-sex-0" checked> Đực
            </label>
            <label>
              <input type="radio" name="sex4" id="buy-sex-1"> Cái
            </label>
          </div>
        </label>

        <label class="row">
          <div class="col-sm-6">
            Tuổi
          </div>
          <div class="col-sm-18">
            <input type="number" class="form-control" id="buy-age">
          </div>
        </label>

        <div id="buy-error" style="color: red; font-weight: bold;"></div>

        <div class="text-center">
          <button class="btn btn-info" onclick="buySubmit()">
            Thêm cần mua
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
    </div>
    <div style="float: left; width: 60%;">
      <input type="text" class="form-control" id="filter-owner" placeholder="Tên chủ">
      <input type="text" class="form-control" id="filter-mobile" placeholder="Số điện thoại">
      <input type="text" class="form-control" id="filter-mobile" placeholder="Địa chỉ">
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
<button class="btn btn-warning select-button" style="float: right;" onclick="deactiveList()" disabled>
  <span class="glyphicon glyphicon-arrow-down"></span>
</button>
<button class="btn btn-info select-button" style="float: right;" onclick="activeList()" disabled>
  <span class="glyphicon glyphicon-arrow-up"></span>
</button>

<div id="content">
  {content}
</div>

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
            content.html(data['html'])
          }, () => {})
        }
      )
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
      species: $("#filter-species").val(),
      breed: $("#filter-breed").val(),
      page: global['page'],
      limit: 10,
      status: getChecked('status')
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

  function remove(id) {
    $.post(
      strHref,
      { action: 'remove', id: id, filter: checkFilter() },
      (response, status) => {
        checkResult(response, status).then(data => {
          content.html(data['html'])
        }, () => { })
      }
    )
  } 

  function edit(id) {
    global['id'] = id
    $.post(
      global['url'],
      {action: 'get-buy', id: global['id']},
      (response, status) => {
        checkResult(response, status).then(data => {
          $("#species-buy").val(data['data']['species'])
          $("#breed-buy").val(data['data']['breed'])
          $("#buy-sex-" + data['data']['sex']).prop('checked', true)
          $("#buy-age").val(data['data']['age'])
          $("#user-buy").modal('show')
        }, () => {})
      }
    )    
  }

  function checkBuyData() {
    var sex0 = $("#buy-sex-0").prop('checked'), sex1 = $("#buy-sex-1").prop('checked')
    return {
      species: $("#species-buy").val(),
      breed: $("#breed-buy").val(),
      sex: (sex0 ? 1 : 2),
      age: $("#buy-age").val()
    }
  }

  function buySubmit() {
    data = checkBuyData()
    if (Number(data['age']) == NaN || data['age'] < 0) {
      data['age'] = 0
    }
    if (!data['species'].length || !data['breed'].length || !data['age'].length) {
      $("#buy-error").text('Các trường không được để trống')
    }
    else {
      freeze()
      $.post(
        global['url'],
        {action: 'buy', data: data, id: global['id'], filter: checkFilter()},
        (response, status) => {
          checkResult(response, status).then(data => {
            $("#user-buy").modal('hide')
          }, () => {})
        }
      )    
    }
  }
</script>
<!-- END: main -->