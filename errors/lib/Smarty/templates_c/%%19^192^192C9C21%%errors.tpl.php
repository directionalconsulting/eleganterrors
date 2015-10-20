<?php /* Smarty version 2.6.18, created on 2015-10-20 14:08:22
         compiled from errors.tpl */ ?>
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
					<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "translate.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
					<div class="row">
						<div id="response">
							<div class="main-icon text-warning"><span class="uxicon uxicon-alert"></span></div>
							<h1><?php echo $this->_tpl_vars['status']->response; ?>
</h1>
							<img src="<?php echo $this->_tpl_vars['base']; ?>
/assets/img/<?php echo $this->_tpl_vars['status']->image; ?>
" alt="<?php echo $this->_tpl_vars['status']->response; ?>
">
						</div>
					</div>
					<div class="row">
						<div id="reason">
							<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "url.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
							<p><?php echo $this->_tpl_vars['status']->reason; ?>
<br />
								<a href="<?php echo $this->_tpl_vars['config']->contact_link; ?>
" class="contact" title="Contact Us">please contact us.</a>
							</p>
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