<!-- BEGIN: main -->
<button class="btn btn-success" onclick="addDisease()">
  <span class="glyphicon glyphicon-plus"> </span>
</button>
<table class="table table-bordered">
  <tr>
    <th> STT </th>
    <th> Thú cưng </th>
    <th> Ngày điều trị </th>
    <th> Loại bệnh </th>
    <th> Thời gian khỏi </th>
  </tr>
  <!-- BEGIN: row -->
  <tr>
    <td> {index} </td>
    <td> {pet} </td>
    <td> {treat} </td>
    <td> {disease} </td>
    <td> {treated} </td>
  </tr>
  <tr>
    <td colspan="5">
      <div class="row">
        <div class="col-sm-6">
          {note}
        </div>
        <div class="col-sm-6" style="text-align: right;">
          <button class="btn btn-info" onclick="editDisease({id})">
            <span class="glyphicon glyphicon-edit"></span>
          </button>
        </div>
      </div>
    </td>
  </tr>
  <!-- END: row -->
</table>
<!-- END: main -->
