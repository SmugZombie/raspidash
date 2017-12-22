#!/bin/bash
# Kills the Raspidash python process
# github.com/smugzombie

raspidashPID=$(ps aux | grep raspidash | grep -v grep | awk {'print $2'})
for i in $raspidashPID; do
        echo "Killing PID: " $i
        kill $i
done

