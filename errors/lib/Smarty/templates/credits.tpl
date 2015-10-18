<!--[include file="header.tpl"]-->
	<body>
		<div id="canvas">
			<div id="leftpanel">
			</div>
			<div id="rightpanel">
			</div>
			<div id="page">
				<div id="content">';
					<div id="alert">
						<svg height="100" width="100">
							<polygon points="50,25 17,80 82,80" stroke-linejoin="round" style="fill:none;stroke:#ff8a00;stroke-width:8"/>
							<text x="42" y="74" fill="#ff8a00" font-family="sans-serif" font-weight="900" font-size="42px">!</text>
							<text x="07" y="96" fill="#338833" font-family="sans-serif" font-weight="900" font-size="11px" font-variant="small-caps" letter-spacing="0.05em"><!--[$config->package]--></text>
						</svg>
					</div>
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
				</div>
			</div>
		</div>
	</body>
</html>