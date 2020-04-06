<!-- BEGIN: main -->
<!-- BEGIN: treat -->
<div>
  <form>
    <div class="input-group">
      <input type="hidden" name="disease" value="{disease}">
      <input class="form-control" type="text" name="keyword" value="{keyword}" placeholder="Tìm kiếm thú cưng">
      <div class="input-group-btn">
        <button class="btn btn-info">
          <span class="glyphicon glyphicon-search"></span>
        </button>
      </div>
    </div>
  </form>
</div>
<table class="table table-bordered">
  <tr>
    <th style="width: 20%;">
      Ngày điều trị
    </th>
    <th style="width: 20%;">
      Ngày thời gian điều trị
    </th>
    <th style="width: 15%;">
      Thú cưng
    </th>
    <th style="width: 45%;">
      Ghi chú
    </th>
  </tr>
  <!-- BEGIN: row -->
  <tr>
    <td>
      {start}
    </td>
    <td>
      {end}
    </td>
    <td>
      {pet}
    </td>
    <td>
      {note}
    </td>
  </tr>
  <!-- END: row -->
</table>
<!-- END: treat -->
<!-- BEGIN: disease -->
<div>
  <form>
    <div class="input-group">
      <input class="form-control" type="text" name="keyword" value="{keyword}" placeholder="Tìm kiếm loại bệnh">
      <div class="input-group-btn">
        <button class="btn btn-info">
          <span class="glyphicon glyphicon-search"></span>
        </button>
      </div>
    </div>
  </form>
</div>
<div style="clear: both;"></div>
<p>Chọn một bệnh bên dưới:</p>
<ul>
  <!-- BEGIN: row -->
  <li>
    <a href="/news/summary/?disease={disease}"> {disease} </a>
  </li>
  <!-- END: row -->
</ul>
<!-- END: disease -->
<!-- BEGIN: nodata -->
<p>Chưa có dữ liệu</p>
<!-- END: nodata -->
<!-- END: main -->
