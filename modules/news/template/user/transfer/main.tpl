<!-- BEGIN: main -->
<div class="container">
  <div id="msgshow"></div>
  <div class="modal" id="modal-confirm" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-body">
          <button class="close" data-dismiss="modal">&times;</button>
          <p> Xác nhận yêu cầu chuyển nhượng? </p>

          <div class="text-center" onclick="confirmSubmit()">
            <button class="btn btn-success"> Xác nhận </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <a href="/">
    <img src="/themes/default/images/banner.png" style="width: 200px;">
  </a>

  <div style="float: right;">
    <a href="/{module_file}/logout"> Đăng xuất </a>
  </div>
  <div class="separate"></div>
  <a style="margin: 8px 0px; display: block;" href="javascript:history.go(-1)">
    <span class="glyphicon glyphicon-chevron-left">  </span> Trở về </a>
  </a>

<ul class="nav nav-tabs">
  <li class="active"><a data-toggle="tab" href="#home"> Danh sách đã chuyển </a></li>
  <li><a data-toggle="tab" href="#menu1"> Danh sách đã nhận </a></li>
  <li><a data-toggle="tab" href="#menu2"> Yêu cầu chuyển nhượng </a></li>
</ul>

<div class="tab-content">
  <div id="home" class="tab-pane fade in active">
    {content}
  </div>
  <div id="menu1" class="tab-pane fade">
    {content1}
  </div>
  <div id="menu2" class="tab-pane fade">
    {content2}
  </div>
</div>

</div>
<script>
  var global = {
    url: '{url}',
    page: 1,
    page2: 1,
    page3: 1,
  }
  var content = $("#home")
  var content2 = $("#menu1")
  var content3 = $("#menu2")

  var modalConfirm = $("#modal-confirm")

  function checkFilter() {
    return {
      page: global['page'],
      limit: 10,
      type: 'goPage'
    }
  }
  function checkFilter1() {
    return {
      page: global['page1'],
      limit: 10,
      type: 'goPage1'
    }
  }
  function checkFilter2() {
    return {
      page: global['page2'],
      limit: 10,
      type: 'goPage2'
    }
  }

  function goPage(page) {
    global['page'] = page
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

  function goPage1(page) {
    global['page'] = page
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

  function goPage2(page) {
    global['page2'] = page
    $.post(
      global['url'],
      {action: 'filter2', filter: checkFilter()},
      (response, status) => {
        checkResult(response, status).then(data => {
          content.html(data['html'])
        }, () => {})
      }
    )
  }

  function confirm(id) {
    global['id'] = id
    modalConfirm.modal('show')
  }

  function confirmSubmit() {
    $.post(
      global['url'],
      {action: 'confirm', id: global['id'], filter: checkFilter()},
      (result, statatus) => {
        checkResult(result, statatus).then(data => {
          modalConfirm.modal('hide')
          content2.html(data['html'])
        }, () => {})
      }
    )
  }
</script>
<!-- END: main -->
