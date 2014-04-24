<?php
session_start();
//connect to the database - either include a connection variable file
//or type the following lines:
require_once 'conn.inc.php';
//Let's make the variables easy to access in our queries
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$firstname = $_POST['firstname'];
$add1 = $_POST['add1'];
$add2 = $_POST['add2'];
$city = $_POST['city'];
$state = $_POST['state'];
$zip = $_POST['zip'];
$phone = $_POST['phone'];
$fax = $_POST['fax'];
$email = $_POST['email'];
$shipfirst = $_POST['shipfirst'];
        $shiplast = $_POST['shiplast'];
$shipadd1 = $_POST['shipadd1'];
$shipadd2 = $_POST['shipadd2'];
$shipcity = $_POST['shipcity'];
$shipstate = $_POST['shipstate'];
$shipzip = $_POST['shipzip'];
$shipstate = $_POST['shipstate'];
$shipphone = $_POST['shipphone'];
$shipemail = $_POST['shipemail'];
$total = $_POST['total'];
$sessid = session_id();
$today = date("Y-m-d");
//1) Assign Customer Number to new Customer, or find existing customer number
$query = "SELECT * FROM customers WHERE
(customers_firstname = '$firstname' AND
customers_lastname = '$lastname' AND
customers_add1 = '$add1' AND
customers_add2 = '$add2' AND
customers_city = '$city')";
$results = mysql_query($query)
or (mysql_error());
$rows = mysql_num_rows($results);
if ($rows < 1) {
//assign new custnum
$query2 = "INSERT INTO customers (
customers_firstname, customers_lastname, customers_add1,
customers_add2, customers_city, customers_state,
customers_zip, customers_phone, customers_fax,
customers_email)
VALUES (
'$firstname',
'$lastname',
'$add1',
'$add2',
'$city',
'$state',
'$zip',
'$phone',
'$fax',
'$email')";
$insert = mysql_query($query2)
or (mysql_error());
$custid = mysql_insert_id();
}
//If custid exists, we want to make it equal to custnum
//Otherwise we will use the existing custnum
if ($custid) {
$customers_custnum = $custid;
}
//2) Insert Info into ordermain
//determine shipping costs based on order total (25% of total)
$shipping = $total * 0.25;
$query3 = "INSERT INTO ordermain (
ordermain_orderdate, ordermain_custnum,
ordermain_subtotal,ordermain_shipping,
ordermain_shipfirst, ordermain_shiplast,
ordermain_shipadd1, ordermain_shipadd2,
ordermain_shipcity, ordermain_shipstate,
ordermain_shipzip, ordermain_shipphone,
ordermain_shipemail)
VALUES (
'$today',
'$customers_custnum',
'$total',
'$shipping'
'$shipfirst',
'$shiplast',
'$shipadd1',
'$shipadd2',
'$shipcity',
'$shipstate',
'$shipzip',
'$shipphone',
'$shipemail')";
$insert2 = mysql_query($query3)
or (mysql_error());
$orderid = mysql_insert_id();
//3) Insert Info into orderdet
//find the correct cart information being temporarily stored
$query = "SELECT * FROM carttemp WHERE carttemp_sess='$sessid'";
$results = mysql_query($query)
or (mysql_error());
//put the data into the database one row at a time
while ($row = mysql_fetch_array($results)) {
extract($row);
$query4 = "INSERT INTO orderdet (
orderdet_ordernum, orderdet_qty, orderdet_prodnum)
VALUES (
'$orderid',
'$carttemp_quan',
'$carttemp_prodnum')";
$insert4 = mysql_query($query4)
or (mysql_error());
}
//4)delete from temporary table
$query = "DELETE FROM carttemp WHERE carttemp_sess='$sessid'";
$delete = mysql_query($query);
//5)email confirmations to us and to the customer
/* recipients */
$to = "<" . $email .">";
        /* subject */
$subject = "Order Confirmation";
/* message */
/* top of message */
$message = "
<html>
<head>
<title>Order Confirmation</title>
</head>
<body>
Here is a recap of your order:<br><br>
Order date: ";
$message .= $today;
$message .= "
<br>
Order Number: ";
$message .= $orderid;
$message .= "
<table width=\"50%\" border=\"0\">
<tr>
<td>
<p>Bill to:<br>";
$message .= $firstname;
$message .= " ";
$message .= $lastname;
$message .= "<br>";
$message .= $add1;
$message .= "<br>";
if ($add2) {
$message .= $add2 . "<br>";
}
$message .= $city . ", " . $state . " " . $zip;
$message .= "</p></td>
<td>
<p>Ship to:<br>";
$message .= $shipfirst . " " . $shiplast;
$message .= "<br>";
$message .= $shipadd1 . "<br>";
if ($shipadd2) {
$message .= $shipadd2 . "<br>";
}
$message .= $shipcity . ", " . $shipstate . " " . $shipzip;
$message .= "</p>
</td>
</tr>
</table>
<hr width=\"250px\" align=\"left\">
<table cellpadding=\"5\">";
//grab the contents of the order and insert them
//into the message field
$query = "SELECT * FROM orderdet WHERE orderdet_ordernum = '$orderid'";
$results = mysql_query($query)
or die (mysql_query());
while ($row = mysql_fetch_array($results)) {
extract($row);
$prod = "SELECT * FROM products
WHERE products_prodnum = '$orderdet_prodnum'";
$prod2 = mysql_query($prod);
$prod3 = mysql_fetch_array($prod2);
extract($prod3);
$message .= "<tr><td>";
$message .= $orderdet_qty;
$message .= "</td>";
$message .="<td>";
$message .= $products_name;
$message .= "</td>";
$message .= "<td align=\"right\">";
$message .= $products_price;
$message .= "</td>";
$message .= "<td align=\"right\">";
//get extended price
$extprice = number_format($products_price * $orderdet_qty, 2);
$message .= $extprice;
$message .= "</td>";
$message .= "</tr>";
}
$message .= "<tr>
<td colspan=\"3\" align=\"right\">
Your total before shipping is:
</td>
<td align=\"right\">";
$message .= number_format($total, 2);
$message .= "
</td>
</tr>
<tr>
<td colspan=\"3\" align=\"right\">
Shipping Costs:
</td>
<td align=\"right\">";
$message .= number_format($shipping, 2);
$message .= "
</td>
</tr>
<tr>
<td colspan=\"3\" align=\"right\">
Your final total is:
</td>
<td align=\"right\"> ";
$message .= number_format(($total + $shipping), 2);
$message .= "
</td>
</tr>
</table>
</body>
</html>";
/* headers */
$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
$headers .= "From: <storeemail@email.com>\r\n";
$headers .= "Cc: <storeemail@email.com>\r\n";
$headers .= "X-Mailer: PHP / ".phpversion()."\r\n";
/* mail it */
//mail($to, $subject, $message, $headers);
//6)show them their order & give them an order number
echo "Step 1 - Please Enter Billing and Shipping Information<br>";
echo "Step 2 - Please Verify Accuracy and Make Any Necessary Changes<br>";
echo "<strong>Step 3 - Order Confirmation and Receipt</strong><br><br>";
echo $message;
?>