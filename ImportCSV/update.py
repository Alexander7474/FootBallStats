import pymysql
import sys
import unidecode

con = pymysql.connect(host="localhost",
                        user="root",
                        password="",
                        db="foot_stat",)
print('Connected to DB: {}'.format("local"))
# Create cursor and execute Load SQL
cursor = con.cursor()

requete="SELECT * FROM table_joueur"
#execution des requête
cursor.execute(requete)
data = cursor.fetchall()
new_board = {}
for player in data:
    if player[1] not in new_board.keys():
        new_board[player[1]] = []
    if player[0] not in new_board[player[1]]:
        new_board[player[1]].append(player[0])
    if player[2] not in new_board[player[1]]:
        new_board[player[1]].append(player[2])
    if player[3] not in new_board[player[1]]:
        new_board[player[1]].append(player[3])
for team in new_board:
    requete = "UPDATE table_equipe SET classement_fifa = %s, groupe = %s, selectionneur = %s WHERE Equipe = %s"
    val=(new_board[team][1],new_board[team][0],new_board[team][2],team)
    print(cursor.execute(requete,val))
    con.commit()
    
con.close()