<!-- BEGIN: main -->
<button class="btn btn-success" onclick="addVaccine()">
  <span class="glyphicon glyphicon-plus"> </span>
</button>
<table class="table table-bordered">
  <tr>
    <th> STT </th>
    <th> Thú cưng </th>
    <th> Ngày tiêm </th>
    <th> Ngày tái chủng </th>
    <th> Loại tiêm phòng </th>
  </tr>
  <!-- BEGIN: row -->
  <tr class="{color}">
    <td rowspan="2"> {index} </td>
    <td> {pet} </td>
    <td> {time} </td>
    <td> {recall} </td>
    <td> {type} </td>
  </tr>
  <tr class="{color}">
    <td colspan="4">
      <div class="col-sm-6">
        {note}
      </div>
      <div class="col-sm-6" style="text-align: right;">
        <!-- BEGIN: recall -->
        <button class="btn btn-info" onclick="recall('2-{typeid}')">
          Tái chủng
        </button>
        <button class="btn btn-info" onclick="donevac({id})">
          <span class="glyphicon glyphicon-check"></span>
        </button>
        <!-- END: recall -->
        <button class="btn btn-info" onclick="editVaccine({id})">
          <span class="glyphicon glyphicon-edit"></span>
        </button>
      </div>
    </td>
  </tr>
  <!-- END: row -->
</table>
<!-- END: main -->
