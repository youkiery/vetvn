<!-- BEGIN: main -->
<div id="pet-vaccine" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body text-center">
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

        <button class="btn btn-success" id="btn-vaccine-insert" onclick="insertVaccineSubmit()">
          Thêm lịch tiêm phòng
        </button>
        <button class="btn btn-success" id="btn-vaccine-edit" onclick="editVaccineSubmit()">
          Sửa lịch tiêm phòng
        </button>
        <button class="btn btn-success" id="btn-vaccine-recall" onclick="recallSubmit()">
          Nhắc lại
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
          <input type="text" class="form-control" id="disease-suggest" autocomplete="off">
        </label>

        <div class="text-center">
          <button class="btn btn-success" onclick="insertDiseaseSuggestSubmit()">
            Thêm lịch sử bệnh
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="insert-disease" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <label class="form-group">
          Ngày bệnh
          <input type="text" class="form-control" id="disease-treat" autocomplete="off">
        </label>

        <label class="form-group">
          Ngày điều trị
          <input type="text" class="form-control" id="disease-treated" autocomplete="off">
        </label>

        <label class="form-group">
          Loại bệnh
          <div class="relative">
            <input type="text" class="form-control" id="disease-disease" autocomplete="off">
            <div class="suggest" id="disease-suggest-disease"></div>
          </div>
        </label>

        <label class="form-group">
          Ghi chú
          <input type="text" class="form-control" id="disease-note" autocomplete="off">
        </label>

        <div class="text-center">
          <button class="btn btn-success" id="btn-disease-insert" onclick="insertDiseaseSubmit()">
            Thêm lịch sử bệnh
          </button>
          <button class="btn btn-success" id="btn-disease-edit" onclick="editDiseaseSubmit()">
            Sửa lịch sử bệnh
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="insert-breeder" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <p> Thêm lịch phối giống </p>
        <label class="form-group">
          Ngày phối giống
          <input type="text" class="form-control" id="breeder-time" value="{today}" autocomplete="off">
        </label>

        <label class="form-group relative">
          Đối tượng phối
          <div class="input-group">
            <input type="text" class="form-control" id="breeder-target" autocomplete="off">
            <input type="hidden" id="breeder-targetid">
            <div class="input-group-btn">
              <button class="btn btn-success" onclick="addTarget()">
                <span class="glyphicon glyphicon-plus"></span>
              </button>
            </div>
          </div>
          <div class="suggest" id="breeder-suggest-target"></div>
        </label>

        <label class="form-group relative">
          Số lượng con dự đoán
          <input type="number" class="form-control" id="breeder-number" value="1" autocomplete="off">
        </label>

        <!-- <div id="breeder-child"></div> -->
        <!-- <button class="btn btn-success" onclick="addChild()">
          <span class="glyphicon glyphicon-plus"></span>
        </button> -->

        <label class="form-group">
          Ghi chú
          <input type="text" class="form-control" id="breeder-note" autocomplete="off">
        </label>

        <div class="text-center">
          <button class="btn btn-success" id="btn-breeder-insert" onclick="insertBreederSubmit()">
            Thêm lịch phối giống
          </button>
          <button class="btn btn-success" id="btn-breeder-edit" onclick="editBreederSubmit()">
            Sửa lịch phối giống
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="modal-target" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
          <p class="text-center"> <b> Thêm thú cưng </b> </p>
          <label class="row">
            <div class="col-sm-3">
              Chủ thú cưng
            </div>
            <div class="col-sm-9 relative">
              <div class="input-group">
                <input type="text" class="form-control" id="owner" autocomplete="off">
                <div class="input-group-btn">
                  <button class="btn btn-success" onclick="addOwner()">
                    <span class="glyphicon glyphicon-plus"></span>
                  </button>
                </div>
              </div>
              <div class="suggest" id="owner-suggest"></div>
            </div>
          </label>

          <label class="row">
            <div class="col-sm-3">
              Tên thú cưng
            </div>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="pet-name" autocomplete="off">
            </div>
          </label>

          <label class="row">
            <div class="col-sm-3">
              Ngày sinh
            </div>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="pet-dob" value="{today}" autocomplete="off">
            </div>
          </label>

          <label class="row">
            <div class="col-sm-3">
              Giống
            </div>
            <div class="col-sm-9 relative">
              <input type="text" class="form-control" id="species" autocomplete="off">
              <div class="suggest" id="species-suggest"></div>
            </div>
          </label>

          <label class="row">
            <div class="col-sm-3">
              Loài
            </div>
            <div class="col-sm-9 relative">
              <input type="text" class="form-control" id="breed-pet" autocomplete="off">
              <div class="suggest" id="breed-suggest-pet"></div>
            </div>
          </label>

          <label class="row">
            <div class="col-sm-3">
              Giới tính
            </div>
            <div class="col-sm-9">
              <label>
                <input type="radio" name="sex2" id="pet-sex-0" checked> Đực
              </label>
              <label>
                <input type="radio" name="sex2" id="pet-sex-1"> Cái
              </label>
            </div>
          </label>

          <label class="row">
            <div class="col-sm-3">
              Màu sắc
            </div>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="pet-color" autocomplete="off">
            </div>
          </label>

          <label class="row">
            <div class="col-sm-3">
              Microchip
            </div>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="pet-microchip" autocomplete="off">
            </div>
          </label>

          <label class="row">
            <div class="col-sm-3">
              Xăm tai
            </div>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="pet-miear" autocomplete="off">
            </div>
          </label>

          <label class="row">
            <div class="col-sm-3">
              Xuất xứ
            </div>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="origin-pet" autocomplete="off">
            </div>
          </label>

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
          </div>
      </div>
    </div>
  </div>
</div>

<div id="modal-owner" class="modal fade" role="dialog">
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

        <div class="text-center">
          <button class="btn btn-success" onclick="insertOwnerSubmit()">
            Thêm khách hàng
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- END: main -->