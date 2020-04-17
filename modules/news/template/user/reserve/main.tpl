<!-- BEGIN: main -->
<div class="container">
  <div id="msgshow"></div>

  <div class="modal" id="modal-confirm" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-body">
          <button class="close" data-dismiss="modal">&times;</button>
          <p> Xác nhận chuyển về danh sách thú cưng? </p>

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
  <div id="content">
    {content}
  </div>
</div>

<script>
  var global = {
    id: 0,
    url: '{url}',
    page: 1
  }
  var content = $("#content")
  var modalConfirm = $("#modal-confirm")

  function checkFilter() {
    return {
      page: global['page'],
      limit: 10
    }
  }

  function goPage(page) {
    global['page'] = page
    $.post(
      global['url'],
      {action: 'filter', filter: checkFilter()},
      (result, statatus) => {
        checkResult(result, statatus).then(data => {
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
          content.html(data['html'])
        }, () => {})
      }
    )
  }
</script>
<!-- END: main -->
