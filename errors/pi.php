<?php
/**
 * Created by PhpStorm
 * Project: defense-ability
 * User: gman
 * Date: 10/1/15
 * Time: 11:48 PM
 */
ob_start();
phpinfo();
$contents = ob_get_clean();

$display = preg_replace("%(^.*?)\b(Environment.*?)\b(PHP License.*$)%sim","$1$3",$contents);
$display = preg_replace('%<td class="e">SMTP%','<td class="e" style="background-color:yellow;">SMTP',$display);
$display = preg_replace('%<td class="e">sendmail_from%','<td class="e" style="background-color:yellow;">sendmail_from',$display);

echo $display;
?>
