<!-- BEGIN: main -->
<link rel="stylesheet" href="/modules/core/src/style.css">
<link rel="stylesheet" href="/themes/default/src/glyphicons.css">
<link rel="stylesheet" href="/themes/default/src/jquery-ui.min.css">
<script type="text/javascript" src="/themes/default/src/jquery-ui.min.js"></script>
<script type="text/javascript" src="/themes/default/src/jquery.ui.datepicker-vi.js"></script>

<div id="msgshow"></div>

{modal}

<form>
  <input type="hidden" name="nv" value="news">
  <input type="hidden" name="op" value="revenue">
  <div class="form-group input-group">
    <select class="form-control" name="type">
      <option value="1" {type1}> Danh sách thu </option>
      <option value="2" {type2}> Danh sách chi </option>
    </select>
    <div class="input-group-btn">
      <button class="btn btn-info" style="height: 32px;">
        Lọc
      </button>
    </div>
  </div>
</form>

<div style="float: right;">
  <button class="btn btn-success btn-sm" onclick="checkAllModal()">
    Thêm hàng loạt
  </button>
  <!-- BEGIN: collect -->
  <button class="btn btn-success btn-sm" id="nceti" onclick="newCeti()">
    Thêm phiếu thu
  </button>
  <!-- END: collect -->
  <!-- BEGIN: pay -->
  <button class="btn btn-success btn-sm" id="npay" onclick="pay()">
    Thêm phiếu chi
  </button>
  <!-- END: pay -->
</div>

<div style="clear: both;"></div>
<div id="content">
  {content}
</div>

<script src="/modules/core/vhttp.js"></script>
<script>
  var content = $("#content")
  var global = {
    id: 0,
    petid: 0,
    page: 1,
    page2: 1,
    parentid: 0,
    certify: 0
  }

  $(document).ready(() => {
    $("#filter-from, #filter-end").datepicker({
      format: 'dd/mm/yyyy',
      changeMonth: true,
      changeYear: true
    });
    $("#pay-price, #ceti-price").keyup((e) => {
      var current = e.currentTarget
      var val = Number(current['value'].replace(/\,/g, ""));
      if (Number.isFinite(val)) {
        money = val
      }

      val = formatter.format(val).replace(/ ₫/g, "").replace(/\./g, ",");
      current.value = val
    })
    installCheckbox()
  })

  function t1() {
    $("#nceti").show()
    $("#npay").hide()
  }

  function t2() {
    $("#nceti").hide()
    $("#npay").show()
  }

  function showStatistic() {
    $("#modal-statistic").modal('show')
  }

  function viewStatistic(e) {
    e.preventDefault()
    $.post(
      strHref,
      { action: 'statistic', filter: { from: $("#filter-from").val(), end: $("#filter-end").val() } },
      (response, status) => {
        checkResult(response, status).then(data => {
          $("#statistic").html(data['html'])
        })
      }
    )
  }

  function filter() {
    if ($("#filter-type-1").prop('checked')) {
      goPage(1)
    }
    else {
      goPage2(1)
    }
  }

  function goPage(page) {
    global['page'] = page
    $.post(
      strHref,
      { action: 'filter', filter: checkFilter() },
      (response, status) => {
        checkResult(response, status).then(data => {
          content.html(data['html'])
          installCheckbox()
          $("#modal-ceti").modal('hide')
        }, () => { })
      }
    )
  }

  function goPage2(page) {
    global['page2'] = page
    $.post(
      strHref,
      { action: 'filter', filter: checkFilter2() },
      (response, status) => {
        checkResult(response, status).then(data => {
          content.html(data['html'])
          installCheckbox()
          $("#modal-ceti").modal('hide')
        }, () => { })
      }
    )
  }

  function checkFilter() {
    return {
      page: global['page'],
      limit: 10,
      type: ($("#filter-type-1").prop('checked') ? 1 : 2)
    }
  }

  function checkFilter2() {
    return {
      page: global['page2'],
      limit: 10,
      type: ($("#filter-type-1").prop('checked') ? 1 : 2)
    }
  }

  function removePay(id) {
    global['id'] = id
    $("#modal-remove-pay").modal('show')
  }

  function removePaySubmit() {
    $.post(
      strHref,
      { action: 'remove-pay', id: global['id'], filter: checkFilter2() },
      (response, status) => {
        checkResult(response, status).then(data => {
          content.html(data['html'])
          installCheckbox()
          $("#modal-pay").modal('hide')
        }, () => { })
      }
    )
  }

  function pay() {
    $("#modal-pay").modal('show')
  }

  function checkPay() {
    return {
      userid: $("#pay-user").val(),
      price: Number($("#pay-price").val().replace(/\,/g, "")),
      content: $("#pay-content").val()
    }
  }

  function paySubmit() {
    if ($("#filter-type-1").prop('checked')) {
      $("#filter-type-2").prop('checked', true);
      global['page2'] = 1
    }
    $.post(
      strHref,
      { action: 'pay', data: checkPay(), filter: checkFilter2() },
      (response, status) => {
        checkResult(response, status).then(data => {
          content.html(data['html'])
          installCheckbox()
          $("#modal-pay").modal('hide')
        }, () => { })
      }
    )
  }

  function newCeti() {
    $("#modal-parent").modal('show')
  }

  function ceti(id, price) {
    global['id'] = id

    $("#ceti-price").val(price)
    $("#modal-ceti").modal('show')
  }

  function cetiSubmit() {
    if (global['certify']) {
      vhttp.checkelse('', { action: 'check-all', price: Number($("#ceti-price").val().replace(/\,/g, "")), list: list }).then(data => {
        $("#content").html(data['html'])
        installCheckbox()
        $("#modal-ceti").modal('hide')
      })
    }
    else {
      vhttp.checkelse('', { action: 'ceti', price: Number($("#ceti-price").val().replace(/\,/g, "")), id: global['id'] }).then(data => {
        content.html(data['html'])
        installCheckbox()
        $("#modal-ceti").modal('hide')
      })
    }
  }

  function removeCetiSubmit() {
    if (global['certify']) {
      vhttp.checkelse('', { action: 'remove-check-all', list: list }).then(data => {
        $("#content").html(data['html'])
        installCheckbox()
        $("#modal-ceti").modal('hide')
      })
    }
    else {
      vhttp.checkelse('', { action: 'remove-ceti', id: global['id'] }).then(data => {
        content.html(data['html'])
        installCheckbox()
        $("#modal-ceti").modal('hide')
      })
    }
  }

  function parentFilter() {
    $.post(
      global['url'],
      // {action: 'filter-parent', key: $("#parent-key").val(), type: ($("#parent-type-1").prop('checked') ? 1 : 2)},
      { action: 'filter-parent', key: $("#parent-key").val() },
      (response, status) => {
        checkResult(response, status).then(data => {
          $("#parent-list").html(data['html'])
        }, () => { })
      }
    )
  }

  function thisOwner(id) {
    global['parentid'] = id
    petFilter()
  }

  function petFilter() {
    if (global['parentid']) {
      $.post(
        global['url'],
        { action: 'filter-pet', key: $("#pet-key").val(), parentid: global['parentid'] },
        (response, status) => {
          checkResult(response, status).then(data => {
            $("#pet-list").html(data['html'])
          }, () => { })
        }
      )
    }
  }

  function thisPet(id, name) {
    $("#modal-parent").modal('hide')
    ceti(id, 0)
  }

  function checkCheckbox() {
    list = []
    $(".checkbox:checked").each((index, item) => {
      list.push(item.getAttribute('rel'))
    })
    return list
  }

  function installCheckbox() {
    $("#check-all").click(e => {
      value = e.currentTarget.checked
      $(".checkbox").prop('checked', value)
    })
  }

  function checkAllModal() {
    if (!(list = checkCheckbox()).length) alert_msg('Chọn ít nhất một mục')
    else {
      global['certify'] = 1
      $("#modal-ceti").modal('show')
    }
  }

  function removeCheckAll() {
    if (!(list = checkCheckbox()).length) alert_msg('Chọn ít nhất một mục')
    else {
      vhttp.checkelse('', { action: 'check-all', list: list }).then(data => {
        $("#content").html(data['html'])
        installCheckbox()
      })
    }
  }
</script>
<!-- END: main -->