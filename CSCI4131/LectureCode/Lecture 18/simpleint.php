<?php
    // get the data from the form
    $principal = $_POST['loan'];
    $interest_rate = $_POST['interest_rate'];
    $years = $_POST['years'];

    // calculate the interest on the loan
    $interest = $principal * ($interest_rate * 0.01) * $years;
    

    // apply currency and percent formatting
    $principal_f = '$'.number_format($principal, 2);
    $yearly_rate_f = $interest_rate.'%';
    $interest_f = '$'.number_format($interest, 2);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Simple Interest Calculator</title>
    <link rel="stylesheet" type="text/css" href="main.css"/>
</head>
<body>
    <div id="content">
        <h1>Simple Interest Calculator</h1>

        <label>Loan Amount:</label>
        <span><?php echo $principal_f; ?></span><br />

        <label>Interest Rate:</label>
        <span><?php echo $yearly_rate_f; ?></span><br />

        <label>Number of Years:</label>
        <span><?php echo $years; ?></span><br />

        <label>Interest Due:</label>
        <span><?php echo $interest_f; ?></span><br />
    </div>
</body>
</html>