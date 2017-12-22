#!/bin/bash

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

