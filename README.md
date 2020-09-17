## App tech task

A simple example of working with symfony components.

* **Vendor**: rez1dent3
* **Package**: app-tech-task
* **PHP Version**: 7.4
* **Based symfony components**: `5.x`
* **[Composer](https://getcomposer.org/):** `composer create-project --prefer-dist rez1dent3/rez1dent3/app-tech-task`


[[API Docs](https://documenter.getpostman.com/view/5325225/TVKA5eob)] 
[[Demo](https://tech-task-app.herokuapp.com/)] 

### Get started 

Copy and configure .env:
```
cp .env.dev .env
vi .env
```

Let's get started:
```bash
docker-compose up -d
docker-compose exec php composer docrtine:schema
```

The postman file can be found [here](https://raw.githubusercontent.com/rez1dent3/app-tech-task/master/API.postman_collection.json).

It worked!

---
Supported by

[![Supported by JetBrains](https://cdn.rawgit.com/bavix/development-through/46475b4b/jetbrains.svg)](https://www.jetbrains.com/)
