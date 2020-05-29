<!-- BEGIN: main -->
<div class="modal" role="dialog" id="insert-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <div type="button" class="close" data-dismiss="modal"> &times; </div> <br><br>
        <div class="form-group row">
          <label class="col-sm-6">
            Tên khóa học
          </label>
          <div class="col-sm-18">
            <input type="text" class="form-control" id="insert-name">
          </div>
        </div>

        <div class="form-group row">
          <label class="col-sm-6">
            Phí học
          </label>
          <div class="col-sm-18">
            <input type="text" class="form-control" id="insert-price">
          </div>
        </div>

        <div class="form-group row">
          <label class="col-sm-6">
            Giới thiệu
          </label>
          <div class="col-sm-18">
            <textarea class="form-control" id="insert-intro" rows="5"></textarea>
          </div>
        </div>

        <div class="form-group row">
          <label class="col-sm-6">
            Thuộc khóa
          </label>
          <div class="col-sm-18">
            <select class="form-control" id="insert-parent">
              {subcount}
            </select>
          </div>
        </div>

        <div class="text-center">
          <button class="btn btn-success insert-modal" id="insert-btn" onclick="insertSubmit()">
            Thêm khóa học
          </button>

          <button class="btn btn-info insert-modal" id="update-btn" onclick="updateSubmit()">
            Sửa khóa học
          </button>
        </div>

      </div>
    </div>
  </div>
</div>
<!-- END: main -->
