<div id="footer">
    <div class="left">
        <a href="http://validator.w3.org/check?uri=http://<!--[$host]--><!--[$base]-->/<!--[$code]-->" rel="nofollow" title="HTML Validator"><img
                    src="<!--[$base]-->/assets/img/html5.png" alt="Valid  HTML5 with SVG 1.1, MathML 3.0, RDFa 1.1, and ITS 2.0 support."></a>
    </div>
    <div class="center">
        <!--[foreach from=$logos item=tag]-->
        <a <!--[if not $tag.title|strstr:'GitHub']-->rel="nofollow"<!--[/if]--> href="<!--[$tag.link]-->" title="<!--[$tag.title|replace:'_':' ']-->"><img src="<!--[$base]-->/assets/img/<!--[$tag.image]-->" alt="<!--[$tag.title]-->" /></a>
        <!--[/foreach]-->
    </div>
    <div class="right">
        <a href="http://jigsaw.w3.org/css-validator/validator?uri=http://<!--[$host]--><!--[$base]-->/<!--[$code]-->"  rel="nofollow" title="CSS Validator">
            <img src="<!--[$base]-->/assets/img/valid-css.png" alt="Valid CSS!" />
        </a>
    </div>
</div>