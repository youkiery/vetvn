<!-- BEGIN: main -->
<button class="btn btn-success" onclick="addBreeder()">
  <span class="glyphicon glyphicon-plus"> </span>
</button>
<table class="table table-bordered">
  <tr>
    <th> STT </th>
    <th> Ngày phối </th>
    <th> Đối tượng phối </th>
    <th> Chủ nuôi </th>
    <th> Số con </th>
  </tr>
  <!-- BEGIN: row -->
  <tr>
    <td> {index} </td>
    <td> {time} </td>
    <td> {target} </td>
    <td> {owner} </td>
    <td> {number} </td>
  </tr>
  <tr>
    <td colspan="6">
      <div class="row">
        <div class="col-sm-8">
          {note}
        </div>
        <div class="col-sm-4" style="text-align: right;">
          <button class="btn btn-info" onclick="editBreeder({id})">
            <span class="glyphicon glyphicon-edit"></span>
          </button>
        </div>
      </div>
    </td>
  </tr>
  <!-- END: row -->
</table>
<!-- END: main -->
