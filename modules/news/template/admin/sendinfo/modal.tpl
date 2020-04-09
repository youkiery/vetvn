<!-- BEGIN: main -->
<div class="modal" id="sendinfo-modal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <div class="form-group">
          Thông tin yêu cầu
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="xxx rows">
          <div class="col-3"> Tên thú cưng </div>
          <div class="col-9"> <input type="text" class="form-control" id="name"> </div>
        </div>
        <div class="text-red" id="name-error"></div>

        <div class="xxx rows">
          <p class="col-3"> Giới tính </p>
          <div class="col-9">
            <label> <input type="radio" name="sex" value="0" checked> Đực </label>
            <label> <input type="radio" name="sex" value="1"> Cái </label>
          </div>
        </div>
        <div class="text-red" id="sex-error"></div>

        <div class="xxx rows">
          <div class="col-3"> Ngày sinh </div>
          <div class="col-9"> <input type="text" class="form-control date" id="birthtime"> </div>
        </div>
        <div class="text-red" id="birthtime-error"></div>

        <div class="xxx rows">
          <div class="col-3"> Giống loài </div>
          <div class="col-9 relative">
            <input type="text" class="form-control" id="species2">
            <div class="suggest" id="species2-suggest"></div>
          </div>
        </div>
        <div class="text-red" id="species2-error"></div>

        <div class="xxx rows">
          <div class="col-3"> Màu lông </div>
          <div class="col-3 relative">
            <input type="text" class="form-control" id="color">
            <div class="suggest" id="color-suggest"></div>
          </div>
          <div class="col-3"> Kiểu lông </div>
          <div class="col-3 relative">
            <input type="text" class="form-control" id="type">
            <div class="suggest" id="type-suggest"></div>
          </div>
        </div>
        <div class="text-red" id="color-error"></div>
        <div class="text-red" id="type-error"></div>

        <div class="xxx rows">
          <div class="col-3"> Người nhân giống </div>
          <div class="col-9"> <textarea class="form-control" id="breeder" rows="3">{info}</textarea> </div>
        </div>
        <div class="text-red" id="breeder-error"></div>

        <div class="xxx rows">
          <div class="col-3"> Chủ nuôi </div>
          <div class="col-9"> <textarea class="form-control" id="owner" rows="3">{info}</textarea> </div>
        </div>
        <div class="text-red" id="owner-error"></div>

        <div class="rows">
          <div class="col-3">
            Bố
          </div>
          <div class="col-3 relative">
            <!-- <div class="input-group"> -->
              <input type="text" class="form-control" id="father">
              <!-- <div class="input-group-btn">
                <button class="btn btn-success">
                  <span class="glyphicon glyphicon-plus"></span>
                </button>
              </div> -->
            <!-- </div> -->
            <div class="suggest" id="father-suggest"> </div>
          </div>
          <div class="col-3">
            Mẹ
          </div>
          <div class="col-3 relative">
            <!-- <div class="input-group"> -->
              <input type="text" class="form-control" id="mother">
              <!-- <div class="input-group-btn">
                <button class="btn btn-success">
                  <span class="glyphicon glyphicon-plus"></span>
                </button>
              </div> -->
            <!-- </div> -->
            <div class="suggest" id="mother-suggest"> </div>
          </div>
        </div>

        <div class="text-center">
          <span id="image-list"></span>
          <label class="insert text-center thumb">
            <img style="width: 100px; height: 100px;" src="/assets/images/upload.png">
          </label>
        </div>
        <div style="clear: both;"></div>

        <div class="text-center">
          <button class="edit btn btn-info" onclick="editInfo()">
            Sửa thông tin
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="done-modal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <div class="form-group">
          Xác nhận
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="text-center">
          <p> Sau khi xác nhận sẽ không thể rút lại, thú cưng sẽ được tạo mới, đồng thời duyệt đăng </p>
          <div class="rows form-group">
            <div class="col-3"> Số microchip </div>
            <div class="col-9">
              <input type="text" class="form-control" id="done-micro">
            </div>
          </div>
          <button class="edit btn btn-info" onclick="doneSubmit()">
            Xác nhận duyệt
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- END: main -->
