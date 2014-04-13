<?php

// simple chat class
class SimpleChat {

    // DB variables
    var $sDbName;
    var $sDbUser;
    var $sDbPass;

    // constructor
    function SimpleChat() {
        //mysql_connect("localhost","username","password");
        $this->sDbName = 'simplechat';
        $this->sDbUser = 'root';
        $this->sDbPass = '';
    }

    // adding to DB table posted message
    function acceptMessages() {
        if ($_COOKIE['member_name']) {
            if(isset($_POST['s_say']) && $_POST['s_message']) {
                $sUsername = $_COOKIE['member_name'];

                //the host, name, and password for your mysql
                $vLink = mysql_connect("localhost", $this->sDbUser, $this->sDbPass);

                //select the database
                mysql_select_db($this->sDbName);

                $sMessage = mysql_real_escape_string($_POST['s_message']);
                if ($sMessage != '') {
                    mysql_query("INSERT INTO `s_chat_messages` SET `user`='{$sUsername}', `message`='{$sMessage}', `when`=UNIX_TIMESTAMP()");
                }

                mysql_close($vLink);
            }
        }

        ob_start();
        require_once('chat_input.html');
        $sShoutboxForm = ob_get_clean();

        return $sShoutboxForm;
    }

    function getMessages() {
        $vLink = mysql_connect("localhost", $this->sDbUser, $this->sDbPass);

        //select the database
        mysql_select_db($this->sDbName);

        //returning the last 15 messages
        $vRes = mysql_query("SELECT * FROM `s_chat_messages` ORDER BY `id` DESC LIMIT 15");

        $sMessages = '';

        // collecting list of messages
        if ($vRes) {
            while($aMessages = mysql_fetch_array($vRes)) {
                $sWhen = date("H:i:s", $aMessages['when']);
                $sMessages .= '<div class="message">' . $aMessages['user'] . ': ' . $aMessages['message'] . '<span>(' . $sWhen . ')</span></div>';
            }
        } else {
            $sMessages = 'DB error, create SQL table before';
        }

        mysql_close($vLink);

        ob_start();
        require_once('chat_begin.html');
        echo $sMessages;
        require_once('chat_end.html');
        return ob_get_clean();
    }
}

?>
