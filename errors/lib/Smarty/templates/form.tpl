<div class="row">
	<div id="reason">
		<form method="post"
		      enctype="application/x-www-form-urlencoded"
		      action="<!--[$base]-->/<!--[$config->routes->form]-->"
		      name="<!--[$config->routes->form]-->"
		      id="contact">
			<input type="hidden" name="withClass" value="<!--[$smarty.session.withClass]-->">
			<p>
			<fieldset>
				<legend for="problem">Was This The Problem ?</legend>
				<p>
					<label>Server Error
						<textarea id="problem" name="problem" readonly="readonly">
							<!--[foreach from=$env->last key=t item=cell]-->
								<!--[$t]-->: <!--[$cell]-->
							<!--[/foreach]-->
						</textarea>
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
				<p >
					<label for="keycode" id="robot">
						<img id="captcha" src="<!--[$status->captcha]-->" title="Captcha"/>
						<input type="text" tabindex="4" name="keystring" id="keycode" placeholder="Enter Code">
					</label>
				</p>
			</fieldset>

			<fieldset>
				<legend>Submit or Quit ?</legend>
				<p class="inline">
					<label for="submit">Submit
						<input type="image" tabindex="5" name="submit" id="submit" src="<!--[$base]-->/assets/img/send.png">
					</label>
				</p>
				<p class="inline">
					<label for="cancel">Cancel
						<input type="image" tabindex="6"  name="cancel" id="cancel" src="<!--[$base]-->/assets/img/error.png">
					</label>
				</p>
				<p>Clicking submit will send this form to the site administrator</p>
			</fieldset>

			</p>
		</form>
	</div>
</div>
