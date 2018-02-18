PHP Framework-free Realworld App Example
========================================

[![Build Status](https://travis-ci.org/ztsu/php-fwfree-realworld-app.svg?branch=master)](https://travis-ci.org/ztsu/php-fwfree-realworld-app)

## Spec complete status (2/19)

- `POST /api/users/login` ✔
- `POST /api/users` ✔
- `GET /api/user` ✔
- `PUT /api/user`
- `GET /api/profiles/:username`
- `POST /api/profiles/:username/follow`
- `DELETE /api/profiles/:username/follow`
- `GET /api/articles`
- `GET /api/articles/feed`
- `GET /api/articles/:slug`
- `POST /api/articles`
- `PUT /api/articles/:slug`
- `DELETE /api/articles/:slug`
- `POST /api/articles/:slug/comments`
- `GET /api/articles/:slug/comments`
- `DELETE /api/articles/:slug/comments/:id`
- `POST /api/articles/:slug/favorite`
- `DELETE /api/articles/:slug/favorite`
- `GET /api/tags`

## How to run

```sh
$ make install
$ make db
$ make run
```