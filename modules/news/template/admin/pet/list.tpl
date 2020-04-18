<!-- BEGIN: main -->
<table class="table table-bordered">
  <tr>
    <th> Tài khoản </th>
    <th> Chủ nuôi </th>
    <th> SĐT </th>
    <th> Thú cưng </th>
    <th> Giống </th>
    <th> Microchip </th>
  </tr>
  <!-- BEGIN: row -->
  <tbody id="{id}">
    <tr class="clickable-row" data-href=''>
      <td> <a href="/news/detail/?id={id}"> {username} </a> </td>
      <td> <a href="/news/detail/?id={id}"> {owner} </a> </td>
      <td> <a href="/news/detail/?id={id}"> {mobile} </a> </td>
      <td> <a href="/news/detail/?id={id}"> {name} </a> </td>
      <td> <a href="/news/detail/?id={id}"> {species} </a> </td>
      <td> <a href="/news/detail/?id={id}"> {micro} </a> </td>
    </tr>
    <tr>
      <td colspan="7" style="text-align: right;">
        <button class="btn btn-xs btn-info" onclick="push({id})" title="Đẩy lên đầu trang">
          đẩy
        </button>
        <button class="btn btn-xs btn-info" onclick="edit({id})" title="Chỉnh sửa thông tin">
          sửa
        </button>
        <!-- BEGIN: lock -->
        <button class="btn btn-xs btn-info" onclick="lock({id}, 1)" title="Mở khóa quyền chỉnh sửa">
          khóa
        </button>
        <!-- END: lock -->
        <!-- BEGIN: unlock -->
        <button class="btn btn-xs btn-warning" onclick="lock({id}, 0)" title="Khóa quyền chỉnh sửa">
          mở khóa
        </button>
        <!-- END: unlock -->
        <!-- BEGIN: uncheck -->
        <button class="btn btn-xs btn-warning" onclick="checkPet({id}, 0)" title="Bất hoạt thú cưng">
          bất hoạt
        </button>
        <button class="btn btn-xs {ceti_btn}" onclick="cetiSubmit({id})" title="Cấp giấy thú cưng">
          chứng nhận
        </button>
        <!-- END: uncheck -->
        <!-- BEGIN: check -->
        <button class="btn btn-xs btn-success" onclick="checkPet({id}, 1)" title="Kích hoạt thú cưng">
          kích hoạt
        </button>
        <!-- END: check -->
        <button class="btn btn-xs btn-danger" onclick="deletePet({id})" title="Xóa thú cưng">
          xóa
        </button>
      </td>
    </tr>
  </tbody>
  <!-- END: row -->
</table>
{nav}
<!-- END: main -->
