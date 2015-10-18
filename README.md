# Elegant Errors

### HTTP Status Codes & ErrorDocument directives with customizable templates and built in contact form

> It's time to clean up those ugly server mistakes using ErrorDocuments, RewriteRules and Class

We've all seen the very blank and less than helpful standard *404 Page Not Found* or the occasional *500 Internal Server Error* when things really have gone wrong.
 
Sometimes there's an email address, usually bogus, but it requires opening an email client, copying the address and pasting the URL, error code, writing a message along with preferably noting the time it occurred, hoping someday some action will be taken.
  
Elegant Errors aims to replace the standard dry, less than helpful, traditional error message response with beautifully stylized templates, humorous graphics and helpful messages including a self contained contact form with built-in captcha to eliminate network resource requirements.

The secure contact form captures the referrer URL, date & time, error code, server and environment info along with any user information the client optionally chooses to include when submitting the form are sent to the addresses provided in the form config section of the YAML file.  This directory is protected by an .htaccess file preventing any external access.

**Website maintainers please change the config file and enter your contact information for the secure mailer.**

## Installation

Copy the required directives the root level **.htaccess** file into your website's main folder <u>.htaccess</u> in order to enable the __ErrorDocument__ and __RewriteRule__ directives required for __ElegantErrors__ to operate properly.



+ __ElegantErrors -__ *all of these are required - they are currently Apache 2.x only*
+ __RewriteRules -__ *anything referencing __errors__ folder*
+ __DirectoryIndex -__ *only if your .htaccess file <u>does not</u> already have this directive*
+ __All Other Rules -__ *<u>optional</u> :: collected over time, use if desired and please comment...*

## Removal

Removal instructions are documented if required by a plugin or vendor requirement.<br />
<span style="font-size:75%;">(*Only required if advanced features have been enabled in <u>config.yaml</u>, otherwise safe to delete*)</span>
  
### To-Do's

Features TBD, got notes, now just need time...

<!---(
@TODO - Do it right with a RecursiveDirectoryFileIterator...
)-->
+ Background Images - *multiple folders with random per page load using one or all folders*
<!---(
@TODO - Find, adapt, create, write a middleware auth layer...
)-->
+ Auth - *remote authentication for changing config setting options*
<!---(
@see https://en.wikipedia.org/wiki/Automatic_number_announcement_circuit#ANAC_numbers
)-->
+ Service Codes - *service codes for operator modes similar to 411, 511, 611, 811, 911, etc...*
<!---(
@see https://en.wikipedia.org/wiki/Public_holidays_in_the_United_States
)-->
+ Holiday Msgs - *humorous messages for holidays as either default error message or practically wild joker card, 10xx (4 digits)*

  