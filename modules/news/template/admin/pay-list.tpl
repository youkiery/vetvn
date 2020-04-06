<!-- BEGIN: main -->
<p> 
  <!-- BEGIN: msg -->
  Tìm kiếm {keyword} từ {from} đến {end} trong {count} kết quả
  <!-- END: msg -->
</p>
<table class="table table-bordered">
  <tr>
    <th> STT </th>
    <th> Người chi </th>
    <th> Nội dung </th>
    <th> Giá tiền </th>
    <th> Thời gian </th>
    <th></th>
  </tr>
  <!-- BEGIN: row -->
  <tbody>
    <tr class="clickable-row" data-href=''>
      <td> {index} </td>
      <td> {name} </td>
      <td> {content} </td>
      <td> {price} </td>
      <td> {time} </td>
      <td>
        <button class="btn btn-danger" onclick="removePay({id})">
          <span class="glyphicon glyphicon-remove"></span>
        </button>
      </td>
    </tr>
  </tbody>
  <!-- END: row -->
</table>
{nav}
<!-- END: main -->
