<?php
if ( ! defined( '_TLDDOMAIN' ) ) {
    define( '_TLDDOMAIN', $_SERVER['HTTP_HOST'] );
}
class ElegantMail extends ElegantErrors {

    private $content;
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

        $email = $this->contact->email;

        $recipient = $this->config->contact->email;

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

        /**
         * @TODO - Implement attach file(s) option... TBD
         *
        // check for an attachment if there is a file upload it
        if ($attachment_name) {
            if ($attachment_size > 0) {
                if (!$attachment_type) $attachment_type =  "application/unknown";
                $content .= "Attached File: ".$attachment_name."\n";
                $fp = fopen($attachment,  "r");
                $attachment_chunk = fread($fp, filesize($attachment));
                $attachment_chunk = base64_encode($attachment_chunk);
                $attachment_chunk = chunk_split($attachment_chunk);
            }
        }

        // check for a file if there is a file upload it
        if ($_FILES['file_name']['name']) {
            if ($_FILES['file_name']['size'] > 0) {
                if (!ereg("/$", $path_to_file))
                    $path_to_file = $path_to_file."/";
                $location = $path_to_file.$_FILES['file_name']['name'];
                if (file_exists($path_to_file.$_FILES['file_name']['name']))
                    $location = $path_to_file.rand(1000,3000).".".$_FILES['file_name']['name'];
                if (is_dir($path_to_file)) {
                    if(move_uploaded_file($_FILES['file_name']['tmp_name'], $location)) {
                        $content .= "Uploaded File: ".$location."\n";
                    } else {
                        $content .= "Warning: There was a problem with ".$location."\n";
                    }
                }
            }
        }

        // second file (see manual for instructions on how to add more.)
        if ($_FILES['file2_name']['name']) {
            if ($file_size > 0) {
                if (!ereg("/$", $path_to_file))
                    $path_to_file = $path_to_file."/";
                $location = $path_to_file.$_FILES['file2_name']['name'];
                if (file_exists($path_to_file.$_FILES['file2_name']['name']))
                    $location = $path_to_file.rand(1000,3000).".".$_FILES['file2_name']['name'];
                if (is_dir($path_to_file)) {
                    if(move_uploaded_file($_FILES['file2_name']['tmp_name'], $location)) {
                        $content .= "Uploaded File: ".$location."\n";
                    } else {
                        $content .= "Warning: There was a problem with ".$location."\n";
                    }
                }
            }
        }

        // third file (see manual for instructions on how to add more.)
        if ($_FILES['file3_name']['name']) {
            if ($file_size > 0) {
                if (!ereg("/$", $path_to_file))
                    $path_to_file = $path_to_file."/";
                $location = $path_to_file.$_FILES['file3_name']['name'];
                if (file_exists($path_to_file.$_FILES['file3_name']['name']))
                    $location = $path_to_file.rand(1000,3000).".".$_FILES['file3_name']['name'];
                if (is_dir($path_to_file)) {
                    if(move_uploaded_file($_FILES['file3_name']['tmp_name'], $location)) {
                        $content .= "Uploaded File: ".$location."\n";
                    } else {
                        $content .= "Warning: There was a problem with ".$location."\n";
                    }

                }
            }
        }

         *
         * @TODO - Implement withClass environment report :: WIP TBD
         *
        // if the env_report option is on: get eviromental variables
        if ($env_report) {
            $env_report = ereg_replace( " +", "", $env_report);
            $env_reports = split(",",$env_report);
            $content .= "\n------ eviromental variables ------\n";
            for ($i=0;$i<count($env_reports);$i++) {
                $string = trim($env_reports[$i]);
                if ($env_reports[$i] == "REMOTE_HOST")
                    $content .= "REMOTE HOST: ".$_SERVER['REMOTE_HOST']."\n";
                if ($env_reports[$i] == "REMOTE_USER")
                    $content .= "REMOTE USER: ". $_SERVER['REMOTE_USER']."\n";
                if ($env_reports[$i] == "REMOTE_ADDR")
                    $content .= "REMOTE ADDR: ". $_SERVER['REMOTE_ADDR']."\n";
                if ($env_reports[$i] == "HTTP_USER_AGENT")
                    $content .= "BROWSER: ". $_SERVER['HTTP_USER_AGENT']."\n";
            }
        }
         **/
        die("Got to here, almost home...");
        // send it off
        self::postMaster(stripslashes($content), ($subject)?stripslashes($subject):"Form Submission", $email, $recipient);
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

    }

    protected function buildBody($title, $bgcolor, $text_color, $link_color, $vlink_color, $alink_color, $style_sheet) {
        if ($style_sheet)
            echo "<link rel=stylesheet href=\"$style_sheet\" type=\"text/css\">\n";
        if ($title)
            echo "<title>$title</title>\n";
        if (!$bgcolor)
            $bgcolor = "#FFFFFF";
        if (!$text_color)
            $text_color = "#000000";
        if (!$link_color)
            $link_color = "#0000FF";
        if (!$vlink_color)
            $vlink_color = "#FF0000";
        if (!$alink_color)
            $alink_color = "#000088";
        if ($background)
            $background = "background=\"$background\"";
        echo "<body bgcolor=\"$bgcolor\" text=\"$text_color\" link=\"$link_color\" vlink=\"$vlink_color\" alink=\"$alink_color\" $background>\n\n";
    }

    protected function printError($reason,$type = 0) {
        /**
         * @TODO - Implement HTML options for styling in config and form...
         * self::buildBody($title, $bgcolor, $text_color, $link_color, $vlink_color, $alink_color, $style_sheet);
         */

        if ($type == "missing") {
            // @TODO - revisit this...
            if ($missing_field_redirect) {
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

    public function parseForm() {
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
                                $content[] = array($field,$array[$field][$z]);
                        } else
                            $content[] = array($field,$array[$field]);
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
                            $content[] = array($key,$val[$z]);
                    } else
                        $content[] = array($key,$val);
                }
            }
        }
        $this->content = $content;
    }

    protected function postMaster($content, $subject, $email, $recipient) {
        // @TODO - Replace global variables with class variables...
        global $attachment_chunk, $attachment_name, $attachment_type, $attachment_sent, $bcc;

        $ob = "----=_OuterBoundary_000";
        $ib = "----=_InnerBoundery_001";

        $headers  = "MIME-Version: 1.0\r\n";
        if ($recipient=="info@"._TLDDOMAIN) {
            $email = "info@"._TLDDOMAIN;
        }
        $headers .= "From: ".$email."\n";
        $headers .= "To: ".$recipient."\n";
        $headers .= "Reply-To: ".$email."\n";
        if ($bcc) $headers .= "Bcc: ".$bcc."\n";
        $headers .= "X-Priority: 1\n";
        $headers .= "X-Mailer: DT Formmail".VERSION."\n";
        $headers .= "Content-Type: multipart/mixed;\n\tboundary=\"".$ob."\"\n";


        $message  = "This is a multi-part message in MIME format.\n";
        $message .= "\n--".$ob."\n";
        $message .= "Content-Type: multipart/alternative;\n\tboundary=\"".$ib."\"\n\n";
        $message .= "\n--".$ib."\n";
        $message .= "Content-Type: text/plain;\n\tcharset=\"iso-8859-1\"\n";
        $message .= "Content-Transfer-Encoding: quoted-printable\n\n";
        $message .= $content."\n\n";
        $message .= "\n--".$ib."--\n";
        if ($attachment_name && !$attachment_sent) {
            $message .= "\n--".$ob."\n";
            $message .= "Content-Type: $attachment_type;\n\tname=\"".$attachment_name."\"\n";
            $message .= "Content-Transfer-Encoding: base64\n";
            $message .= "Content-Disposition: attachment;\n\tfilename=\"".$attachment_name."\"\n\n";
            $message .= $attachment_chunk;
            $message .= "\n\n";
            $attachment_sent = 1;
        }
        $message .= "\n--".$ob."--\n";

        mail($recipient, $subject, $message, $headers);
    }
}