<!-- BEGIN: main -->
<div class="modal" id="user-modal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <div class="form-group">
          Thông tin khách hàng
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <label class="rows">
          <div class="col-3">
            Họ tên
          </div>
          <div class="col-9">
            <input type="text" class="form-control" id="user-name">
          </div>
        </label>

        <label class="rows">
          <div class="col-3">
            Số điện thoại
          </div>
          <div class="col-9">
            <input type="text" class="form-control" id="user-mobile">
          </div>
        </label>

        <label class="rows">
          <div class="col-3">
            Địa chỉ
          </div>
          <div class="col-9">
            <input type="text" class="form-control" id="user-address">
          </div>
        </label>

        <label class="rows">
          <div class="col-3">
            CMND
          </div>
          <div class="col-9">
            <input type="text" class="form-control" id="user-politic">
          </div>
        </label>

        <div class="text-center">
          <button class="btn btn-info" onclick="updateSubmit()">
            Chỉnh sửa thông tin
          </button>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="modal" id="modal-contact" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <p class="text-center">
          Danh sách thú cưng
        </p>

        <div id="contact-content" style="max-height: 400px; overflow-y: scroll;">
          
        </div>
      </div>
    </div>
  </div>
</div>
<!-- END: main -->
