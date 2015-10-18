<?php /* Smarty version 2.6.18, created on 2015-10-18 06:33:52
         compiled from credits.tpl */ ?>
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
							<text x="07" y="96" fill="#338833" font-family="sans-serif" font-weight="900" font-size="11px" font-variant="small-caps" letter-spacing="0.05em"><?php echo $this->_tpl_vars['config']->package; ?>
</text>
						</svg>
					</div>
					<div class="row">
						<div id="response">
							<div class="main-icon text-warning"><span class="uxicon uxicon-alert"></span></div>
							<h1><?php echo $this->_tpl_vars['config']->credits->response; ?>
</h1>
							<img src="<?php echo $this->_tpl_vars['base']; ?>
assets/img/<?php echo $this->_tpl_vars['config']->credits->image; ?>
" alt="<?php echo $this->_tpl_vars['config']->credits->imagetext; ?>
">
						</div>
					</div>
					<div class="row">
						<div id="reason">'
							<p>
								<?php echo $this->_tpl_vars['config']->credits->reason; ?>
<br />
								<?php if (isset($url) && !empty($url)): ?>
								Please follow <a href="<?php echo $this->_tpl_vars['url']; ?>
">this link</a>,
								<?php  endif;  ?>
								<a href="<?php echo $this->_tpl_vars['config']->credits->link; ?>
" class="contact" title="Contact <?php echo $this->_tpl_vars['config']->credits->package; ?>
">please contact us.</a>
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