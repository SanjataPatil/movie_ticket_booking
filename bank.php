<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

extract($_POST);
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>OMTBS - Payment</title>
    <link href="css/bank.css" rel="stylesheet" type="text/css"/>
</head>

<body>

<div id="mainContainer" class="row large-centered">
    <div class="text-center"><h2>BANK</h2></div>
    <hr class="divider">
    
    <dl class="mercDetails">
        <dt>Merchant</dt> <dd>OMTBS</dd>
        <dt>Transaction Amount</dt> <dd>INR <?php echo htmlspecialchars($_SESSION['amount']); ?></dd>
        <dt>Debit Card</dt> <dd>
            <?php 
            // Mask the card number for security
            if (!empty($number)) {
                echo str_repeat("*", strlen($number) - 4) . substr($number, -4);
            } else {
                echo "N/A";
            }
            ?>
        </dd>
    </dl>
    
    <hr class="divider">
    
    <!-- Payment confirmation form -->
    <form name="form1" id="form1" method="post" action="payment_success.php">
        <fieldset class="page2">
            <div class="page-heading">
                <h6 class="form-heading">Confirm Payment</h6>
                <p class="form-subheading">Click below to confirm your booking.</p>
            </div>

            <div class="row formInputSection">
                <div class="large-12 columns text-center">
                    <button class="expanded button next" type="submit">Make Payment</button>
                </div>
            </div>

            <p class="text-center">
                <a class="tryAgain" href="movie.php">Go back</a> to merchant
            </p>
        </fieldset>
    </form>
</div>

</body>
</html>
