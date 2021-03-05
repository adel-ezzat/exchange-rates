<!DOCTYPE html>
<html lang="en">
<head>
  <title>USD Exchange Rates</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js" ></script>
</head>
<body>

<div class="container">
  <h2>USD Exchange Rates</h2>

  <form id="rates">

  <div class="form-group">
    <label for="currency">Curruncy :</label>
    <select class="form-control" name="currency" id="currency" required>

      <option value="eur_usd">Euro</option>
      <option value="cny_usd">Chinese yuan renminbi</option>
      <option value="jpy_usd">Japanese Yen</option>
      <option value="gbp_usd">Pound sterling</option>
      <option value="chf_usd">Swiss franc</option>
      <option value="egp_usd">Egyptian pound</option>
      <option value="sar_usd">Saudi riyal</option>
      <option value="kwd_usd">Kuwaiti dinar</option>
      <option value="aed_usd">United Arab Emirates dirham</option>

    </select>
  </div>
   
    <div class="form-group">
      <label for="amount">Amount:</label>
      <input type="number" min="1" class="form-control" id="amount" placeholder="Enter Amount" name="amount" required>
    </div>
   
   
    <button type="submit" class="btn btn-primary">Convert</button>
  </form>

<p style="padding-top: 10px;"></p>

</div>

<script>
$(function() {
  $("#rates").validate({
    rules: {
      currency:{ 
        required: true,
      },
      amount:{
        required: true,
        number: true,
        minlength: 1
      }
    },
    messages: {
        currency: "Please select currency",
        amount: "Please enter currency amount",
    },

    submitHandler: function(form) {

    $.ajax({
                    type: "POST",
                    url: "/api/convert",
                    data: {
                        'currency': $( "#currency option:selected" ).val(),
                        'amount':  $( "#amount" ).val(),
                    },
                    success: function (res) {

                        var originalAmount = res.originalAmount;
                        var originalCurrency = res.originalCurrency;
                        var exchangeRate = res.exchangeRate;
                        var exchangeCurrency = res.exchangeCurrency;
                        var differenceFromYesterday = res.differenceFromYesterday;
                        $("p").empty();
                        $("p").append(" <strong>Original Amount</strong> : " + originalAmount + "</br>");
                        $("p").append(" <strong>Original Currency</strong> : " + originalCurrency + "</br>");
                        $("p").append(" <strong>Exchange Rate</strong> : " + exchangeRate + "</br>");
                        $("p").append(" <strong>Exchange Currency</strong> : " + exchangeCurrency + "</br>");
                        $("p").append(" <strong>Percentage Difference</strong> : " + differenceFromYesterday + " % </br>");



                    }
                });    
    }
  });
});
</script>

</body>
</html>
