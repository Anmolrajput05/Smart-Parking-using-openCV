#!/usr/bin/env python

'''
VideoCapture sample showcasing  some features of the Video4Linux2 backend

Sample shows how VideoCapture class can be used to control parameters
of a webcam such as focus or framerate.
Also the sample provides an example how to access raw images delivered
by the hardware to get a grayscale image in a very efficient fashion.

Keys:
    ESC    - exit
    g      - toggle optimized grayscale conversion

'''

# Python 2/3 compatibility
from __future__ import print_function
import TrainAndTest
import cv2 as cv
import numpy as np
import cv2
import  imutils
import parking_request_processor as prp


def numberPlate(imageIn):

    image =  imageIn.copy();
    # Read the image file
    #image = cv2.imread('reviver_digial_license.png')

    # Resize the image - change width to 500
    image = imutils.resize(image, width=500)

    # Display the original image
    cv2.imshow("Original Image", image)
    #return
    # RGB to Gray scale conversion
    gray = cv2.cvtColor(image, cv2.COLOR_BGR2GRAY)
    cv2.imshow("1 - Grayscale Conversion", gray)

    
    # Noise removal with iterative bilateral filter(removes noise while preserving edges)
    gray = cv2.bilateralFilter(gray, 11, 17, 17)
    cv2.imshow("2 - Bilateral Filter", gray)

    # Find Edges of the grayscale image
    edged = cv2.Canny(gray, 170, 200)
    cv2.imshow("4 - Canny Edges", edged)
    
    # Find contours based on Edges
    (new, cnts, _) = cv2.findContours(edged.copy(), cv2.RETR_LIST, cv2.CHAIN_APPROX_SIMPLE)
    cnts=sorted(cnts, key = cv2.contourArea, reverse = True)[:30] #sort contours based on their area keeping minimum required area as '30' (anything smaller than this will not be considered)
    NumberPlateCnt = None #we currently have no Number plate contour

    # loop over our contours to find the best possible approximate contour of number plate

    
    
    count = 0
    for c in cnts:
            peri = cv2.arcLength(c, True)
            approx = cv2.approxPolyDP(c, 0.02 * peri, True)
            if len(approx) == 4:  # Select the contour with 4 corners
                NumberPlateCnt = approx #This is our approx Number Plate Contour
                break

    #print(str(NumberPlateCnt == None) == 'True')
    if str(NumberPlateCnt == None) == 'True' : return None, None

    
    
    #print("CONT:"+str(NumberPlateCnt))  #[[[135 190]]
                                #[[136 302]]
                                #[[419 303]]
                                #[[418 190]]]

    # Drawing the selected contour on the original image
    
    
    cv2.drawContours(image, [NumberPlateCnt], -1, (0,0,255), 4)

    #[[[153 110]]

     #[[148 236]]

     #[[476 242]]

     #[[476 110]]]


    

    rect = cv2.minAreaRect(approx)
    box = cv2.boxPoints(rect)
    box = np.int0(box)

    
    x,y,w,h = cv2.boundingRect(NumberPlateCnt)
    print("H-"+str(h)) #minimum hight of rect
    print("W-"+str(w)) #minimum width of rect

    if not(h > 110 and w > 350): return None, None
    if not(h < 140 and w < 450): return None,None
        
    
    #image = cv2.rectangle(image,(x,y),(x+w,y+h),(255,0,0),2)

    cv2.imshow("Final Image With Number Plate Detected", image)

    #print("W:"+str(w) + "   H:"+str(h))

    #x, y, width, height = cv2.boundingRect(NumberPlateCnt)
    #roi = image[y:y+height, x:x+width]
    roi = image[y+25:y+h-25, x+8:x+w-8]

    
    cv2.imshow("Final Number Plate", roi)
    numberStr = TrainAndTest.process(roi)
    return roi,numberStr





def decode_fourcc(v):
    v = int(v)
    return "".join([chr((v >> 8 * i) & 0xFF) for i in range(4)])

font = cv.FONT_HERSHEY_SIMPLEX
color = (0, 255, 0)

cap = cv.VideoCapture(0)
cap.set(cv.CAP_PROP_AUTOFOCUS, False)  # Known bug: https://github.com/opencv/opencv/pull/5474

cv.namedWindow("Video")

convert_rgb = True
fps = int(cap.get(cv.CAP_PROP_FPS))
focus = int(min(cap.get(cv.CAP_PROP_FOCUS) * 100, 2**31-1))  # ceil focus to C_LONG as Python3 int can go to +inf

cv.createTrackbar("FPS", "Video", fps, 30, lambda v: cap.set(cv.CAP_PROP_FPS, v))
cv.createTrackbar("Focus", "Video", focus, 100, lambda v: cap.set(cv.CAP_PROP_FOCUS, v / 100))

waitcount = 0;
shot_idx = 0;
while True:
    status, img = cap.read()

    fourcc = decode_fourcc(cap.get(cv.CAP_PROP_FOURCC))

    fps = cap.get(cv.CAP_PROP_FPS)

    if not bool(cap.get(cv.CAP_PROP_CONVERT_RGB)):
        if fourcc == "MJPG":
            img = cv.imdecode(img, cv.IMREAD_GRAYSCALE)
        elif fourcc == "YUYV":
            img = cv.cvtColor(img, cv.COLOR_YUV2GRAY_YUYV)
        else:
            print("unsupported format")
            break

    #cv.putText(img, "Mode: {}".format(fourcc), (15, 40), font, 1.0, color)
    #cv.putText(img, "FPS: {}".format(fps), (15, 80), font, 1.0, color)
    cv.imshow("Video", img)
    imge = img.copy()
    roi,numberStr = numberPlate(imge)
    if numberStr != None:
        print(numberStr)
    if str(roi) != "None":
        cv.imshow("Final Image", roi)
    #print(str(roi))

    if numberStr != None:
        waitcount+=1
    if waitcount > 20:
        waitcount = 0 
        userPhone,scanRequestfor = prp.getScanRequest()
        print(userPhone)
        print(scanRequestfor)
        if userPhone == 'NO_REQUESTS' or scanRequestfor == 'NO_REQUESTS':
            continue
        regNo = prp.getScanedRegistrationNumber()
        userPhone,res_update_reg,status = prp.submitScanedRegistrationNo(userPhone,numberStr,scanRequestfor)
        print(res_update_reg)





    

    k = cv.waitKey(1)

    if k == 27:
        break
    elif k == ord('g'):
        convert_rgb = not convert_rgb
        cap.set(cv.CAP_PROP_CONVERT_RGB, convert_rgb)
    elif k == ord(' '):
        shotdir = 'C:\opencv3_4\opencv\sources\samples\python\Car-Number-Plate-Detection-OpenCV-Python-master - Copy'
        fn = '%s/shot_%03d.bmp' % (shotdir, shot_idx)
        cv.imwrite(fn, roi)
        print(fn, 'saved')
        shot_idx += 1


cv2.destroyAllWindows()
cv.destroyAllWindows()



