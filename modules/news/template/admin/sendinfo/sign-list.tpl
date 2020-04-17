<!-- BEGIN: main -->
<table class="table table-bordered">
  <tr>
    <th class="cell-center"> STT </th>
    <th class="cell-center"> Tên người ký </th>
    <th> </th>
  </tr>
  <!-- BEGIN: row -->
  <tr>
    <td> {index} </td>
    <td> <input class="form-control" type="text" id="sign-{id}" value="{name}"> </td>
    <td> 
      <button class="btn btn-info btn-xs" onclick="updateSign({id})">
        cập nhật
      </button>  
      <button class="btn btn-danger btn-xs" onclick="removeSign({id})">
        xóa
      </button>  
    </td>
  </tr>
  <!-- END: row -->
</table>
<!-- END: main -->
