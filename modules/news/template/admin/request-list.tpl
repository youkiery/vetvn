<!-- BEGIN: main -->
<table class="table table-bordered">
  <tr>
    <th>
      STT
    </th>
    <th>
      Chủ trại
    </th>
    <th>
      Địa chỉ
    </th>
    <th>
      Số điện thoại
    </th>
    <th>
      Thú cưng
    </th>
    <th>
      Loại yêu cầu
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
        {owner}
      </td>
      <td>
        {address}
      </td>
      <td>
        {mobile}
      </td>
      <td>
        {pet}
      </td>
      <td>
        {type}
      </td>
      <td>
        <!-- BEGIN: tick -->
        <button class="btn btn-info" onclick="check({id})">
          <span class="glyphicon glyphicon-check"></span>
        </button>
        <button class="btn btn-danger" onclick="remove({id})">
          <span class="glyphicon glyphicon-remove"></span>
        </button>
        <!-- END: tick -->
      </td>
    </tr>
  </tbody>
  <!-- END: row -->
</table>
{nav}
<!-- END: main -->
