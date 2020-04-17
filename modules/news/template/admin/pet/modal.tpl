<!-- BEGIN: main -->
<!-- <div id="modal-parent" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <div style="clear: both;"></div>
          <div class="row">
            <div class="col-sm-12">
              <div class="input-group">
                <input type="text" class="form-control" id="parent-key" placeholder="Người dùng theo số điện thoại">
                <div class="input-group-btn">
                  <button class="btn btn-info" onclick="parentFilter()">
                    Tìm kiếm
                  </button>
                </div>
              </div>
              <div id="parent-list" style="max-height: 400px; overflow-y: scroll;">

              </div>
            </div>
            <div class="col-sm-12">
              <div class="input-group">
                <input type="text" class="form-control" id="pet-key" placeholder="Tên, giống loài thú cưng">
                <div class="input-group-btn">
                  <button class="btn btn-info" onclick="petFilter()">
                    Tìm kiếm
                  </button>
                </div>
              </div>
              <div id="pet-list" style="max-height: 400px; overflow-y: scroll;">

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div> -->

<div id="modal-ceti" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-body text-center">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <p>
          Nhập số tiền thu?
        </p>
        <input type="text" class="form-control" id="ceti-price">
        <button class="btn btn-info" onclick="cetiSubmit()">
          Lưu
        </button>
        <button class="btn btn-danger" onclick="removeCetiSubmit()">
          Xóa
        </button>
      </div>
    </div>
  </div>
</div>

<div id="modal-owner" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="text-center">
          <p>
            Chọn chủ cho thú cưng
          </p>
          <div class="input-group">
            <input type="text" class="form-control" id="owner-key" placeholder="Số điện thoại">
            <div class="input-group-btn">
              <button class="btn btn-success" onclick="insertUser()"> <span class="glyphicon glyphicon-plus"> </span>
              </button>
            </div>
          </div>

          <button class="btn btn-info" onclick="filterOwner()">
            Tìm kiếm
          </button>
        </div>
        <div id="owner-list" style="max-height: 400px; overflow-y: scroll;">

        </div>
      </div>
    </div>
  </div>
</div>

<div id="insert-user" class="modal fade" role="dialog">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-body text-center">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <p>
          Chỉnh sửa thông tin
        </p>
        <form onsubmit="insertUserSubmit(event)">
          <div class="row">
            <label>
              <div class="col-sm-8">
                Tên đăng nhập
              </div>
              <div class="col-sm-16">
                <input type="text" class="form-control" id="username" autocomplete="off">
              </div>
            </label>
          </div>

          <div class="row">
            <label>
              <div class="col-sm-8">
                Họ và tên
              </div>
              <div class="col-sm-16">
                <input type="text" class="form-control" id="fullname" autocomplete="off">
              </div>
            </label>
          </div>

          <div class="row">
            <label>
              <div class="col-sm-8">
                Số CMND
              </div>
              <div class="col-sm-16">
                <input type="text" class="form-control" id="politic" autocomplete="off">
              </div>
            </label>
          </div>

          <div class="row">
            <label>
              <div class="col-sm-8">
                Điện thoại
              </div>
              <div class="col-sm-16">
                <input type="text" class="form-control" id="phone" autocomplete="off">
              </div>
            </label>
          </div>

          <div class="row">
            <label>
              <div class="col-sm-8">
                Tỉnh
              </div>
              <div class="col-sm-16">
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
              <div class="col-sm-8">
                Quận/Huyện/Thành phố
              </div>
              <div class="col-sm-16">
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
              <div class="col-sm-8">
                Xã/Phường/Thị trấn
              </div>
              <div class="col-sm-16">
                <input type="text" class="form-control" id="al3" autocomplete="off">
              </div>
            </label>
          </div>

          <div class="row">
            <label>
              <div class="col-sm-8">
                Địa chỉ
              </div>
              <div class="col-sm-16">
                <input type="text" class="form-control" id="address" autocomplete="off">
              </div>
            </label>
          </div>

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

<div id="insert-pet" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <p class="text-center"> <b> </b> </p>

        <label class="row">
          <div class="col-sm-6">
            Tên thú cưng
          </div>
          <div class="col-sm-18">
            <input type="text" class="form-control" id="pet-name">
          </div>
        </label>

        <label class="row">
          <div class="col-sm-6">
            Ngày sinh
          </div>
          <div class="col-sm-18">
            <input type="text" class="form-control" id="pet-dob" value="{today}">
          </div>
        </label>

        <label class="row">
          <div class="col-sm-6">
            Giống
          </div>
          <div class="col-sm-18 relative">
            <input type="text" class="form-control" id="species">
            <div class="suggest" id="species-suggest"></div>
          </div>
        </label>

        <label class="row">
          <div class="col-sm-6">
            Loài
          </div>
          <div class="col-sm-18 relative">
            <input type="text" class="form-control" id="breed-pet">
            <div class="suggest" id="breed-suggest-pet"></div>
          </div>
        </label>

        <label class="row">
          <div class="col-sm-6">
            Giới tính
          </div>
          <div class="col-sm-18">
            <label>
              <input type="radio" name="sex" id="pet-sex-0" checked> Đực
            </label>
            <label>
              <input type="radio" name="sex" id="pet-sex-1"> Cái
            </label>
          </div>
        </label>

        <label class="row">
          <div class="col-sm-6">
            Màu sắc
          </div>
          <div class="col-sm-18">
            <input type="text" class="form-control" id="pet-color">
          </div>
        </label>

        <label class="row">
          <div class="col-sm-6">
            Microchip
          </div>
          <div class="col-sm-18">
            <input type="text" class="form-control" id="pet-microchip">
          </div>
        </label>

        <label class="row">
          <div class="col-sm-6">
            Xăm tai
          </div>
          <div class="col-sm-18">
            <input type="text" class="form-control" id="pet-miear">
          </div>
        </label>

        <label class="row">
          <div class="col-sm-6">
            Xuất xứ
          </div>
          <div class="col-sm-18">
            <input type="text" class="form-control" id="origin-pet">
          </div>
        </label>

        <div class="row" id="pet-parent-m">
          <div class="col-sm-12">
            Chó cha
            <div class="relative">
              <div class="input-group">
                <input class="form-control" id="parent-m" type="text" autocomplete="off">
                <input class="form-control" id="parent-m-s" type="hidden">
                <div class="input-group-btn">
                  <button class="btn btn-success" style="min-height: 32px;" onclick="addParent('m')">
                    <span class="glyphicon glyphicon-plus"></span>
                  </button>
                </div>
              </div>
              <div class="suggest" id="parent-suggest-m"></div>
            </div>
          </div>

          <div class="col-sm-12" id="pet-parent-f">
            Chó mẹ
            <div class="relative">
              <div class="input-group">
                <input class="form-control" id="parent-f" type="text" autocomplete="off">
                <input class="form-control" id="parent-f-s" type="hidden">
                <div class="input-group-btn relative">
                  <button class="btn btn-success" style="min-height: 32px;" onclick="addParent('f')">
                    <span class="glyphicon glyphicon-plus"></span>
                  </button>
                </div>
              </div>
              <div class="suggest" id="parent-suggest-f"></div>
            </div>
          </div>
        </div>

        <label class="row">
          <div class="col-sm-6">
            Hình ảnh
          </div>
          <div class="col-sm-18">
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
          <div class="col-sm-6">
            Tên thú cưng
          </div>
          <div class="col-sm-18">
            <input type="text" class="form-control" id="parent-name">
          </div>
        </label>

        <label class="row">
          <div class="col-sm-6">
            Ngày sinh
          </div>
          <div class="col-sm-18">
            <input type="text" class="form-control" id="parent-dob">
          </div>
        </label>

        <label class="row">
          <div class="col-sm-6">
            Giống
          </div>
          <div class="col-sm-18 relative">
            <input type="text" class="form-control" id="species-parent">
            <div class="suggest" id="species-parent-suggest"></div>
          </div>
        </label>

        <label class="row">
          <div class="col-sm-6">
            Loài
          </div>
          <div class="col-sm-18 relative">
            <input type="text" class="form-control" id="breed-parent">
            <div class="suggest" id="breed-suggest-parent"></div>
          </div>
        </label>

        <label class="row">
          <div class="col-sm-6">
            Giới tính
          </div>
          <div class="col-sm-18">
            <label>
              <input type="radio" name="psex" id="parent-sex-0" checked> Đực
            </label>
            <label>
              <input type="radio" name="psex" id="parent-sex-1"> Cái
            </label>
          </div>
        </label>

        <label class="row">
          <div class="col-sm-6">
            Màu sắc
          </div>
          <div class="col-sm-18">
            <input type="text" class="form-control" id="parent-color">
          </div>
        </label>

        <label class="row">
          <div class="col-sm-6">
            Microchip
          </div>
          <div class="col-sm-18">
            <input type="text" class="form-control" id="parent-microchip">
          </div>
        </label>

        <label class="row">
          <div class="col-sm-6">
            Xăm tai
          </div>
          <div class="col-sm-18">
            <input type="text" class="form-control" id="parent-miear">
          </div>
        </label>

        <label class="row">
          <div class="col-sm-6">
            Hình ảnh
          </div>
          <div class="col-sm-18">
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
<!-- END: main -->