<?php
//connect to the database - either include a connection variable file
//or type the following lines:
require_once 'conn.inc.php';
$query = "SELECT * FROM products";
$results = mysql_query($query)
or die(mysql_error());
?>
<html>
<head>
<title>Comic Book Appreciation Site Product List</title>
</head>
<body>
<div align="center">
Thanks for visiting our site! Please see our list of awesome
products below, and click on the link for more information:
<br><br>
<table width="300">
<?php
// Show only Name, Price and Image
while ($row = mysql_fetch_array($results)) {
extract($row);
echo "<tr><td align=\"center\">";
echo "<a href=\"getprod.php?prodid=" . $products_prodnum . "\">";
echo "<em>THUMBNAIL<br>IMAGE</em></a></td>";
echo "<td>";
echo "<a href=\"getprod.php?prodid=" . $products_prodnum . "\">";
echo $products_name;
echo "</td></a>";
echo "<td align=\"right\">";
echo "<a href=\"getprod.php?prodid=" . $products_prodnum . "\">";
echo "$" . $products_price;
echo "</a></td></tr>";
}
?>
</table>
</div>
</body>
</html>