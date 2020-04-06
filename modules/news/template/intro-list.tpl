<!-- BEGIN: main -->
<table class="table table-bordered">
  <tr>
    <th>
      STT
    </th>
    <th>
      Tên khách
    </th>
    <th>
      Địa chỉ
    </th>
    <th>
      Số điện thoại
    </th>
    <th>
      Chuyên mục
    </th>
  </tr>
  <!-- BEGIN: row -->
  <tr>
    <td rowspan="3"> {index} </td>
    <td> {target} </td>
    <td> {address} </td>
    <td> {mobile} </td>
    <td> {type} </td>
  </tr>
  <tr>
    <td>
      {name}
    </td>
    <td>
      {breed}
    </td>
    <td>
      {species}
    </td>
    <td>
      <a href="/news/detail/?id={pid}"> Chi tiết </a>
    </td>
  </tr>
  <tr>
    <td colspan="4">
      <div style="width: 50%; float: left;">
        Ghi chú: {note}
      </div>
      <div style="width: 50%; float: left; text-align: right">
        <button class="btn btn-info btn-sm" onclick="hideIntro({id})">
          Ẩn thông tin này
        </button>
      </div> 
    </td>
  </tr>
  <!-- END: row -->
</table>
{nav}
<!-- END: main -->
