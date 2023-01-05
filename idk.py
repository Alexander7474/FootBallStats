import pymysql

host = 'localhost'
user = 'root'
password = ''
database='foot_stat'

myDB = pymysql.connect(host=host,
                        user=user,
                        password=password,
                        db=database,
                        autocommit=True,
                        local_infile=1)

Query = "SELECT * FROM stat_full WHERE Classement_FIFA = 1"
cursor = myDB.cursor()
cursor.execute(Query)
data = cursor.fetchall()
print(data[0])