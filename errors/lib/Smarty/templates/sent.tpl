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
					<div class="row">
						<div id="response">
							<div class="main-icon text-warning"><span class="uxicon uxicon-alert"></span></div>
							<h1><!--[$status->response]--></h1>
							<img src="<!--[$base]-->assets/img/<!--[$status->image]-->" alt="<!--[$status->response]-->">
						</div>
					</div>
					<div class="row">
						<div id="reason">
							<!---# @TODO - Fix this and make it nice looking along with the form.tpl... #-->
							<table align="center">
								<tr>
									<td>
										<h2>Thank you for contacting <!--[$sitename]--></h2>
									</td>
								</tr>
								<tr>
									<td>
										<p>We have received your form information and will review shortly.</p>

										<p>We appreciate your interest in the domain and will reply promptly.</p>

										<p>Regards,</p>

										<p><!--[$sitename]--></p>
									</td>
								</tr>
							</table>
						</div>
					</div>
					<!--[include file="footer.tpl"]-->
				</div>
			</div>
		</div>
	</body>
</html>