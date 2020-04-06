<!-- BEGIN: main -->
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.js"></script> 
<link rel="stylesheet" href="/themes/default/src/glyphicons.css">
<link rel="stylesheet" href="/modules/{module_file}/src/style.css">

<style>
  .select {
    background: rgb(223, 223, 223);
    border: 2px solid deepskyblue;
  }
</style>

<form onsubmit="filter(event)">
  <div class="row">
    <div class="col-sm-6">
      <input type="text" class="form-control" id="keyword" placeholder="Từ khóa">
    </div>
    <div class="col-sm-6">
      <select class="form-control" id="limit">
        <option value="10"> 10 </option>
        <option value="20"> 20 </option>
        <option value="50"> 50 </option>
        <option value="75"> 75 </option>
        <option value="100"> 100 </option>
      </select>
    </div>
    <div class="col-sm-6">
      <input type="text" class="form-control" id="atime" value="{atime}">
    </div>
    <div class="col-sm-6">
      <input type="text" class="form-control" id="ztime" value="{ztime}">
    </div>
  </div>
  <label> <input type="radio" name="user-status" class="status" id="user-status-0" checked> Toàn bộ </label>
  <label> <input type="radio" name="user-status" class="status" id="user-status-1"> Hủy xác nhận </label>
  <label> <input type="radio" name="user-status" class="status" id="user-status-2"> Chờ xác nhận </label>
  <label> <input type="radio" name="user-status" class="status" id="user-status-3"> Đã xác nhận </label>

  <button class="btn btn-info">
    <span class="glyphicon glyphicon-search"></span>
  </button>
</form>

<button class="btn btn-info" style="float: right;" onclick="selectRow(this)">
  <span class="glyphicon glyphicon-unchecked"></span>
</button>
<button class="btn btn-danger select-button" style="float: right;" onclick="removeList()" disabled>
  <span class="glyphicon glyphicon-trash"></span>
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
      value = splipper(temp[0].getAttribute('id'), 'user-status')
    }
    return {
      page: global['page'],
      limit: limit.val(),
      keyword: keyword.val(),
      atime: atime.val(),
      ztime: ztime.val(),
      status: value
    }
  }

  function filter(e) {
    e.preventDefault()
    global['page'] = 1
    $.post(
      strHref,
      {action: 'filter', filter: checkFilter()},
      (response, status) => {
        checkResult(response, status).then(data => {
          global['page'] = page
          content.html(data['html'])
        }, () => {})
      }
    )
  }

  function goPage(page) {
    global['page'] = page
    $.post(
      strHref,
      {action: 'gopage', filter: checkFilter()},
      (response, status) => {
        checkResult(response, status).then(data => {
          content.html(data['html'])
        }, () => {})
      }
    )
  }

  function check(id) {
    $.post(
      strHref,
      {action: 'check', id: id, filter: checkFilter()},
      (response, status) => {
        checkResult(response, status).then(data => {
          content.html(data['html'])
        }, () => {})
      }
    )
  } 

  function remove(id) {
    $.post(
      strHref,
      {action: 'remove', id: id, filter: checkFilter()},
      (response, status) => {
        checkResult(response, status).then(data => {
          content.html(data['html'])
        }, () => {})
      }
    )
  } 
</script>
<!-- END: main -->
