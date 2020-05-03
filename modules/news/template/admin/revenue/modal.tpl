<!-- BEGIN: main -->
<div id="modal-parent" class="modal fade" role="dialog">
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
            <div id="parent-list" style="max-height: 400px; overflow-y: scroll;"> </div>
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
            <div id="pet-list" style="max-height: 400px; overflow-y: scroll;"> </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="modal-ceti" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-body text-center">
        <div class="form-group">
          Nhập số tiền thu?
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="text-center">
          <div class="form-group">
            <input type="text" class="form-control" id="ceti-price" placeholder="Số tiền">
          </div>
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
</div>

<div id="modal-statistic" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body text-center">
        <form class="row">
          <div class="col-sm-6">
            <input type="text" class="form-control" id="filter-from">
          </div>
          <div class="col-sm-6">
            <input type="text" class="form-control" id="filter-end">
          </div>
          <button class="btn btn-info" onclick="viewStatistic(event)">
            Lọc theo thời gian
          </button>
        </form>

        <div id="statistic">
          {statistic}
        </div>

      </div>
    </div>
  </div>
</div>

<div id="modal-remove-pay" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-body text-center">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <p>
          Xác nhận xóa?
        </p>
        <button class="btn btn-danger" onclick="removePaySubmit()">
          Xóa
        </button>
      </div>
    </div>
  </div>
</div>

<div id="modal-pay" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-body text-center">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <p>
          Nhập phiếc chi?
        </p>
        <select class="form-control" id="pay-user">
          <!-- BEGIN: user -->
          <option value="{userid}">{username}</option>
          <!-- END: user -->
        </select>
        <input type="text" class="form-control" id="pay-price" placeholder="Số tiền">
        <textarea class="form-control" id="pay-content" rows="3"></textarea>
        <button class="btn btn-info" onclick="paySubmit()">
          Lưu
        </button>
      </div>
    </div>
  </div>
</div>

<!-- END: main -->