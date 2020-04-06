<!-- BEGIN: main -->
<table class="table table-bordered">
  <!-- BEGIN: row -->
  <tbody id="{id}">

    <tr class="{color}">
      <td rowspan="3" class="cell-center">
        {index}
      </td>
      <td>
        Tên chủ: {owner}
      </td>
      <td>
        Địa chỉ: {address}
      </td>
      <td>
        SĐT: {mobile}
      </td>
    </tr>
    <tr>
      <td>
        Giống: {species}
      </td>
      <td>
        Loài: {breed}
      </td>
      <td>
        {type}
      </td>
    </tr>
    <tr>
      <td colspan="3" style="text-align: right;">
        <button class="btn btn-info" onclick="push({id})">
          <span class="glyphicon glyphicon-upload"></span>
        </button>
        <!-- BEGIN: yes -->
        <button class="btn btn-success" onclick="uncheck({id})">
          <span class="glyphicon glyphicon-check"></span>
        </button>
        <!-- END: yes -->
        <!-- BEGIN: no -->
        <button class="btn btn-warning" onclick="check({id})">
          <span class="glyphicon glyphicon-unchecked"></span>
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
