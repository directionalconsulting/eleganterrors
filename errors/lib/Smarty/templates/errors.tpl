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
						</svg>
					</div>
					<div class="row">
						<div id="response">
							<div class="main-icon text-warning"><span class="uxicon uxicon-alert"></span></div>
							<h1><!--[$status->response]--></h1>
							<img src="<!--[$base]-->assets/img/<!--[$status->image]-->" alt="<!--[$status->response]-->">
						</div>
					</div>
					<div class="row">
						<div id="reason">'
							<!--[php]-->if (isset($url) && !empty($url)):<!--[/php]-->
							<p>Please follow <a href="<!--[$url]-->">this link</a></p>
							<!--[php]--> endif; <!--[/php]-->
							<p><!--[$status->reason]--><br />
								<a href="<!--[$config->contact_link]-->" class="contact" title="Contact Us">please contact us.</a>
							</p>
						</div>
					</div>
					<!--[include file="footer.tpl"]-->
				</div>
			</div>
		</div>
	</body>
</html>