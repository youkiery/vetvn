<!-- BEGIN: main -->
<div class="modal" id="edit-modal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <div type="button" class="close" data-dismiss="modal"> &times; </div> <br><br>

        <div class="form-group">
          <label class="label-control"> Họ và tên </label>
          <div>
            <input type="text" class="form-control" id="signup-name">
          </div>
        </div>
        <div class="form-group">
          <label class="label-control"> Địa chỉ </label>
          <div>
            <input type="text" class="form-control" id="signup-address">
          </div>
        </div>
        <div class="form-group">
          <label class="label-control"> Số điện thoại </label>
          <div class="relative">
            <input type="text" class="form-control" id="signup-mobile">
          </div>
        </div>
        <div style="clear: both;"></div>
        <div class="text-center">
          <button class="btn btn-info" onclick="signupPresubmit()">
            Sửa thông tin
          </button>
          <div id="notify" style="color: red; font-size: 1.3em; font-weight: bold;"> </div>
        </div>

      </div>
    </div>
  </div>
</div>

<div class="modal" id="remove-modal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <div type="button" class="close" data-dismiss="modal"> &times; </div> <br><br>

        <div class="text-center">
          <div class="form-group">
            Sau khi xác nhận, phiếu đăng ký sẽ mất vĩnh viễn, bạn có chắc chắn?
          </div>
          <button class="btn btn-danger" onclick="removeSubmit()">
            Xóa phiếu đăng ký
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- END: main -->