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

### Check if database is up and running

- [go to phpMyAdmin](http://localhost:8001)
- login with username: root, password: Azerty123

---

## URL Paths

```
GET	/

GET	/login
POST	/login

GET	/register
POST	/register

GET	/tirps
GET	/trips/{{ID}}
POST	/trips/new

GET	/users

GET	/reviews
GET	/reviews/{{ID}}
POST	/reviews/new
```

---

## Support

if u want support contact one of the developers ;)

---

## Authors

[Downes Lukas](https://gitlab.com/lukas.downes)
[Bert Van den Broeck](https://gitlab.com/bert.vandenbroeck)
[Van de Voorde Siebe](https://gitlab.com/siebe.vandevoorde)

---

## License

licened by [odisee](https://odisee.be)

---