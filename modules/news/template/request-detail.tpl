<!-- BEGIN: main -->
<div>
  <!-- BEGIN: row -->
  <div style="float: left;">
    {title}
  </div>
  <div style="float: right; width: 150px;">
    <!-- BEGIN: request -->
    <button class="btn btn-info" onclick="requestSubmit({id}, {type}, 1)">
      yêu cầu
    </button>
    <!-- END: request -->
    <!-- BEGIN: rerequest -->
    <button class="btn btn-warning" onclick="requestSubmit({id}, {type}, 1)">
      yêu cầu lại
    </button>
    <!-- END: rerequest -->
    <!-- BEGIN: cancel -->
    <button class="btn btn-danger" onclick="cancelSubmit({id}, {type}, 1)">
      hủy
    </button>
    <!-- END: cancel -->
  </div>
  <div style="clear: both;"></div>
  <hr>
  <!-- END: row -->
  <!-- BEGIN: row2 -->
  <div style="float: left;">
    {title}
  </div>
  <div style="float: right; width: 150px;">
    <!-- BEGIN: rerequest2 -->
    <button class="btn btn-warning" onclick="requestSubmit({id}, {type}, 2)">
      yêu cầu lại
    </button>
    <!-- END: rerequest2 -->
    <!-- BEGIN: cancel2 -->
    <button class="btn btn-danger" onclick="cancelSubmit({id}, {type}, 2)">
      hủy
    </button>
    <!-- END: cancel2 -->
  </div>
  <div style="clear: both;"></div>
  <hr>
  <!-- END: row2 -->
</div>
<!-- END: main -->
