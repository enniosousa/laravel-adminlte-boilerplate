## Install

#### Prepare the .env (copy and customize the copy)
```
cp .env.example .env
```

#### Create containers stack
```
docker-compose up -d
```

#### Create sail alias to run PHP and Laravel Command Line
```
alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'
```

#### Migrate database
```
sail php artisan migrate
```