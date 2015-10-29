<ul>
	<!--[foreach from=$rightcol key=cat item=group]-->
		<!--[if $group|is_string]-->
			<li class="category"><!--[$cat|replace:'_':' ']--></li>
		<!--[/if]-->
		<!--[if $group|is_array]-->
			<ul>
				<!--[foreach from=$group key=title item=url]-->
					<li class="group"><a href="<!--[$url]-->"><!--[$title|replace:'_':' ']--></a></li>
				<!--[/foreach]-->
			</ul>
		<!--[/if]-->
	<!--[/foreach]-->
</ul>