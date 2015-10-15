# Elegant Errors

## Error Documents with customizable templates and self contained Contact Form

We've all seen the very blank and less than helpful standard *404 Page Not Found* or the occasional *500 Internal Server Error* when things really have gone wrong.
 
Sometimes there's an email address, usually bogus, but it requires opening an email client, copying the address and pasting the URL, error code, writing a message along with preferably noting the time it occurred, hoping someday some action will be taken.
  
Elegant Errors aims to replace the standard dry, less than helpful, traditional error message response with beautifully stylized templates, humorous graphics and helpful messages including a self contained contact form with built-in captcha to eliminate network resource requirements.

The secure contact form captures the referrer URL, date & time, error code, server and environment info along with any user information the client optionally chooses to include when submitting the form are sent to the addresses provided in the form config section of the YAML file.  This directory is protected by an .htaccess file preventing any external access.

**Website maintainers please change the config file and enter your contact information for the secure mailer.**

## Installation

Copy the required directives from **/.htaccess** file into your .htaccess file.

+ ErrorDocument - *all of these are required - they are currently Apache 2.x only*
+ RewriteRules - *anything referencing /errors folder*
+ DirectoryIndex - *only if your .htaccess file does not already have this directive*
+ **All Other Rules -** *optional :: mostly from other files collected over time, please comment...*
  
### To-Do's:

Features TBD, got my notes, now just need time...

+ Background Images - *multiple folders with random per page load using one or all folders with config setting*
+ Auth - *remote authentication for changing config setting options*
+ Service Codes - *service codes for operator modes similar to 411, 511, 611, 811, 911, etc...*
  