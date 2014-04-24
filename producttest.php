<?php
//connect to the database - either include a connection variable file or
//type the following lines:

require_once 'conn.inc.php';
$query = "SELECT * FROM products";
$results = mysql_query($query)
or die(mysql_error());
?>
<html>
<head>
<title>Product List</title>
</head>
<body>
<table border="1" cellpadding="5" cellspacing="5">
<tr>
<th width="10%">Product Number</th>
<th width="20%">Name</th>
<th width="50%">Description</th>
<th width="10%">Price</th>
<th width="10%">Date Added</th>
</tr>
<?php
while ($row = mysql_fetch_array($results)) {
extract($row);
echo "<tr><td width=\"10%\">";
echo $products_prodnum;
echo "</td><td width=\"20%\">";
echo $products_name;
echo "</td><td width=\"50%\">";
echo $products_proddesc;
echo "</td><td width=\"10%\">";
echo $products_price;
echo "</td><td width=\"10%\">";
echo $products_dateadded;
echo "</td></tr>";
}
?>
</table>
</body>
</html>