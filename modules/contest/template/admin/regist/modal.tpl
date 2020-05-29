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

<div class="modal" id="court-modal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <div type="button" class="close" data-dismiss="modal"> &times; </div> <br><br>
        <div class="form-group" style="float: right;">
          <button class="btn btn-success" onclick="insertCourtModal()">
            Thêm khóa học
          </button>
        </div>
        <div style="clear: both;"></div>

        <div id="court-content">
          {court_content}
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal" role="dialog" id="insert-court-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <div type="button" class="close" data-dismiss="modal"> &times; </div> <br><br>
        <div class="form-group row">
          <label class="col-3">
            Tên khóa học
          </label>
          <div class="col-9">
            <input type="text" class="form-control" id="insert-name">
          </div>
        </div>

        <div class="form-group row">
          <label class="col-3">
            Phí học
          </label>
          <div class="col-9">
            <input type="text" class="form-control" id="insert-price">
          </div>
        </div>

        <div class="form-group row">
          <label class="col-3">
            Giới thiệu
          </label>
          <div class="col-9">
            <textarea class="form-control" id="insert-intro" rows="5"></textarea>
          </div>
        </div>

        <div class="form-group row">
          <label class="col-3">
            Thuộc khóa
          </label>
          <div class="col-9">
            <select class="form-control" id="insert-parent">
              {subcount}
            </select>
          </div>
        </div>

        <div class="text-center">
          <button class="btn btn-success insert-modal" id="insert-btn" onclick="insertCourtSubmit()">
            Thêm khóa học
          </button>

          <button class="btn btn-info insert-modal" id="update-btn" onclick="updateCourtSubmit()">
            Sửa khóa học
          </button>
        </div>

      </div>
    </div>
  </div>
</div>

<!-- END: main -->