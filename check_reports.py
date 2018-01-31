import pymysql

db = pymysql.connect(user="root", passwd="codepurple", db="gotcha", unix_socket="/run/mysqld/mysqld.sock", autocommit=True)

cursor = db.cursor()

cursor.execute("select * from reports;")

results = cursor.fetchall()

kill = []
killed = []
verified_kills = []

# Go through all reports and separate them into a list of "I have goten somebody" reports and "Somebody got me" reports
# Save in lists as a tuple: (reporter, subject of report)
for i in results:
    if i[0] not in kill and i[0] not in killed:
        if i[2] == "kill":
            kill.append((i[0], i[1]))
        elif i[2] == "killed":
            killed.append((i[0], i[1]))

# go through kill list and verify if the opposite report has been filed in the killed list 
# add to verified list if so
for i in kill:
    if (i[1], i[0]) in killed:
        verified_kills.append(i)

print("kill -> killed")
for i in kill:
    print(i)
print("killed by <- killer")
for i in killed:
    print(i)
print("verified kills:")
# For everybody in verified list, give killer the victim's target, and then set victim's target to "killed"
for i in verified_kills:
    cursor.execute('select target from users where username = "'+i[1]+'";')
    new_target = cursor.fetchall() 
    cursor.execute('UPDATE users SET target ="'+new_target[0][0]+'" where username = "'+i[0]+'";')
    cursor.execute('UPDATE users SET target = "killed" where username = "'+i[1]+'";')
    print(i)

db.close()
