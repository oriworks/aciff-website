#!/bin/bash
docker run --rm -v $(pwd):/var/www/html --network host php8.2:latest php "$@"