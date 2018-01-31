import pymysql
import random

db = pymysql.connect(user="root", passwd="codepurple", db="gotcha", unix_socket="/run/mysqld/mysqld.sock", autocommit=True)
cursor = db.cursor()
cursor.execute("select * from users;")
results = cursor.fetchall()

users_left = []
for i in results:
    users_left.append(i[1])

for i in results:
    if i[6] == None:
        if len(users_left) > 1:
            user_to_target = random.randrange(0, len(users_left))
            while users_left[user_to_target] == i[1]:
                user_to_target = random.randrange(0, len(users_left))
        else:
            user_to_target = 0
        cursor.execute('UPDATE users SET target = "'+users_left[user_to_target]+'" WHERE username = "'+i[1]+'" ;')
        users_left.pop(user_to_target)

db.close()
