<?php /* Smarty version 2.6.18, created on 2015-10-19 10:07:12
         compiled from alert.tpl */ ?>
<div id="alert">
	<svg height="100" width="100">
		<polygon points="50,25 17,80 82,80" stroke-linejoin="round" style="fill:orange;stroke:orange;stroke-width:8"/>
		<text x="42" y="74" style="fill: <?php echo $this->_tpl_vars['status']->color; ?>
; font-family: sans-serif; font-weight: 900; font-size: 42px;">!</text>
		<text x="07" y="96" style="fill: firebrick; font-family: sans-serif; font-weight: 900; font-size: 11px; font-variant: small-caps; letter-spacing: 0.05em;"><?php echo $this->_tpl_vars['config']->package; ?>
</text>
	</svg>
</div>