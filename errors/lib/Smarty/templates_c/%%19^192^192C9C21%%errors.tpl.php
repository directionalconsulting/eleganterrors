<?php /* Smarty version 2.6.18, created on 2015-10-18 05:03:32
         compiled from errors.tpl */ ?>
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
					<div id="alert">
						<svg height="100" width="100">
							<polygon points="50,25 17,80 82,80" stroke-linejoin="round" style="fill:none;stroke:#ff8a00;stroke-width:8"/>
							<text x="42" y="74" fill="#ff8a00" font-family="sans-serif" font-weight="900" font-size="42px">!</text>
						</svg>
					</div>
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
						<div id="reason">'
							<?php if (isset($url) && !empty($url)): ?>
							<p>Please follow <a href="<?php echo $this->_tpl_vars['url']; ?>
">this link</a></p>
							<?php  endif;  ?>
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