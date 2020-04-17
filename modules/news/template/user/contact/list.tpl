<!-- BEGIN: main -->
<table class="table table-bordered">
  <tr>
    <th> STT </th>
    <th> Tên chủ </th>
    <th> Địa chỉ </th>
    <th> SĐT </th>
    <th> CMND </th>
    <th>  </th>
  </tr>
  <!-- BEGIN: row -->
  <tbody id="{id}">
    <tr>
      <td rowspan="2" class="cell-center">
        {index}
      </td>
      <td>
        {fullname}
      </td>
      <td>
        {address}
      </td>
      <td>
        {mobile}
      </td>
      <td>
        {politic}
      </td>
      <td style="text-align: right;">
        <button class="btn btn-info btn-xs" onclick="update({id})">
          sửa
        </button>
        <!-- <button class="btn btn-info btn-xs" onclick="view({id})">

        </button> -->
      </td>
    </tr>
  </tbody>
  <!-- END: row -->
</table>
{nav}
<!-- END: main -->
