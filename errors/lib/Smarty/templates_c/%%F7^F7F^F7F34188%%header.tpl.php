<?php /* Smarty version 2.6.18, created on 2015-10-20 12:13:40
         compiled from header.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'strip_tags', 'header.tpl', 26, false),array('modifier', 'html_decode', 'header.tpl', 26, false),)), $this); ?>
	<head>

		<title><?php echo $this->_tpl_vars['config']->title; ?>
</title>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<?php if (isset($url) && !empty($url)): ?>
		<meta http-equiv="Refresh" content="<?php echo $this->_tpl_vars['timeout']; ?>
; url=http://<?php echo $this->_tpl_vars['url']; ?>
" />
		<?php  endif;  ?>
		<link rel="stylesheet" href="<?php echo $this->_tpl_vars['base']; ?>
/assets/css/styles.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php echo $this->_tpl_vars['base']; ?>
/assets/css/form.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php echo $this->_tpl_vars['base']; ?>
/assets/css/alerts.css" type="text/css" media="screen" />
		<script src="<?php echo $this->_tpl_vars['base']; ?>
/assets/js/chkform.js" type="text/javascript" language="javascript"></script>
		<script src="<?php echo $this->_tpl_vars['base']; ?>
/assets/js/chkform_lang.js" type="text/javascript" language="javascript"></script>
		<script src="<?php echo $this->_tpl_vars['base']; ?>
/assets/js/form.js" type="text/javascript" language="javascript"></script>
		<!---( Removed JS for now in favor of a single page load using PHP as it permits better file handling
		script type="application/javascript" src="<?php echo $this->_tpl_vars['base']; ?>
assets/js/jquery-1.11.3.min.js"></script
		script type="application/javascript" src="<?php echo $this->_tpl_vars['base']; ?>
assets/js/jquery.resizeframe.js"></script )-->
		<?php if ($this->_tpl_vars['config']->bkgd_img != null): ?>
		<style type="text/css">
			#canvas {
				background-image: url("<?php echo $this->_tpl_vars['base']; ?>
/assets/bkgd/<?php echo $this->_tpl_vars['config']->bkgd_img; ?>
");
			}
		</style>
		<?php endif; ?>
		<meta name="keywords" content="<?php echo $this->_tpl_vars['keywords']; ?>
" />
		<meta name="description" content="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['description'])) ? $this->_run_mod_handler('strip_tags', true, $_tmp) : smarty_modifier_strip_tags($_tmp)))) ? $this->_run_mod_handler('html_decode', true, $_tmp) : smarty_modifier_html_decode($_tmp)); ?>
" />
	</head>