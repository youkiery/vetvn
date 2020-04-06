<!-- BEGIN: main -->

<table class="table table-bordered">
  <!-- BEGIN: row -->
  <tbody class="{pc}" style="display: {display}; border: 2px solid black;">
    <tr>
      <td rowspan="3" style="vertical-align: inherit; text-align: center;"> {name} </td>
      <td> Giới tính: {sex} </td>
    </tr>
    <tr>
      <td> Loài: {breed} </td>
    </tr>
    <tr>
      <td> Giống: {species} </td> 
    </tr>
    <tr class="right">
      <td colspan="2">
        <button class="btn btn-warning" onclick="transfer({id})">
          <img src="/themes/default/images/transfer.png" style="width: 20px; height: 20px;">
        </button>
        <button class="btn btn-info" onclick="request({id})">
          <img src="/themes/default/images/request.png" style="width: 20px; height: 20px;">
        </button>
        <button class="btn btn-info" onclick="addVaccine({id})">
          <img src="/themes/default/images/syringe.png" style="width: 20px; height: 20px;">
        </button>
        <button class="btn btn-info" onclick="editPet({id})">
          <span class="glyphicon glyphicon-edit"></span>
        </button>
        <button class="btn btn-info" onclick="parentToggle({id})" {pr}>
          <img src="/themes/default/images/parent.png" style="width: 20px; height: 20px;">
        </button>
        <a href="/{module_name}/info?id={id}"> 
          <button class="btn btn-info">
            Chi tiết
          </button>
        </a>
      </td>
    </tr>
  </tbody>
  <!-- END: row -->
</table>
{nav}
<!-- END: main -->