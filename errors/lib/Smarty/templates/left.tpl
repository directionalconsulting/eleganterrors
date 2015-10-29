<ul>
	<!--[foreach from=$leftcol key=cat item=group]-->
		<!--[if $group|is_array]-->
			<ul>
				<!--[foreach from=$group key=title item=url]-->
					<li><a href="<!--[$url]-->"><!--[$title|str_replace:'_':' '|ucwords]--></a></li>
				<!--[/foreach]-->
			</ul>
		<!--[else]-->
			<li><a href="<!--[$group]-->"><!--[$cat|str_replace:'_':' '|ucwords]--></a></li>
		<!--[/if]-->
	<!--[/foreach]-->
</ul>
