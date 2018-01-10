#!/usr/bin/python
# RaspiDash v1
# Simple service which watches for a specific bluetooth device to enable / disable recording. Built for use as a dash camera
# github.com/smugzombie
# Requires: Blinkstick device (Otherwise remove references to blinkstick

import subprocess
import bluetooth
import time
import os
import sys

try:
	from blinkstick import blinkstick
	blinkstick_enabled = True
except:
	blinkstick_enabled = False
# Global Variables
if blinkstick_enabled:
	led = blinkstick.find_first()
	led.set_color(name="yellow")
disconnect_count = 0
camera_status = 0
CONFIG_PATH="/opt/raspidash/config.ini"
# Target Information
target_name = ""
target_mac = ""
debugging=False
logging=False
debug_path=""
log_path=""


def readConfig():
        global target_name,target_mac,debugging,logging,debug_path,log_path

        import ConfigParser
        config = ConfigParser.RawConfigParser()
        try: config.read(CONFIG_PATH)
        except: return False


        try:
                target_name = config.get('setup', 'target_name')
                target_mac = config.get('setup', 'target_mac')
		debugging = config.getboolean("debug","enabled")
		debug_path = config.get('debug', 'debug_path')
		logging = config.getboolean('logging','enabled')
		log_path = config.get('logging','log_path')
        except:
                print "Invalid Config Provided!"
                sys.exit()


        if target_mac == "":
                print "Invalid Mac Provided!"
                sys.exit()

readConfig()



def debug(message):
	now = time.strftime("%b %d %H:%M:%S")
	if debugging is True:
		log = open(debug_path,'a')  # Open file in append mode
		log.write(now + " " + message + '\n')   # Write to file
		log.close()               # Close file

print "RaspiDash Debug"
print "Target Device: " + target_name + " (" + target_mac + ")" 

if debugging is True:
	print "Debug Enabled"

debug("Raspidash Started - Target Device " + target_name + " (" + target_mac + ")")




# Enables the /dev/video0 device to be recorded from
def warmUpCamera():
    debug("Warming up camera")
    warmer = subprocess.check_output("/sbin/modprobe bcm2835-v4l2", shell=True)

# Stops the script recording video
def stopRecording():
    debug("Stopping recording")
    test = subprocess.check_output("/bin/bash /opt/raspidash/scripts/stop_recording.sh", shell=True)
    debug("Recording stopped")

# Starts the script recording video
def resumeRecording():
    debug("Starting recording")
    os.system("/bin/bash /opt/raspidash/scripts/start_recording.sh")
    debug("Recording started")

#warmUpCamera()

debug("Running Main")
while True:
    # Format a timestamp for debugging output
    timestring = time.strftime("%a, %d %b %Y %H:%M:%S", time.gmtime())

    # Search for target device 
    result = bluetooth.lookup_name(target_mac, timeout=8)

    # If result not empty, Device is available
    if (result != None):
	# Debug Output
        print timestring + " - " + target_name + ": in"
	# Change blinkstick color
	if blinkstick_enabled:
		led.set_color(name='green')
	# Reset the disconnect count
	disconnect_count = 0
    else:
	# Debug Output
        print timestring + " - " + target_name + ": out"
	debug("Target Device not found")
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
	     debug("Target Device Found")
	     print "Start Recording"
	     resumeRecording()
	# Eitherway set the camera status to "recording"
	camera_status = 1
    # Sleep for 5, then do it all over again
    time.sleep(5)

