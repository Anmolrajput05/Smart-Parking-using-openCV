import requests
import json
import time
import random
import serial

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



# update gate status
def updateGateStatus(userPhone,gateStatus,statusFor):
    update_gate_url = host + 'set_gate_status.php'
    update_gate_data = {'set_gate_status':'T',
                         'userPhone':userPhone,
                         'gateStatus':gateStatus,
                         'statusFor':statusFor}
    result_update = requests.post(update_gate_url,update_gate_data)
    print(result_update.text)
    jsonStr = json.loads(result_update.text)
    userPhone = jsonStr['userPhone']
    statusFor = jsonStr['statusFor']
    status = jsonStr['status']
    return userPhone,statusFor,status



# parking step 1 on request scan number plate
def getGateRequest():
    gate_request_url = host + 'get_gate_operation.php'
    request_data = {'gate_request' : 'request'}
    gate_request_result = requests.post(gate_request_url, request_data)
    print(gate_request_result.text)
    jsonStr = json.loads(gate_request_result.text)
    userPhone = jsonStr['userPhone']
    entranceGateAction = jsonStr['entranceGateAction']
    exitGateAction = jsonStr['exitGateAction']
    return userPhone,entranceGateAction,exitGateAction


# wait or sleep
def wait():
    time.sleep(1)
# wait or sleep
def waitL():
    time.sleep(5)


# scan and return registration number
def getScanedRegistrationNumber():
    vihicleRegistration = random.randint(1000,9999) # replace with scanning
    return vihicleRegistration


#process parking gate cycle
def processParkingGate(userPhone,serialPort):
    print("Command opening sent arduino") #replace with arduiono communication
    serialPort.write('OPEN_PARKING'.encode('ascii')+'\r\n')
    waitL()
    oprationStatus = serialPort.readline();
    print(oprationStatus)
    userPhone,statusFor,status = updateGateStatus(userPhone,"Oppened","PARKING")
    print(userPhone,statusFor,status)
    waitL()
    oprationStatus = serialPort.readline();
    serialPort.write('CLOSE_PARKING'.encode('ascii')+'\r\n')
    userPhone,statusFor,status = updateGateStatus(userPhone,"Closing","PARKING")
    print(userPhone,statusFor,status)
    waitL()
    oprationStatus = serialPort.readline();
    print(oprationStatus)
    userPhone,statusFor,status = updateGateStatus(userPhone,"Closed","PARKING")
    print(userPhone,statusFor,status)
    

#process exit gate cycle
def processExitGate(userPhone,serialPort):
    print("Command exit opening sent arduino") #replace with arduiono communication
    serialPort.write('OPEN_EXIT'.encode('ascii')+'\r\n')
    waitL()
    oprationStatus = serialPort.readline();
    print(oprationStatus)
    userPhone,statusFor,status = updateGateStatus(userPhone,"Oppened","EXIT")
    print(userPhone,statusFor,status)
    serialPort.write('CLOSE_EXIT'.encode('ascii')+'\r\n')
    waitL()
    oprationStatus = serialPort.readline();
    print(oprationStatus)
    userPhone,statusFor,status = updateGateStatus(userPhone,"Closing","EXIT")
    print(userPhone,statusFor,status)
    waitL()
    userPhone,statusFor,status = updateGateStatus(userPhone,"Closed","EXIT")
    print(userPhone,statusFor,status)
    
    
    

#d process gate operations
def processGateOperation(userPhone,entranceGateAction,exitGateAction,serialPort):
    if entranceGateAction == "Opening":
        processParkingGate(userPhone,serialPort)
    elif exitGateAction == "Opening":
        processExitGate(userPhone,serialPort)



if __name__=="__main__":
    print('__main__')
    
 
    port = "COM4"
    baud = 9600
 
    serialPort = serial.Serial(port, baud, timeout=1)
    # open the serial port
    if serialPort.isOpen():
        print(serialPort.name + ' is open...')


    while(True):
        wait()
        userPhone,entranceGateAction,exitGateAction = getGateRequest()
        print(userPhone)
        print(entranceGateAction)
        print(exitGateAction)
        if userPhone == 'NO_REQUESTS':
            continue
        processGateOperation(userPhone,entranceGateAction,exitGateAction,serialPort)
        #regNo = getScanedRegistrationNumber()
        #userPhone,res_update_reg,status = submitScanedRegistrationNo(userPhone,regNo,scanRequestfor)
        #print(res_update_reg)
        

    
    
    
    
    
