<!-- BEGIN: main -->
<p> 
  <!-- BEGIN: msg -->
  Tìm kiếm {keyword} từ {from} đến {end} trong {count} kết quả
  <!-- END: msg -->
</p>
<table class="table table-bordered">
  <tr>
    <th> STT </th>
    <th> Tên </th>
    <th> Chủ nuôi </th>
    <th> Số microchip </th>
    <th> Giới tính </th>
    <th> Ngày sinh </th>
    <th> Giống </th>
  </tr>
  <!-- BEGIN: row -->
  <tbody id="{id}">
    <tr class="clickable-row" data-href=''>
      <td> <a href="/news/detail/?id={id}"> {index} </a> </td>
      <td> <a href="/news/detail/?id={id}"> {name} </a> </td>
      <td> <a href="/news/detail/?id={id}"> {owner} </a> </td>
      <td> <a href="/news/detail/?id={id}"> {microchip} </a> </td>
      <td> <a href="/news/detail/?id={id}"> {sex} </a> </td>
      <td> <a href="/news/detail/?id={id}"> {dob} </a> </td>
      <td> <a href="/news/detail/?id={id}"> {breed} </a> </td>
    </tr>
    <tr>
      <td colspan="7" style="text-align: right;">
        <button class="btn btn-info" onclick="push({id})" data-toggle="tooltip" data-placement="top" title="Đẩy lên đầu trang">
          <span class="glyphicon glyphicon-upload"></span>
        </button>
        <button class="btn btn-info" onclick="editPet({id})" data-toggle="tooltip" data-placement="top" title="Chỉnh sửa thông tin">
          <span class="glyphicon glyphicon-edit"></span>
        </button>
        <!-- BEGIN: lock -->
        <button class="btn btn-info" onclick="lock({id}, 1)" data-toggle="tooltip" data-placement="top" title="Mở khóa quyền chỉnh sửa">
          <span class="glyphicon glyphicon-lock"></span>
        </button>
        <!-- END: lock -->
        <!-- BEGIN: unlock -->
        <button class="btn btn-warning" onclick="lock({id}, 0)" data-toggle="tooltip" data-placement="top" title="Khóa quyền chỉnh sửa">
          <span class="glyphicon glyphicon-lock"></span>
        </button>
        <!-- END: unlock -->
        <!-- BEGIN: uncheck -->
        <button class="btn btn-warning" onclick="checkPet({id}, 0)" data-toggle="tooltip" data-placement="top" title="Bất hoạt thú cưng">
          <span class="glyphicon glyphicon-check"></span>
        </button>
        <button class="btn {ceti_btn}" onclick="cetiSubmit({id})" data-toggle="tooltip" data-placement="top" title="Cấp giấy thú cưng">
          <img src="{url}//themes/default/images/cetificate.png">
        </button>
        <!-- END: uncheck -->
        <!-- BEGIN: check -->
        <button class="btn btn-success" onclick="checkPet({id}, 1)" data-toggle="tooltip" data-placement="top" title="Kích hoạt thú cưng">
          <span class="glyphicon glyphicon-unchecked"></span>
        </button>
        <!-- END: check -->
        <button class="btn btn-success" onclick="pickOwner({id}, {userid}, '{mobile}')" data-toggle="tooltip" data-placement="top" title="Thay đổi chủ nuôi">
          <span class="glyphicon glyphicon-user"></span>
        </button>
        <button class="btn btn-danger" onclick="deletePet({id})" data-toggle="tooltip" data-placement="top" title="Xóa thú cưng">
          <span class="glyphicon glyphicon-remove"></span>
        </button>
      </td>
    </tr>
  </tbody>
  <!-- END: row -->
</table>
{nav}
<!-- END: main -->
