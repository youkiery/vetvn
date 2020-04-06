<!-- BEGIN: main -->
<table class="table table-bordered">
  <!-- BEGIN: row -->
  <tbody>
    <tr>
      <td> {name} </td>
      <td> {breed} </td>
      <td> {species} </td>
    </tr>
    <tr>
      <td colspan="3" style="text-align: right;">
        <!-- BEGIN: breed -->
        <button class="btn btn-info" onclick="breedingSubmit({id})">
          Cần phối
        </button>
        <!-- END: breed -->
        <!-- BEGIN: sell -->
        <button class="btn btn-info" onclick="sellSubmit({id})">
          Cần bán
        </button>
        <!-- END: sell -->
      </td>
    </tr>
  </tbody>
  <!-- END: row -->
</table>
<!-- END: main -->
