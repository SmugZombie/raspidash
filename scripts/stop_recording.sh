#!/bin/bash
# Kills the record.sh script associated with raspidash, as well as anything using the avconv service
# github.com/smugzombie

recordingPID=$(ps aux | grep record.sh | grep -v grep | awk {'print $2'})
for i in $recordingPID; do
        echo "Killing PID: " $i
        kill $i
done

cameraPID=$(ps aux | grep avconv | grep -v grep | awk {'print $2'})
for i in $cameraPID; do
        echo "Killing PID: " $i
        kill $i
done

