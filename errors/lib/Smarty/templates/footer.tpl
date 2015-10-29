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
        <a rel="license" href="https://www.gnu.org/licenses/gpl-3.0-standalone.html" title="GNU GPLv3 License"><img src="<!--[$base]-->/assets/img/gplv3.png" alt="GPLv3"/></a>
	    <a rel="license" href="https://www.gnu.org/licenses/gpl-3.0-standalone.html" title="GNU GPLv3 License"><img src="<!--[$base]-->/assets/img/apache.png" alt="Apache"/></a>
	    <a rel="license" href="https://www.gnu.org/licenses/gpl-3.0-standalone.html" title="GNU GPLv3 License"><img src="<!--[$base]-->/assets/img/php.png" alt="PHP"/></a>
	    <a rel="license" href="https://www.gnu.org/licenses/gpl-3.0-standalone.html" title="GNU GPLv3 License"><img src="<!--[$base]-->/assets/img/javascript.png" alt="GPLv3"/></a>
	    <a rel="license" href="https://www.gnu.org/licenses/gpl-3.0-standalone.html" title="GNU GPLv3 License"><img src="<!--[$base]-->/assets/img/json.png" alt="JSON"/></a>
	    <a rel="license" href="https://www.gnu.org/licenses/gpl-3.0-standalone.html" title="GNU GPLv3 License"><img src="<!--[$base]-->/assets/img/yaml.png" alt="YAML"/></a>
    </div>
    <div id="rightfoot">
        <a href="http://jigsaw.w3.org/css-validator/validator?uri=http://<!--[$host]--><!--[$base]-->/<!--[$code]-->">
            <img src="<!--[$base]-->/assets/img/valid-css.png" alt="Valid CSS!" />
        </a>
    </div>
</div>