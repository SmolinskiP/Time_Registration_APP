import mysql.connector as database

def Db_Connect(db_user, db_password, db_host, db_database):
    try:
        conn = database.connect(
            user = db_user,
            password = db_password,
            host = db_host,
            database = db_database
        )
    except database.Error as e:
        print(f"Nie udalo sie polaczyc z baza danych MariaDB: {e}")
        sys.exit(1)
    return conn
