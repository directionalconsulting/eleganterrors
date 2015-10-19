<!--[include file="header.tpl"]-->
	<body>
		<div id="canvas">
			<div id="leftpanel">
			</div>
			<div id="rightpanel">
			</div>
			<div id="page">
				<div id="content">';
					<!--[include file="alert.tpl"]-->
					<div class="row">
						<div id="response">
							<div class="main-icon text-warning"><span class="uxicon uxicon-alert"></span></div>
							<h1><!--[$config->credits->response]--></h1>
							<img src="<!--[$base]-->assets/img/<!--[$config->credits->image]-->" alt="<!--[$config->credits->imagetext]-->">
						</div>
					</div>
					<div class="row">
						<div id="reason">'
							<p>
								<!--[$config->credits->reason]--><br />
								<!--[php]-->if (isset($url) && !empty($url)):<!--[/php]-->
								Please follow <a href="<!--[$url]-->">this link</a>,
								<!--[php]--> endif; <!--[/php]-->
								<a href="<!--[$config->credits->link]-->" class="contact" title="Contact <!--[$config->credits->package]-->">please contact us.</a>
							</p>
						</div>
					</div>
					<!--[include file="footer.tpl"]-->
