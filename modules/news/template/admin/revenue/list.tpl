<!-- BEGIN: main -->
<p> 
  <!-- BEGIN: msg -->
  Tìm kiếm {keyword} từ {from} đến {end} trong {count} kết quả
  <!-- END: msg -->
</p>
<table class="table table-bordered">
  <tr>
    <th> Chủ nuôi </th>
    <th> <input type="checkbox" id="check-all"> </th>
    <th> Tên </th>
    <th> Giống loài </th>
    <th> Số tiền </th>
    <th></th>
  </tr>
  <!-- BEGIN: row -->
  <tbody>
    <tr>
      <td> {fullname} </td>
      <td> <input type="checkbox" class="checkbox" id="check-{cid}" rel="{cid}"> </td>
      <td> {name} </td>
      <td> {species} </td>
      <td> {price} </td>
      <td>
        <button class="btn btn-warning" onclick="ceti({cid}, '{price}')">
          <img src="/themes/default/images/cetificate.png">
        </button>
      </td>
    </tr>
  </tbody>
  <!-- END: row -->
</table>
{nav}
<!-- END: main -->
