<div id="alert">
	<!--[php]-->if (!preg_match('%credits%',$_SERVER['REQUEST_URI'])):<!--[/php]-->
	<a href="<!--[$base]-->/credits" title="<!--[$config->package]-->">
		<!--[php]-->endif;<!--[/php]-->
		<svg height="100" width="100">
			<polygon points="50,25 17,80 82,80" stroke-linejoin="round" style="fill:orange;stroke:orange;stroke-width:8"/>
			<text x="42" y="74" style="fill: <!--[$status->color]-->; font-family: sans-serif; font-weight: 900; font-size: 42px;">!</text>
			<text x="07" y="96" style="fill: firebrick; font-family: sans-serif; font-weight: 500; font-size: 11px; font-variant: small-caps; letter-spacing: 0.05em;"><!--[$config->package]--></text>
		</svg>
		<!--[php]-->if (!preg_match('%credits%',$_SERVER['REQUEST_URI'])):<!--[/php]-->
	</a>
	<!--[php]-->endif;<!--[/php]-->
</div>