<!DOCTYPE html>
<html>
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
					<!--[include file="translate.tpl"]-->
					<div class="row">
						<div id="response">
							<div class="main-icon text-warning"><span class="uxicon uxicon-alert"></span></div>
							<h1><!--[$config->credits->response]--></h1>
							<img src="<!--[$base]-->/assets/img/<!--[$config->credits->image]-->" alt="<!--[$config->credits->imagetext]-->">
						</div>
					</div>
					<div class="row">
						<div id="reason">
							<p>
								<!--[$config->credits->reason]--><br />
								<!--[include file="url.tpl"]-->
								<a href="<!--[$config->credits->package_link]-->" class="contact" title="Contact <!--[$config->package]-->">click here to learn more about <!--[$config->package]--></a>
							</p>
						</div>
					</div>
					<!--[include file="footer.tpl"]-->
				</div>
			</div>
		</div>
	</body>
</html>