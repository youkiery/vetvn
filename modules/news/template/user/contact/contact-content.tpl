<!-- BEGIN: main -->
<table class="table table-bordered">
  <tr>
    <th> STT </th>
    <th> Tên thú cưng </th>
    <th> Giống </th>
    <th> Loài </th>
    <th>  </th>
  </tr>
  <!-- BEGIN: row -->
  <tr class="{color}">
    <td>
      {index}
    </td>
    <td>
      {name}
    </td>
    <td>
      {species}
    </td>
    <td>
      {breed}
    </td>
    <td style="text-align: right;">
      <button class="btn btn-info" onclick="takeback({id})">
        <span class="glyphicon glyphicon-arrow-left"></span>
      </button>
    </td>
  </tr>
  <!-- END: row -->
</table>
{nav}
<!-- END: main -->
