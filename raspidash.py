#!/usr/bin/python

import subprocess
import bluetooth
import time
import os
from blinkstick import blinkstick

led = blinkstick.find_first()
led.set_color(name="yellow")
disconnect_count = 0
camera_status = 0
statusFile="/tmp/camera.status"
#proc = None

target_hostname = "SmugPhone"
target_mac = "B8:53:AC:79:3F:56"

print "RaspiDash Debug"

def stopRecording():
#    writeToFile("0")
    test = subprocess.check_output("/bin/bash /opt/raspidash/scripts/stop_recording.sh", shell=True)
#    proc.kill()

def resumeRecording():
#    global proc
#    writeToFile("1")
    #test = subprocess.check_output("/bin/bash /opt/raspidash/scripts/start_recording.sh", shell=True)
#    proc = subprocess.Popen(["/bin/bash","/opt/raspidash/scripts/start_recording.sh"], stdout=subprocess.PIPE,      stderr=subprocess.PIPE, shell=True)
    os.system("/bin/bash /opt/raspidash/scripts/start_recording.sh")

def writeToFile(value):
    f = open(statusFile,'w')
    f.write(value)
    f.close()

while True:
    #print "Checking " + time.strftime("%a, %d %b %Y %H:%M:%S", time.gmtime())
    timestring = time.strftime("%a, %d %b %Y %H:%M:%S", time.gmtime())

    result = bluetooth.lookup_name('B8:53:AC:79:3F:56', timeout=5)
    if (result != None):
        print timestring + " - " + target_hostname + ": in"
	led.set_color(name='green')
	disconnect_count = 0
    else:
        print timestring + " - " + target_hostname + ": out"
	led.set_color(name='red')
	disconnect_count = disconnect_count + 1

    print "Debug: " + str(disconnect_count)

    if disconnect_count >= 5:
	if camera_status == 1:
	     print "Stop Recording..."
	     stopRecording()
	camera_status = 0
    elif disconnect_count == 0:
	if camera_status == 0:
	     print "Start Recording"
	     resumeRecording()
	camera_status = 1
    time.sleep(5)
