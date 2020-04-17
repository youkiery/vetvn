<!-- BEGIN: main -->
<style>
  .btn-sm {
    padding: 2px !important;
    min-height: 12px !important;
  }
</style>
<div class="container">
  <div id="msgshow"></div>
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
    url: '{url}',
    page: 1
  }
  var content = $("#content")

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
      (response, status) => {
        checkResult(response, status).then(data => {
          content.html(data['html'])
        }, () => {})
      }
    )
  }

  function hideIntro(id) {
    // freeze()
    $.post(
      global['url'],
      {action: 'hide', id: id, filter: checkFilter()},
      (response, status) => {
        checkResult(response, status).then(data => {
          content.html(data['html'])
        }, () => {})
      }
    )
  }
</script>
<!-- END: main -->
