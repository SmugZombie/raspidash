#!/bin/sh
 
file_name=/opt/raspidash/video/webcam_

for i in `seq 1 1 100` 
do
	current_time=$(date "+%b-%d-%Y__%H.%M.%S")	 
	new_fileName=$file_name$current_time.mp4
	avconv -f video4linux2 -r 16 -s 640x480 -i /dev/video0 -c:v mpeg4 -r 16 -an -s 640x480 -b 1024k -t 00:30:30 -y $new_fileName
done
 
