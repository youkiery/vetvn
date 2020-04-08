<!-- BEGIN: main -->
<style>
  .modal {
    overflow-y: auto;
  }
</style>

<div class="container">
  <div id="msgshow"></div>
  <div id="loading">
    <div class="black-wag"> </div>
    <img class="loading" src="/themes/default/images/loading.gif">
  </div>

  <div class="modal" id="user-buy" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <label class="row">
            <div class="col-sm-3">
              Loài
            </div>
            <div class="col-sm-9" style="text-align: right;">
              <input type="text" class="form-control" id="species-buy">
              <div class="suggest" id="species-suggest-buy" style="text-align: left;"></div>
            </div>
          </label>

          <label class="row">
            <div class="col-sm-3">
              Giống
            </div>
            <div class="col-sm-9" style="text-align: right;">
              <input type="text" class="form-control" id="breed-buy">
              <div class="suggest" id="breed-suggest-buy" style="text-align: left;"></div>
            </div>
          </label>

          <label class="row">
            <div class="col-sm-3">
              Giới tính
            </div>
            <div class="col-sm-9">
              <label>
                <input type="radio" name="sex4" id="buy-sex-0" checked> Sao cũng được
              </label>
              <label>
                <input type="radio" name="sex4" id="buy-sex-1"> Đực
              </label>
              <label>
                <input type="radio" name="sex4" id="buy-sex-2"> Cái
              </label>
            </div>
          </label>

          <label>
            <input type="checkbox" name="age" id="buy-age-check" checked> Sao cũng được
          </label>
          <label class="row">
            <div class="col-sm-3">
              Tuổi
            </div>
            <div class="col-sm-9">
              <input type="number" class="form-control" id="buy-age" placeholder="tháng" disabled>
            </div>
          </label>

          <label>
            <input type="checkbox" name="age" id="buy-price-check" checked> Liên hệ
          </label>
          <label for="customRange2">Khoảng giá <span id="buy-price"></span></label>
          <input type="range" class="buy-form" min="0" max="100" id="buy-price-from" disabled>
          <input type="range" class="buy-form" min="0" max="100" id="buy-price-end" disabled>

          <label>
            Yêu cầu thêm
            <textarea class="form-control" id="buy-note" rows="5"></textarea>
          </label>

          <div id="buy-error" style="color: red; font-weight: bold;"></div>

          <div class="text-center">
            <button class="btn btn-info" onclick="buySubmit()">
              Thêm cần mua
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

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
          <p class="text-center">
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

          <div class="text-center">
            <button class="btn btn-success" onclick="insertVaccineSubmit()">
              Thêm lịch tiêm phòng
            </button>
          </div>
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
              Thêm lịch loại tiêm phòng
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

  <div id="request-detail" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body text-center">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <p>
            Yêu cầu tiêm phòng, bắn chip
          </p>

          <div id="request-content"></div>
        </div>
      </div>
    </div>
  </div>

  <div id="private-confirm" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-body text-center">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <p>
            Xác nhận hủy đăng ký trại?
          </p>
          <button class="btn btn-info" onclick="privateSubmit()">
            Xác nhận
          </button>
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
                  Tên đăng nhập <span style="color: red;" class="glyphicon glyphicon-afterisk"> * </span>
                </div>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="username" autocomplete="off">
                </div>
              </label>
            </div>

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
                  <select class="form-control al2" id="al2{l1id}" style="display: {active}">
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
              Tên thú cưng
            </div>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="pet-name">
            </div>
          </label>

          <label class="row">
            <div class="col-sm-3">
              Ngày sinh
            </div>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="pet-dob" value="{today}">
            </div>
          </label>

          <label class="row">
            <div class="col-sm-3">
              Giống
            </div>
            <div class="col-sm-9 relative">
              <input type="text" class="form-control" id="species">
              <div class="suggest" id="species-suggest"></div>
            </div>
          </label>

          <label class="row">
            <div class="col-sm-3">
              Loài
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
              Nuôi làm giống
            </div>
            <div class="col-sm-9">
              <label>
                <input type="checkbox" id="pet-breeder" checked>
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
              Tên thú cưng
            </div>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="parent-name">
            </div>
          </label>

          <label class="row">
            <div class="col-sm-3">
              Ngày sinh
            </div>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="parent-dob">
            </div>
          </label>

          <label class="row">
            <div class="col-sm-3">
              Giống
            </div>
            <div class="col-sm-9 relative">
              <input type="text" class="form-control" id="species-parent">
              <div class="suggest" id="species-parent-suggest"></div>
            </div>
          </label>

          <label class="row">
            <div class="col-sm-3">
              Loài
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
              Là cá thể giống
            </div>
            <div class="col-sm-9">
              <label>
                <input type="checkbox" id="parent-breeder" checked>
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

          <div class="text-center">
            <button class="btn btn-success" onclick="insertParentSubmit()">
              Thêm thú cưng
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <a href="/">
    <img src="/themes/default/images/banner.png" style="width: 200px;">
  </a>

  <div style="float: right;">
    <a href="/{module_file}/logout"> Đăng xuất </a>
  </div>

  <h2> Thông tin cá nhân </h2>
  <div style="float: left; width: 250px; height: 250px; overflow: hidden;" class="thumbnail" id="avatar">
  </div>
  <div style="float: left; margin-left: 10px;">
    <div class="form-group"> Tên: {fullname} </div>
    <div class="form-group"> Điện thoại: {mobile} </div>
    <div class="form-group"> Địa chỉ: {address} </div>

    <div class="form-group">
      <button class="btn btn-info" onclick="editUser({userid})">
        Chỉnh sửa thông tin
      </button>
      <button class="btn btn-warning" onclick="privateConfirm()">
        Huỷ ký trại
      </button>
    </div>

    <div class="form-group">
      <button class="btn btn-info" onclick="changeMail()">
        Email
      </button>
      <button class="btn btn-info" onclick="changePassword()">
        Đổi mật khẩu
      </button>
    </div>

    <div class="form-group">
      <button class="btn btn-info" onclick="buy()">
        Cần mua
      </button>
      <a class="btn btn-info" href="/news/sendinfo"> Yêu cầu cấp chứng nhận </a>
    </div>
  </div>
  <div style="clear: left;"></div>
  <p> <a href="/{module_file}/trading"> Quản lý mua, bán, phối</a> <span style="font-weight: bold; color: red;">{intro_count}</span></p>
  <p> <a href="/{module_file}/transfer"> Danh sách chuyển nhượng <span style="font-weight: bold; color: red;">{transfer_count}</span> </a> </p>
  <p> <a href="/{module_file}/reserve"> Danh sách bán, mất</a> </p>
  <p> <a href="/{module_file}/contact"> Danh sách khách hàng </a> </p>
  <!-- BEGIN: xter -->
  <p> <a href="/{module_file}/statistic"> Danh sách thu chi</a> </p>
  <!-- END: xter -->
  <h2> Danh sách thú cưng  </h2>

  <form onsubmit="filterS(event)">
    <input type="text" class="form-control" id="search-keyword" style="display: inline-block; width: 30%;"
      placeholder="Từ khóa">
    <select class="form-control" id="search-limit" style="display: inline-block; width: 30%;">
      <option value="10">10</option>
      <option value="20">20</option>
      <option value="50">50</option>
      <option value="100">100</option>
    </select>
    <button class="btn btn-info">
      <span class="glyphicon glyphicon-search"></span>
    </button>
  </form>

  <button class="btn btn-success" style="float: right;" onclick="addPet()">
    <span class="glyphicon glyphicon-plus"> </span>
  </button>

  <div style="clear: both;"></div>

  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#a" onclick="change(0)"> Đực giống </a></li>
    <li><a data-toggle="tab" href="#b" onclick="change(1)"> Cái giống </a></li>
    <li><a data-toggle="tab" href="#c" onclick="change(2)"> Con non </a></li>
  </ul>

  <div id="pet-list">
    {list}
  </div>
</div>

<script src="https://www.gstatic.com/firebasejs/6.0.2/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/5.7.0/firebase-storage.js"></script>
<script>
  var global = {
    login: 1,
    text: ['Đăng ky', 'Đăng nhập'],
    url: '{origin}',
    id: -1,
    parent: 'm',
    tabber: [{tabber}],
    page: 1,
    pet: -1,
    owner: -1,
    request: -1,
    type: 0
  }
  var vaccine = {
    type: $("#vaccine-type"),
    time: $("#vaccine-time"),
    recall: $("#vaccine-recall")
  }
  var pet = {
    name: $("#pet-name"),
    dob: $("#pet-dob"),
    species: $("#species"),
    breed: $("#breed-pet"),
    sex0: $("#pet-sex-0"),
    sex1: $("#pet-sex-1"),
    color: $("#pet-color"),
    microchip: $("#pet-microchip"),
    miear: $("#pet-miear"),
    origin: $("#origin-pet"),
    parentm: $("#parent-m-s"),
    parentf: $("#parent-f-s")
  }
  var parent = {
    name: $("#parent-name"),
    dob: $("#parent-dob"),
    sex0: $("#parent-sex-0"),
    sex1: $("#parent-sex-1"),
    color: $("#parent-color"),
    microchip: $("#parent-microchip"),
    miear: $("#pet-miear"),
    // origin: $("#origin-pet"),
    species: $("#species-parent"),
    breed: $("#breed-parent")
  }
  var user = {
    username: $("#username"),
    fullname: $("#fullname"),
    politic: $("#politic"),
    mobile: $("#phone"),
    address: $("#address")
  }
  var uploaded = {}
  var position = JSON.parse('{position}')
  var al1 = $("#al1")
  var al2 = $("#al2")
  var al3 = $("#al3")
  var owner = {
    fullname: $("#owner-name"),
    mobile: $("#owner-mobile"),
    address: $("#owner-address"),
    politic: $("#owner-politic")
  }
  var mostly = {
    pet: {
      dob: '{today}',
      species: '{most_species}',
      breeder: '{most_breeder}',
      origin: '{most_oringin}'
    }
  }
  var vaccine = {
    type: $("#vaccine-type"),
    time: $("#vaccine-time"),
    recall: $("#vaccine-recall")
  }

  var uploadedUrl = ''
  var vaccineContent = $("#vaccine-content")
  var insertDiseaseSuggest = $("#insert-disease-suggest")
  var userImage = $("#user-image")
  var userPreview = $("#user-preview")
  var petPreview = $("#pet-preview")
  var username = $("#username")
  var password = $("#password")
  var vpassword = $("#vpassword")
  var fullname = $("#fullname")
  var phone = $("#phone")
  var address = $("#address")
  var keyword = $("#keyword")
  var cstatus = $(".status")
  var button = $("#button")
  var searchLimit = $("#search-limit")
  var searchKeyword = $("#search-keyword")
  var ibtn = $("#ibtn")
  var ebtn = $("#ebtn")

  var transferPet = $("#transfer-pet")
  var transferOwner = $("#transfer-owner")
  var insertOwner = $("#insert-owner")
  var insertPet = $("#insert-pet")
  var insertUser = $("#insert-user")
  var insertParent = $("#insert-parent")
  var petVaccine = $("#pet-vaccine")
  var requestContent = $("#request-content")
  var requestDetail = $("#request-detail")
  var removetPet = $("#remove-pet")
  var removetUser = $("#remove-user")
  var petList = $("#pet-list")
  var userList = $("#user-list")
  var tabber = $(".tabber")
  var maxWidth = 512
  var maxHeight = 512
  var imageType = ["jpeg", "jpg", "png", "bmp", "gif"]
  var metadata = {
    contentType: 'image/jpeg',
  };
  var file, filename
  remind = JSON.parse('{remind}')
  var thumbnail
  var canvas = document.createElement('canvas')

  var thumbnailImage = new Image()
  thumbnailImage.src = '/themes/default/images/thumbnail.jpg'
  thumbnailImage.onload = (e) => {
    var context = canvas.getContext('2d')
    var width = thumbnailImage.width
    var height = thumbnailImage.height
    var x = width
    if (height > width) {
      x = height
    }
    var rate = 256 / x
    canvas.width = rate * width
    canvas.height = rate * height

    context.drawImage(thumbnailImage, 0, 0, width, height, 0, 0, canvas.width, canvas.height)
    thumbnail = canvas.toDataURL("image/jpeg")
  }

  var firebaseConfig = {
    apiKey: "AIzaSyAgxaMbHnlYbUorxXuDqr7LwVUJYdL2lZo",
    authDomain: "petcoffee-a3cbc.firebaseapp.com",
    databaseURL: "https://petcoffee-a3cbc.firebaseio.com",
    projectId: "petcoffee-a3cbc",
    storageBucket: "petcoffee-a3cbc.appspot.com",
    messagingSenderId: "351569277407",
    appId: "1:351569277407:web:8ef565047997e013"
  };

  firebase.initializeApp(firebaseConfig);

  var storage = firebase.storage();
  var storageRef = firebase.storage().ref();

  tabber.click((e) => {
    var className = e.currentTarget.getAttribute('class')
    global[login] = Number(splipper(className, 'tabber'))
    // button.text(global['text'][global['login']])
  })

  $("#pet-dob, #parent-dob, #vaccine-time, #vaccine-recall").datepicker({
    format: 'dd/mm/yyyy',
    changeMonth: true,
    changeYear: true
  });

  loadImage('{image}', 'avatar')

  $(this).ready(() => {
    installRemind('m', 'parent')
    installRemind('f', 'parent')
    // installRemindv2('pet', 'species')
    installRemindv2('buy', 'breed')
    installRemindv2('buy', 'species')
    installRemindv2('pet', 'breed')
    installRemindv2('pet', 'origin')
    // installRemindv2('parent', 'species')
    installRemindv2('parent', 'breed')
    installRemindOwner('transfer-owner')
    installRemindSpecies('species')
    installRemindSpecies('species-parent')
  })

  function doneSubmit() {
    freeze()
    $.post(
      global['url'],
      {action: 'done', id: global['id'], filter: checkFilter(), tabber: global['tabber']},
      (response, status) => {
        checkResult(response, status).then(data => {
          petList.html(data['html'])
          $("#transfer-pet").modal('hide')
        }, () => {})
      }
    )    
  }

  function buy() {
    $("#buy-sex-0").prop('checked', true)
    $("#buy-age-check").prop('checked', true)
    $("#buy-age").prop('disabled', true)
    $("#user-buy").modal('show')
  }

  $("#buy-age-check").change(() => {
    if ($("#buy-age-check").prop('checked')) {
      $("#buy-age").prop('disabled', true)
      $("#buy-age").val('')
    }
    else {
      $("#buy-age").prop('disabled', false)
      $("#buy-age").val('1')
    }
  })

  $("#buy-price-check").change(() => {
    if ($("#buy-price-check").prop('checked')) {
      $("#buy-price-from").prop('disabled', true)
      $("#buy-price-end").prop('disabled', true)
      $("#buy-price").text('')
    }
    else {
      $("#buy-price-from").prop('disabled', false)
      $("#buy-price-end").prop('disabled', false)
      $("#buy-price").text(checkPrice())
    }
  })

  $("#buy-price-from, #buy-price-end").change(() => {
    $("#buy-price").text(checkPrice())
  })

  function checkPrice() {
    var from = $("#buy-price-from").val()
    var end = $("#buy-price-end").val()

    if (end - from < 0) {
      $("#buy-price-from").val(end)
      $("#buy-price-end").val(from)
      temp = from
      from = end
      end = temp
    }

    return 'Từ ' + parseCurrency(from * 100000) + ' đến ' + parseCurrency(end * 100000)
  }

  function checkBuyData() {
    var sex = splipper($("[name=sex4]:checked").attr('id'), 'buy-sex-')
    sex.length ? '' : sex = 0
    var age = $("#buy-age").val()
    if ($("#buy-age-check").prop('checked')) {
      age = 0
    }
    var price = $("#buy-price-check").prop('checked')
    if (!price) {
      var from = $("#buy-price-from").val()
      var end = $("#buy-price-end").val()
      price = from + '-' + end
    }
    else price = 0
    return {
      species: $("#species-buy").val(),
      breed: $("#breed-buy").val(),
      sex: sex,
      age: age,
      price: price,
      note: $("#buy-note").val()
    }
  }

  function buySubmit() {
    data = checkBuyData()
    freeze()
    $.post(
      global['url'],
      {action: 'buy', data: data},
      (response, status) => {
        checkResult(response, status).then(data => {
          $("#user-buy").modal('hide')
        }, () => {})
      }
    )    
  }

  function sellSubmit() {
    freeze()
    $.post(
      global['url'],
      {action: 'sell', id: global['id']},
      (response, status) => {
        checkResult(response, status).then(data => {
          $("#market-content").html(data['html'])
        }, () => {})
      }
    )    
  }

  function unsellSubmit() {
    freeze()
    $.post(
      global['url'],
      {action: 'unsell', id: global['id']},
      (response, status) => {
        checkResult(response, status).then(data => {
          $("#market-content").html(data['html'])
        }, () => {})
      }
    )    
  }

  function breedingSubmit() {
    freeze()
    $.post(
      global['url'],
      {action: 'breeding', id: global['id']},
      (response, status) => {
        checkResult(response, status).then(data => {
          $("#market-content").html(data['html'])
        }, () => {})
      }
    )    
  }

  function unbreedingSubmit() {
    freeze()
    $.post(
      global['url'],
      {action: 'unbreeding', id: global['id']},
      (response, status) => {
        checkResult(response, status).then(data => {
          $("#market-content").html(data['html'])
        }, () => {})
      }
    )    
  }

  function changeMail() {
    $("#user-mail").modal('show')
  }

  function changeMailSubmit() {
    var mail = $("#imail").val().trim()
    if (!/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(mail)) {
      $("#mail-error").text('Không đúng định dạng')
    }
    else {
      $("#mail-error").text('')
      freeze()
      $.post(
        global['url'],
        {action: 'change-mail', mail: mail},
        (response, status) => {
          checkResult(response, status).then(data => {
            $("#mail-error").text(data['error'])
            $("#user-mail").modal('hide')
          }, () => { })
        }
      )
    }
  }

  function changePassword() {
    $("#user-pass").modal('show')
  }

  function changePasswordSubmit() {
    var pass1 = $("#pass-v1").val().trim(), pass2 = $("#pass-v2").val().trim(), pass3 = $("#pass-v3").val().trim()
    if (!pass1 || !pass2 || !pass3) {
      $("#pass-error").text('Các trường không được trống')
    }
    else if (pass3!== pass2) {
      $("#pass-error").text('Mật khẩu không trùng nhau')
    }
    else {
      $("#pass-error").text('')
      freeze()
      $.post(
        global['url'],
        {action: 'change-pass', opass: pass1, npass: pass3},
        (response, status) => {
          checkResult(response, status).then(data => {
            $("#user-pass").modal('hide')
          }, () => { })
        }
      )
    }
  }

  function centerConfirm() {
    $("#center-confirm").modal('show')
  }

  function pickSpecies(name, id) {
    if (($("#insert-parent").data('bs.modal') || {}).isShown) {
      $("#species-parent").val(name)
    }
    else {
      $("#species").val(name)
    }
  }

  function transfer(id) {
    freeze()
    $.post(
      global['url'],
      {action: 'get-sell', id: id},
      (response, status) => {
        checkResult(response, status).then(data => {
          global['id'] = id
          $("#market-content").html(data['html'])
          transferPet.modal('show')
        }, () => {})
      }
    )    
  }

  function transferPetSubmit() {
    freeze()
    $.post(
      global['url'],
      { action: 'transfer-owner', petid: global['id'], ownerid: global['owner'], type: global['type'], filter: checkFilter(), tabber: global['tabber'] },
      (response, status) => {
        checkResult(response, status).then(data => {
          $("#transfer-owner").val('')
          transferPet.modal('hide')
          petList.html(data['html'])
        }, () => { })
      }
    )
  }

  function addOwner() {
    insertOwner.modal('show')
  }

  function insertOwnerSubmit() {
    freeze()
    $.post(
      global['url'],
      { action: 'insert-owner', data: checkInputSet(owner) },
      (response, status) => {
        checkResult(response, status).then(data => {
          transferOwner.val(data['name'])
          global['owner'] = data['id']
          global['type'] = 2
          insertOwner.modal('hide')
          clearInputSet(owner)
        }, () => { })
      }
    )
  }

  function pickOwner(name, id, type) {
    transferOwner.val(name)
    global['owner'] = id
    global['type'] = type
  }

  function installRemindOwner(section) {
    var timeout
    var input = $("#" + section)
    var suggest = $("#" + section + "-suggest")

    input.keyup(() => {
      clearTimeout(timeout)
      timeout = setTimeout(() => {
        var key = paintext(input.val())
        var html = ''

        $.post(
          global['url'],
          { action: 'parent2', keyword: key },
          (response, status) => {
            checkResult(response, status).then(data => {
              suggest.html(data['html'])
            }, () => { })
          }
        )

        suggest.html(html)
      }, 200);
    })
    input.focus(() => {
      suggest.show()
    })
    input.blur(() => {
      setTimeout(() => {
        suggest.hide()
      }, 200);
    })
  }

  function installRemindSpecies(section) {
    var timeout
    var input = $("#" + section)
    var suggest = $("#" + section + "-suggest")


    input.keyup(() => {
      clearTimeout(timeout)
      timeout = setTimeout(() => {
        var key = paintext(input.val())
        var html = ''

        $.post(
          global['url'],
          { action: 'species', keyword: key },
          (response, status) => {
            checkResult(response, status).then(data => {
              suggest.html(data['html'])
            }, () => { })
          }
        )

        suggest.html(html)
      }, 200);
    })
    input.focus(() => {
      suggest.show()
    })
    input.blur(() => {
      setTimeout(() => {
        suggest.hide()
      }, 200);
    })
  }

  function privateConfirm() {
    $("#private-confirm").modal('show')
  }

  function privateSubmit() {
    freeze()
    $.post(
      global['url'],
      { action: 'private' },
      (response, status) => {
        checkResult(response, status).then(data => {
          window.location.reload()
        }, () => { })
      }
    )
  }

  function change(pid) {
    global['tabber'][0] = pid
    filter()
  }

  function request(id) {
    freeze()
    $.post(
      global['url'],
      { action: 'get-request', id: id },
      (response, status) => {
        checkResult(response, status).then(data => {
          global['request'] = id
          requestContent.html(data['html'])
          requestDetail.modal('show')
        }, () => { })
      }
    )
  }

  function newRequestSubmit() {
    freeze()
    $.post(
      global['url'],
      { action: 'new-request', name: $("#request-other").val(), id: global['request'] },
      (response, status) => {
        checkResult(response, status).then(data => {
          requestContent.html(data['html'])
          // requestDetail.modal('hide')
        }, () => { })
      }
    )
  }

  function requestSubmit(id, value, type) {
    freeze()
    $.post(
      global['url'],
      { action: 'request', id: id, type: type, value: value },
      (response, status) => {
        checkResult(response, status).then(data => {
          requestContent.html(data['html'])
        }, () => { })
      }
    )
  }

  function cancelSubmit(id, type) {
    freeze()
    $.post(
      global['url'],
      { action: 'cancel', id: id, type: type },
      (response, status) => {
        checkResult(response, status).then(data => {
          requestContent.html(data['html'])
        }, () => { })
      }
    )
  }

  function addVaccine(id) {
    global['id'] = id
    petVaccine.modal('show')
  }

  function insertVaccineSubmit() {
    freeze()
    $.post(
      global['url'],
      { action: 'insert-vaccine', data: checkVaccineData(), id: global['id'] },
      (response, status) => {
        checkResult(response, status).then(data => {
          window.location.href = '/{module_name}/info/?id=' + global['id'] + '&target=vaccine'
          petVaccine.modal('hide')
        }, () => { })
      }
    )
  }

  function addParent(name) {
    insertParent.modal('show')
    global['parent'] = name
    clearInputSet(parent)
    petPreview.val('')
    $("#parent" + global['parent']).val('')
    $("#parent" + global['parent' + '-s']).val(0)
  }

  function checkParentData() {
    var data = checkInputSet(parent)
    data['breeder'] = $("#parent-breeder").prop('checked')
    data['sex0'] = parent['sex0'].prop('checked')
    data['sex1'] = parent['sex1'].prop('checked')
    return data
  }

  function insertParentSubmit() {
    freeze()
    uploader('parent').then((imageUrl) => {
      $.post(
        global['url'],
        { action: 'insert-parent', id: global['id'], data: checkParentData(), image: imageUrl, filter: checkFilter(), tabber: global['tabber'] },
        (response, status) => {
          checkResult(response, status).then(data => {
            uploaded['parent']
            petList.html(data['html'])
            file = false
            filename = ''
            clearInputSet(parent)
            $("#parent-preview").attr('src', thumbnail)
            remind = JSON.parse(data['remind'])
            insertParent.modal('hide')
            $("#parent-breeder").prop('checked', true)
            $("#parent-" + global['parent']).val(data['name'])
            $("#parent-" + global['parent'] + '-s').val(data['id'])
          }, () => { })
        }
      )
    })
  }

  function pickParent(e, name, id) {
    var idp = splipper(e.parentNode.getAttribute('id'), 'parent-suggest')
    $('#parent-' + idp + '-s').val(id)
    $('#parent-' + idp).val(name)
  }

  function installRemind(name, type) {
    var timeout
    var input = $("#" + type + "-" + name)
    var suggest = $("#" + type + "-suggest-" + name)

    input.keyup(() => {
      clearTimeout(timeout)
      timeout = setTimeout(() => {
        var key = paintext(input.val())
        var html = ''

        $.post(
          global['url'],
          { action: 'parent', keyword: key },
          (response, status) => {
            checkResult(response, status).then(data => {
              suggest.html(data['html'])
            }, () => { })
          }
        )

        suggest.html(html)
      }, 200);
    })
    input.focus(() => {
      suggest.show()
    })
    input.blur(() => {
      setTimeout(() => {
        suggest.hide()
      }, 200);
    })
  }

  function installRemindv2(name, type) {
    var timeout
    var input = $("#" + type + "-" + name)
    var suggest = $("#" + type + "-suggest-" + name)

    input.keyup(() => {
      clearTimeout(timeout)
      timeout = setTimeout(() => {
        var key = paintext(input.val())
        var html = ''

        for (const index in remind[type]) {
          if (remind[type].hasOwnProperty(index)) {
            const element = paintext(remind[type][index]['name']);

            if (element.search(key) >= 0) {
              html += '<div class="suggest_item" onclick="selectRemindv2(\'' + name + '\', \'' + type + '\', \'' + remind[type][index]['name'] + '\')"><p class="right-click">' + remind[type][index]['name'] + '</p></div>'
            }
          }
        }
        suggest.html(html)
      }, 200);
    })
    input.focus(() => {
      suggest.show()
    })
    input.blur(() => {
      setTimeout(() => {
        suggest.hide()
      }, 200);
    })
  }

  function selectRemindv2(name, type, value) {
    $("#" + type + "-" + name).val(value)
  }

  function center() {
    freeze()
    $.post(
      global['url'],
      { action: 'center' },
      (response, status) => {
        checkResult(response, status).then(data => {
          window.location.reload()
        }, () => { })
      }
    )
  }

  function onselected(input, previewname) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      var fullname = input.files[0].name
      var name = Math.round(new Date().getTime() / 1000) + '_' + fullname.substr(0, fullname.lastIndexOf('.'))
      var extension = fullname.substr(fullname.lastIndexOf('.') + 1)
      uploaded[previewname] = {}
      filename = name + '.' + extension

      reader.onload = function (e) {
        var type = e.target["result"].split('/')[1].split(";")[0];
        if (["jpeg", "jpg", "png", "bmp", "gif"].indexOf(type) >= 0) {
          var image = new Image();
          image.src = e.target["result"];
          image.onload = (e2) => {
            var c = document.createElement("canvas")
            var ctx = c.getContext("2d");
            var ratio = 1;
            if (image.width > maxWidth)
              ratio = maxWidth / image.width;
            else if (image.height > maxHeight)
              ratio = maxHeight / image.height;
            c.width = image["width"];
            c.height = image["height"];
            ctx.drawImage(image, 0, 0);
            var cc = document.createElement("canvas")
            var cctx = cc.getContext("2d");
            cc.width = image.width * ratio;
            cc.height = image.height * ratio;
            cctx.fillStyle = "#fff";
            cctx.fillRect(0, 0, cc.width, cc.height);
            cctx.drawImage(c, 0, 0, c.width, c.height, 0, 0, cc.width, cc.height);
            file = cc.toDataURL("image/jpeg")
            $("#" + previewname + "-preview").attr('src', file)
            file = file.substr(file.indexOf(',') + 1);
            uploaded[previewname] = {
              url: '',
              file: file,
              name: filename              
            }
          }
        };
      };

      if (imageType.indexOf(extension) >= 0) {
        reader.readAsDataURL(input.files[0]);
      }
    }
  }

  // function preview() {
  //   var file = userImage[0]['files']
  //   if (file && file[0]) {
  //     var reader = new FileReader();
  //     reader.readAsDataURL(file[0]);  
  //     reader.onload = (e) => {
  //       var type = e.target["result"].split('/')[1].split(";")[0];
  //       if (["jpeg", "jpg", "png", "bmp", "gif"].indexOf(type) >= 0) {
  //         cc.width = image.width * ratio;
  //         cc.height = image.height * ratio;
  //         cctx.fillStyle = "#fff";
  //         cctx.fillRect(0, 0, cc.width, cc.height);
  //         cctx.drawImage(c, 0, 0, c.width, c.height, 0, 0, cc.width, cc.height);
  //         var base64Image = cc.toDataURL("image/jpeg");
  //         this.post.image.push(base64Image)
  //       }
  //     }
  //   }
  // }

  function deletePet(id) {
    global['id'] = id
    removetPet.modal('show')
  }

  function removePetSubmit() {
    freeze()
    $.post(
      global['url'],
      { action: 'remove', id: global['id'], filter: checkFilter() },
      (response, status) => {
        checkResult(response, status).then(data => {
          global['page'] = 1
          petList.html(data['html'])
          removetPet.modal('hide')
        }, () => { })
      }
    )
  }

  function editPet(id) {
    freeze()
    $.post(
      global['url'],
      { action: 'get', id: id },
      (response, status) => {
        checkResult(response, status).then(data => {
          global['id'] = id
          parseInputSet(data['data'], pet)
          $("#pet-breeder").prop('checked', false)
          if (data['more']['breeder'] < 2) {
            $("#pet-breeder").prop('checked', true)
          }
          $("#parent-f").val(data['more']['f'])
          $("#parent-m").val(data['more']['m'])
          $("#pet-sex-" + data['more']['sex']).prop('checked', true)
          var image = new Image()
          image.src = data['image']
          petPreview.attr('src', thumbnail)
          image.addEventListener('load', (e) => {
            petPreview.attr('src', image.src)
          })

          ibtn.hide()
          ebtn.show()
          insertPet.modal('show')
        }, () => { })
      }
    )
  }

  function checkPetData() {
    var data = checkInputSet(pet)
    data['breeder'] = $("#pet-breeder").prop('checked')
    data['sex0'] = pet['sex0'].prop('checked')
    data['sex1'] = pet['sex1'].prop('checked')
    return data
  }

  function deleteImage(url) {
    return new Promise((resolve) => {
      if (!url) {
        resolve()
      }
      url = url.substr(0, url.search(/\?alt=/))
      var xref = storage.refFromURL(url);

      xref.delete().then(function() {
        resolve()        
      }).catch(function(error) {
        resolve()        
      });
    })
  }

  function editPetSubmit() {
    freeze()
    uploader('pet').then((imageUrl) => {
      $.post(
        global['url'],
        { action: 'editpet', id: global['id'], data: checkPetData(), image: imageUrl, filter: checkFilter(), tabber: global['tabber'] },
        (response, status) => {
          checkResult(response, status).then(data => {
            uploaded['pet']
            deleteImage(data['image']).then(() => {
              petList.html(data['html'])
              clearInputSet(pet)
              file = false
              filename = ''
              $("#parent-m").val('')
              $("#parent-f").val('')
              petPreview.val('')
              remind = JSON.parse(data['remind'])
              insertPet.modal('hide')
            })
          }, () => { })
        }
      )
    })
  }

  function splipper(text, part) {
    var pos = text.search(part + '-')
    var overleft = text.slice(pos)
    if (number = overleft.search(' ') >= 0) {
      overleft = overleft.slice(0, number)
    }
    var tick = overleft.lastIndexOf('-')
    var result = overleft.slice(tick + 1, overleft.length)

    return result
  }

  function checkFilter() {
    // var temp = cstatus.filter((index, item) => {
    //   return item.checked
    // })
    // var value = 0
    // if (temp[0]) {
    //   value = splipper(temp[0].getAttribute('id'), 'status')
    // }
    var data = {
      page: global['page'],
      limit: searchLimit.val(),
      keyword: searchKeyword.val(),
      // status: value
    }
    return data
  }

  function goPage(page) {
    global['page'] = page
    filter()
  }

  function filter() {
    freeze()
    $.post(
      global['url'],
      { action: 'filter', filter: checkFilter(), tabber: global['tabber'] },
      (response, status) => {
        checkResult(response, status).then(data => {
          petList.html(data['html'])
        }, () => { })
      }
    )
  }

  function filterS(e) {
    e.preventDefault()
    filter()
  }

  function check(id, type) {
    freeze()
    $.post(
      global['url'],
      { action: 'check', id: id, type: type, filter: checkFilter() },
      (response, status) => {
        checkResult(response, status).then(data => {
          petList.html(data['html'])
        }, () => { })
      }
    )
  }

  function addPet() {
    ibtn.show()
    ebtn.hide()
    insertPet.modal('show')
    clearInputSet(pet)
    switch(global['tabber'][0]) {
      case 0: 
        pet['sex0'].prop('checked', true)
        $("#pet-breeder").prop('checked', true)
      break;
      case 1: 
        pet['sex1'].prop('checked', true)
        $("#pet-breeder").prop('checked', true)
      break;
      case 2: 
        pet['sex0'].prop('checked', true)
        $("#pet-breeder").prop('checked', false)
      break;
    }
    $("#parent-m").val('')
    $("#parent-f").val('')
    petPreview.attr('src', thumbnail)
  }

  function insertPetSubmit() {
    freeze()
    uploader('pet').then(imageUrl => {
      $.post(
        global['url'],
        { action: 'insertpet', data: checkPetData(), filter: checkFilter(), tabber: global['tabber'], image: imageUrl },
        (response, status) => {
          checkResult(response, status).then(data => {
            uploaded['pet']
            petList.html(data['html'])
            clearInputSet(pet)
            file = false
            filename = ''
            $("#parent-m").val('')
            $("#parent-f").val('')
            $("#pet-breeder").prop('checked', true)
            petPreview.val('')
            remind = JSON.parse(data['remind'])
            insertPet.modal('hide')
          }, () => { })
        }
      )
    })
  }

  function clearInputSet(dataSet) {
    for (const dataKey in dataSet) {
      if (dataSet.hasOwnProperty(dataKey)) {
        dataSet[dataKey].val('')
      }
    }
  }

  function checkInputSet(dataSet) {
    var data = {}

    for (const dataKey in dataSet) {
      if (dataSet.hasOwnProperty(dataKey)) {
        const cell = dataSet[dataKey];

        data[dataKey] = cell.val()
      }
    }

    return data
  }

  function parseInputSet(dataSet, inputSet) {
    for (const dataKey in dataSet) {
      if (dataSet.hasOwnProperty(dataKey)) {
        inputSet[dataKey].val(dataSet[dataKey])
      }
    }
  }


  function editUser(id) {
    freeze()
    $.post(
      global['url'],
      {action: 'getuser', id: id},
      (response, status) => {
        checkResult(response, status).then(data => {
          global['id'] = id
          parseInputSet(data['data'], user)
          var index = searchPosition(data['more']['al1'])
          var index2 = searchPosition2(index, data['more']['al2'])
          $("#al1").val(index)
          $("#al2" + index).val(index2)
          var image = new Image()
          image.src = data['image']
          image.addEventListener('load', (e) => {
            userPreview.attr('src', image.src)
          })
          insertUser.modal('show')
        }, () => {})
      }
    )
  }

  function editUserSubmit(e) {
    e.preventDefault()
    freeze()
    if (data = checkEdit()) {
      uploader('user').then((imageUrl) => {
        $.post(
          global['url'],
          {action: 'edituser', data: data, image: imageUrl, id: global['id']},
          (response, status) => {
            checkResult(response, status).then(data => {
              uploaded['user']
              deleteImage(data['image']).then(() => {
                window.location.reload()
              })
            }, () => {})
          }
        )
      })
    }
  }

  function searchPosition(area = '') {
    result = 0
    position.forEach((item, index) => {
      if (item['name'] == area) {
        result = index
      }
    })
    return result
  }

  function searchPosition2(areaname, district = '') {
    if (areaname < 0) {
      areaname = 0
    }
    result = 0
    position[areaname]['district'].forEach((item, index) => {
      if (item == district) {
        result = index
      }
    })
    return result
  }

  function checkEdit() {
    $("#user-error").text('')
    var check = true
    var data = checkInputSet(user)
    for (const row in data) {
      if (data.hasOwnProperty(row)) {
        if (!data[row].trim().length) {
          $("#user-error").text('Các trường không được bỏ trống')
          defreeze()
          return false
        }
      }
    }

    data['a1'] = position[al1.val()]['name']
    data['a2'] = position[al1.val()]['district'][$("#al2" + al1.val()).val()]
    data['a3'] = al3.val()

    return data
  }

  function insertDiseaseSuggestSubmit() {
    freeze()
    $.post(
      global['url'],
      { action: 'insert-disease-suggest', disease: $('#disease-suggest').val() },
      (response, status) => {
        checkResult(response, status).then(data => {
          insertDiseaseSuggest.modal('hide')
          vaccine['type'].html(data['html'])
        }, () => { })
      }
    )
  }

  function addDiseaseSuggest() {
    insertDiseaseSuggest.modal('show')
  }

  function checkDiseaseData() {
    return {
      treat: diseaseTreat.val(),
      treated: diseaseTreated.val(),
      disease: diseaseDisease.val(),
      note: diseaseNote.val(),
    }
  }

  function checkVaccineData() {
    var type = vaccine['type'].val().split('-')
    return {
      type: type['0'],
      val: type['1'],
      time: vaccine['time'].val(),
      recall: vaccine['recall'].val()
    }
  }

  function parentToggle(id) {
    $(".i" + id).fadeToggle()
  }

  function uploader(name) {
    return new Promise(resolve => {
      if (!uploaded[name] || !uploaded[name]['file']) {
        resolve('')
      }
      else if (uploaded[name]['url']) {
        resolve(uploaded[name]['url'])
      }
      else {
        var uploadTask = storageRef.child('images/' + uploaded[name]['filename'] + '?t=' + new Date().getTime() / 1000).putString(uploaded[name]['file'], 'base64', metadata);
        uploadTask.on(firebase.storage.TaskEvent.STATE_CHANGED, // or 'state_changed'
          function(snapshot) {
            var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
            console.log('Upload is ' + progress + '% done');
            switch (snapshot.state) {
              case firebase.storage.TaskState.PAUSED: // or 'paused'
                console.log('Upload is paused');
                break;
              case firebase.storage.TaskState.RUNNING: // or 'running'
                console.log('Upload is running');
                break;
            }
          }, function(error) {
            resolve('')
            switch (error.code) {
              case 'storage/unauthorized':
                // User doesn't have permission to access the object
              break;
              case 'storage/canceled':
                // User canceled the upload
              break;
              case 'storage/unknown':
                // Unknown error occurred, inspect error.serverResponse
              break;
            }
          }, function() {
            // Upload completed successfully, now we can get the download URL
            uploadTask.snapshot.ref.getDownloadURL().then(function(downloadURL) {
            uploaded[name]['url'] = downloadURL
            resolve(downloadURL)
            console.log('File available at', downloadURL);
          });
        });
      }
    })
	}
</script>
<!-- END: main -->