<div id="footer">
    <!--[php]-->if (!preg_match('%credits%',$_SERVER['REQUEST_URI'])):<!--[/php]-->
    <p>
        <a href="<!--[$config->routes->credits]-->" class="credits" title="Credits">Click here for additional information about this page</a>
    </p>
    <!--[php]-->endif;<!--[/php]-->
    <div id="leftfoot">
        <a href="http://validator.w3.org/check?uri=http://<!--[$host]--><!--[$base]-->/<!--[$code]-->"><img
                    src="<!--[$base]-->/assets/img/html5.png" alt="Valid  HTML5 with SVG 1.1, MathML 3.0, RDFa 1.1, and ITS 2.0 support."></a>
    </div>
    <div id="centerfoot">
        <!--[foreach from=$logos item=tag]-->
        <a rel="nofollow" href="<!--[$tag.link]-->" title="<!--[$tag.title|replace:'_':' ']-->"><img src="<!--[$base]-->/assets/img/<!--[$tag.image]-->" alt="<!--[$tag.title]-->" /></a>
        <!--[/foreach]-->
    </div>
    <div id="rightfoot">
        <a href="http://jigsaw.w3.org/css-validator/validator?uri=http://<!--[$host]--><!--[$base]-->/<!--[$code]-->">
            <img src="<!--[$base]-->/assets/img/valid-css.png" alt="Valid CSS!" />
        </a>
    </div>
</div>