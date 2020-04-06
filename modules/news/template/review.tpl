<style>
  #review {
    width: 25%;
    padding: 20px;
    position: fixed;
    bottom: 0px;
    right: 0px;
    border: 1px solid lightgray;
    border-top-left-radius: 20px;
    background: white;
  }

  #review-bar {
    height: 20px;
    font-size: 12px;
    width: 75px;
    position: fixed;
    bottom: 0px;
    right: 0px;
    border: 1px solid lightgray;
    background: cornflowerblue;
  }

  @media (max-width: 876px) {
    #review {
      width: 300px;
    }
  }
</style>
<div id="review" style="display: none;">
  <div style="position: absolute; top: 0px; left: 0px; width: -webkit-fill-available; height: 20px; background: cornflowerblue; border-top-left-radius: 20px; color: white; text-align: right; background-color: cornflowerblue; font-weight: bold; font-size: 1.2em; padding-right: 4px;" onclick="hideReview()">
    &times;
  </div>
  <form onsubmit="sendReview(event)" style="margin-top: 10px;">
    <input type="text" class="form-control" id="review-username" placeholder="Tên hiển thị">
    <div class="text-center">
      Nội dung
      <textarea class="form-control" id="review-content" rows="5"></textarea>
      <button class="btn btn-info">
        Gửi góp ý
      </button>
    </div>
  </form>
</div>
<div id="review-bar" class="text-center" style="color: white; font-weight: bold; line-height: 22px;" onclick="showReview()">
  Góp ý
  <span class="glyphicon glyphicon-hand-up">
  </span>
</div>

<script>
  function hideReview() {
    $("#review").hide()
    $("#review-bar").show()
  }

  function showReview() {
    $("#review").show()
    $("#review-bar").hide()
  }

  function sendReview(e) {
    e.preventDefault()
    $.post(
      '/news/review/',
      {action: 'send-review', username: $("#review-username").val(), content: $("#review-content").val()},
      (response, status) => {
        checkResult(response, status).then(data => {
          $("#review-username").val('')
          $("#review-content").val('')
        }, () => {})
      }
    )
  }
</script>
