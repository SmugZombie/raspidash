#!/bin/bash

wlan=`/sbin/ifconfig wlan0 | grep inet | wc -l`

if [ $wlan -eq 0 ]; then
/sbin/ifdown wlan0 && /sbin/ifup wlan0
else
echo interface is up
fi
