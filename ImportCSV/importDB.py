import pymysql
import sys
import unidecode

def csv_to_mysql(load_query,TableQuerySQL, host, user, password,database):
    """Fonction qui execute le requêtes dans la base de données sql

    Args:
        load_query (str): Requête pour envoyer les données du fichier csv
        TableQuerySQL (str): Requête pour créer la table en fonction du fichier csv
        host (str): host de la base de données
        user (str): username de la db
        password (str): passwrod de la db
        database (str): nom de la db
    """
    try:
        #connection db
        con = pymysql.connect(host=host,
                                user=user,
                                password=password,
                                db=database,
                                autocommit=True,
                                local_infile=1)
        print('Connected to DB: {}'.format(host))
        # Create cursor and execute Load SQL
        cursor = con.cursor()
        #execution des requête
        cursor.execute(TableQuerySQL)
        cursor.execute(load_query)
        print('Succuessfully loaded the table from csv.')
        con.close()
    except Exception as e:
        print('Error: {}'.format(str(e)))
        sys.exit(1)

#nome de la futur table
TableName='stat_full'
#Chemin du csv a convertir
CSV = "C:/wamp/www/FootBallStats/ImportCSV/CDM2014.csv"
#ouverture du csv a convertir
file = open(CSV, "r",encoding="utf-8")
reader = file.read()
TableRowName= (reader.split('\n')[0].split(','),reader.split('\n')[1].split(','))

#creation de la requête pour créer la table
TableQuerySQL = """CREATE TABLE """+TableName+"""("""

for i in range(len(TableRowName[0])):
    #nom de la colone en enlevant les chr illégaux
    ColumName = TableRowName[0][i]
    illegalCHR = R"""\/'.()[]#"!-*£ù%^;?=+"""
    replaceCHR = R"""- """
    for c in replaceCHR: ColumName = ColumName.replace(c,"_")
    for c in illegalCHR: ColumName = ColumName.replace(c,'')
    ColumName = unidecode.unidecode(ColumName)
    #verification du type d'arg de la colone
    try:
        int(TableRowName[1][i])
        ColumType = 'int'
    except:
        try:
            float(TableRowName[1][i])
            ColumType = 'float'
        except:
            ColumType = 'varchar(255)'
    #si dernière colone finir avec ) pour fermer la requête
    if i < len(TableRowName[0])-1:
        TableQuerySQL += ColumName + " " + ColumType + ", "
    else:
        TableQuerySQL += ColumName + " " + ColumType + ")"

#requête pour load le csv dans la table créé
load_query = """LOAD DATA LOCAL INFILE '"""+CSV+"""' INTO TABLE """+TableName+"""\
 FIELDS TERMINATED BY ',' ENCLOSED BY  '"' IGNORE 1 ROWS;"""

print(TableQuerySQL)
print(load_query)

#Info de base sur la db
host = 'localhost'
user = 'root'
password = ''
db='foot_stat'

#éxecution du bordel
csv_to_mysql(load_query,TableQuerySQL, host, user, password,db)