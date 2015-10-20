	<head>

		<title><!--[$config->title]--></title>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!--[php]-->if (isset($url) && !empty($url)):<!--[/php]-->
		<meta http-equiv="Refresh" content="<!--[$timeout]-->; url=http://<!--[$url]-->" />
		<!--[php]--> endif; <!--[/php]-->
		<link rel="stylesheet" href="<!--[$base]-->/assets/css/styles.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="<!--[$base]-->/assets/css/form.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="<!--[$base]-->/assets/css/alerts.css" type="text/css" media="screen" />
		<script src="<!--[$base]-->/assets/js/chkform.js" type="text/javascript" language="javascript"></script>
		<script src="<!--[$base]-->/assets/js/chkform_lang.js" type="text/javascript" language="javascript"></script>
		<script src="<!--[$base]-->/assets/js/form.js" type="text/javascript" language="javascript"></script>
		<!---( Removed JS for now in favor of a single page load using PHP as it permits better file handling
		script type="application/javascript" src="<!--[$base]-->assets/js/jquery-1.11.3.min.js"></script
		script type="application/javascript" src="<!--[$base]-->assets/js/jquery.resizeframe.js"></script )-->
		<!--[if $config->bkgd_img ne null]-->
		<style type="text/css">
			#canvas {
				background-image: url("<!--[$base]-->/assets/bkgd/<!--[$config->bkgd_img]-->");
			}
		</style>
		<!--[/if]-->
		<meta name="keywords" content="<!--[$keywords]-->" />
		<meta name="description" content="<!--[$description|strip_tags|html_decode]-->" />
	</head>
