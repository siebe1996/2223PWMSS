# 2223PWMSS

## Description

This is a school project. Rebu is a taxi app build for web&mobile server side.

---

## Installation

### Pull project

```
cd existing_repo
git remote add origin https://gitlab.com/ikdoeict/siebe.vandevoorde/2223PWMSS.git
git branch -M main
git push -uf origin main
```

### Start up composer

```
cd existing_repo
docker compose up
```
open new terminal
```
cd existing_repo
docker compose exec php-web bash
composer install
```

### Install Node.js
```
cd app/public/js/openLayers/
npm install
```

### Check if database is up and running

- [go to phpMyAdmin](http://localhost:8001)
- login with username: root, password: Azerty123

### Check if site is up and running

- [go to site](http://localhost:8080)

---

## URL Paths

```
GET     /
POST    /

GET     /about
GET     /me
GET     /me/months/(\d+)
POST    /me/search

GET     /login
POST    /login
GET     /logout
GET     /register
POST    /register
GET     /verification
POST    /verification

POST 	/rides/(\d+)/cancel
POST    /diver/rides/(\d+)/accept
GET     /driver/rides/(\d+)confirm
POST 	/driver/rides/(\d+)/accept
GET 	/driver/rides/(\d+)/confirm
POST 	/driver/rides/(\d+)/confirm
POST 	/driver/rides/(\d+)/cancelstartfinish

GET 	/driver/rides
GET     /drivers/create
POST    /drivers/create
GET 	/drivers/(\d+)
POST 	/drivers/(\d+)/search
GET 	/drivers/(\d+)/months/(\d+)

GET 	 /badrequest
```

---

## Support

if u want support contact one of the developers ;)

---

## Authors

[Downes Lukas](https://gitlab.com/lukas.downes), 
[Van den Broeck Bert](https://gitlab.com/bert.vandenbroeck), 
[Van de Voorde Siebe](https://gitlab.com/siebe.vandevoorde)

---

## License

licensed by [Odisee](https://odisee.be)

---