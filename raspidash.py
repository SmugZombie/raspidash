#!/usr/bin/python
# RaspiDash v1
# Simple service which watches for a specific bluetooth device to enable / disable recording. Built for use as a dash camera
# github.com/smugzombie
# Requires: Blinkstick device (Otherwise remove references to blinkstick

import subprocess
import bluetooth
import time
import os
try:
	from blinkstick import blinkstick
except:
	blinkstick_enabled = False
# Global Variables
if blinkstick_enabled:
	led = blinkstick.find_first()
	led.set_color(name="yellow")
disconnect_count = 0
camera_status = 0

# Target Information
target_hostname = "SmugPhone"
target_mac = "B8:53:AC:79:3F:56"

print "RaspiDash Debug"

# Enables the /dev/video0 device to be recorded from
def warmUpCamera():
    warmer = subprocess.check_output("/sbin/modprobe bcm2835-v4l2", shell=True)

# Stops the script recording video
def stopRecording():
    test = subprocess.check_output("/bin/bash /opt/raspidash/scripts/stop_recording.sh", shell=True)

# Starts the script recording video
def resumeRecording():
    os.system("/bin/bash /opt/raspidash/scripts/start_recording.sh")

warmUpCamera()

while True:
    # Format a timestamp for debugging output
    timestring = time.strftime("%a, %d %b %Y %H:%M:%S", time.gmtime())

    # Search for target device 
    result = bluetooth.lookup_name('B8:53:AC:79:3F:56', timeout=5)

    # If result not empty, Device is available
    if (result != None):
	# Debug Output
        print timestring + " - " + target_hostname + ": in"
	# Change blinkstick color
	if blinkstick_enabled:
		led.set_color(name='green')
	# Reset the disconnect count
	disconnect_count = 0
    else:
	# Debug Output
        print timestring + " - " + target_hostname + ": out"
	# Change blinkstick color
	if blinkstick_enabled:
		led.set_color(name='red')
	# Increment the disconnect count
	disconnect_count = disconnect_count + 1

    # Debug disconnect count
    print "Debug: " + str(disconnect_count)

    # If disconnect_count reaches threashold, stop recording
    if disconnect_count >= 5:
	if camera_status == 1:
	     print "Stop Recording..."
	     stopRecording()
	camera_status = 0
    # If disconnect_count = 0, check camera status
    elif disconnect_count == 0:
	# If camera status is "not recording", start recording
	if camera_status == 0:
	     print "Start Recording"
	     resumeRecording()
	# Eitherway set the camera status to "recording"
	camera_status = 1
    # Sleep for 5, then do it all over again
    time.sleep(5)

