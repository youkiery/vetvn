<!-- BEGIN: main -->
<table class="table table-bordered">
  <tr>
    <th> Chủ nuôi </th>
    <th> SĐT </th>
    <th> Tên thú cưng </th>
    <th> </th>
  </tr>
  <!-- BEGIN: row -->
  <tr>
    <td> {fullname} </td>
    <td> {mobile} </td>
    <td> {name} </td>
    <td> 
      <!-- BEGIN: edit -->
      <button class="btn btn-info btn-sm" onclick="edit({id})"> sửa </button>  
      <!-- END: edit -->
      <!-- BEGIN: info -->
      <a href="/news/detail/?id={petid}" class="btn btn-info btn-sm"> chi tiết </a>
      <!-- END: info -->
    </td>
  </tr>
  <!-- END: row -->
</table>
<!-- END: main -->
