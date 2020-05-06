<!-- BEGIN: main -->
<table class="table table-bordered">
  <tr>
    <th class="cell-center"> STT </th>
    <th class="cell-center"> Người dùng </th>
    <th class="cell-center"> Số điện thoại </th>
    <th class="cell-center"> Tên thú cưng </th>
    <th class="cell-center"> Giống loài </th>
    <th class="cell-center"> Giới tính </th>
    <th class="cell-center"> Ngày sinh </th>
    <th> </th>
  </tr>
  <!-- BEGIN: row -->
  <tr style="font-size: 0.9em;">
    <td> {index} </td>
    <td> {user} </td>
    <td> {mobile} </td>
    <td> {name} </td>
    <td> {species} </td>
    <td> {sex} </td>
    <td> {birthtime} </td>
    <td> 
      <!-- BEGIN: done -->
      <button class="btn btn-info btn-xs" onclick="edit({id})">
        sửa
      </button>  
      <button class="btn btn-success btn-xs" onclick="done({id}, '{regno}', '{micro}')">
        duyệt
      </button>  
      <!-- END: done -->
      <button class="btn btn-danger btn-xs" onclick="remove({id})">
        xóa
      </button>  
      <button class="btn btn-info btn-xs" onclick="preview({id})">
        chi tiết
      </button>  
    </td>
  </tr>
  <!-- END: row -->
</table>
{nav}
<!-- END: main -->
