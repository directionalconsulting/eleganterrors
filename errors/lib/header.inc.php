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
	<title><?php echo $this->code . " - ". $this->status->response; ?></title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php if (isset($this->url) && !empty($this->url)): ?>
	<meta http-equiv="Refresh" content="<?php echo $this->timeout; ?>; url=http://<?php echo $this->url; ?>" />
	<?php endif; ?>
	<link rel="stylesheet" type="text/css" href="assets/css/alerts.css">
	<!-- Removed JS for now in favor of a single page load using PHP as it permits better file handling -->
	<!-- script type="application/javascript" src="assets/js/jquery-1.11.3.min.js"></script -->
	<!-- script type="application/javascript" src="assets/js/jquery.resizeframe.js"></script -->
	<?php if (isset($this->config->bkgd_image) && !empty($this->config->bkgd_image)): ?>
	<style type="text/css">
		#canvas {
			background-image: url("assets/bkgd/<?php echo $this->config->bkgd_image; ?>");
		}
	</style>
	<?php endif; ?>
</head>