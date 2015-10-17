<?php /* Smarty version 2.6.18, created on 2015-10-16 08:58:18
         compiled from contactus_write.tpl */ ?>
<table id="content" align="center">
    <tr>
        <td colspan="2">
            <h1>Contact Music for the Masses</h1>
            <form action="/contact-us" method="post" id="contactus" name="contactus"
              enctype="application/x-www-form-urlencoded" onsubmit="return configureValidation(this,3);"
              onreset="confirm(errormsg[99]); reset(); clearForm(this); history.go();">
            <input type="hidden" name="subject" value="<?php echo $this->_tpl_vars['sitename']; ?>
 <?php echo $this->_tpl_vars['subject']; ?>
">
            <input type="hidden" name="time" value="<?php echo $this->_tpl_vars['time']; ?>
">
            <input type="hidden" name="ip" value="<?php echo $this->_tpl_vars['folder']; ?>
">
            <input type="hidden" name="env_report" value="REMOTE_ADDR, REMOTE_HOST, HTTP_USER_AGENT">
            <input type="hidden" name="redirect" value="/thank-you">
            <input type="hidden" name="ar_from" value="info@<?php echo $this->_tpl_vars['base']; ?>
">
            <input type="hidden" name="ar_subject" value="Thank you for your interest">
            <input type="hidden" name="ar_file" value="/errors/assets/autoresponder.txt">
            <fieldset>
                <legend></legend>
                <label><span class="field">First Name</span></label>
                    <input type="text" tabindex="0" name="first" id="first_name" value="<?php echo $this->_tpl_vars['first']; ?>
">
                <label><span class="field">Last Name</span></label>
                    <input type="text" tabindex="1" name="last" id="last_name" value="<?php echo $this->_tpl_vars['last']; ?>
">
            </fieldset>
            <fieldset>
                <legend></legend>
                <label><span class="field">Email</span></label>
                    <input type="text" tabindex="2" name="email" id="email" value="<?php echo $this->_tpl_vars['email']; ?>
">
            </fieldset>
            <fieldset>
                <legend></legend>
                <label><span class="field">Message</span></label>
                    <textarea name="inquiry" tabindex="3" id="message" rows="8" cols="110"><?php echo $this->_tpl_vars['message']; ?>
</textarea>
            </fieldset>
            <fieldset>
                <legend></legend>
                <label id="quit">
                    <input type="image" tabindex="6"  name="cancel" id="cancel" src="/errors/assets/img/error.png">
                </label>
                <label id="key">
                    Enter Verification Code
                    <img src="/errors/lib/secureword.php?<?php echo session_name() ?>=<?php  echo session_id() ?>"
                         alt="Enter text shown to contact <?php echo $this->_tpl_vars['sitename']; ?>
"
                         title="Enter text shown to contact <?php echo $this->_tpl_vars['sitename']; ?>
" class="veriword">
                    <input type="text" tabindex="4" name="keystring" id="keycode" title="Verification Code">
                </label>
                <label id="send">
                    <input type="image" tabindex="5" name="submit" id="submit" src="/errors/assets/img/send.png">
                </label>
            </fieldset>
            </form>
            <br>
            <div id="errordiv">&nbsp;</div>
            <?php if ($this->_tpl_vars['tryagain'] == 1): ?>
                <br>
                <p class="keys">Code entered does not match, try again.</p>
            <?php endif; ?>
        </td>
    </tr>
</table>