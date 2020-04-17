<!-- BEGIN: main -->
<p> 
  <!-- BEGIN: msg -->
  Tìm kiếm {keyword} từ {from} đến {end} trong {count} kết quả
  <!-- END: msg -->
</p>
<table class="table table-bordered">
  <tr>
    <th> Tên </th>
    <th> Chủ nuôi </th>
    <th> Số microchip </th>
    <th> Giống loài </th>
    <th> Số tiền </th>
    <th> Ngày thu </th>
  </tr>
  <!-- BEGIN: row -->
  <tbody>
    <tr class="clickable-row" data-href=''>
      <td> <a href="/news/detail/?id={id}"> {name} </a> </td>
      <td> <a href="/news/detail/?id={id}"> {fullname} </a> </td>
      <td> <a href="/news/detail/?id={id}"> {microchip} </a> </td>
      <td> <a href="/news/detail/?id={id}"> {species} </a> </td>
      <td> <a href="/news/detail/?id={id}"> {price} </a> </td>
      <td> <a href="/news/detail/?id={id}"> {time} </a> </td>
    </tr>
  </tbody>
  <!-- END: row -->
</table>
{nav}
<!-- END: main -->
