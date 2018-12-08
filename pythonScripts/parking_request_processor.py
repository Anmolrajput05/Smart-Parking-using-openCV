import requests
import json
import time
import random


host = 'http://localhost/parking/'


# submit step register otp for entrance
def submitScanedRegistrationNo(userPhone, registration, scanResultOf):
    registration_url = host + 'update_registraton_scan_result.php'
    registration_data = {'update_registration_scan_result':'T',
                         'userPhone':userPhone,
                         'userVehicleNo':registration,
                         'scanResultOf':scanResultOf}
    result_registration = requests.post(registration_url,registration_data)
    print(result_registration.text)
    jsonStr = json.loads(result_registration.text)
    userPhone = jsonStr['userPhone']
    scanResultOf = jsonStr['scanResultOf']
    status = jsonStr['status']
    return userPhone,scanResultOf,status





# parking step 1 on request scan number plate
def getScanRequest():
    scan_parking_url = host + 'get_scan_request.php'
    scan_parking_data = {'scan_requests_parking' : 'request'}
    result_scan_parking = requests.post(scan_parking_url, scan_parking_data)
    print(result_scan_parking.text)
    jsonStr = json.loads(result_scan_parking.text)
    userPhone = jsonStr['userPhone']
    scanRequestfor = jsonStr['scanRequestfor']
    return userPhone,scanRequestfor


# wait or sleep
def wait():
    time.sleep(1)


# scan and return registration number
def getScanedRegistrationNumber():
    vihicleRegistration = random.randint(1000,9999) # replace with scanning
    return 1456



if __name__=="__main__":
    print('__main__')
    while(True):
        wait()
        userPhone,scanRequestfor = getScanRequest()
        print(userPhone)
        print(scanRequestfor)
        if userPhone == 'NO_REQUESTS' or scanRequestfor == 'NO_REQUESTS':
            continue
        regNo = getScanedRegistrationNumber()
        userPhone,res_update_reg,status = submitScanedRegistrationNo(userPhone,regNo,scanRequestfor)
        print(res_update_reg)
        

    
    
    
    
    
