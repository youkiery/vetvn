<!-- BEGIN: main -->
<table class="table table-bordered">
  <tr>
    <th> STT </th>
    <th> Tài khoản </th>
    <th> Họ tên </th>
    <th> Địa chỉ </th>
    <th> Số điện thoại </th>
  </tr>
  <!-- BEGIN: row -->
  <tbody id="{id}">
    <tr>
      <td>
        {index}
      </td>
      <td>
        {username}
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
    </tr>
    <tr>
      <td colspan="5" style="text-align: right;">
        <button class="btn btn-info" onclick="changePassword({id})">
          Đổi mật khẩu
        </button>
        <button class="btn btn-info" onclick="editUser({id})" data-toggle="tooltip" data-placement="top" title="Sửa">
          <span class="glyphicon glyphicon-edit"></span>
        </button>
        <!-- BEGIN: uncheck -->
        <button class="btn btn-warning" onclick="checkUser({id}, 0)" data-toggle="tooltip" data-placement="top" title="Bất hoạt người dùng">
          <span class="glyphicon glyphicon-check"></span>
        </button>
        <!-- END: uncheck -->
        <!-- BEGIN: check -->
        <button class="btn btn-success" onclick="checkUser({id}, 1)" data-toggle="tooltip" data-placement="top" title="Kích hoạt người dùng">
          <span class="glyphicon glyphicon-unchecked"></span>
        </button>
        <!-- END: check -->
        <button class="btn btn-danger" onclick="deleteUser({id})" data-toggle="tooltip" data-placement="top" title="Xóa người dùng">
          <span class="glyphicon glyphicon-remove"></span>
        </button>
      </td>
    </tr>
  </tbody>
  <!-- END: row -->
</table>
{nav}
<!-- END: main -->
