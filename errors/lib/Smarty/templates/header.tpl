	<head>
		<title><!--[$config->title]--></title>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script src="<!--[$base]-->/assets/js/chkform.js" type="text/javascript" ></script>
		<script src="<!--[$base]-->/assets/js/chkform_lang.js" type="text/javascript" ></script>
		<script src="<!--[$base]-->/assets/js/form.js" type="text/javascript" ></script>
		<!---( Removed JS for now in favor of a single page load using PHP as it permits better file handling
		script type="application/javascript" src="<!--[$base]-->assets/js/jquery-1.11.3.min.js"></script
		script type="application/javascript" src="<!--[$base]-->assets/js/jquery.resizeframe.js"></script )-->
		<link rel="stylesheet" href="<!--[$base]-->/assets/css/styles.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="<!--[$base]-->/assets/css/form.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="<!--[$base]-->/assets/css/alerts.css" type="text/css" media="screen" />
		<!--[if $config->global->background ne '']-->
		<style type="text/css">
			#canvas {
				background-image: url("<!--[$base]-->/assets/bkgd/<!--[$config->global->background]-->");
			}
		</style>
		<!--[/if]-->
		<meta name="keywords" content="<!--[$config->meta->keywords]-->" />
		<meta name="description" content="<!--[$config->meta->description|strip_tags|html_decode]-->" />
		<meta name="author" content="<!--[$config->meta->author]-->" />
		<meta name="copyright" content="<!--[$config->meta->copyright]-->" />
		<!--[if $url ne '']-->
			<meta http-equiv="refresh" content="<!--[$config->meta->timeout]-->; url=<!--[$url]-->" />
		<!--[/if]-->
	</head>
