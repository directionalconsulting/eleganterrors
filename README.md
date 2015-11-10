# Elegant Errors

### HTTP Status Codes & ErrorDocument directives with customizable templates and built in contact form

> Oops... a server error occurred, not without class!

We've all seen the very blank and less than helpful standard *404 Page Not Found* or the occasional *500 Internal Server Error* when things really have gone wrong.
 
Sometimes there's an email address, usually bogus, but it requires opening an email client to send the broken URL with server error code hoping someone takes action and fixes the problem.
  
Elegant Errors replaces standard error pages using beautifully stylized templates, humorous graphics, helpful messages and a contact form with built-in captcha to eliminate network resource requirements.

The contact form captures the server environment including referrer URL and any user information the client optionally chooses to include when submitting the form.  The form is securely mailed using PHP and captcha to eliminate spam to the addresses of your choice easily changed in the config file. 

__>> Website maintainers <u>please change the contact email</u> in the config.yaml file__

<span style="font-size:75%;"> __PRODUCTION SERVERS:__ Generate __config.json__ prior to uploading with [PECL YAML](http://php.net/manual/en/book.yaml.php), DO NOT manually edit the file.</span>

Give it a try @ [/errors/demo](http://gordonhackett.com/errors/demo)

-----------

## Requirements

+ PHP
  - version 5.3.x or higher
  - [Composer](https://www.digitalocean.com/community/tutorials/how-to-install-and-use-composer-on-ubuntu-14-04)
+ PECL
  - [YAML](https://pecl.php.net/package/yaml)
+ PEAR
  - [phpDocumentor](http://www.phpdoc.org/)
  - [Mail](https://pear.php.net/package/Mail)
  - [Mail_Mime](https://pear.php.net/package/Mail_Mime)
  - [Net_SMTP](https://pear.php.net/package/Net_SMTP)
+ Web Servers
  - Apache version 2.2.x or higher
  - <i>NginX and Microsoft IIS coming soon...</i>
+ Linux
  - tested on [Ubuntu Trusty](http://releases.ubuntu.com/14.04/)

## Installation

1. Checkout or download the zip to get the files into a working directory.  
2. ```cd``` into the working directory and type ```composer update``` to update the vendor folder.
3. Make a backup of your main ```.htaccess``` file.
4. Copy the __ErrorDocument__ and __RewriteRule__ directives from the working directory __.htaccess__ file.
  + The following rules are required for __ElegantErrors__ to operate properly:
    - __ErrorDocument -__ *all of these are required - they are currently Apache 2.x only*
    - __RewriteRules -__ *anything referencing __errors__ folder*
    - __DirectoryIndex -__ *only if your .htaccess file <u>does not</u> already have this directive*
    - __All Other Rules -__ *<u>optional</u>: collected over time, use if desired and please comment...*
  <br /><span style="font-size:85%;"><i>The directives should be copied into the main root level .htaccess file.<br />Carefully inspect your file for duplicates or conflicts before uploading.</i></span><br />
5. Upload the __/errors__ folder and your new main ```.htaccess``` file
6. Change the write permissions to __777__
  - __/errors/lib/Smarty/templates_c__
  - __/errors/lib/Smarty/cache__

## Removal

Removal instructions are documented if required by a plugin or vendor requirement.<br />
<span style="font-size:75%;">(*Only required if certain advanced features have been enabled in <u>config.yaml</u>, otherwise safe to delete, __see #comments__*)</span>

-----------

### License
See the GNU General Public License found in LICENSE.txt for more details.  
  
### References
For the complete list of references, please visit the __/errors/credits__ page within the application.
+ [HTTP Status Codes](https://en.wikipedia.org/wiki/Public_holidays_in_the_United_States)
+ [Public Holidays USA](https://en.wikipedia.org/wiki/Public_holidays_in_the_United_States)
+ [IETF RFC](https://www.ietf.org/rfc.html)
+ [ANAC Numbers](https://en.wikipedia.org/wiki/Automatic_number_announcement_circuit#ANAC_numbers)
+ __Apache Documentation__
  + [.htaccess Tutorial](http://httpd.apache.org/docs/current/howto/htaccess.html)
  + [Custom Error Documents](https://httpd.apache.org/docs/2.4/custom-error.html)
  + [Environment Variables](https://httpd.apache.org/docs/2.2/env.html)
  + [Rewrite Rules](http://httpd.apache.org/docs/2.2/mod/mod_rewrite.html)
    + [Rewrite Flags](https://httpd.apache.org/docs/2.4/rewrite/flags.html)    
  + [Aliases & Redirects](https://httpd.apache.org/docs/2.2/mod/mod_alias.html)

---------

#### @TODOs

Features TBD, got notes, just need time...

+ Background Images - *multiple folders with random per page load using one or all folders*
+ Auth - *remote authentication for changing config setting options*
+ Service Codes - *service codes for operator modes similar to 411, 511, 611, 811, 911, etc...*
+ Holiday Msgs - *holiday messages using 98x ~ 999 codes*
+ Redirect Countdown - *JS countdown timeout for redirection of URL with 3xx codes*
+ Logging - *$_SESSION history of URLs visited preceeding the status code response page*
+ Config - *split into multiple sectional files to simplify editing, codes, routes, contact, etc...*
+ Database - *abstraction layer for MySQL, PostgreSQL, MongoDB, InfluxDB, sqlite3, etc...*
+ Dashboard - *view logs, status codes and history patterns by URL plus change config options*
+ Tests - *PHPUnit, Mess Detector and Code Coverage for classes, modules, routes, configs, etc...*
+ Packaging - *Composer vendor library with all assets required for inclusion in composer.json file*
