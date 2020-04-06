<!-- BEGIN: main -->
<table class="table table-bordered">
  <tr>
    <th>
      STT
    </th>
    <th>
      Loại tiêm phòng
    </th>
    <th>
      Tỉ lệ sử dụng      
    </th>
    <th></th>
  </tr>
  <!-- BEGIN: row -->
  <tbody id="{id}">
    <tr>
      <td> {index} </td>
      <td id="name-{id}"> {disease} </td>
      <td> {rate} </td>
      <td style="text-align: right;">
        <!-- BEGIN: yes -->
        <button class="btn btn-success" onclick="check({id})">
          <span class="glyphicon glyphicon-unchecked"></span>
        </button>
        <!-- END: yes -->
        <!-- BEGIN: no -->
        <button class="btn btn-warning" onclick="uncheck({id})">
          <span class="glyphicon glyphicon-check"></span>
        </button>
        <!-- END: no -->
        <button class="btn btn-info" onclick="edit({id})">
          <span class="glyphicon glyphicon-edit"></span>
        </button>
        <button class="btn btn-danger" onclick="remove({id})">
          <span class="glyphicon glyphicon-remove"></span>
        </button>
      </td>    
    </tr>
  </tbody>
  <!-- END: row -->
</table>
{nav}
<!-- END: main -->
