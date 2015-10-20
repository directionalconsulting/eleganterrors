<?php /* Smarty version 2.6.18, created on 2015-10-20 12:15:07
         compiled from sent.tpl */ ?>
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
						<div id="response">
							<div class="main-icon text-warning"><span class="uxicon uxicon-alert"></span></div>
							<h1><?php echo $this->_tpl_vars['status']->response; ?>
</h1>
							<img src="<?php echo $this->_tpl_vars['base']; ?>
assets/img/<?php echo $this->_tpl_vars['status']->image; ?>
" alt="<?php echo $this->_tpl_vars['status']->response; ?>
">
						</div>
					</div>
					<div class="row">
						<div id="reason">
							<!---# @TODO - Fix this and make it nice looking along with the form.tpl... #-->
							<table align="center">
								<tr><td class="translate"><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "translate.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td></tr>
								<tr>
									<td>
										<h2>Thank you for contacting <?php echo $this->_tpl_vars['sitename']; ?>
</h2>
									</td>
								</tr>
								<tr>
									<td>
										<p>We have received your form information and will review shortly.</p>

										<p>We appreciate your interest in the domain and will reply promptly.</p>

										<p>Regards,</p>

										<p><?php echo $this->_tpl_vars['sitename']; ?>
</p>
									</td>
								</tr>
							</table>
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