# Telegram

This is for Telegram Robots, If you want to create a new BOT in telegram and using Apache Webserver you can connect your information to your webhost.

You could only should Save files and do Some Changes.

* I've designed control panel for it, with boostrap, to control something.
* You could control your bot with your Telegram Account in your cellphone or desktop platform.
* Please note! it's important you must upload files in pr .
* You should put your telegram ID in >> config.php put number in $contact_us_user_id=array("HERE"), without "".
* You should put your token ID in >> config.php line 2 => $bot_token="5822988914:AAHzZasdfsdf6dzzmM0A-Pd4CIxwDGTUposJg".
* You should import db.sql file to your database.
* You should turn on your cronjob in your control panel, Please add them in your cronjob:
/usr/local/bin/php -q /home/YOUR_NAME/YOUR_DIR/index.php > /home/YOUR_NAME/YOUR_DIR/crnoutputtg.txt 2>&1
sleep 5; /usr/local/bin/php -q /home/YOUR_NAME/YOUR_DIR/index.php > /home/YOUR_NAME/YOUR_DIR/crnoutputtg.txt 2>&1
sleep 35; /usr/local/bin/php -q /home/YOUR_NAME/YOUR_DIR/index.php > /home/YOUR_NAME/YOUR_DIR/crnoutputtg.txt 2>&1
sleep 40; /usr/local/bin/php -q /home/YOUR_NAME/YOUR_DIR/index.php > /home/YOUR_NAME/YOUR_DIR/crnoutputtg.txt 2>&1
sleep 45; /usr/local/bin/php -q /home/YOUR_NAME/YOUR_DIR/index.php > /home/YOUR_NAME/YOUR_DIR/crnoutputtg.txt 2>&1
sleep 50; /usr/local/bin/php -q /home/YOUR_NAME/YOUR_DIR/index.php > /home/YOUR_NAME/YOUR_DIR/crnoutputtg.txt 2>&1
sleep 55; /usr/local/bin/php -q /home/YOUR_NAME/YOUR_DIR/index.php > /home/YOUR_NAME/YOUR_DIR/crnoutputtg.txt 2>&1
/usr/local/bin/php -q /home/YOUR_NAME/YOUR_DIR/mass_cron.php > /home/YOUR_NAME/YOUR_DIR/crnoutputtgmass.txt 2>&1 */2	
sleep 10; /usr/local/bin/php -q /home/YOUR_NAME/YOUR_DIR/index.php > /home/YOUR_NAME/YOUR_DIR/crnoutputtg.txt 2>&1
sleep 15; /usr/local/bin/php -q /home/YOUR_NAME/YOUR_DIR/index.php > /home/YOUR_NAME/YOUR_DIR/crnoutputtg.txt 2>&1
sleep 20; /usr/local/bin/php -q /home/YOUR_NAME/YOUR_DIR/index.php > /home/YOUR_NAME/YOUR_DIR/crnoutputtg.txt 2>&1
sleep 25; /usr/local/bin/php -q /home/YOUR_NAME/YOUR_DIR/index.php > /home/YOUR_NAME/YOUR_DIR/crnoutputtg.txt 2>&1
sleep 30; /usr/local/bin/php -q /home/YOUR_NAME/YOUR_DIR/index.php > /home/YOUR_NAME/YOUR_DIR/crnoutputtg.txt 2>&1

* YOUR_NAME is your home name, YOUR_DIR is a directory or folder name that you've uploaded files. 
You can download the commands, cronjobs.txt file.
* There are some persian phrases, please let me know, if you would to change it to your language. :-)
This file will be change in future ... :-)
