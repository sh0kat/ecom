<?php

// set error reporting level
if (version_compare(phpversion(), "5.3.0", ">=") == 1)
 error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
else
 error_reporting(E_ALL & ~E_NOTICE);

require_once('inc/login.inc.php');
require_once('inc/chat.inc.php');

// initialization of login system and generation code
$oSimpleLoginSystem = new SimpleLoginSystem();

$oSimpleChat = new SimpleChat();

// draw login box
echo $oSimpleLoginSystem->getLoginBox();

// draw chat application
$sChatResult = 'Need login before using';
if ($_COOKIE['member_name'] && $_COOKIE['member_pass']) {
 if ($oSimpleLoginSystem->check_login($_COOKIE['member_name'], $_COOKIE['member_pass'])) {
 $sChatResult = $oSimpleChat->acceptMessages();
 }
}
echo $sChatResult;

?>