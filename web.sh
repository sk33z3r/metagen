#!/usr/bin/env bash

case $1 in
    down) docker-compose down;;
    up) docker-compose up -d;;
    *) echo "Invalid command: $0 [down|up]"; exit 1;;
esac
