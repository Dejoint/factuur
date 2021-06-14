import serial
import time
import pymysql as mysql #communication to database
import pymysql.cursors

def getDatabaseConnection(ipaddress, usr, passwd, charset, curtype):
    print('Connected');
    sqlCon  = pymysql.connect(host=ipaddress, user=usr, password=passwd, charset=charset, cursorclass=curtype);
    return sqlCon;
def addData(cursor, temp, press, humi, light):
    try:
        sqlAddData = 'INSERT INTO weermetingen (temperatuur, druk, vochtigheid, licht) VALUES (' + temp + ',' + press + ',' + humi + ',' + light + ');' 
        cursor.execute(sqlAddData);
    except Exception as Ex:
        print("Error creating MySQL User: %s"%(Ex));

ipaddress   = "192.168.0.114";  # MySQL server is running on local machine
usr         = 'root';
passwd      = 'Azerty123*';
charset     = "utf8mb4";
curtype    = pymysql.cursors.DictCursor;

mySQLConnection = getDatabaseConnection(ipaddress, usr, passwd, charset, curtype);
mySQLCursor     = mySQLConnection.cursor();

ser = serial.Serial(
    port='/dev/ttyUSB1',
    baudrate=115200)

time.sleep(2) 

ser.isOpen()
ser.write('TEMP\n')
out = ''
        
time.sleep(1)
while ser.inWaiting() > 0:
    out += ser.read(1)

if out != '':
    print(">>" + out)
