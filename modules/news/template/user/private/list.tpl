<!-- BEGIN: main -->
<table class="table table-bordered">
  <!-- BEGIN: row -->
  <tbody class="{pc}" style="border: 2px solid black;">
    <tr>
      <td rowspan="3" style="vertical-align: inherit; text-align: center;"> {name} </td>
      <td> Giới tính: {sex} </td>
    </tr>
    <tr>
      <td> Giống loài: {species} </td> 
    </tr>
    <tr>
      <td> Chủ nuôi: {owner} </td> 
    </tr>
    <tr class="right">
      <td colspan="2">
        <!-- <button class="btn btn-warning" onclick="transfer({id})">
          <img src="/themes/default/images/transfer.png" style="width: 20px; height: 20px;">
        </button> -->
        <button class="btn btn-info" onclick="request({id})">
          <img src="/themes/default/images/request.png" style="width: 20px; height: 20px;">
        </button>
        <button class="btn btn-info" onclick="addVaccine({id})">
          <img src="/themes/default/images/syringe.png" style="width: 20px; height: 20px;">
        </button>
        <button class="btn btn-info" onclick="edit({id})" {lock}>
          <span class="glyphicon glyphicon-edit"></span>
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