<!-- BEGIN: main -->
<table class="table table-bordered table-hover">
  <tr>
    <th> STT </th>
    <th> Người đăng ký </th>
    <th> Số điện thoại </th>
    <th> Môn đăng ký </th>
    <th></th>
  </tr>
  <!-- BEGIN: row -->
  <tr>
    <td> {index} </td>
    <td> {name} </td>
    <td> {mobile} </td>
    <td> {court} </td>  
    <td>
      <button class="btn btn-info" onclick="edit({id})">
        <span class="glyphicon glyphicon-edit"></span>
      </button>
      <button class="btn btn-danger" onclick="remove({id})">
        <span class="glyphicon glyphicon-remove"></span>
      </button>
      <!-- BEGIN: yes -->
      <button class="btn btn-warning" rel="{id}" onclick="activeSubmit({id}, 0)">
        Hủy xác nhận
      </button>
      <!-- END: yes -->
      <!-- BEGIN: no -->
      <button class="btn btn-info" rel="{id}" onclick="activeSubmit({id}, 1)">
        Xác nhận
      </button>
      <!-- END: no -->
    </td>
  </tr>
  <!-- END: row -->
</table>
{nav}
<!-- END: main -->
