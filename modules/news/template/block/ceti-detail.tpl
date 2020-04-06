<!-- BEGIN: main -->
<div class="container">
  <style>
    label { font-weight: normal; }
  </style>
  <div id="msgshow"></div>
  <div id="loading">
    <div class="black-wag"> </div>
    <img class="loading" src="/themes/default/images/loading.gif">
  </div>

  <a href="/">
    <img src="/themes/default/images/banner.png" style="width: 200px;">
  </a>

  <div style="float: right;">
    <a href="/{module_file}/logout"> Đăng xuất </a>
  </div>
  <div style="clear: both;"></div>
  <a style="margin: 8px 0px; display: block;" href="javascript:history.go(-1)">
    <span class="glyphicon glyphicon-chevron-left">  </span> Trở về </a>
  </a>
  <div style="clear: both;"></div>

  <!-- BEGIN: A -->
  <p>
    Thú cưng không tồn tại
  </p>
  <!-- END: A -->
  <!-- BEGIN: B -->
  <div class="row">
    <label>
      font chữ: <input type="text" class="form-control" id="size" value="16" /> <br>
    </label>
    <label>
      Dịch trên: <input type="text" class="form-control" id="top" value="-14" /> <br>
    </label>
    <label>
      Dịch trái: <input type="text" class="form-control" id="left" value="0" /> <br>
    </label>
  </div>
  <div class="text-center">
    <button class="btn btn-info" onclick="printSubmit(0)">  
      Mẫu 1
    </button>
    <button class="btn btn-info" onclick="printSubmit(1)">
      Mẫu 2
    </button>
  </div>
  <div id="content">
    <label>
      Số đăng ký
      <input type="text" class="form-control" id="regno" value="{regno}">
    </label>
    <label>
      Số chip
      <input type="text" class="form-control" id="micro" value="{micro}">
    </label>
    <label>
      Số xăm
      <input type="text" class="form-control" id="tatto" value="{tatto}">
    </label>
    <label>
      Tên
      <input type="text" class="form-control" id="name" value="{name}">
    </label>
    <label>
      Giống
      <input type="text" class="form-control" id="species" value="{species}">
    </label>
    <div>
      <div>
        Giới tính
      </div>
      <label style="width: fit-content; margin: 5px;">
        Đực
        <input type="radio" name="sex" class="sex" id="sex-1" {sex_1}>
      </label>
      <label style="width: fit-content; margin: 5px;">
        <input type="radio" name="sex" class="sex" id="sex-0" {sex_0}>
        Cái
      </label>
    </div>
    <label>
      Ngày sinh
      <input type="text" class="form-control" id="dob" value="{dob}">
    </label>
    <label>
      Kiểu lông
      <input type="text" class="form-control" id="coat" value="{coat}">
    </label>
    <label>
      Màu lông
      <input type="text" class="form-control" id="color" value="{color}">
    </label>
    <label>
      Người nhân giống
      <input type="text" class="form-control" id="breeder" value="{breeder}">
    </label>
    <label>
      Chủ nuôi
      <input type="text" class="form-control" id="owner" value="{owner}">
    </label>
    <table class="table table-bordered">
      <tr>
        <td rowspan="2">
          <label>
            Cha
            <input type="text" class="form-control parent-name" id="pf" value="{pf}">
          </label>
        </td>
        <td>
          <label>
            Ông nội
            <input type="text" class="form-control parent-name" id="f21f" value="{f21f}">
          </label>
        </td>
        <td>
          <label>
            Bố của ông nội
            <input type="text" class="form-control parent-name" id="f31f" value="{f31f}">
          </label>
          <label>
            Mẹ của ông nội
            <input type="text" class="form-control parent-name" id="f31m" value="{f31m}">
          </label>
        </td>
      </tr>
      <tr>
        <td>
          <label>
            Bà nội
            <input type="text" class="form-control parent-name" id="f21m" value="{f21m}">
          </label>
        </td>
        <td>
          <label>
            Bố của bà nội
            <input type="text" class="form-control parent-name" id="f32f" value="{f32f}">
          </label>
          <label>
            Mẹ của bà nội
            <input type="text" class="form-control parent-name" id="f32m" value="{f32m}">
          </label>
        </td>
      </tr>
      <tr>
        <td rowspan="2">
          <label>
            Mẹ
            <input type="text" class="form-control parent-name" id="pm" value="{pm}">
          </label>
        </td>        
        <td>
          <label>
            Ông ngoại
            <input type="text" class="form-control parent-name" id="f22f" value="{f22f}">
          </label>
        </td>
        <td>
          <label>
            Bố của ông ngoại
            <input type="text" class="form-control parent-name" id="f33f" value="{f33f}">
          </label>
          <label>
            Mẹ của ông ngoại
            <input type="text" class="form-control parent-name" id="f33m" value="{f33m}">
          </label>
        </td>
      </tr>
      <tr>
        <td class="2">
          <label>
            Bà ngoại
            <input type="text" class="form-control parent-name" id="f22m" value="{f22m}">
          </label>
        </td>
        <td>
          <label>
            Bố của bà ngoại
            <input type="text" class="form-control parent-name" id="f34f" value="{f34f}">
          </label>
          <label>
            Mẹ của bà ngoại
            <input type="text" class="form-control parent-name" id="f34m" value="{f34m}">
          </label>
        </td>
      </tr>
    </table>
    <label>
      Ngày cấp
      <input type="text" class="form-control" id="issue" value="{issue}">
    </label>
  </div>
  <!-- END: B -->
</div>
<script>
  var braket = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABkAAABrCAYAAACCAympAAAACXBIWXMAAAsTAAALEwEAmpwYAAACEElEQVRoge3YvWtUURDG4SfrR+IHRgyCKKjRWNjYKAbE0sJKKy0sBMXCzsp/QLC3tbRTO2MdiGIjFjaCgouNIOK3RERNNBaTJYVC7ll2luzNfZu7zZkfM3Nm9vBSF63pQYwxtDDXg1j/1QncwY4swFFM4UgWYBKPcQZDGYBxvMZ5venpPxrCLTzEhgwADOM5LmcBYAI/sa7kUKsQcgA/FM5EKaSTSZG6ySQdMoFf2ZD0TIb1oScji9/0TBpIZfW1J6lzUr9yNZBKql9PUuekfuUafEjTk67KNfj/J/WBNFd4ZZZrph+QB6WAbiAz3UCqaAQHca/bAMtl0sJF3McbSzespzqNT2IpXpDgpUziK77gGkZ7GbyFk3gnfJRzEso0JrysBdzA5l4DCLvpMJ6IZk8LGzDFPNsuMvmMWVzKAm3EVbFKPuBYBgS2iJLN4S7WZ4HOill5gf2lh6vurmfCrduJQ1mQt5gX5uZ4FuS76MlabCs4VwT5belR960EUAKZx8fF34/wJwOyIBYltEsAJRDCqiX6kg4pHsYSSOeVUrz2Vyek05PBz6R+5WrmpJKaK7zKyzX4c1K/njTlWmWQvj3u2pIzgZf9gNQnk1fC/yoyDUohs8Jr2ZoJaeO98L5SdR1PsTsTMioMz5vC5FlWpeUi3LxT2IQrXcaorF24jeOZEMKamsK+bNBe7MmGrAz9Bb6uhdIsSdeyAAAAAElFTkSuQmCC'
  var braket2 = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAA8AAABGCAYAAAATgc7uAAAACXBIWXMAAAsTAAALEwEAmpwYAAABoklEQVRYhd3XPWtVQRDG8V9ejOZGUcFCEEQROzux8QU/g5214iew9aPYWQsW1hYiVopYRdDCwiBYGFCTm5g3i9lIhHv33J0jXPSB7c7/PDNzdmfO8l/raFl/aHYC8DTu4WwrfA73sYLlCYx+awmPi2uzbuFJ7YFa2FfwPAtfxHoGnscFDDPwoDin4KWyNjLwInbxMwtvldUMD/rAi9jRI+xeOafhAbb7OG+VF6Tg6RRsUODNrPO25CY5YloF28+5qhrcqXHwYXzPwrN4kYVXRcNvgk/goeieb7vggzqJRyLX2y3gGTwTw+zypNDBsL+KVnsVx1ucFeAuPuGpSKNZd7CHBxl4Bh/wTkyNsRr1nffwBefFn0ETDGtiyKVO1Td8xPusc9W1Bm+Kk5WC1zEn9ngKnulyHwcPi/NCFp7HoQy8UcBUzr3C/isFS+Xcq2DDAqbg/R2W/s7TK9iCZNg/xHlOwWuiAVZH7Th4R0yPFAyfcSoLv8aNmvtcBV7GNVzCSyP+UWrwrrhX3RT3yDctMNFFX+G6KOJKx/MjdUxH8f4h/QK9sWMBLqvhCAAAAABJRU5ErkJggg=='
  var global = [{
    template: `
      <style>
      @page { size: A4 landscape;}
      * { font-size: -font-pt; }
      div { position: absolute; }
      body { margin: 0pt; }
      </style>
      <div style="top: calc(54mm + -t-mm + -t1-mm); left: calc(-4mm + 187mm + -r-mm);">
        name
      </div>
      <div style="top: calc(54mm + -t-mm + -t2-mm); left: calc(-4mm + 205mm + -r-mm);">
        regno
      </div>
      <div style="top: calc(54mm + -t-mm + -t3-mm); left: calc(-4mm + 209mm + -r-mm);">
        micro
      </div>
      <div style="top: calc(54mm + -t-mm + -t4-mm); left: calc(-4mm + 202mm + -r-mm);">
        tatto
      </div>
      <div style="top: calc(54mm + -t-mm + -t5-mm); left: calc(-4mm + 191mm + -r-mm);">
        breed
      </div>
      <div style="top: calc(54mm + -t-mm + -t6-mm); left: calc(-4mm + 212mm + -r-mm);">
        dob
      </div>
      <div style="top: calc(54mm + -t-mm + -t6-mm); left: calc(-4mm + 265mm + -r-mm);">
        sex
      </div>
      <div style="top: calc(54mm + -t-mm + -t7-mm); left: calc(-4mm + 191mm + -r-mm);">
        color
      </div>
      <div style="top: calc(54mm + -t-mm + -t7-mm); left: calc(-4mm + 262mm + -r-mm);">
        coat
      </div>
      <div style="top: calc(54mm + -t-mm + -t8-mm); left: calc(-4mm + 192mm + -r-mm);">
        -pf-
      </div>
      <div style="top: calc(54mm + -t-mm + -t9-mm); left: calc(-4mm + 192mm + -r-mm);">
        -pm-
      </div>
      <div style="top: calc(54mm + -t-mm + -t10-mm); left: calc(-4mm + 219mm + -r-mm);">
        breeder
      </div>
      <div style="top: calc(54mm + -t-mm + -t12-mm); left: calc(-4mm + 198mm + -r-mm);">
        owner
      </div>
      <div style="top: calc(54mm + -t-mm + -t14-mm); left: calc(-4mm + 263mm + -r-mm);">
        issue
      </div>`,
      line: 8.6
    }, 
    {
      template: `<style>
      @page { size: A4 landscape;}
      * { font-size: -font-pt; }
      div { position: absolute; }
      body { margin: 0pt; }
      </style>
      <div style="top: calc(72mm + -t-mm + -t1-mm); left: calc(-4mm + 59mm + -r-mm);">
        regno
      </div>
      <div style="top: calc(72mm + -t-mm + -t1-mm); left: calc(-4mm + 150mm + -r-mm);">
        micro
      </div>
      <div style="top: calc(72mm + -t-mm + -t1-mm); left: calc(-4mm + 249mm + -r-mm);">
        tatto
      </div>
      <div style="top: calc(72mm + -t-mm + -t2-mm); left: calc(-4mm + 39mm + -r-mm);">
        name
      </div>
      <div style="top: calc(72mm + -t-mm + -t2-mm); left: calc(-4mm + 158mm + -r-mm);">
        breed
      </div>
      <div style="top: calc(72mm + -t-mm + -t2-mm); left: calc(-4mm + 259mm + -r-mm);">
        sex
      </div>
      <div style="top: calc(72mm + -t-mm + -t3-mm); left: calc(-4mm + 66mm + -r-mm);">
        dob
      </div>
      <div style="top: calc(72mm + -t-mm + -t3-mm); left: calc(-4mm + 173mm + -r-mm);">
        coat
      </div>
      <div style="top: calc(72mm + -t-mm + -t3-mm); left: calc(-4mm + 256mm + -r-mm);">
        color
      </div>
      <div style="top: calc(72mm + -t-mm + -t4-mm); left: calc(-4mm + 74mm + -r-mm);">
        breeder
      </div>
      <div style="top: calc(72mm + -t-mm + -t5-mm); left: calc(-4mm + 51mm + -r-mm);">
        owner
      </div>

        <div style="top: calc(72mm + -t-mm + -t8-mm); left: calc(-4mm + 48mm + -r-mm);">
          -pf-
        </div>
        <div style="top: calc(70mm + -t-mm + -t13-mm); left: calc(-4mm + 48mm + -r-mm);">
          -pm-
        </div>

        <div style="top: calc(72mm + -t-mm + -t7-mm); left: calc(-4mm + 97mm + -r-mm);">
          <img src="`+ braket +`">
        </div>
        <div style="top: calc(72mm + -t-mm + -t12-mm); left: calc(-4mm + 97mm + -r-mm);">
          <img src="`+ braket +`">
        </div>

        <div style="top: calc(72mm + -t-mm + -t7-mm); left: calc(-4mm + 102mm + -r-mm);">
          -f21f-
        </div>
        <div style="top: calc(72mm + 2mm + -t-mm + -t9-mm); left: calc(-4mm + 102mm + -r-mm);">
          -f21m-
        </div>
        <div style="top: calc(72mm + -t-mm + -t12-mm); left: calc(-4mm + 102mm + -r-mm);">
          -f22f-
        </div>
        <div style="top: calc(72mm + 2mm + -t-mm + -t14-mm); left: calc(-4mm + 102mm + -r-mm);">
          -f22m-
        </div>

        <div style="top: calc(72mm + -t-mm + -t6-mm); left: calc(-4mm + 150mm + -r-mm)">
          <img src="`+ braket2 +`">
        </div>
        <div style="top: calc(72mm + 5mm  + -t-mm + -t8-mm); left: calc(-4mm + 150mm + -r-mm);">
          <img src="`+ braket2 +`">
        </div>
        <div style="top: calc(72mm + -t-mm + -t11-mm); left: calc(-4mm + 150mm + -r-mm)">
          <img src="`+ braket2 +`">
        </div>
        <div style="top: calc(72mm + 5mm + -t-mm + -t13-mm); left: calc(-4mm + 150mm + -r-mm);">
          <img src="`+ braket2 +`">
        </div>

        <div style="top: calc(72mm + 1mm + -t-mm + -t6-mm); left: calc(-4mm + 155mm + -r-mm);">
          -f31f-
        </div>
        <div style="top: calc(72mm + 2mm + -t-mm + -t7-mm); left: calc(-4mm + 155mm + -r-mm);">
          -f31m-
        </div>
        <div style="top: calc(72mm + 6mm + -t-mm + -t8-mm); left: calc(-4mm + 155mm + -r-mm);">
          -f32f-
        </div>
        <div style="top: calc(72mm + 7mm + -t-mm + -t9-mm); left: calc(-4mm + 155mm + -r-mm);">
          -f32m-
        </div>
        <div style="top: calc(72mm + 1mm + -t-mm + -t11-mm); left: calc(-4mm + 155mm + -r-mm);">
          -f33f-
        </div>
        <div style="top: calc(72mm + 2mm + -t-mm + -t12-mm); left: calc(-4mm + 155mm + -r-mm);">
          -f33m-
        </div>
        <div style="top: calc(72mm + 6mm + -t-mm + -t13-mm); left: calc(-4mm + 155mm + -r-mm);">
          -f34f-
        </div>
        <div style="top: calc(72mm + 7mm + -t-mm + -t14-mm); left: calc(-4mm + 155mm + -r-mm);">
          -f34m-
        </div>
      
      <div style="top: calc(72mm + 1mm + -t-mm + -t11-mm); left: calc(255mm + -r-mm);">
        issue
      </div>`,
      line: 8.3
    }
  ]
  var rid = '{id}'
  var lang = {'regno': 'Số đăng ký', 'micro': 'Số chip', 'tatto': 'Số xăm', 'name': 'Tên', 'species': 'Giống', 'sex': 'Giới tính', 'dob': 'Ngày sinh', 'coat': 'Kiểu lông', 'color': 'Màu', 'breeder': 'Người nhân giống', 'owner': 'Chủ nuôi', 'issue': 'Ngày cấp'}
  $("#dob, #issue").datepicker({
    format: 'dd/mm/yyyy',
    changeMonth: true,
    changeYear: true
  });
  function printSubmit(paper) {
    if (printdata = precheck()) {
      save(printdata).then(() => {
        m_size = Number(document.getElementById('size').value)
        m_top = Number(document.getElementById('top').value)
        m_left = Number(document.getElementById('left').value)
        x = global[paper]['template']
        for (i = 1; i <= 25; i++) {
          patt = new RegExp('-t'+ i +'-', 'g')
          x = x.replace(patt, global[paper]['line'] * (i - 1))
        }
        $(".parent-name").each((index, item) => {
          id = item.getAttribute('id')
          value = item.value
          if (!value.length) {
            value = 'chưa xác định'
          }
          x = x.replace(new RegExp('-'+ id +'-', 'g'), value)
        })
        x = x.replace(new RegExp('-t-', 'g'), m_top)
        x = x.replace(new RegExp('-r-', 'g'), m_left)
        x = x.replace(new RegExp('-font-', 'g'), m_size)
        x = replaceData(printdata, x)
        // console.log(printdata, x);
        
        var winPrint = window.open('', '_blank', 'left=0,top=0,width=800,height=600');
        winPrint.focus()
        winPrint.document.write(x);
        setTimeout(() => {
          winPrint.print()
          winPrint.close()
        }, 300)
      })
    }
  }
  function replaceData(data, text) {
    for (const key in data) {
      if (data.hasOwnProperty(key)) {
        const element = data[key];
        text = text.replace(key, element)
      }
    }
    return text
  }
  function save(data) {
    return new Promise((resolve) => {
      $.post(
        '',
        { action: 'save', data: data, id: rid },
        (response, status) => {
          checkResult(response, status).then(data => {
            resolve()
          }, () => {})
        }
      )
    })
  }
  function precheck() {
    var data = {
      regno: $("#regno").val(),
      micro: $("#micro").val(),
      tatto: $("#tatto").val(),
      name: $("#name").val(),
      species: $("#species").val(),
      sex: $("#sex-0").prop('checked') ? 'Cái' : 'Đực',
      dob: $("#dob").val(),
      coat: $("#coat").val(),
      color: $("#color").val(),
      breeder: $("#breeder").val(),
      owner: $("#owner").val(),
      issue: $("#issue").val()
    }

    for (const key in data) {
      if (data.hasOwnProperty(key)) {
        const value = data[key];
        if (key !== 'tatto' && !value.length) {
          alert_msg('Các trường không được trống, ' + lang[key]);
          return 0
        }
      }
    }
    return data
  }
</script>
<!-- END: main -->
