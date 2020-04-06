<!-- BEGIN: main -->
<table class="table table-bordered">
  <!-- BEGIN: row -->
  <tbody id="{id}">
    <tr>
      <td rowspan="2"> {index} </td>
      <td> Tên khách: {target} </td>
      <td> Địa chỉ: {address} </td>
      <td> Số điện thoại: {mobile} </td>
      <td> Chuyên mục: {type} </td>
    </tr>
    <tr>
      <td>
        Chủ đăng: {from}
      </td>
      <td>
        Số điện thoại: {mobile2}
      </td>
      <td>
        Tên: {petname}
      </td>
      <td>
        Loài: {breed}
      </td>
    </tr>
    <tr>
      <td colspan="5">
        <div style="width: 50%; float: left;">
          Ghi chú: {note}
        </div>
        <div style="width: 50%; float: left; text-align: right;">
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
          <button class="btn btn-danger" onclick="remove({id})">
            <span class="glyphicon glyphicon-remove"></span>
          </button>
        </div>
      </td>
    </tr>
  </tbody>
  <!-- END: row -->
</table>
{nav}
<!-- END: main -->
