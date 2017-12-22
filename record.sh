#!/bin/sh
# RaspiDash
# github.com/smugzombie

# Define filename prefix 
file_name=/opt/raspidash/video/webcam_

for i in `seq 1 1 100` 
do
	# Grab current timestamp (Will be odd without rtc..)
	current_time=$(date "+%b-%d-%Y__%H.%M.%S")	 
	# Build the new filename
	new_fileName=$file_name$current_time.mp4
	# Start recording to the new file
	avconv -f video4linux2 -r 16 -s 640x480 -i /dev/video0 -c:v mpeg4 -r 16 -an -s 640x480 -b 1024k -t 00:30:30 -y $new_fileName
done
 
