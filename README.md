# 理想国网络验证系统

> 已然遥远的理想乡，那是我们的理想国

## 要求

- php>=8.1
- laravel

## 安装
```shell
git clone git@github.com:zmoyi/Utopia.git

cd Utopia

composer install

cp .env.example .env

php artisan key:generate
```

## 配置数据库
在 .env 文件中配置数据库连接信息，包括数据库类型、数据库地址、数据库名称、数据库用户名和密码等。
```shell
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=database_name
DB_USERNAME=database_username
DB_PASSWORD=database_password

#队列
QUEUE_CONNECTION=redis

# 全文搜索驱动以及是否开启队列
SCOUT_QUEUE=true
SCOUT_DRIVER=database
```

### 导入全文搜索索引
```shell
php artisan scout:import "App\Models\CardCodes "
```
