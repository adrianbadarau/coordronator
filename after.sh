#!/usr/bin/env bash
tr -d '\r' <~/.bash_aliases >~/tmp
mv ~/tmp ~/.bash_aliases
#export XDEBUG_CONFIG="remote_enable=1 remote_mode=req remote_port=9000 remote_host=192.168.10.10 remote_connect_back=0"
export PHP_IDE_CONFIG="serverName=vagrant"
export XDEBUG_CONFIG="idekey=PHPSTORM remote_host=192.168.10.10 profiler_enable=1"