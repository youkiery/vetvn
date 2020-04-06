<!-- BEGIN: main -->
<table class="table table-bordered">
  <tr>
    <th> STT </th>
    <th> Tên </th>
    <th> Loại </th>
    <th> Số lần sử dụng </th>
    <th></th>
  </tr>
  <!-- BEGIN: row -->
  <tbody id="{id}">
    <tr>
      <td> {index} </td>
      <td id="name-{id}"> {name} </td>
      <td id="value-{id}"> {type} </td>
      <td> {rate} </td>
      <td> 
        <!-- BEGIN: yes -->
        <button class="btn btn-info" onclick="check({id})">
          <span class="glyphicon glyphicon-unchecked"></span>
        </button>  
        <!-- END: yes -->
        <!-- BEGIN: no -->
        <button class="btn btn-warning" onclick="nocheck({id})">
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
