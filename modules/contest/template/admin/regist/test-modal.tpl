<!-- BEGIN: main -->
<div class="modal" id="modal-test" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <div type="button" class="close" data-dismiss="modal"> &times; </div> <br><br>
        
        <div class="input-group form-group">
          <input type="text" class="form-control" id="test-input" placeholder="Thêm phần thi mới">
          <div class="input-group-btn">
            <button class="btn btn-success" onclick="testInsertSubmit()">
              <span class="glyphicon glyphicon-plus"></span>
            </button>
          </div>
        </div>
        <div id="test-content">
          {content}
        </div>
        <div class="text-center">
          <button class="btn btn-success" onclick="updateTestAllSubmit()">
            Cập nhật toàn bộ
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- END: main -->
