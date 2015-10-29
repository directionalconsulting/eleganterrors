<!DOCTYPE html>
<html>
<!--[include file="header.tpl"]-->
<body>
		<div id="canvas">

			<div id="page">
				<div id="content">
					<div id="leftcol">
						<!--[include file="left.tpl"]-->
					</div>
					<div id="rightcol">
						<!--[include file="right.tpl"]-->
					</div>
					<div>
						<!--[include file="alert.tpl"]-->
					</div>
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
								<a href="<!--[$config->credits->link]-->" class="contact" title="Contact <!--[$config->package]-->">click here to learn more about <!--[$config->package]--></a>
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