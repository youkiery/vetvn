<!-- BEGIN: main -->
<style>
  label {
    width: 100%;
  }
</style>
<div class="container">
  <div id="msgshow"></div>
  <form>
    <table class="table">
      <tr>
        <td>
          <div class="row">
            <label>
              <div class="col-sm-3">
                Tên
              </div>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="bio-name">
              </div>
            </label>
          </div>
          
          <div class="row">
            <label>
              <div class="col-sm-3">
                Ngày sinh
              </div>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="bio-dob">
              </div>
            </label>
          </div>
          
          <div class="row">
            <label>
              <div class="col-sm-3">
                Giống
              </div>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="bio-species">
              </div>
            </label>
          </div>
          
          <div class="row">
            <label>
              <div class="col-sm-3">
                Loài
              </div>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="bio-breed">
              </div>
            </label>
          </div>
          
          <div class="row">
            <label>
              <div class="col-sm-3">
                Giới tính
              </div>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="bio-sex">
              </div>
            </label>
          </div>
          
          <div class="row">
            <label>
              <div class="col-sm-3">
                Màu sắc
              </div>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="bio-color">
              </div>
            </label>
          </div>
          
          <div class="row">
            <label>
              <div class="col-sm-3">
                Microchip
              </div>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="bio-microchip">
              </div>
            </label>
          </div>
        </td>
        <td>
          <div class="row">
            <label>
              <div class="col-sm-3">
                Chủ chó bố
              </div>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="bio-ownerf">
              </div>
            </label>
          </div>

          <div class="row">
            <label>
              <div class="col-sm-3">
                Chó bố
              </div>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="bio-ownerf">
              </div>
            </label>
          </div>

          <div class="row">
            <label>
              <div class="col-sm-3">
                Chủ chó mẹ
              </div>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="bio-ownerf">
              </div>
            </label>
          </div>

          <div class="row">
            <label>
              <div class="col-sm-3">
                Chó mẹ
              </div>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="bio-ownerf">
              </div>
            </label>
          </div>

        </td>
      </tr>
      <tr>
        <td colspan="2" class="text-center">
          <button class="btn btn-success">
            Gửi danh sách
          </button>
        </td>
      </tr>
    </table>
  </form>
  <div id="content">
    <table class="table table-bordered">
      <tr>
        <th> STT </th>
        <th> Hình ảnh </th>
        <th> Thông tin </th>
      </tr>
      <tr>
        <td rowspan="8"> 1 </td>
        <td rowspan="8"> <img src=""> </td>
        <td>
          Tên
        </td>
      </tr>
      <tr>
        <td> Tuổi </td>
      </tr>
      <tr>
        <td> Ngày sinh </td>
      </tr>
      <tr>
        <td> Giống </td>
      </tr>
      <tr>
        <td> Loài </td>
      </tr>
      <tr>
        <td> Giới tính </td>
      </tr>
      <tr>
        <td> Màu sắc </td>
      </tr>
      <tr>
        <td> Microchip </td>
      </tr>
    </table>
  </div>
</div>
<script>
  var content = $("#content")
</script>
<!-- END: main -->
