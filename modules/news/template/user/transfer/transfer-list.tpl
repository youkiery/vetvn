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
      Tên thú cưng
    </th>
    <th>
      Ngày chuyển
    </th>
  </tr>
  <!-- BEGIN: row -->
  <tr>
    <td> {index} </td>
    <td> {target} </td>
    <td> {address} </td>
    <td> {mobile} </td>
    <td> <a href="/{module_file}/detail/?id={id}"> {pet} </a> </td>
    <td> {time} </td>
  </tr>
  <!-- END: row -->
</table>
{nav}
<!-- END: main -->
