propel ORM
===

# 安裝
依官網的安裝驟來安裝。

### 安裝方式
有3種安裝方式
1. composer
2. git
3. zip

先使用git來安裝。
```
git clone git://github.com/propelorm/Propel2 vendor/propel
```

測試propel安裝是否正確
```
cd myproject
ln -s vendor/propel/bin/propel propel
propel
```

另一種方式比較方便, 在`.bash_profile`中加入path
```
nano .basc_profile
export PATH="/Users/chenchihho/Sites/vendor/propel/bin:$PATH"
```
---
# 開始使用 - Database first

### config

* [Configuration Properties Reference](http://propelorm.org/documentation/reference/configuration-file.html)


---
# 資源

### 官網
* [propel](http://propelorm.org/)
* [install](http://propelorm.org/documentation/01-installation.html)