<?xml version="1.0" encoding="utf-8"?>
{browser_detect vendor="bot" assign=browser}
{include file="contactus_header.tpl"}
{if $smarty.server.REQUEST_URI eq '/thank-you'}
{include file="thankyou_write.tpl"}
{else}
{include file="contactus_write.tpl"}
{/if}
{include file="footer.tpl"}