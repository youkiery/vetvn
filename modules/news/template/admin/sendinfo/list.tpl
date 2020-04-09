<!-- BEGIN: main -->
<table class="table table-bordered">
  <tr>
    <th> Người dùng </th>
    <th> Số điện thoại </th>
    <th> Tên thú cưng </th>
    <th> Giống loài </th>
    <th> Giới tính </th>
    <th> Ngày sinh </th>
    <th> </th>
  </tr>
  <!-- BEGIN: row -->
  <tr>
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
      <button class="btn btn-success btn-xs" onclick="done({id})">
        duyệt
      </button>  
      <!-- END: done -->
    </td>
  </tr>
  <!-- END: row -->
</table>
<!-- END: main -->
