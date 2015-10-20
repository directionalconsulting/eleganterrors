<?php /* Smarty version 2.6.18, created on 2015-10-20 14:18:33
         compiled from footer.tpl */ ?>
<div id="footer">
    <div id="leftshoe">
        <a href="http://validator.w3.org/check?uri=referer"><img
                    src="http://www.w3.org/Icons/valid-html401" alt="Valid HTML 4.01 Transitional" height="31" width="88"></a>
    </div>
    <div id="doormat">
        <?php if (!preg_match('%credits%',$_SERVER['REQUEST_URI'])): ?>
        <p>
            <a href="<?php echo $this->_tpl_vars['config']->credits->link; ?>
" class="credits" title="Credits">Click here for additional information about this page</a>
        </p>
        <?php endif; ?>
        <a rel="license" href="https://www.gnu.org/licenses/gpl-3.0-standalone.html" title="GNU GPLv3 License"><img src="<?php echo $this->_tpl_vars['base']; ?>
/assets/img/gplv3.png"/></a>
    </div>
    <div id="rightshoe">
        <a href="http://jigsaw.w3.org/css-validator/check/referer">
            <img style="border:0;width:88px;height:31px;" src="http://jigsaw.w3.org/css-validator/images/vcss" alt="Valid CSS!">
        </a>
    </div>
</div>