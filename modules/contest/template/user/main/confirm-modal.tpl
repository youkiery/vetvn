<!-- BEGIN: main -->
<div class="modal" id="confirm-modal" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-body">
        <div type="button" class="close" data-dismiss="modal"> &times; </div> <br><br>
        <div class="form-group form-inline">
          <div class="input-group">
            <input type="text" class="form-control" id="filter-limit" value="10">
            <div class="input-group-btn">
              <button class="btn btn-info" onclick="goPage(1)">
                Hiển thị
              </button>
            </div>
          </div>
          <select class="form-control" id="filter-species">
            <option value="0" checked> Toàn bộ </option>
            <!-- BEGIN: species -->
            <option value="{id}" checked> {species} </option>
            <!-- END: species -->
          </select>
        </div>
        <div class="form-group form-inline">
          Danh sách phần thi
          <!-- BEGIN: contest -->
          <label class="checkbox" style="margin-right: 10px"> <input type="checkbox" class="filter-contest" index="{id}" checked> {contest} </label>
          <!-- END: contest -->
        </div>
        <div class="form-group text-center">
          <button class="btn btn-info" onclick="goPage(1)">
            Lọc danh sách
          </button>
        </div>
        
        <div id="confirm-content">
          {content}
        </div>
      </div>
    </div>
  </div>
</div>
<!-- END: main -->
