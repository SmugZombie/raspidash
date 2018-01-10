
#!/usr/bin/env python


from picamera import PiCamera
from time import sleep

camera = PiCamera()
camera.rotation = 180
camera.start_preview()
sleep(5)
camera.capture('/opt/raspidash/web/images/preview.jpg')
camera.stop_preview()

print '/opt/raspidash/web/images/preview.jpg'
