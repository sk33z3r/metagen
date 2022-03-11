#!/usr/bin/env bash

case $1 in
    down) docker-compose down;;
    up) docker-compose up -d --build --force-recreate;;
    reload) docker-compose restart;;
    *) echo "Invalid command: $0 [down|up|reload]"; exit 1;;
esac
