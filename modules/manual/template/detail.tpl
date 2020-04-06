<!-- BEGIN: main -->
<div class="container">
  <div id="msgshow"></div>
  <a href="/">
    <img src="/themes/default/images/banner.png" style="float: left; width: 200px;">
  </a>
  <div style="float: right;">
    {FILE "heading.tpl"}
  </div>
  <div style="clear: right;"></div>
  <div style="clear: both;"></div>

  <div class="row">
    <div class="col-sm-3">
      <!-- BEGIN: menu -->
      <a href="/{module_name}/{cat}/{alias}-{id}.html"> {title} </a>
      <hr>
      <!-- END: menu -->
    </div>
    <div class="col-sm-9">
      <div id="content">
        {content}
      </div>
    </div>
  </div>

</div>
<!-- END: main -->
