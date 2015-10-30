#!/bin/bash
#
# .git Commit and clean script...
#
# Gordon Hackett - Directional-Consulting.com
# 2015-10-29 19:11:06
# 1446171072890
#
##
rm errors/lib/config.xml -fv
rm errors/lib/config.json -fv
rm errors/lib/Smarty/cache/* -fv
rm errors/lib/Smarty/templates_c/* -fv
read -p "Press [Reload] button in web browser to update config files..."
sudo chown gman.www-data * -R
rm errors/lib/Smarty/cache/* -fv
rm errors/lib/Smarty/templates_c/* -fv
git add --all
git commit
git push -u origin master
