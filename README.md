# selfdestruct
A super simple cronjob to delete folders on a given date. No database required.

# Content
* `index.php`: An overview of folders that should get deleted
* `cron.php`: The cronjob you can execute once per day
* `TextFileAccess.php`: Simple file access functions
* `deletelist.txt`: The list of folders that should be deleted

![Image of Self-Destruct Overview page](https://user-images.githubusercontent.com/2188617/67633316-b9feeb00-f8ae-11e9-98c5-cae6ccf3638f.PNG)

# Setup
1. Add the project to your root folder. The script is designed to delete folders that are within the parent folder (`../*`).
2. Create an empty file deletelist.txt. Access index.php in the browser, and add the folders you would like to delete with dates in the format `YYYY-MM-DD`. Make sure single digits have a leading zero.
3. Add a cronjob so that cron.php is executed once per day (`curl https://yourwebsite.com/selfdestruct/cron.php`)
4. Optional: Protect the selfdestruct folder with htaccess. If you do so, make sure your cronjob is using the credentials for execution (`curl -u user:pass https://yourwebsite.com/selfdestruct/cron.php`)

# Remarks
* The script will ignore lines in deletelist.txt that start with `#` or are empty
* On the overview page you have an additional column that tells you if the folder still exists
* If you add `*` as folder, everything inside your root folder (including the selfdestruct folder) will get deleted
* **Use of this tool at your own risk!**
