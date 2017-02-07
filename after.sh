#!/usr/bin/env bash
tr -d '\r' <~/.bash_aliases >~/tmp
mv ~/tmp ~/.bash_aliases