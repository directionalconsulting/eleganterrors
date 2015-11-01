<div class="row">
	<div id="reason">
		<form method="post"
		      enctype="application/x-www-form-urlencoded"
		      action="<!--[$base]-->/contact"
		      method="post"
		      onsubmit="return configureValidation(this,3);"
		      onreset="confirm(errormsg[99]); reset(); clearForm(this); history.go();">
			<input type="hidden" name="redirect" value="<!--[$base]-->/thank-you">
			<input type="hidden" name="elegant" value="<!--[$smarty.session.withClass]-->"
			<p>
			<fieldset>
				<legend for="problem">Was This The Problem ?</legend>
				<p>
					<label>Accept <!--[$config->package]--> report?
						<input type="checkbox" id="yes" name="yes">
					</label>
				</p>
				<p>
					<label>Server Error
						<textarea id="problem" name="problem" placeholder="<!--[$status->code]-->"></textarea>
					</label>
				</p>
			</fieldset>
			<fieldset>
					<legend>How Can We Help ?</legend>
					<p>
						<label for="message"><span class="field">Message</span>
							<textarea id="message" name="message"><!--[$message]--></textarea>
						</label>
					</p>
			</fieldset>

			<fieldset>
				<legend>May We Contact You ?</legend>
				<p>
					<label for="name">Name
						<input type="text" id="name" name="name" placeholder="Your Name" />
					</label>
				</p>

				<p>
					<label for="email">Email
						<input type="email" id="email" name="email" placeholder="you@mailhost.tld" />
					</label>
				</p>
			</fieldset>

			<fieldset>
				<legend>Prove you're not a robot !</legend>
				<p>
					<label for="keycode">
						<img src="<!--[$status->captcha]-->" />
						<input type="text" tabindex="4" name="keystring" id="keycode" placeholder="Enter Verification Code">
					</label>
				</p>
			</fieldset>

			<fieldset>
				<legend>Submit or Quit ?</legend>
				<p>
					<label for="submit">Submit
						<input type="image" tabindex="5" name="submit" id="submit" src="<!--[$base]-->/assets/img/send.png">
					</label>
				</p>
				<p>
					<label for="cancel">Cancel
						<input type="image" tabindex="6"  name="cancel" id="cancel" src="<!--[$base]-->/assets/img/error.png">
					</label>
				</p>

			</fieldset>

			</p>
		</form>
		<br>
		<div id="errordiv">&nbsp;</div>
		<!--[if $tryagain eq 1]-->
			<br>
			<p class="keys">Code entered does not match, try again.</p>
		<!--[/if]-->
	</div>
</div>
