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