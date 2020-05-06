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
          <div class="col-3"> Số Microchip </div>
          <div class="col-3"> <input type="text" class="form-control" id="micro"> </div>
          <div class="col-3"> Số đăng ký </div>
          <div class="col-3"> <input type="text" class="form-control" id="regno"> </div>
        </div>

        <div class="xxx rows">
          <div class="col-3"> Tên thú cưng </div>
          <div class="col-9"> <input type="text" class="form-control" id="name"> </div>
        </div>
        <div class="text-red" id="name-error"></div>

        <div class="xxx rows">
          <p class="col-3"> Giới tính </p>
          <div class="col-9">
            <label style="width: 45%; display: inline-block;"> <input type="radio" name="sex" value="0" checked> Đực
            </label>
            <label style="width: 45%; display: inline-block;"> <input type="radio" name="sex" value="1"> Cái </label>
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
          <div class="col-9">
            <div class="relative">
              <div class="input-group">
                <input type="text" class="form-control" id="breeder">
                <div class="input-group-btn">
                  <button class="btn btn-success" style="min-height: 32px;" onclick="insertUser('breeder')">
                    <span class="glyphicon glyphicon-plus"></span>
                  </button>
                </div>
              </div>
              <div class="suggest" id="breeder-suggest"></div>
            </div>
          </div>
        </div>
        <div class="xxx rows" style="font-size: 0.8em;">
          <div class="col-3"> </div>
          <div class="col-3">
            Họ tên: <span id="breeder-name"></span>
          </div>
          <div class="col-4">
            SĐT: <span id="breeder-mobile"></span>
          </div>
          <div class="col-2" style="text-align: right;">
            <button class="btn btn-danger" style="min-height: 32px;" onclick="clearUser('breeder')">
              <span class="glyphicon glyphicon-remove"></span>
            </button>
          </div>
        </div>
        <div class="text-red" id="breeder-error"></div>

        <div class="xxx rows">
          <div class="col-3"> Chủ nuôi </div>
          <div class="col-9">
            <div class="relative">
              <div class="input-group">
                <input type="text" class="form-control" id="owner">
                <div class="input-group-btn">
                  <button class="btn btn-success" style="min-height: 32px;" onclick="insertUser('owner')">
                    <span class="glyphicon glyphicon-plus"></span>
                  </button>
                </div>
              </div>
              <div class="suggest" id="owner-suggest"></div>
            </div>
          </div>
        </div>
        <div class="xxx rows" style="font-size: 0.8em;">
          <div class="col-3"> </div>
          <div class="col-3">
            Họ tên: <span id="owner-name"></span>
          </div>
          <div class="col-4">
            SĐT: <span id="owner-mobile"></span>
          </div>
          <div class="col-2" style="text-align: right;">
            <button class="btn btn-danger" style="min-height: 32px;" onclick="clearUser('owner')">
              <span class="glyphicon glyphicon-remove"></span>
            </button>
          </div>
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
          <button class="btn btn-success" onclick="insertUserSubmit()">
            Thêm khách hàng
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="info-modal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <div class="form-group">
          Chi tiết yêu cầu
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="text-center">
          <img style="max-width: 250px; margin: auto;" id="info-image" class="img-responsive">
        </div>
        <p> Tên thú cưng: <span id="info-name"></span> </p>
        <p> Giới tính: <span id="info-sex"></span> </p>
        <p> Ngày sinh: <span id="info-birthtime"></span> </p>
        <p> Giống loài: <span id="info-species"></span> </p>
        <p> Màu lông: <span id="info-color"></span> </p>
        <p> Kiểu lông: <span id="info-type"></span> </p>
        <p> Người nhân giống: <span id="info-breeder"></span> </p>
        <p> Chủ nuôi: <span id="info-owner"></span> </p>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="done-modal" role="dialog">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-body">
        <div class="form-group">
          Xác nhận
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="text-center">
          <p> Sau khi xác nhận sẽ không thể rút lại, thú cưng sẽ được tạo mới, đồng thời duyệt đăng </p>
          <div class="rows form-group">
            <div class="col-3"> Số đăng ký </div>
            <div class="col-9">
              <input type="text" class="form-control" id="done-regno">
            </div>
          </div>

          <div class="rows form-group">
            <div class="col-3"> Số microchip </div>
            <div class="col-9">
              <input type="text" class="form-control" id="done-micro">
            </div>
          </div>

          <div class="rows form-group">
            <div class="col-3"> Người ký </div>
            <div class="col-9">
              <select class="form-control" id="done-sign">
                <!-- BEGIN: sign -->
                <option value="{id}"> {name} </option>
                <!-- END: sign -->
              </select>
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

<div class="modal" id="remove-modal" role="dialog">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-body">
        <div class="form-group">
          Xóa yêu cầu
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="text-center">
          <p> Sau khi xác nhận yêu cầu sẽ bị xóa vĩnh viễn </p>
          <button class="btn btn-danger" onclick="removeSubmit()">
            Xác nhận
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="sign-modal" role="dialog">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-body">
        <div class="form-group">
          Danh sách chữ ký
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="form-group input-group">
          <input type="text" class="form-control" id="sign-name">
          <div class="input-group-btn">
            <button class="btn btn-success" onclick="insertSign()"> thêm </button>
          </div>
        </div>

        <div id="sign-content">
          {sign_content}
        </div>
      </div>
    </div>
  </div>
</div>
<!-- END: main -->