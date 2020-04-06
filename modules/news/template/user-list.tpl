<!-- BEGIN: main -->
<table class="table table-bordered">
  <tr>
    <th> STT </th>
    <th> Họ tên </th>
    <th> Địa chỉ </th>
    <th> Số điện thoại </th>
    <th>  </th>
  </tr>
  <!-- BEGIN: row -->
  <tr>
    <td>
      {index}
    </td>
    <td>
      {fullname}
    </td>
    <td>
      {address}
    </td>
    <td>
      {mobile}
    </td>
    <td>
      <button class="btn btn-info" onclick="editUser({id})">
        <span class="glyphicon glyphicon-edit"></span>
      </button>
      <!-- BEGIN: uncheck -->
      <button class="btn btn-warning" onclick="checkUser({id}, 0)">
        <span class="glyphicon glyphicon-unchecked"></span>
      </button>
      <!-- END: uncheck -->
      <!-- BEGIN: check -->
      <button class="btn btn-success" onclick="checkUser({id}, 1)">
        <span class="glyphicon glyphicon-check"></span>
      </button>
      <!-- END: check -->
      <button class="btn btn-danger" onclick="deleteUser({id})">
        <span class="glyphicon glyphicon-remove"></span>
      </button>
    </td>
  </tr>
  <!-- END: row -->
</table>
<!-- END: main -->
