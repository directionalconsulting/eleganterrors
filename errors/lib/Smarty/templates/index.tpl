<!DOCTYPE html>
<html>
<!--[include file="header.tpl"]-->
<body>
<div id="canvas">
	<div id="page">
		<div id="content">
			<div id="leftcol">
				<!--[if $status->credits eq 1]-->
				<!--[include file="left.tpl"]-->
				<!--[/if]-->
			</div>
			<div id="rightcol">
				<!--[if $status->credits eq 1]-->
				<!--[include file="right.tpl"]-->
				<!--[/if]-->
			</div>
			<div id="maincol">
				<!--[include file="alert.tpl"]-->
				<!--[include file="$route.tpl"]-->
				<!--[if $status->credits eq 0]-->
			</div>
			<!--[include file="footer.tpl"]-->
			<!--[else]-->
			</div>
			<!--[include file="footer.tpl"]-->
		</div>
		<!--[/if]-->
	</div>
</div>
</body>
</html>