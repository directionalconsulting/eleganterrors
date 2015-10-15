<?php
/**
 * Created by PhpStorm
 * Project: defense-ability
 * User: gman
 * Date: 10/2/15
 * Time: 4:55 AM
 */
?>
<head>
	<title><?php echo $errDoc->code . " - ". $errDoc->status->response; ?></title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php if (isset($errDoc->url) && !empty($errDoc->url)): ?>
	<meta http-equiv="Refresh" content="<?php echo $errDoc->timeout; ?>; url=http://<?php echo $errDoc->url; ?>" />
	<?php endif; ?>
	<link rel="stylesheet" type="text/css" href="assets/css/alerts.css">
	<!-- Removed JS for now in favor of a single page load using PHP as it permits better file handling -->
	<!-- script type="application/javascript" src="assets/js/jquery-1.11.3.min.js"></script -->
	<!-- script type="application/javascript" src="assets/js/jquery.resizeframe.js"></script -->
	<?php if (isset($errDoc->bkgd_image) && !empty($errDoc->bkgd_image)): ?>
	<style type="text/css">
		#canvas {
			background-image: url("assets/bkgd/<?php echo $errDoc->bkgd_image; ?>");
		}
	</style>
	<?php endif; ?>
</head>