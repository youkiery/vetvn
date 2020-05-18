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
          <div class="col-3"> Chủ tài khoản </div>
          <div class="col-9">
            <div class="relative">
              <input type="text" class="form-control" id="petuser">
              <div class="suggest" id="petuser-suggest"></div>
            </div>
          </div>
        </div>
        <div class="xxx rows" style="font-size: 0.8em;">
          <div class="col-3"> </div>
          <div class="col-3">
            Họ tên: <span id="petuser-name"></span>
          </div>
          <div class="col-4">
            SĐT: <span id="petuser-mobile"></span>
          </div>
          <div class="col-2" style="text-align: right;">
            <button class="btn btn-danger" style="min-height: 32px;" onclick="clearUser('petuser')">
              <span class="glyphicon glyphicon-remove"></span>
            </button>
          </div>
        </div>
        <div class="text-red" id="petuser-error"></div>

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

        <div class="text-center form-group" style="overflow: auto; width: fit-content; margin: auto;">
          <span id="image-list"></span>
          <label class="text-center image-box">
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
<!-- END: main -->