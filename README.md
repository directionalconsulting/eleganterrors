# Elegant Errors

### HTTP Status Codes & ErrorDocument directives with customizable templates and built in contact form

> Because it's a mistake to excuse errors without class

We've all seen the very blank and less than helpful standard *404 Page Not Found* or the occasional *500 Internal Server Error* when things really have gone wrong.
 
Sometimes there's an email address, usually bogus, but it requires opening an email client to send the broken URL with server error code hoping someone takes action and fixes the problem.
  
Elegant Errors replaces standard error pages using beautifully stylized templates, humorous graphics, helpful messages and a contact form with built-in captcha to eliminate network resource requirements.

The contact form captures the server environment including referrer URL and any user information the client optionally chooses to include when submitting the form.  The form is securely mailed using PHP and captcha to eliminate spam to the addresses of your choice easily changed in the config file. 

__>> Website maintainers <u>please change the contact email</u> in the config.yaml file__

<span style="font-size:75%;"> __PRODUCTION SERVERS:__ Generate __config.json__ prior to uploading with [PECL YAML](http://php.net/manual/en/book.yaml.php), DO NOT manually edit the file.</span>


## Installation

Copy the required directives the root level **.htaccess** file into your website's main folder <u>.htaccess</u> in order to enable the __ErrorDocument__ and __RewriteRule__ directives required for __ElegantErrors__ to operate properly.

+ __ErrorDocument -__ *all of these are required - they are currently Apache 2.x only*
+ __RewriteRules -__ *anything referencing __errors__ folder*
+ __DirectoryIndex -__ *only if your .htaccess file <u>does not</u> already have this directive*
+ __All Other Rules -__ *<u>optional</u>: collected over time, use if desired and please comment...*

## Removal

Removal instructions are documented if required by a plugin or vendor requirement.<br />
<span style="font-size:75%;">(*Only required if certain advanced features have been enabled in <u>config.yaml</u>, otherwise safe to delete, __see #comments__*)</span>

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

### @TODOs

Features TBD, got notes, just need time...

+ Background Images - *multiple folders with random per page load using one or all folders*
+ Auth - *remote authentication for changing config setting options*
+ Service Codes - *service codes for operator modes similar to 411, 511, 611, 811, 911, etc...*
+ Holiday Msgs - *holiday messages using 10xx (4 digit) codes*
+ Redirect Countdown - *JS countdown timeout for redirection of URL with 3xx codes*
+ Logging - *$_SESSION history of URLs visited preceeding the status code response page*
+ Database - *abstraction layer for MySQL, PostgreSQL, MongoDB, InfluxDB, sqlite3, etc...*
+ Dashboard - *view logs, status codes and history patterns by URL plus change config options*
+ Tests - *PHPUnit, Mess Detector and Code Coverage for classes, modules, routes, configs, etc...*
+ Packaging - *Composer vendor library with all assets required for inclusion in composer.json file*

  