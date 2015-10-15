<table id="content" align="center">
    <tr>
        <td colspan="2">
            <h1>Contact Music for the Masses</h1>
            <form action="/contact-us" method="post" id="contactus" name="contactus"
              enctype="application/x-www-form-urlencoded" onsubmit="return configureValidation(this,3);"
              onreset="confirm(errormsg[99]); reset(); clearForm(this); history.go();">
            <input type="hidden" name="subject" value="{$sitename} {$subject}">
            <input type="hidden" name="time" value="{$time}">
            <input type="hidden" name="ip" value="{$folder}">
            <input type="hidden" name="env_report" value="REMOTE_ADDR, REMOTE_HOST, HTTP_USER_AGENT">
            <input type="hidden" name="redirect" value="/thank-you">
            <input type="hidden" name="ar_from" value="info@{$base}">
            <input type="hidden" name="ar_subject" value="Thank you for your interest">
            <input type="hidden" name="ar_file" value="/forms/assets/autoresponder.txt">
            <fieldset>
                <legend></legend>
                <label><span class="field">First Name</span></label>
                    <input type="text" tabindex="0" name="first" id="first_name" value="{$first}">
                <label><span class="field">Last Name</span></label>
                    <input type="text" tabindex="1" name="last" id="last_name" value="{$last}">
            </fieldset>
            <fieldset>
                <legend></legend>
                <label><span class="field">Email</span></label>
                    <input type="text" tabindex="2" name="email" id="email" value="{$email}">
            </fieldset>
            <fieldset>
                <legend></legend>
                <label><span class="field">Message</span></label>
                    <textarea name="inquiry" tabindex="3" id="message" rows="8" cols="110">{$message}</textarea>
            </fieldset>
            <fieldset>
                <legend></legend>
                <label id="quit">
                    <input type="image" tabindex="6"  name="cancel" id="cancel" src="/forms/assets/error.png">
                </label>
                <label id="key">
                    Enter Verification Code
                    <img src="/forms/includes/secureword.php?{php}echo session_name(){/php}={php} echo session_id(){/php}"
                         alt="Enter text shown to contact {$sitename}"
                         title="Enter text shown to contact {$sitename}" class="veriword">
                    <input type="text" tabindex="4" name="keystring" id="keycode" title="Verification Code">
                </label>
                <label id="send">
                    <input type="image" tabindex="5" name="submit" id="submit" src="/forms/assets/send.png">
                </label>
            </fieldset>
            </form>
            <br>
            <div id="errordiv">&nbsp;</div>
            {if $tryagain eq 1}
                <br>
                <p class="keys">Code entered does not match, try again.</p>
            {/if}
        </td>
    </tr>
</table>
