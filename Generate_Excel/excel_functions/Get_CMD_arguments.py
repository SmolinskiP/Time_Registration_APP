import sys

def Get_Localization():
    try:
        localization = sys.argv[1]
        print("Lokalizacja - " + localization)
    except:
        sys.exit(1)
    return localization

def Get_Department():
    try:
        department = sys.argv[2]
        print("Dzial - " + department)
    except:
        pass
    return department

def Get_Month_Year():
    try:
        month = sys.argv[3]
        year = sys.argv[4]
        if int(month) < 10:
            month = "0" + month
        month_year = str(year) + "-" + str(month) + "-"
        print("Miesiac + rok - " + month_year)
    except:
        pass
    return month_year

def Main_Db_Query(localization, department):
    if int(department) == 0:
        sql_query_1 = "SELECT imie, nazwisko, id, palacz, umowa, firma, stanowisko FROM pracownicy WHERE lokalizacja = " + str(localization) + " ORDER BY nazwisko"
        print("Jade po lokalizacji")
    else:
        sql_query_1 = "SELECT imie, nazwisko, id, palacz, umowa, firma, stanowisko FROM pracownicy WHERE dzial = " + str(department) + " ORDER BY nazwisko"
        print("Jade po dziale")
    return sql_query_1
