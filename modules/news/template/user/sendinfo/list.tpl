<!-- BEGIN: main -->
<table class="table table-bordered">
  <tr>
    <th class="cell-center"> STT </th>
    <th class="cell-center"> Chủ nuôi </th>
    <th class="cell-center"> SĐT </th>
    <th class="cell-center"> Tên thú cưng </th>
    <th class="cell-center"> </th>
  </tr>
  <!-- BEGIN: row -->
  <tr style="font-size: 0.9em;">
    <td> {index} </td>
    <td> {fullname} </td>
    <td> {mobile} </td>
    <td> {name} </td>
    <td> 
      <!-- BEGIN: edit -->
      <button class="btn btn-info btn-xs" onclick="edit({id})"> sửa </button>  
      <!-- END: edit -->
      <button class="btn btn-info btn-xs" onclick="preview({id})"> chi tiết </button>  
    </td>
  </tr>
  <!-- END: row -->
</table>
{nav}
<!-- END: main -->
