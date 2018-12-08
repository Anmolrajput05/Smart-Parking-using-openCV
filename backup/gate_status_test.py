import requests
import json
r = requests.get('http://localhost/parking/get_gate_status.php?get_gate_status=e&userPhone=8057445982')
print(r.text)

phone = '8057445982'

r = requests.post('http://localhost/parking/set_gate_status.php',data = {'set_gate_status':'true', 'userPhone':phone,'entranceGateAction':'Opened'})
print(r.text)
