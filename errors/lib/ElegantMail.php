<?php

if ( ! defined( '_TLDDOMAIN' ) ) {
    define( '_TLDDOMAIN', $_SERVER['HTTP_HOST'] );
}

/**
 * PEAR libraries :: stable - very common, proven, reliable!
 *
 * Mail 1.2.0
 * Mail_mime 1.3.0
 * Net_SMTP 1.7.0
 *
 */
require_once('Mail.php');
require_once('Mail/mime.php');
require_once('Net/SMTP.php');

class ElegantMail extends ElegantErrors {

    private $content;
    private $subject;
    private $email;
    private $from;
    private $reply;
    private $referers;
    private $banlist;
    private $recipient;
    private $required;
    private $missing_fields_redirect;

    function __construct(ElegantErrors $elegantErrors) {

        $this->recipient = $this->config->contact->email;

        $this->referers = $this->config->contact->referers;

        $this->banlist = $this->config->contact->banlist;

        $this->required = $this->config->contact->required;
    }

    public function sendMail() {

        self::parseForm();

        $email = $this->content->email;

        $recipient = $this->recipient;

        $referers = $this->referers;

        $banlist = $this->banlist;

        if ($referers)
            self::checkReferer($referers);

        if ($banlist)
            self::checkBanlist($banlist, $email);

        $recipient_in = split(',',$recipient);
        for ($i=0;$i<count($recipient_in);$i++) {
            $recipient_to_test = trim($recipient_in[$i]);
            //@TODO - Replace eregi...
            if (!eregi("^[_\\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\\.)+[a-z]{2,6}$", $recipient_to_test)) {
                self::printError("<b>I NEED VALID RECIPIENT EMAIL ADDRESS ($recipient_to_test) TO CONTINUE</b>");
            }
        }

        (isset($this->config->contact->missing_fields_redirect)) ?
            $missing_fields_redirect = $this->config->contact->missing_fields_redirect: $missing_fields_redirect = null;
        $missing_field_list = '';

        if ($this->required)
            $require = $this->required;
        // handle the required fields
        if ($require) {
            // seperate at the commas
            $require = ereg_replace( " +", "", $require);
            $required = split(",",$require);
            for ($i=0;$i<count($required);$i++) {
                $string = trim($required[$i]);
                // check if they exsist
                if((!(${$string})) || (!(${$string}))) {
                    // if the missing_fields_redirect option is on: redirect them
                    if ($missing_fields_redirect) {
                        header ("Location: $missing_fields_redirect");
                        exit;
                    }
                    $require;
                    $missing_field_list .= "<b>Missing: $required[$i]</b><br>\n";
                }
            }
            // send errors to our mighty errors function
            if ($missing_field_list)
                print_error($missing_field_list,"missing");
        }

        (isset($this->config->contact->sort)) ? $sort = $this->config->contact->sort : $sort = "alphabetic";
        // sort alphabetic or prepare an order
        if ($sort == "alphabetic") {
            uksort($_POST, "strnatcasecmp");
        } elseif ((ereg('^order:.*,.*', $sort)) && ($list = explode(',', ereg_replace('^order:', '', $sort)))) {
            $sort = $list;
        }

        // send it off
        self::postMaster();
        die("Got to here, almost home...");

        /**
         * @TODO - Implement autoresponder template... TBD
         *
        if (file_exists($ar_file)) {
            $fd = fopen($ar_file, "rb");
            $ar_message = fread($fd, filesize($ar_file));
            fclose($fd);
            mail_it($ar_message, ($ar_subject)?stripslashes($ar_subject):"RE: Form Submission", ($ar_from)?$ar_from:$recipient, $email);
        }

        if (isset($_POST['redirect']))
            $redirect = $_POST['redirect'];

        // if the redirect option is set: redirect them
        if ($redirect) {
            header("Location: $redirect");
            exit;
        } else {
            echo "Thank you for your submission\n";
            echo "<br><br>\n";
        }

        if (_DEBUG === true) {
            print_r($_POST);

            print_r($_FILES);
        }
         **/

    }

    /**
     * @TODO - Implement HTML Style options and mail...
     * @TODO - Replace with LESS...
     * @deprecated - from old version...
     * @param $title
     * @param $bgcolor
     * @param $text_color
     * @param $link_color
     * @param $vlink_color
     * @param $alink_color
     * @param $style_sheet
     *
    protected function buildBody() {
     * @TODO - Implement HTML mail...
       }
     **/


    protected function printError($reason,$type = 0) {
        /**
         * @TODO - Implement HTML options for styling in config and form && REPLACE THIS ERROR DUMP...
         * self::buildBody($title, $bgcolor, $text_color, $link_color, $vlink_color, $alink_color, $style_sheet);
         */

        if ($type == "missing") {
            // @TODO - revisit this...
            if ($this->missing_field_redirect) {
                header("Location: $missing_field_redirect?errors=$reason");
                exit;
            } else {
                ?>
                The form was not submitted for the following reasons:<p>
                <ul><?php                 echo $reason."\n";
                    ?></ul>
                Please use your browser's back button to return to the form and try again.<?php
            }
        } else { // every other errors
            ?>
            The form was not submitted because of the following reasons:<p>
        <?php     }
        echo "<br><br>\n";
    }

    protected function checkBanlist($banlist, $email) {
        if (count($banlist)) {
            $allow = true;
            foreach($banlist as $banned) {
                $temp = explode("@", $banned);
                if ($temp[0] == "*") {
                    $temp2 = explode("@", $email);
                    if (trim(strtolower($temp2[1])) == trim(strtolower($temp[1])))
                        $allow = false;
                } else {
                    if (trim(strtolower($email)) == trim(strtolower($banned)))
                        $allow = false;
                }
            }
        }
        if (!$allow) {
            print_error("You are using from a <b>banned email address.</b>");
        }
    }

    protected function checkReferer() {
        $referers = $this->referers;
        if (count($referers)) {
            $found = false;

            $temp = explode("/",getenv("HTTP_REFERER"));
            $referer = $temp[2];

            if ($referer=="") {$referer = $_SERVER['HTTP_REFERER'];
                list($remove,$stuff)=split('//',$referer,2);
                list($home,$stuff)=split('/',$stuff,2);
                $referer = $home;
            }

            for ($x=0; $x < count($referers); $x++) {
                // @TODO - Replace with preg_replace...
                if (eregi ($referers[$x], $referer)) {
                    $found = true;
                }
            }
            if ($referer =="")
                $found = false;
            if (!$found){
                print_error("You are coming from an <b>unauthorized domain.</b>");
                error_log("[FormMail.php] Illegal Referer. (".getenv("HTTP_REFERER").")", 0);
            }
            return $found;
        } else {
            return false; // not a good idea, if empty, it will allow it.
        }
    }

    protected function parseForm() {
        if (isset($_POST) and !empty($_POST)) {
            $array = $_POST;
        }
        (isset($this->config->contact->sort)) ? $sort = $this->config->contact->sort : $sort = null;
        // build reserved keyword array
        $reserved_keys[] = "MAX_FILE_SIZE";
        $reserved_keys[] = "required";
        $reserved_keys[] = "redirect";
        $reserved_keys[] = "require";
        $reserved_keys[] = "path_to_file";
        $reserved_keys[] = "recipient";
        $reserved_keys[] = "subject";
        $reserved_keys[] = "sort";
        $reserved_keys[] = "style_sheet";
        $reserved_keys[] = "bgcolor";
        $reserved_keys[] = "text_color";
        $reserved_keys[] = "link_color";
        $reserved_keys[] = "vlink_color";
        $reserved_keys[] = "alink_color";
        $reserved_keys[] = "title";
        $reserved_keys[] = "missing_fields_redirect";
        $reserved_keys[] = "env_report";
        $reserved_keys[] = "submit";
        $content = array();
        if (count($array)) {
            if (is_array($sort)) {
                foreach ($sort as $field) {
                    $reserved_violation = 0;
                    for ($ri=0; $ri<count($reserved_keys); $ri++)
                        if ($array[$field] == $reserved_keys[$ri]) $reserved_violation = 1;

                    if ($reserved_violation != 1) {
                        if (is_array($array[$field])) {
                            for ($z=0;$z<count($array[$field]);$z++)
                                $content[] = array($field=>$array[$field][$z]);
                                $this->content->$field = $array[$field][$z];
                        } else
                            $content[] = array($field=>$array[$field]);
                        $this->content->$field = $array[$field];
                    }
                }
            }
            while (list($key, $val) = each($array)) {
                $reserved_violation = 0;
                for ($ri=0; $ri<count($reserved_keys); $ri++)
                    if ($key == $reserved_keys[$ri]) $reserved_violation = 1;

                for ($ri=0; $ri<count($sort); $ri++)
                    if ($key == $sort[$ri]) $reserved_violation = 1;

                // prepare content
                if ($reserved_violation != 1) {
                    if (is_array($val)) {
                        for ($z=0;$z<count($val);$z++)
                            $content[] = array($key=>$val[$z]);
                            $this->content->$key = $val[$z];
                    } else
                        $content[] = array($key=>$val);
                        $this->content->$key = $val;
                }
            }
        }
//        $this->content = $content;
    }

    protected function postMaster() {


        $content = ElegantTools::objectToArray($this->content);
        $message = '';
        foreach ($content as $pair) {
            foreach ( $pair as $field => $value ) {
                $message .= $field . ": " . $value . "\n\n";
            }
        }
//        die(var_dump($message));

        $text = $message;
        //@TODO - Add formatting for HTML Version of Email with table layout of values...
//        $html = '<html><body>HTML version of email</body></html>';
        //@TODO Add log attachment options for captuting rich data...
//        $file = '/errors/....log';

        $crlf = "\n";

        // Set mail headers for message...
        $headers = array(
            // Use test conditions...
        );

        $to = $this->config->contact->email;

        if (!empty($this->config->contact->from)) {
            $headers[] = array("From"=>$this->config->contact->from);
        } else {
            $headers[] = array("From"=>str_replace(' ','_',strtolower($this->config->package))."@".$this->config->contact->host);
        }
        if ($this->config->contact->reply_to) $headers[] = array("Reply-To "=>$this->config->contact->reply_to);
        if ($this->config->contact->cc) $headers[] = array("Cc"=>$this->config->contact->cc);
        if ($this->config->contact->bcc) $headers[] = array("Bcc"=>$this->config->contact->bcc);
        if ($this->config->contact->subject) {
            $headers[] = array( "Subject" => $this->config->contact->subject );
        } else {
            //@TODO - Implement Elegance enc/dec f(x)...
            $withClass = ElegantTools::redCarpet($this->content->withClass,'decode');
	        die(var_dump($withClass));
            $subject = $elegance->code . " - " . $elegance->status->response;
//            $subject = "TESTING... ELEGANT ERRORS --- PLEASE STAND-BY...";
            $headers[] = array( "Subject" => $subject );
        }

        die(var_dump($headers));

        // Construct MIME mail msg...
        $mime = new Mail_Mime(array('eol' => $crlf));

        $mime->setTXTBody($text);
//        $mime->setHTMLBody($html);
//        $mime->addAttachment($file, 'text/plain');

        $body = $mime->get(array('text_charset' => 'utf-8'));
        $headers = $mime->headers($headers);

        // Construct SMTP mail factory and send it...
        $smtp = Mail::factory('smtp',
            array(
                'host' => $this->config->contact->host,
                'port' => $this->config->contact->port,
                'auth' => $this->config->contact->auth,
                'username' => $this->config->contact->username,
                'password' => $this->config->contact->password));

//        die(var_dump($smtp));

        $mail = $smtp->send($to, $headers, $body);


        if (PEAR::isError($mail)) {
            echo $mail->getMessage();
        } else {
            echo "Message sent successfully!";
        }
        echo "\n";

    }
}