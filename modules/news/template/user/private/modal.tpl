<!-- BEGIN: main -->
<div class="modal" id="user-mail" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <p class="text-center">
          Bổ sung e-mail để lấy lại mật khẩu khi cần
        </p>

        <label class="row">
          <div class="col-sm-3">
            Nhập email:
          </div>
          <div class="col-sm-9">
            <input type="text" value="{mail}" class="form-control" id="imail" autocomplete="off">
          </div>
        </label>

        <div id="mail-error" style="color: red; font-weight: bold;"></div>

        <div class="text-center">
          <button class="btn btn-info" onclick="changeMailSubmit()">
            Lưu email
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="user-pass" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <p class="text-center">
          Đổi mật khẩu
        </p>

        <label class="row">
          <div class="col-sm-3">
            Mật khẩu cũ
          </div>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="pass-v1" autocomplete="off">
          </div>
        </label>

        <label class="row">
          <div class="col-sm-3">
            Mật khẩu mới
          </div>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="pass-v2" autocomplete="off">
          </div>
        </label>

        <label class="row">
          <div class="col-sm-3">
            Xác nhận mật khẩu
          </div>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="pass-v3" autocomplete="off">
          </div>
        </label>

        <div id="pass-error" style="color: red; font-weight: bold;"></div>

        <div class="text-center">
          <button class="btn btn-info" onclick="changePasswordSubmit()">
            Đổi mật khẩu
          </button>
        </div>

      </div>
    </div>
  </div>
</div>

<div class="modal" id="pet-vaccine" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <p>
          Thêm lịch tiêm phòng
        </p>

        <label class="row">
          <div class="col-sm-3">
            Loại tiêm phòng
          </div>
          <div class="col-sm-9">
            <div class="input-group">
              <select class="form-control" id="vaccine-type">
                {v}
              </select>
              <div class="input-group-btn" onclick="addDiseaseSuggest()">
                <button class="btn btn-success">
                  <span class="glyphicon glyphicon-plus"></span>
                </button>
              </div>
            </div>
          </div>
        </label>

        <label class="row">
          <div class="col-sm-3">
            Ngày tiêm phòng
          </div>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="vaccine-time" value="{today}" autocomplete="off">
          </div>
        </label>

        <label class="row">
          <div class="col-sm-3">
            Ngày nhắc
          </div>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="vaccine-recall" value="{recall}" autocomplete="off">
          </div>
        </label>

        <button class="btn btn-success" onclick="insertVaccineSubmit()">
          Thêm lịch tiêm phòng
        </button>

      </div>
    </div>
  </div>
</div>

<div class="modal" id="insert-disease-suggest" role="dialog">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <p class="text-center"> Nếu mũi tiêm phòng không có trong danh sách, hãy thêm tại đây </p>

        <label>
          Tên mũi tiêm phòng
          <input type="text" class="form-control" id="disease-suggest">
        </label>

        <div class="text-center">
          <button class="btn btn-success" onclick="insertDiseaseSuggestSubmit()">
            Thêm loại tiêm phòng
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="center-confirm" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-body text-center">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <p>
          Xác nhận đăng ký trại?
        </p>
        <button class="btn btn-info" onclick="center()">
          Xác nhận
        </button>
      </div>
    </div>
  </div>
</div>

<div id="request-detail" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <p class="text-center">
          Yêu cầu tiêm phòng, bắn chip
        </p>

        <div id="request-content"></div>
        <label>
          Yêu cầu khác
          <div class="input-group">
            <input type="text" class="form-control" id="request-other">
            <div class="input-group-btn">
              <button class="btn btn-info" onclick="newRequestSubmit()">
                Gửi
              </button>
            </div>
          </div>
        </label>
      </div>
    </div>
  </div>
</div>

<div id="transfer-pet" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal">&times;</button>

        <div>
          Chuyển nhượng cho:
          <div class="relative">
            <div class="input-group">
              <input class="form-control" id="transfer-owner" type="text" autocomplete="off"
                placeholder="tìm kiếm khách hàng">
              <div class="input-group-btn">
                <button class="btn btn-success" style="height: 34px;">
                  <span class="glyphicon glyphicon-search"></span>
                </button>
              </div>
            </div>
            <div class="suggest" id="transfer-owner-suggest"></div>
          </div>
          <div class="text-center">
            <button class="btn btn-info" style="height: 34px;" onclick="transferPetSubmit()">
              Chuyển nhượng
              <!-- <span class="glyphicon glyphicon-plus"></span> -->
            </button>
            <button class="btn btn-success" style="height: 34px;" onclick="addOwner()">
              Thêm khách hàng
              <!-- <span class="glyphicon glyphicon-plus"></span> -->
            </button>
          </div>
        </div>
        <div>
          <label class="row">
            <div class="col-sm-10">
              Nếu thú cưng đã bán/mất nhấn vào đây
            </div>
            <div class="col-sm-2" style="text-align: right;">
              <button class="btn btn-warning" onclick="doneSubmit()">
                <span class="glyphicon glyphicon-usd"></span>
              </button>
            </div>
          </label>
        </div>
        <div id="market-content"></div>

      </div>
    </div>
  </div>
</div>

<div id="insert-owner" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-body text-center">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <p> Điền thông tin chủ trại </p>
        <label class="row">
          <div class="col-sm-3">
            Tên
          </div>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="owner-name">
          </div>
        </label>

        <label class="row">
          <div class="col-sm-3">
            Số điện thoại
          </div>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="owner-mobile">
          </div>
        </label>

        <label class="row">
          <div class="col-sm-3">
            Địa chỉ
          </div>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="owner-address">
          </div>
        </label>

        <label class="row">
          <div class="col-sm-3">
            CMND
          </div>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="owner-politic">
          </div>
        </label>

        <div class="text-center">
          <button class="btn btn-success" onclick="insertOwnerSubmit()">
            Thêm khách hàng
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

  <div id="insert-user" class="modal fade" role="dialog">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <p class="text-center">
          Chỉnh sửa thông tin
        </p>
        <form onsubmit="editUserSubmit(event)">
          <div class="row">
            <label>
              <div class="col-sm-4">
                Họ và tên <span style="color: red;" class="glyphicon glyphicon-afterisk"> * </span>
              </div>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="fullname" autocomplete="off">
              </div>
            </label>
          </div>

          <div class="row">
            <label>
              <div class="col-sm-4">
                Số CMND <span style="color: red;" class="glyphicon glyphicon-afterisk"> * </span>
              </div>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="politic" autocomplete="off">
              </div>
            </label>
          </div>

          <div class="row">
            <label>
              <div class="col-sm-4">
                Điện thoại <span style="color: red;" class="glyphicon glyphicon-afterisk"> * </span>
              </div>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="phone" autocomplete="off">
              </div>
            </label>
          </div>

          <div class="row">
            <label>
              <div class="col-sm-4">
                Tỉnh
              </div>
              <div class="col-sm-8">
                <select class="form-control" id="al1" onchange="l1(this)">
                  <!-- BEGIN: l1 -->
                  <option value="{l1id}"> {l1name} </option>
                  <!-- END: l1 -->
                </select>
              </div>
            </label>
          </div>

          <div class="row">
            <label>
              <div class="col-sm-4">
                Quận/Huyện/Thành phố
              </div>
              <div class="col-sm-8">
                <!-- BEGIN: l2 -->
                <select class="form-control al2" id="al2{l1id}" {active}>
                  <!-- BEGIN: l2c -->
                  <option value="{l2id}"> {l2name} </option>
                  <!-- END: l2c -->
                </select>
                <!-- END: l2 -->
              </div>
            </label>
          </div>

          <div class="row">
            <label>
              <div class="col-sm-4">
                Xã/Phường/Thị trấn
              </div>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="al3" autocomplete="off">
              </div>
            </label>
          </div>

          <div class="row">
            <label>
              <div class="col-sm-4">
                Địa chỉ <span style="color: red;" class="glyphicon glyphicon-afterisk"> * </span>
              </div>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="address" autocomplete="off">
              </div>
            </label>
          </div>

          <label class="row">
            <div class="col-sm-3">
              Hình ảnh
            </div>
            <div class="col-sm-9">
              <div>
                <img class="img-responsive" id="user-preview"
                  style="display: inline-block; width: 128px; height: 128px; margin: 10px;">
              </div>
              <input type="file" class="form-control" id="user-image" onchange="onselected(this, 'user')">
            </div>
          </label>

          <div style="color: red; font-size: 1.2em; font-weight: bold;" class="text-center" id="user-error"> </div>

          <div class="text-center">
            <button class="btn btn-info" id="button">
              Chỉnh sửa thông tin
            </button>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>

<div id="remove-pet" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-body text-center">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <p>
          Xác nhận xóa?
        </p>
        <button class="btn btn-danger" onclick="removePetSubmit()">
          Xóa
        </button>
      </div>
    </div>
  </div>
</div>

<div id="remove-user" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-body text-center">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <p>
          Xác nhận xóa?
        </p>
        <button class="btn btn-danger" onclick="removeUserSubmit()">
          Xóa
        </button>
      </div>
    </div>
  </div>
</div>

<div id="insert-pet" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <p class="text-center"> <b> Thêm thú cưng </b> </p>
        <label class="row">
          <div class="col-sm-3">
            Tên thú cưng <span style="color: red;" class="glyphicon glyphicon-afterisk"> * </span>
          </div>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="pet-name">
          </div>
        </label>

        <label class="row">
          <div class="col-sm-3">
            Ngày sinh <span style="color: red;" class="glyphicon glyphicon-afterisk"> * </span>
          </div>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="pet-dob" value="{today}">
          </div>
        </label>

        <label class="row">
          <div class="col-sm-3">
            Giống <span style="color: red;" class="glyphicon glyphicon-afterisk"> * </span>
          </div>
          <div class="col-sm-9 relative">
            <input type="text" class="form-control" id="species">
            <div class="suggest" id="species-suggest"></div>
          </div>
        </label>

        <label class="row">
          <div class="col-sm-3">
            Loài <span style="color: red;" class="glyphicon glyphicon-afterisk"> * </span>
          </div>
          <div class="col-sm-9 relative">
            <input type="text" class="form-control" id="breed-pet">
            <div class="suggest" id="breed-suggest-pet"></div>
          </div>
        </label>

        <label class="row">
          <div class="col-sm-3">
            Giới tính
          </div>
          <div class="col-sm-9">
            <label>
              <input type="radio" name="sex" id="pet-sex-0" checked> Đực
            </label>
            <label>
              <input type="radio" name="sex" id="pet-sex-1"> Cái
            </label>
          </div>
        </label>

        <label class="row">
          <div class="col-sm-3">
            Màu sắc
          </div>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="pet-color">
          </div>
        </label>

        <label class="row">
          <div class="col-sm-3">
            Microchip
          </div>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="pet-microchip">
          </div>
        </label>

        <label class="row">
          <div class="col-sm-3">
            Xăm tai
          </div>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="pet-miear">
          </div>
        </label>

        <label class="row">
          <div class="col-sm-3">
            Xuất xứ
          </div>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="origin-pet">
          </div>
        </label>

        <div class="row">
          <div class="col-sm-6">
            Chó cha
            <div class="relative">
              <div class="input-group">
                <input class="form-control" id="parent-m" type="text" autocomplete="off">
                <input class="form-control" id="parent-m-s" type="hidden">
                <div class="input-group-btn">
                  <button class="btn btn-success" style="height: 34px;" onclick="addParent('m')">
                    <span class="glyphicon glyphicon-plus"></span>
                  </button>
                </div>
              </div>
              <div class="suggest" id="parent-suggest-m"></div>
            </div>
          </div>

          <div class="col-sm-6">
            Chó mẹ
            <div class="relative">
              <div class="input-group">
                <input class="form-control" id="parent-f" type="text" autocomplete="off">
                <input class="form-control" id="parent-f-s" type="hidden">
                <div class="input-group-btn relative">
                  <button class="btn btn-success" style="height: 34px;" onclick="addParent('f')">
                    <span class="glyphicon glyphicon-plus"></span>
                  </button>
                </div>
              </div>
              <div class="suggest" id="parent-suggest-f"></div>
            </div>
          </div>
        </div>

        <label class="row">
          <div class="col-sm-3">
            Hình ảnh
          </div>
          <div class="col-sm-9">
            <div>
              <img class="img-responsive" id="pet-preview"
                style="display: inline-block; width: 128px; height: 128px; margin: 10px;">
            </div>
            <input type="file" class="form-control" id="user-image" onchange="onselected(this, 'pet')">
          </div>
        </label>

        <div style="color: red; font-size: 1.2em; font-weight: bold;" class="text-center" id="pet-error"> </div>

        <div class="text-center">
          <button class="btn btn-success" id="ibtn" onclick="insertPetSubmit()">
            Thêm thú cưng
          </button>
          <button class="btn btn-success" id="ebtn" onclick="editPetSubmit()" style="display: none;">
            Chỉnh sửa
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="insert-parent" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <p class="text-center"> <b> Thêm cha mẹ </b> </p>
        <label class="row">
          <div class="col-sm-3">
            Tên thú cưng <span style="color: red;" class="glyphicon glyphicon-afterisk"> * </span>
          </div>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="parent-name">
          </div>
        </label>

        <label class="row">
          <div class="col-sm-3">
            Ngày sinh <span style="color: red;" class="glyphicon glyphicon-afterisk"> * </span>
          </div>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="parent-dob">
          </div>
        </label>

        <label class="row">
          <div class="col-sm-3">
            Giống <span style="color: red;" class="glyphicon glyphicon-afterisk"> * </span>
          </div>
          <div class="col-sm-9 relative">
            <input type="text" class="form-control" id="species-parent">
            <div class="suggest" id="species-parent-suggest"></div>
          </div>
        </label>

        <label class="row">
          <div class="col-sm-3">
            Loài <span style="color: red;" class="glyphicon glyphicon-afterisk"> * </span>
          </div>
          <div class="col-sm-9 relative">
            <input type="text" class="form-control" id="breed-parent">
            <div class="suggest" id="breed-suggest-parent"></div>
          </div>
        </label>

        <label class="row">
          <div class="col-sm-3">
            Giới tính
          </div>
          <div class="col-sm-9">
            <label>
              <input type="radio" name="psex" id="parent-sex-0" checked> Đực
            </label>
            <label>
              <input type="radio" name="psex" id="parent-sex-1"> Cái
            </label>
          </div>
        </label>

        <label class="row">
          <div class="col-sm-3">
            Màu sắc
          </div>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="parent-color">
          </div>
        </label>

        <label class="row">
          <div class="col-sm-3">
            Microchip
          </div>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="parent-microchip">
          </div>
        </label>

        <label class="row">
          <div class="col-sm-3">
            Xăm tai
          </div>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="parent-miear">
          </div>
        </label>

        <label class="row">
          <div class="col-sm-3">
            Hình ảnh
          </div>
          <div class="col-sm-9">
            <div>
              <img class="img-responsive" id="parent-preview"
                style="display: inline-block; width: 128px; height: 128px; margin: 10px;">
            </div>
            <input type="file" class="form-control" id="user-image" onchange="onselected(this, 'parent')">
          </div>
        </label>

        <div style="color: red; font-size: 1.2em; font-weight: bold;" class="text-center" id="parent-error"> </div>

        <div class="text-center">
          <button class="btn btn-success" onclick="insertParentSubmit()">
            Thêm thú cưng
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- END: main -->