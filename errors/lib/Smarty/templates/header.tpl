	<head>
		<title><!--[$config->title]--></title>
<!--[include file="meta.tpl"]-->
		<!-- link rel="stylesheet" href="<!--[$base]-->/assets/css/reset.css" type="text/css" media="screen" / -->
		<link rel="stylesheet" href="<!--[$base]-->/assets/css/styles.css" type="text/css" media="screen" />
		<!-- link rel="stylesheet" href="<!--[$base]-->/assets/css/custom.css" type="text/css" media="screen" / -->
		<!--[if $config->global->background ne '']-->
			<style type="text/css">
				#canvas {
					background-image: url("<!--[$base]-->/assets/bkgd/<!--[$config->global->background]-->");
				}
				#maincol {
					width: <!--[$mainWidth]-->;
					text-align: center;
					display: inline-block;
					padding: 0;
					margin: 1.5em;
					line-height: 1.5em;
				}
				#rightcol {
					width: <!--[$sideWidth]-->;
					float: right;
				}
				#leftcol {
					width: <!--[$sideWidth]-->;
					float: left;
				}
			</style>
		<!--[/if]-->
		<script type="application/javascript" src="< !--[$base]-->assets/js/jquery-1.11.3.min.js"></script>
		<!-- script type="application/javascript" src="< !--[$base]-- >assets/js/jquery.resizeframe.js"></script -->
	</head>
