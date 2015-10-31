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
