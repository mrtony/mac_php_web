使用PHP和Mysql
===

使用php和mysql來開發專案。

# 安裝
1. 下載phpmyadmin
2. 在`~/Sites`中建立phpmyadmin目錄
3. 將phpmyadmin解壓到該目錄中
4. 將config.inc.php放入目錄中

### 安裝phpMyadmin
參考[Get Apache, MySQL, PHP and phpMyAdmin working on OSX 10.10 Yosemite](http://coolestguidesontheplanet.com/get-apache-mysql-php-phpmyadmin-working-osx-10-10-yosemite/)實作。
1. 下載: [download](https://www.phpmyadmin.net/downloads/), 選`phpMyAdmin-4.5.1-all-languages.zip`
2. 解壓縮到: `~/Sites/phpmyadmin`
3. 建立config目錄並變更權限


# 連線mysql並取得資料庫中一個table的資料

```
<?php
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '123456';
    $dbname = 'HR';
    $conn = mysql_connect($dbhost, $dbuser, $dbpass) or die('Error with MySQL connection');
    mysql_select_db($dbname);
	$query="SELECT * FROM employees";
	$result=mysql_query($query) or die('MySQL query error');
    $num = mysql_numrows($result);
    mysql_close();
    while($row = mysql_fetch_array($result)){
        echo $row["FirstName"];
    }
    
    echo $num
?>
```

# 使用notOrm的ORM
找到一個php用的light ORM - [NotORM](http://www.notorm.com/).

找到一個教學的站：
 - [Database Interaction Made Easy with NotORM](http://www.sitepoint.com/database-interaction-made-easy-with-notorm/)
 
於是用這個站來搭配`HR database`試了一個頁面, 可印出薪水大於6500的名單。 (看`notOrmTest.php`)

# 其他ORM

1. [Doctrine, the PHP ORM Framework](http://blog.eddie.com.tw/2008/12/23/doctrine-the-php-orm-framework/)
2. [Propel](http://propelorm.org/)
3. [ActiveRecord](http://0x3f.org/blog/flamework-active-record/)

---
# 框架

## Laravel

1. Eloquent ORM : 內建的ORM


## 使用nette


