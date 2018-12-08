import requests
import json
import random
import time

host = 'http://localhost/parking/'


# scan and return registration number
def getScanedRegistrationNumber():
    vihicleRegistration = random.randint(1000,9999) # replace with scanning
    return vihicleRegistration



# wait or sleep
def wait():
    time.sleep(3)


#retrive phone no to send otp
def getPhoneNoToSendOTP():
    otp_get_url = host + 'get_otp_request.php'
    request_data = {'get_otp_request':'e'}
    otp_result  = requests.post(otp_get_url,request_data);
    return otp_result

#submit otp sent confirmation
def optConfirmation(userPhone,OTP_for):
    otp_confirm_url = host + 'register_otp_confirmation.php'
    requset_data = {'update_otp':'T','userPhone':userPhone,'otp_for':OTP_for}
    confirmation_result = requests.post(otp_confirm_url,requset_data)
    return confirmation_result;



if __name__ == "__main__":
    print('__main__')
    while(True):
        wait()
        res = getPhoneNoToSendOTP();
        print(res.text)
        jsonStr = json.loads(res.text)
        userPhone = jsonStr['userPhone']
        otp = jsonStr['OTP']
        message = jsonStr['message']
        otp_for = jsonStr['otp_for']

        print(userPhone)
        print(otp)
        print(message)
        print(otp_for)
        if userPhone == 'NO_REQUESTS':
            continue
        resConf = optConfirmation(userPhone,otp_for)

        print(resConf.text)
        
      
        
        


'''

,data = {'get_otp_request':'e'})
print(r.text)


y = json.loads(r.text)

# the result is a Python dictionary:
phone = y["userPhone"]
optRequest = y["otpRequestEntrance"]
print(y["userPhone"])

generatedOTP = "4981"

r = requests.post('http://localhost/parking/register_parking_otp.php',data = {'update_otp':'true', 'userPhone':phone,'userOTPEntrance':generatedOTP})
print(r.text)

'''
