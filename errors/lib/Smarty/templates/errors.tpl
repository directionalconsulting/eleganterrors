<!DOCTYPE html>
<html>
<!--[include file="header.tpl"]-->
	<body>
	<div id="canvas">
		<div id="page">
			<div id="content">
				<div id="leftcol">
				</div>
				<div id="rightcol">
				</div>
				<div id="maincol">
					<!--[include file="alert.tpl"]-->
					<div class="row">
						<div id="response">
							<h3 class="status_code"><!--[$code|string_format:'%03d']--></h3>
							<h1><!--[$status->response]--></h1>
							<img src="<!--[$base]-->/assets/img/<!--[$status->image]-->" alt="<!--[$status->response]-->">
						</div>
					</div>
				</div>
				<div class="row">
					<div id="reason">
						<!--[include file="url.tpl"]-->
						<!--[$status->reason]--><br />
						<a href="<!--[$config->routes->form]-->" class="contact" title="Contact Us">please contact us.</a>
						<!--[include file="package.tpl"]-->
						<!--[include file="translate.tpl"]-->
					</div>
				</div>
			</div>
			<!--[include file="footer.tpl"]-->
			</div>
		</div>
	</body>
</html>