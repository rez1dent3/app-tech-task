## App tech task

A simple example of working with symfony components.

* **Vendor**: rez1dent3
* **Package**: app-tech-task
* **PHP Version**: 7.4
* **Based symfony components**: `5.x`
* **[Composer](https://getcomposer.org/):** `composer create-project --prefer-dist rez1dent3/rez1dent3/app-tech-task`

[[API Docs](https://documenter.getpostman.com/view/5325225/TVKA5eob)] 
[[Demo](https://tech-task-app.herokuapp.com/)] 
[[Postman File](https://raw.githubusercontent.com/rez1dent3/app-tech-task/master/API.postman_collection.json)]

### Get started 

Builds, creates and attaches to containers for a service.
```bash
docker-compose up -d
```

Creating a database schema.
```bash
docker-compose exec php composer docrtine:schema
```

It worked!

---
Supported by

[![Supported by JetBrains](https://cdn.rawgit.com/bavix/development-through/46475b4b/jetbrains.svg)](https://www.jetbrains.com/)
