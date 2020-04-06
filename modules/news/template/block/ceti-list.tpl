<!-- BEGIN: main -->
<table class="table table-bordered">
  <thead>
    <tr>
      <th> STT </th>
      <th> Số microchip </th>
      <th> Tên </th>
      <th> Giống/loài </th>
      <th></th>
    </tr>
  </thead>
  <!-- BEGIN: row -->
  <tbody>
    <tr>
      <td> {index} </td>
      <td> {micro} </td>
      <td> {name} </td>
      <td> {species} </td>
      <td> <a href="/{module_name}/ceti-detail/?id={rid}"> <span class="glyphicon glyphicon-print"></span> </td>
      <!-- <td> <button class="btn btn-info" onclick="print({rid})"> <span class="glyphicon glyphicon-print"></span> </button> </td> -->
    </tr>
  </tbody>
  <!-- END: row -->
</table>
{nav}
<!-- END: main -->
