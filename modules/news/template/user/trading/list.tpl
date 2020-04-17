<!-- BEGIN: main -->
<table class="table table-bordered">
  <thead>
    <tr>
      <th>
        Tên
      </th>
      <th>
        Loài
      </th>
      <th>
        Giống
      </th>
      <th>
        Trạng thái
      </th>
      <th>
        Chủ đề
      </th>
    </tr>
  </thead>
  <!-- BEGIN: row -->
  <tbody>
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
        {status}
      </td>
      <td>
        <!-- BEGIN: info -->
        <button class="btn btn-info" onclick="info({pid})" style="float: right;">
          Xem liên hệ
        </button>
        <!-- END: info -->
        <!-- BEGIN: link -->
        <a href="/news/info/?id={id}"> Chi tiết </a>
        <!-- END: link -->
        <!-- BEGIN: cancel -->
        <button class="btn btn-info" onclick="cancel({type}, {id})" style="float: right;">
          Hủy
        </button>
        <!-- END: cancel -->
        <!-- BEGIN: request -->
        <button class="btn btn-info" onclick="request({type}, {id})" style="float: right;">
          Yêu cầu lại
        </button>
        <!-- END: request -->
      </td>
    </tr>
  </tbody>
  <!-- END: row -->
</table>
{nav}
<!-- END: main -->