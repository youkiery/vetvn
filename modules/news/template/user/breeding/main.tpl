<!-- BEGIN: main -->
<div class="container">
  <div id="msgshow"></div>
  <div style="float: right;">
    {FILE "../../heading.tpl"}
  </div>
  <div style="clear: right;"></div>
  <a href="/">
    <img src="/themes/default/images/banner.png" style="float: left; width: 200px;">
  </a>
  <form onsubmit="filter(event)" style="width: 60%; float: right;">
    <div class="row">
      <div class="col-sm-6">
        <input type="text" class="form-control" id="species" placeholder="Loài: chó, mèo,...">
        <!-- <select name="species" class="form-control" id="species">
          {species}
        </select> -->
      </div>
      <div class="col-sm-6">
        <input type="text" class="form-control" id="breed" placeholder="Giống: husky, alaska,...">
        <!-- <select name="breed" class="form-control" id="breed">
          {breed}
        </select> -->
      </div>
    </div>
    <label class="input-group">
      <input type="text" class="form-control" name="keyword" value="{keyword}" id="keyword" placeholder="Nhập tên hoặc mã số">
      <div class="input-group-btn">
        <button class="btn btn-info"> Tìm kiếm </button>
      </div>
    </label>
  </form>
  <div style="clear: both;"></div>

  <div id="content">
    {content}
  </div>
</div>
<script>
  var global = {
    'url': '{url}',
    'page': 1
  }
  var content = $("#content")

  function checkFilter() {
    return {
      species: $("#species").val(),
      breed: $("#breed").val(),
      page: global['page'],
      limit: 12,
      keyword: $("#keyword").val()
    }
  }

  function filter(e) {
    e.preventDefault()
    goPage(1)
  }

  function goPage(page) {
    global['page'] = page
    $.post(
      global['url'],
      {action: 'filter', filter: checkFilter()},
      (response, status) => {
        checkResult(response, status).then(data => {
          content.html(data['html'])
        })
      }
    )
  }
</script>
<!-- END: main -->
