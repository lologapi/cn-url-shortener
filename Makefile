#!/bin/bash

UID = $(shell id -u)

build:
	podman build --build-arg UID=${UID} -t api-nginx-image -f ./containers/nginx/Dockerfile ./containers/nginx
	podman build --build-arg UID=${UID} -t api-php-image -f ./containers/php/Dockerfile ./containers/php

start: ## Start the containers
	@podman pod inspect api > /dev/null 2>&1 || podman pod create --name api -p 8080:80 -p 9000:9000
	@podman inspect api-php > /dev/null 2>&1 || podman run -dt --name api-php --pod api --volume "$(PWD)":/appdata/www:rw --restart on-failure api-php-image
	@podman inspect api-nginx > /dev/null 2>&1 || podman run -dt --name api-nginx --pod api --restart on-failure api-nginx-image
	@podman pod start api || true

stop:
	@podman pod stop api
