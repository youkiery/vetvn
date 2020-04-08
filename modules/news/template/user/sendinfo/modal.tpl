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

        <div class="text-center">
          <span id="image-list"></span>
          <label class="insert text-center thumb">
            <img style="width: 100px; height: 100px;" src="/assets/images/upload.png">
            <div style="width: 50px; height: 50px; display: none;" id="image"></div>
          </label>
        </div>
        <div style="clear: both;"></div>

        <div class="text-center">
          <button class="insert btn btn-success" onclick="sendInfo()">
            Gửi thông tin
          </button>
          <button class="edit btn btn-info" onclick="editInfo()">
            Sửa thông tin
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- END: main -->