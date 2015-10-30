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
				<div id="maincol">
					<!--[include file="alert.tpl"]-->
					<div class="row">
						<div id="response">
							<h1><!--[$config->credits->response]--></h1>
							<img src="<!--[$base]-->/assets/img/<!--[$config->credits->image]-->" alt="<!--[$config->credits->imagetext]-->" />
						</div>
					</div>
					<div class="row">
						<div id="reason">
								<!--[include file="url.tpl"]-->
								<!--[$config->credits->reason]--><br />
								<a href="<!--[$config->credits->link]-->" class="contact" title="Contact <!--[$config->package]-->">click here to learn more about <!--[$config->package]--></a>
								<!--[include file="package.tpl"]-->
								<!--[include file="translate.tpl"]-->
						</div>
					</div>
					<!--[if $status->credits eq false]-->
				</div>
				<!--[include file="footer.tpl"]-->
				<!--[else]-->
				<!--[include file="footer.tpl"]-->
			</div>
			<!--[/if]-->
		</div>
	</div>
</body>
</html>