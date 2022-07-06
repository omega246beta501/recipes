import psutil
import os
import time
from datetime import datetime

os.chdir('/root/example-app/vendor/bin')

print("Ejecutando script")
print("Valor actual de la CPU: " + str(psutil.cpu_percent()) + "%")
print("Comenzando rutina")
threshold = 90

lista = list()

def now():
    return str(datetime.now()) + " "

def isOverThreshold(cpuPercent):
    cpuPercent = float(cpuPercent)
    return cpuPercent >= threshold

def checkCPUusage(cpuPercent):
    if(isOverThreshold(psutil.cpu_percent())):
        lista.append(True)
    else:
        lista.append(False)
    print(now() + "Es el valor de la CPU: " + str(cpuPercent) + " > que " + str(threshold) + "?")
    print(lista)

while(True):
    # print(psutil.cpu_times_percent())
    # print(psutil.cpu_percent())

    # print(psutil.virtual_memory())
    print("****************************************")
    print(now() + 'Nueva vuelta al bucle')
    print(now() + "CPU usage: " + str(psutil.cpu_percent()) + "%")

    checkCPUusage(psutil.cpu_percent())
    
    if(len(lista) == 3):
        print(now() + "¿Ya han pasado 90 segundos, ha estado el server a más de " + str(threshold) + " Durante ese tiempo?")
        logic = False

        for element in lista:
            logic = logic or element
        
        if(logic):
            print(now() + "Reinicio el server")
            os.system('sail down')
            time.sleep(5)
            os.system('sail up -d')
            time.sleep(60)
            print(now() + "He reinciado el server")

        else:
            print(now() + "No reinicio el server")
        
        lista.clear()
        checkCPUusage(psutil.cpu_percent())

    print(now() + "Me espero 30 segundos")
    time.sleep(30)

    
        


