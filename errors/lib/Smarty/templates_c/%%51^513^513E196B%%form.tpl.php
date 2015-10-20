<?php /* Smarty version 2.6.18, created on 2015-10-20 12:06:59
         compiled from form.tpl */ ?>
<!DOCTYPE html>
<html>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<body>
		<div id="canvas">
			<div id="leftpanel">
			</div>
			<div id="rightpanel">
			</div>
			<div id="page">
				<div id="content">';
					<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "alert.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
					<div class="row">
						<div id="reason">'
							<form action="<?php echo $this->_tpl_vars['base']; ?>
/contact" method="post" id="contactus" name="contactus"
							      enctype="application/x-www-form-urlencoded" onsubmit="return configureValidation(this,3);"
							      onreset="confirm(errormsg[99]); reset(); clearForm(this); history.go();">
								<input type="hidden" name="redirect" value="<?php echo $this->_tpl_vars['base']; ?>
/thank-you">
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
										<input type="image" tabindex="6"  name="cancel" id="cancel" src="<?php echo $this->_tpl_vars['base']; ?>
/assets/img/error.png">
									</label>
									<label id="key">
										Enter Verification Code
										<img src="<?php echo $this->_tpl_vars['base']; ?>
/lib/secureword.php?<?php echo session_name() ?>=<?php  echo session_id() ?>"
										     alt="Enter text shown to contact <?php echo $this->_tpl_vars['sitename']; ?>
"
										     title="Enter text shown to contact <?php echo $this->_tpl_vars['sitename']; ?>
" class="veriword">
										<input type="text" tabindex="4" name="keystring" id="keycode" title="Verification Code">
									</label>
									<label id="send">
										<input type="image" tabindex="5" name="submit" id="submit" src="<?php echo $this->_tpl_vars['base']; ?>
/assets/img/send.png">
									</label>
								</fieldset>
							</form>
							<br>
							<div id="errordiv">&nbsp;</div>
							<?php if ($this->_tpl_vars['tryagain'] == 1): ?>
							<br>
							<p class="keys">Code entered does not match, try again.</p>
							<?php endif; ?>
						</div>
					</div>
					<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
				</div>
			</div>
		</div>
	</body>
</html>