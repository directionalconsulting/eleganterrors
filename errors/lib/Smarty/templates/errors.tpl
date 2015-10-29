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
				<div id="content">
					<!--[include file="alert.tpl"]-->
					<div class="row">
						<div id="response">
							<div class="main-icon text-warning"><span class="uxicon uxicon-alert"></span></div>
							<h1><!--[$status->response]--></h1>
							<img src="<!--[$base]-->/assets/img/<!--[$status->image]-->" alt="<!--[$status->response]-->">
						</div>
					</div>
					<div class="row">
						<div id="reason">
							<!--[include file="url.tpl"]-->
							<p><!--[$status->reason]--><br />
								<a href="<!--[$config->routes->form]-->" class="contact" title="Contact Us">please contact us.</a>
							</p>
							<!--[include file="translate.tpl"]-->
						</div>
					</div>
					<!--[include file="footer.tpl"]-->
				</div>
			</div>
		</div>
	</body>
</html>