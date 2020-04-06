<!-- BEGIN: main -->
<style>
  .form-group { clear: both; }
  .vetleft, .vetright { position: absolute; top: 0px; width: 135px; text-align: center; }
  .vetleft { left: 0px; }
  .vetright { right: 0px; }
  .vetleft img, .vetright img {
    width: 75px !important;
  }

  @media screen and (max-width: 992px) {
    .vetleft, .vetright { position: unset; display: inline-block; width: 100%; }
  }

  @media screen and (max-width: 768px) {
    .checkbox input[type=checkbox] {
      position: inherit;
      margin-left: inherit;
    }
  }
  @media screen and (max-width: 600px) {
    .vetleft img, .vetright img { width: 50px !important; }
    .hideout {
      display: none;
    }
  }
</style>
<div class="container" style="margin-top: 20px;">
  <div id="msgshow"></div>
  <div style="float: right;">
    {FILE "heading.tpl"}
  </div>
  <div style="clear: right;"></div>
  <form style="width: 60%; float: right;">
    <label class="input-group">
      <input type="hidden" name="nv" value="biograph">
      <input type="hidden" name="op" value="list">
      <input type="text" class="form-control" name="keyword" value="{keyword}" id="keyword" placeholder="Nhập tên hoặc mã số">
      <div class="input-group-btn">
        <button class="btn btn-info"> Tìm kiếm </button>
      </div>
    </label>
  </form>
  <a href="/">
    <img src="/themes/default/images/banner.png" style="float: left; width: 200px;">
  </a>
  <div style="clear: both;"></div>

  <!-- <div style="position: fixed; background: red; width: 100px; height: 100px;"></div>
  <div style="position: fixed; background: blue; right: calc(25% - 125px); width: 100px; height: 100px;"></div> -->

  <div id="content" style="position: relative;">
    <div class="vetleft">
      <img src="/assets/images/5.jpg">
      <img src="/assets/images/1.jpg">
      <img src="/assets/images/3.jpg">
      <img src="/assets/images/4.jpg">
      <img src="/assets/images/9.jpg">
      <img src="/assets/images/2.jpg">
      <p style="font-weight: bold; margin: 14px; font-size: 1.25em; color: deepskyblue; text-shadow: 2px 2px 6px;">LỄ HỘI THÚ CƯNG ĐẮK LẮK 2019</p>
    </div>
    <div>
      <div style="max-width: 500px; margin: auto; border: 1px solid lightgray; border-radius: 10px; padding: 10px 10px 10px 10px;">
        <div class="text-center"> Mẫu đăng ký </div>
        <div class="form-group">
          <label class="label-control"> Tên người đăng ký </label>
          <div>
            <input type="text" class="form-control" id="signup-name">
          </div>
        </div>
        <div class="form-group">
          <label class="label-control"> Tên thú cưng </label>
          <div>
            <input type="text" class="form-control" id="signup-petname">
          </div>
        </div>
        <div class="form-group">
          <label class="label-control"> Giống loài </label>
          <div class="relative">
            <input type="text" class="form-control" id="signup-species">
            <div class="suggest" id="signup-species-suggest"></div>
          </div>
        </div>
        <div class="form-group">
          <label class="label-control"> Địa chỉ </label>
          <div>
            <input type="text" class="form-control" id="signup-address">
          </div>
        </div>
        <div class="form-group">
          <label class="label-control"> Số điện thoại </label>
          <div>
            <input type="text" class="form-control" id="signup-mobile">
          </div>
        </div>
        <div class="form-group">
          <label class="label-control"> Hạng mục đăng ký </label>
          <div class="checkbox">
            <!-- BEGIN: test -->
            <label style="margin-right: 10px; width: 100%;"> <input type="checkbox" name="test" index="{id}"> {name} </label>
            <!-- END: test -->
          </div>
        </div>
        <div style="clear: both;"></div>
        <div class="text-center">
          <button class="btn btn-success" onclick="signupPresubmit()">
            Đăng ký
          </button>
        </div>
      </div>
      <div></div>
    </div>
    <div class="vetright">
      <img src="/assets/images/6.jpg">
      <img src="/assets/images/7.jpg">
      <img src="/assets/images/8.jpg">
      <img src="/assets/images/10.jpg">
      <img src="/assets/images/1.jpg">
      <img src="/assets/images/2.jpg">
      <p style="font-weight: bold; margin: 14px; font-size: 1.25em; color: deepskyblue; text-shadow: 2px 2px 6px;">LỄ HỘI THÚ CƯNG ĐẮK LẮK 2019</p>
    </div>
    <br>
    <!-- BEGIN: list -->
      <div style="max-width: 700px; margin: auto; border: 1px solid lightgray; border-radius: 10px; padding: 10px 10px 60px 10px;">
        <p>
          Danh sách những người đã đăng ký
        </p>
        <br>
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
          {confirm_list}
        </div>
      </div>
    <!-- END: list -->
  </div>
</div>

<div class="modal" id="modal-presignup" role="dialog">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-body">
        <div type="button" class="close" data-dismiss="modal"> &times; </div> <br>
        
        <div class="text-center">
          <p> Xác nhận thông tin đăng ký </p>
          <p> Sau khi xác nhận, thông tin dưới đây sẽ không thể thay đổi </p>
          <button class="btn btn-info" onclick="signupSubmit()">
            Xác nhận đăng ký
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  var global = {
    'species': JSON.parse('{species}'),
    'page': 1,
  }

  $(document).ready(() => {
    installSuggest('signup', 'species')
  })

  function checkFilter() {
    limit = $("#filter-limit")
    if (!(limit > 10)) limit = 10

    contest = []
    $(".filter-contest").each((index, item) => {
      if (item.checked) contest.push(item.getAttribute('index'))
    })
    
    return {
      page: global['page'],
      limit: limit,
      species: $("#filter-species").val(),
      contest: contest
    }
  }

  function signupPresubmit() {
    data = checkSignupData()
    if (!data['name']) {
      alert_msg(data)
    }
    else {
      $("#modal-presignup").modal('show')
    }
  }

  function checkSignupData() {
    test = []
    name = $("#signup-name").val()
    petname = $("#signup-petname").val()
    address = $("#signup-address").val()
    mobile = $("#signup-mobile").val()
    species = $("#signup-species").val()
    if (!name.length) return 'Tên người/đơn vị không được để trống'
    if (!petname.length) return 'Tên thú cưng không được để trống'
    if (!species.length) return 'Giống loài không được để trống'
    if (!address.length) return 'Địa chỉ không được để trống'
    if (!mobile.length) return 'Số điện thoại không được để trống'
    $("[name=test]").each((index, item) => {
      indexkey = item.getAttribute('index')
      if (item.checked) test.push(indexkey)
    })
    if (!test.length) return 'Chọn ít nhất 1 phần thi'
    return {
      name: name,
      petname: petname,
      species: species,
      address: address,
      mobile: mobile,
      test: test
    }
  }

  function signupSubmit() {
    data = checkSignupData()
    if (!data['name']) {
      alert_msg(data)
    }
    else {
      $.post(
        '',
        { action: 'signup', data: data },
        (response, status) => {
          checkResult(response, status).then(data => {
            $("#modal-presignup").modal('hide')
            $("#signup-name").val('')
            $("#signup-petname").val('')
            $("#signup-species").val('')
            $("#signup-address").val('')
            $("#signup-mobile").val('')
            $("[name=test]").each((index, item) => {
              item.checked = false
            })
          })
        }
      )
    }
  }

  function confirmList() {
    $("#confirm-modal").modal('show')
  }

  function goPage(page) {
    global['page'] = page
    $.post(
      '',
      { action: 'filter', filter: checkFilter(), page: global['page'] },
      (response, status) => {
        checkResult(response, status).then(data => {
          $('#confirm-content').html(data['html'])
        })
      }
    )
  }

  function selectKey(name, type, key) {
    input = $("#"+ name +"-"+ type)
    input.val(key)
  }

  function installSuggest(name, type) {
    input = $("#"+ name +"-"+ type)
    suggest = $("#"+ name +"-"+ type + "-suggest")
    
    input.keyup((e) => {
      keyword = e.currentTarget.value.toLowerCase()
      html = ''
      count = 0

      global[type].forEach(item => {
        if (count < 30 && item.toLowerCase().search(keyword) >= 0) {
          count ++
          html += `
            <div class="suggest-item" onclick="selectKey('`+ name +`', '`+ type +`', '`+ item +`')">
              `+ item +`
            </div>`
        }
      })
      
      if (!html.length) {
        html = 'Không có kết quả'
      }
      
      suggest.html(html)
    })
    input.focus(() => {
      suggest.show()
    })
    input.blur(() => {
      setTimeout(() => {
        suggest.hide()
      }, 300);
    })
  }

</script>
<!-- END: main -->
