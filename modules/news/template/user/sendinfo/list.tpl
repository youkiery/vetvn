<!-- BEGIN: main -->
<table class="table table-bordered">
  <tr>
    <th> Tên thú cưng </th>
    <th> Giống loài </th>
    <th> Giới tính </th>
    <th> Ngày sinh </th>
    <th> </th>
  </tr>
  <!-- BEGIN: row -->
  <tr>
    <td> {name} </td>
    <td> {species} </td>
    <td> {sex} </td>
    <td> {birthtime} </td>
    <td> 
      <!-- BEGIN: confirm -->
      {status}
      <!-- END: confirm -->
      <!-- BEGIN: edit -->
      <button class="btn btn-info btn-sm" onclick="edit({id})">
        sửa
      </button>  
      <!-- END: edit -->
    </td>
  </tr>
  <!-- END: row -->
</table>
<!-- END: main -->
