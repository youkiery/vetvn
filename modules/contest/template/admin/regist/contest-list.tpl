<!-- BEGIN: main -->
<table class="table table-bordered">
  <tr>
    <th> STT </th>
    <th> <input type="checkbox" id="contest-check-all"> </th>
    <th> Người tham gia </th>
    <th> Tên thú cưng </th>
    <th> Giống loài </th>
    <th> Địa chỉ </th>
    <th> Số điện thoại </th>
    <th> Mục tham gia </th>
    <th></th>
  </tr>
  <!-- BEGIN: row -->
  <tr>
    <td> {index} </td>
    <td>
      <input type="checkbox" class="contest-checkbox" index="{id}" id="contest-check-{id}">
    </td>
    <td> 
      {name}
    </td>
    <td> 
      {petname}
    </td>
    <td> 
      {species}
    </td>
    <td> 
      {address}
    </td>
    <td> 
      {mobile}
    </td>
    <td> 
      {contest}
    </td>
    <td>
      <!-- BEGIN: done -->
      <button class="btn btn-warning" onclick="confirmSubmit({id}, 0)">
        <span class="glyphicon glyphicon-check"></span>
      </button>
      <!-- END: done -->
      <!-- BEGIN: undone -->
      <button class="btn btn-info" onclick="confirmSubmit({id}, 1)">
        <span class="glyphicon glyphicon-unchecked"></span>
      </button>
      <!-- END: undone -->
      <button class="btn btn-info" onclick="getContest({id})">
        <span class="glyphicon glyphicon-edit"></span>
      </button>
      <button class="btn btn-danger" onclick="removeRow({id})">
        <span class="glyphicon glyphicon-remove"></span>
      </button>
    </td>
  </tr>
  <!-- END: row -->
</table>
{nav}
<!-- END: main -->
