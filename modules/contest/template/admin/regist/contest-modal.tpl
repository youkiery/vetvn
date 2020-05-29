<!-- BEGIN: main -->
<div class="modal" id="modal-contest" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <div type="button" class="close" data-dismiss="modal"> &times; </div> <br><br>
        
        <div class="form-group">
          <label class="label-control col-4"> Tên người/đơn vị đăng ký </label>
          <div class="col-8">
            <input type="text" class="form-control" id="signup-name">
          </div>
        </div>
        <div class="form-group">
          <label class="label-control col-4"> Tên thú cưng </label>
          <div class="col-8">
            <input type="text" class="form-control" id="signup-petname">
          </div>
        </div>
        <div class="form-group">
          <label class="label-control col-4"> Giống loài </label>
          <div class="col-8 relative">
            <input type="text" class="form-control" id="signup-species">
            <div class="suggest" id="signup-species-suggest"></div>
          </div>
        </div>
        <div class="form-group">
          <label class="label-control col-4"> Địa chỉ </label>
          <div class="col-8">
            <input type="text" class="form-control" id="signup-address">
          </div>
        </div>
        <div class="form-group">
          <label class="label-control col-4"> Số điện thoại </label>
          <div class="col-8">
            <input type="text" class="form-control" id="signup-mobile">
          </div>
        </div>
        <div class="form-group">
          <label class="label-control col-4"> Hạng mục đăng ký </label>
          <div class="col-8 checkbox">
            <!-- BEGIN: test -->
            <label style="margin-right: 10px;"> <input type="checkbox" name="contest" index="{id}"> {name} </label>
            <!-- END: test -->
          </div>
        </div>
        <div class="text-center">
          <button class="btn btn-success" onclick="editSubmit()">
            Đăng ký
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- END: main -->
