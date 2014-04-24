<?php
session_start();
//connect to the database - either include a connection variable file
//or type the following lines:
require_once 'conn.inc.php';
//make our database active
//get our variable passed through the URL
$prodid = $_REQUEST['prodid'];
//get information on the specific product we want
$query = "SELECT * FROM products WHERE products_prodnum='$prodid'";
$results = mysql_query($query)
or die(mysql_error());
$row = mysql_fetch_array($results);
extract($row);
?>
<html>
<head>
<title><?php echo $products_name; ?></title>
</head>
<body>
<div align="center">
<table cellpadding="5" width="80%">
<tr>
<td>PRODUCT IMAGE</td>
<td><strong><?php echo $products_name; ?></strong><br>
<?php echo $products_proddesc; ?><br \>
<br>Product Number: <?php echo $products_prodnum; ?>
<br>Price: $<?php echo $products_price; ?><br>
<form method="POST" action="modcart.php?action=add">
Quantity: <input type="text" name="qty" size="2"><br>
<input type="hidden" name="products_prodnum"
value="<?php echo $products_prodnum ?>">
<input type="submit" name="Submit" value="Add to cart">
</form>
<form method="POST" action="cart.php">
<input type="submit" name="Submit" value="View cart">
</form>
</td>
</tr>
</table>
<hr width="200">
<p><a href="cbashop.php">Go back to the main page</a></p>
</div>
</body>
</html>