# SNT Media Backend Coding Challenge

### Summary:

This coding challenge has two parts. First, you will be creating a job that parses and consumes an XML feed of real estate data. Secondly, you will create a small RESTful API to query and update the data.

### Environment Setup:

Install Docker for [Mac][dockerMac] or [Windows][dockerWin].

[dockerMac]:
https://docs.docker.com/docker-for-mac/

[dockerWin]:
https://docs.docker.com/docker-for-mac/

Terminal into the directory with the project Dockerfile.

```sh
$ docker-compose up -d
```

Add the folling to your hosts file on your local machine.

```sh
127.0.0.1 sntmediachallenge.local
```

### API Usage:

There are 3 endpoints:

  - All Listings: http://sntmediachallenge.local/api/listings/all
  - Filtered Paged Listings: http://sntmediachallenge.local/api/listings/filtered?per_page=5
  - Update Listing: http://sntmediachallenge.local/api/listings/{mls_number}/{active|inactive}

Filtered Paged Listings Parameter Options:

```sh
per_page: integer, default 10
order_by: list_price, default null
order_dir: asc|desc, default desc if order_by is set
photos_only - true|false, default false
```

Filtered Paged Listings Example:

http://sntmediachallenge.local/api/listings/filtered?per_page=2&order_by=list_price&order_dir=desc&photos_only=true