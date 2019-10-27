# selfdestruct
A super simple cronjob to delete folders on a given date.

# Content
* index.php: An overview of folders that should get deleted
* cron.php: The cronjob you can execute once per day
* deletelist.txt: The list of folders that should be deleted

# Setup
1. Add the project to your root folder. The script is designed to delete folders that are within the parent folder (../*).
2. Add the folders you like to delete in the future to deletelist.txt. Add the dates in the format YYYY-MM-DD and make sure single digits have a leading zero.
3. Add a cronjob so that cron.php is executed once per day (curl https://yourwebsite.com/selfdestruct/cron.php)
4. Optional: Protect the selfdestruct folder with htaccess. If you do so, make sure your cronjob is using the credentials to execute (curl -u user:pass https://yourwebsite.com/selfdestruct/cron.php)

# Remarks
* The script will ignore lines in deletelist.txt that start with *#* or are empty
* In the ovierview you have an additional column that tells you if the folder still exists
