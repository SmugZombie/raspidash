#!/bin/bash
# Starts the Raspidash python webserver for offloading videos
# github.com/smugzombie

cd /opt/raspidash/video
/usr/bin/nohup python -m SimpleHTTPServer &
