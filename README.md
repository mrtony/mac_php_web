MAC中開發PHP,MySQL, Apache
===

# MAC使用Apache

1. 啟動apache
```
sudo apachectl start
```

2. 在browser開啟網頁 : `localhost`
可以看到畫面出`It Works`

若有發生錯誤
```
AH00526: Syntax error on line 20 of /private/etc/apache2/extra/httpd-mpm.conf:
Invalid command ‘LockFile‘, perhaps misspelled or defined by a module not included in the server configuration
```

解法如下:
```
sudo nano /private/etc/apache2/extra/httpd-mpm.conf
在文件中找到LockFile "/private/var/log/apache2/accept.lock"，用#注释掉如下

並將它註解
＃LockFile "/private/var/log/apache2/accept.lock"

重啟apache
sudo apachectl -k restart
```

# MAC使用php
1. 修改設定檔
```
cd /etc/apache2/
sudo nano httpd.conf
```

2. 在設定檔中開啟php功能
```
將這行註解移除
#LoadModule php5_module libexec/apache2/libphp5.so
```
3. 建立php測試頁
```
cd /Library/WebServer/Documents/
sudo nano phpinfo.php
//加入以下程式
<?php
// Show all information, defaults to INFO_ALL
phpinfo();
?>
```

4. 測試頁面: `http://localhost/phpinfo.php`

---
# 建立site
依以下2個site實作
  - [Get Apache, MySQL, PHP and phpMyAdmin working on OSX 10.10 Yosemite](http://coolestguidesontheplanet.com/get-apache-mysql-php-phpmyadmin-working-osx-10-10-yosemite/)
  - [Setting up a local web server on OS X - 有含perl的設定](https://discussions.apple.com/docs/DOC-3083)
## System Level Site
System level是一個共享的site, 不分user account. 它的位置放在`/Library/WebServer/Documents/`下。 參考上面提到的`MAC使用Apache`就是使用這個方式。


## User level root
每個user可建立自己的sites. 基本上就是建立`~/Sites`目錄下。

1. 建立sites目錄
```
cd ~
mkdir Sites
```

2. 建立conf
```
//USERNAME: 使用whoami查出自己的名己然後取代
cd /etc/apache2/users/
sudo nano USERNAME.conf
```

  - before Yosemite
```
<Directory "/Users/USERNAME/Sites/">
Options Indexes Multiviews
AllowOverride AuthConfig Limit
Order allow,deny
Allow from all
</Directory>
```

  - after Yosemite
```
<Directory "/Users/USERNAME/Sites/">
    AddLanguage en .en
    LanguagePriority en fr de
    ForceLanguagePriority Fallback
    Options Indexes MultiViews
    AllowOverride None
    Order allow,deny
    Allow from localhost
     Require all granted
</Directory>
```

3. 修改設定檔httpd.conf
```
cd /etc/apache2/
sudo nano httpd.conf
//將以下4行註解拿掉
LoadModule authz_core_module libexec/apache2/mod_authz_core.so
LoadModule authz_host_module libexec/apache2/mod_authz_host.so
LoadModule userdir_module libexec/apache2/mod_userdir.so
Include /private/etc/apache2/extra/httpd-userdir.conf
```

4. 修改設定檔httpd-userdir.conf
```
cd /etc/apache2/extra/
sudo nano httpd-userdir.conf
//確定以上這行的註解拿掉
Include /private/etc/apache2/users/*.conf
```

---
# 安裝MySQL

1. 下載MySQL
到[Download MySQL Community Server](http://dev.mysql.com/downloads/mysql/)下載*Mac OS X 10.10 (x86, 64-bit), DMG Archive*

2. 安裝
執行DMG完成安裝。安裝完成後顯示以下訊息:
```
2015-11-21T03:19:43.594110Z 1 [Note] A temporary password is generated for root@localhost: gOZf#1aF<Py8
If you lose this password, please consult the section How to Reset the Root Password in the MySQL reference manual.
```

3. 啟動MySQL
  - 使用命令列
```
sudo /usr/local/mysql/support-files/mysql.server start
```
  - 使用系統偏好去啟動: 打開*系統偏好*, 點選MySQL icon, 點選啟動按鈕
  
4. 建立mysql路徑
為了不用每次執行mysql時都要輸入mysql的執行檔路徑, 參考[What it is and How to Modify the Shell Path in OSX 10.11 El Capitan using Terminal](http://coolestguidesontheplanet.com/add-shell-path-osx/)將路徑加入，一啟動系統就直接設好。

  - 檢查PATH : `echo $PATH`, mysql並不在路徑中
  - 加入.bash_profile
```
cd ~
nano .bash_profile
//加入以下這行
export PATH="/usr/local/mysql/bin:$PATH"
```
  - 重新啟動terminal, 打`echo $PATH`, mysql的路徑就會自動設好了。
  - note: 加入暫時路徑(重啟即消失): 以PATH將原路徑再加上mysql, example如下：`PATH=/usr/bin:/bin:/usr/sbin:/sbin:/usr/local/bin:/usr/local/mysql/bin`

5. 設定mysql自動啟動
因為MAX OS 10.10後無法自動啟動mysql, [MYSQL-Installing a MySQL Launch Daemon](https://dev.mysql.com/doc/refman/5.6/en/osx-installation-launchd.html)也有提到。

  - 建立plist
```
sudo nano /Library/LaunchDaemons/com.mysql.mysql.plist
```
  - 貼上以下內容
```
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE plist PUBLIC "-//Apple//DTD PLIST 1.0//EN" "http://www.apple.com/DTDs/PropertyList-1.0.dtd">
<plist version="1.0">
  <dict>
    <key>KeepAlive</key>
    <true/>
    <key>Label</key>
    <string>com.mysql.mysqld</string>
    <key>ProgramArguments</key>
    <array>
    <string>/usr/local/mysql/bin/mysqld_safe</string>
    <string>--user=mysql</string>
    </array>
  </dict>
</plist>
```
  - 執行
```
sudo launchctl load -w /Library/LaunchDaemons/com.mysql.mysql.plist
```

6. 修正socket error
安裝mysql/php時, mysql.sock會被放在`tmp`目錄中。要搭配MAC PHP, 必需修正mysql與php的socket設定
```
sudo mkdir /var/mysql
sudo ln -s /tmp/mysql.sock /var/mysql/mysql.sock
```
注意： 千萬不用

7. 設定mysql root password
參考[MySQL修改密碼與忘記密碼重設](http://emn178.pixnet.net/blog/post/87659567-mysql%E4%BF%AE%E6%94%B9%E5%AF%86%E7%A2%BC%E8%88%87%E5%BF%98%E8%A8%98%E5%AF%86%E7%A2%BC%E9%87%8D%E8%A8%AD)
  - 方法1
```
mysql -u root -p
Enter password: 輸入安裝好產生的密碼: gOZf#1aF<Py8 , 然後就進到mysql console
//設定密碼
SET PASSWORD FOR 'root'@'localhost' = PASSWORD('123456');
```
  - 方法2
```
/usr/local/mysql/bin/mysqladmin -u root password 'yourpasswordhere'
```

8. 建立user
  - 查詢
```
SELECT User, Host FROM mysql.user;
```
  - 建立user: 參考[CREATE USER Syntax](http://dev.mysql.com/doc/refman/5.5/en/create-user.html),[Adding User Accounts](http://dev.mysql.com/doc/refman/5.5/en/adding-users.html)
```
CREATE USER 'chenchihho'@'localhost' IDENTIFIED BY '123456';
```

---
# 安裝phpMyadmin
參考[Get Apache, MySQL, PHP and phpMyAdmin working on OSX 10.10 Yosemite](http://coolestguidesontheplanet.com/get-apache-mysql-php-phpmyadmin-working-osx-10-10-yosemite/)實作。
1. 下載: [download](https://www.phpmyadmin.net/downloads/), 選`phpMyAdmin-4.5.1-all-languages.zip`
2. 解壓縮到: `~/Sites/phpmyadmin`
3. 建立config目錄並變更權限
```
mkdir ~/Sites/phpmyadmin/config
chmod o+w ~/Sites/phpmyadmin/config
```
4. 到phpmyadmin設定頁面: `http://localhost/~chenchihho/phpmyadmin/setup/`
5. 選擇*建立伺服器*或*create server*
6. 選擇*認證*或*Authentication*的TAB
7. 輸入mysql的root的密碼後儲存。會自動切換到主頁面，並顯示伺服器資訊。
8. 執行下方的儲存，在`~/Sites/phpmyadmin/config`中會產生`config.inc.php`, 將它move到`~/Sites/phpmyadmin`並將`~/Sites/phpmyadmin/config`空目錄刪除。

我有將config.php備份出來, 從Github clone下來後因為沒有phpadmin, 下載完解壓後, 再將這個檔案放入phpadmin目錄中即可。