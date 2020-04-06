<!-- BEGIN: main -->
<table class="table table-bordered">
  <tr>
    <th>
      STT
    </th>
    <th>
      Họ và tên
    </th>
    <th>
      Địa chỉ
    </th>
    <th>
      Số điện thoại
    </th>
    <th>
      Vai trò
    </th>
    <th></th>
  </tr>
  <!-- BEGIN: row -->
  <tbody id="{id}">
    <tr class="{color}">
      <td>
        {index}
      </td>
      <td>
        {name}
      </td>
      <td>
        {address}
      </td>
      <td>
        {mobile}
      </td>
      <td>
        {allow}
      </td>
      <td>
        <button class="btn btn-danger" onclick="remove({id})">
          <span class="glyphicon glyphicon-remove"></span>
        </button>
      </td>
    </tr>
  </tbody>
  <!-- END: row -->
</table>
{nav}
<!-- END: main -->
