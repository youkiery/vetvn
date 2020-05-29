<!-- BEGIN: main -->
<table class="table table-bordered table-hover">
  <tr>
    <th> STT </th>
    <th> Tên khóa </th>
    <th> Phí khóa học </th>
    <th> Giới thiệu </th>
    <!-- <th> Người thực hiện </th> -->
    <th></th>
  </tr>
  <!-- BEGIN: row -->
  <tr>
    <td> {index} </td>
    <td> {name} </td>
    <td> {price} </td>
    <td> {intro} </td>
    <!-- <td> {performer} </td> -->
    <td>
      <button class="btn btn-info btn-sm" onclick="updateCourt({id})">
        <span class="glyphicon glyphicon-edit"></span>
      </button>
      <!-- <button class="btn btn-warning btn-sm" onclick="hide({id})">
        <span class="glyphicon glyphicon-eye-close"></span>
      </button> -->
    </td>
  </tr>
  <!-- END: row -->
</table>
<!-- END: main -->
