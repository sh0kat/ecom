<?php
//connect to the database - either include a connection variable file
//or type the following lines:
$connect = mysql_connect("localhost", "root", "")
or die ("Hey loser, check your server connection.");
mysql_select_db("ecommerce");
$query = "INSERT INTO products VALUES (
'00001', 'CBA Logo T-shirt',
'This T-shirt will show off your CBA connection.
Our t-shirts are high quality and 100% preshrunk cotton.',
17.95, '2004-08-01'),
('00002','CBA Bumper Sticker',
'Let the world know you are a proud supporter of the
CBA Web site with this colorful bumper sticker.',
5.95, '2004-08-01'),
('00003', 'CBA Coffee Mug',
'With the CBA logo looking back at you over your
morning cup of coffee, you\'re sure to have a great
start to your day. Our mugs are microwave and dishwasher
safe.',
8.95, '2004-08-01'),
('00004', 'Superhero Body Suit',
'We have a complete selection of colors and sizes for you
to choose from. This body suit is sleek, stylish, and
won\'t hinder your crime-fighting or evil scheming abilities.
We also offer your choice in monogrammed letter applique.',
99.95, '2004-08-01'),
('00005', 'Small Grappling Hook',
'This specialized hook will get you out of the tightest
places. Specially designed for portability and stealth,
please be aware that this hook does come with
a weight limit.',
139.95, '2004-08-01'),
('00006', 'Large Grappling Hook',
'For all your heavy-duty building-to-building swinging needs,
this large version of our grappling hook will safely transport
you throughout the city. Please be advised however that at
50 pounds, this is hardly the hook to use if you\'re a
lightweight.',
199.95, '2004-08-01')";
$result = mysql_query($query)
or die(mysql_error());
echo "Products added successfully!";
?>