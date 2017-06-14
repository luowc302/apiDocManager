# 获取Ibos官网授权表

#### 通过composer加载包。
````
composer require luo/scrape-ibos
````
#### 运行，即可直接返回csv表格至浏览器(默认返回)。
````
runScrape::run();
````

#### 如果需要返回JSON格式，请如下运行。
````
runScrape::run(1);
````
