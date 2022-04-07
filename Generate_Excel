from time import strftime
from time import gmtime
#!/usr/bin/env python3

int_total_time = 0
import sys
#SET FREE DAYS - WEEKENDS AND HOLIDAYS
import excel_functions.free_days as free_days
weekends = free_days.Create_Free_days()

#CONNECT TO DATABASE
import excel_functions.DBconnect as DBconnect
conn = DBconnect.Db_Connect("", "", "", "")
cursor = conn.cursor()

#GET COMMAND-LINE ARGUMENTS AND CREATE BASED-VARIABLES
import excel_functions.Get_CMD_arguments as Get_CMD_arguments
localization = Get_CMD_arguments.Get_Localization()
department = Get_CMD_arguments.Get_Department()
month_year =  Get_CMD_arguments.Get_Month_Year()

#CREATE AND EXECUTE MAIN SQL QUERY
sql_query_1 = Get_CMD_arguments.Main_Db_Query(localization, department)
cursor.execute(sql_query_1)
sql_query_1 = cursor.fetchall()

#CELL COLORS
from excel_functions.cell_types import *

def Get_SQL_Data(table, data1, data2, where_data):
    if where_data == 0:
        query = "Error 47: Empty SQL data"
    else:
        query = "SELECT " + data1 + " FROM " + table + " WHERE " + str(data2) + " = " + str(where_data)
        cursor.execute(query)
        query = cursor.fetchall()[0][0]
    return query

def Get_Total_Time(id, action, date):
    cursor.execute("SELECT DATE_FORMAT(TIME, '%H:%i:%s') FROM obecnosc WHERE pracownik = " + str(id) + " AND action = " + str(action) + " AND time LIKE '" + date + "%'")
    sql_query_time_1 = cursor.fetchall()
    sql_query_time_1 = str(sql_query_time_1)[3:-4]
    h = sql_query_time_1[0:2]
    if h:
        h = int(h)
    m = sql_query_time_1[3:5]
    if m:
       m = int(m)
    s = sql_query_time_1[6:8]
    if s:
        s = int(s)
        ftotal_time = int(h) * 3600 + int(m) * 60 + int(s)
        del h
        del m
        del s
    try:
        return ftotal_time
    except:
        return None


workbook.add_worksheet("Spis treści")
hyperlink_count = 1

for (imie, nazwisko, id, palacz, umowa, firma, stanowisko) in sql_query_1:
    worksheet = workbook.get_worksheet_by_name("Spis treści")
    worksheet.write_url('A' + str(hyperlink_count), "internal:'" + nazwisko + " " + imie + "'!A1", string = nazwisko + " " + imie)
    hyperlink_count += 1
    workbook.add_worksheet(nazwisko + " " + imie)
    worksheet = workbook.get_worksheet_by_name(nazwisko + " " + imie)
    worksheet.write_url('A40', "internal:'Spis treści'!A1", string = "Spis treści")
    worksheet.write(0, 0, imie)
    worksheet.write(0, 1, nazwisko)
    worksheet.write(0, 5, "Umowa:")
    worksheet.write(0, 7, "Firma:")
    worksheet.write(2, 0, "Surowe dane poniżej:")
    worksheet.write(3, 0, "Dzień:")
    worksheet.write(3, 1, "Wejście:")
    worksheet.write(3, 2, "Wyjście:")
    worksheet.write(3, 7, "Etat:")
    worksheet.write(3, 4, "Godzina wejścia:")
    worksheet.write(3, 5, "Godzina wyjścia:")
    worksheet.write(3, 6, "Komentarz:")
    worksheet.write(3, 8, "Liczba przepracowanych godzin brutto:")
    worksheet.write(3, 9, "Liczba przepracowanych godzin netto:")
    worksheet.write(3, 10, "Nadgodziny:")
    worksheet.write_formula('K36', '=SUM(K5:K35)')
    worksheet.write_formula('I36', '=SUM(I5:I35)')
    worksheet.write_formula('H36', '=SUM(H5:H35)')
    if palacz == 1:
        worksheet.write(0, 3, "Palacz", red_cell)
    worksheet.write(1, 5, Get_SQL_Data("_umowa", "rodzaj", "id", umowa))
    worksheet.write(1, 7, Get_SQL_Data("_firma", "firma", "id", firma))
    worksheet.write(2, 5, Get_SQL_Data("_stanowisko", "stanowisko", "id", stanowisko))

    x = 1
    while x < 32:
        cell2_type = black_cell
        if x < 10:
            y = "0" + str(x)
        else:
            y = str(x)
        actual_date = month_year + y

        entry_total_time = Get_Total_Time(str(id), 1, actual_date)
        exit_total_time = Get_Total_Time(str(id), 2, actual_date)

        try:
            int_total_time = exit_total_time - entry_total_time
            if int_total_time < 28800:
                 cell2_type = red_cell
            total_total_time = strftime("%H:%M:%S", gmtime(int_total_time))
            del exit_total_time
            del entry_total_time
        except:
            cell2_type = black_cell
        worksheet = workbook.get_worksheet_by_name(nazwisko + " " + imie)
        if 'total_total_time' in locals():
            worksheet.write(x+3, 9, total_total_time, cell2_type)
            del total_total_time
        
        if actual_date in weekends:
            day_cell = green_cell
        else:
            day_cell = black_cell
        worksheet.write(x+3, 0, actual_date, day_cell)
        worksheet.write_formula('I'+str(x+4), '=ROUND(J'+str(x+4)+'*24,0)')
        worksheet.write_formula('K'+str(x+4), '=IF(U' + str(x+4) + '=TRUE,V' + str(x+4) + ',"")'  )
        worksheet.write_formula('Z'+str(x+4), '=(L' + str(x+4) + "*24)-8", white_cell)
        worksheet.write_formula('Y'+str(x+4), '=ROUND(Z' + str(x+4) + ',0)', white_cell)
        worksheet.write_formula('X'+str(x+4), '=MROUND(J' + str(x+4) + '*24,0.0001)', white_cell)
        worksheet.write_formula('W'+str(x+4), '=MROUND(X' + str(x+4) + '-8,0.0001)', white_cell)
        worksheet.write_formula('V'+str(x+4), '=FLOOR(W' + str(x+4) + ',0.5)', white_cell)
        worksheet.write_formula('U'+str(x+4), '=ISNUMBER(V' + str(x+4) + ')', white_cell)

#Baska inny etat
        if id == 8:
            worksheet.write_formula('H'+str(x+4), '=IF(I' + str(x+4) + '>=0.01,7,I' + str(x+4) + ')')
        else:
            worksheet.write_formula('H'+str(x+4), '=IF(I' + str(x+4) + '>=0.01,8,I' + str(x+4) + ')')
        x += 1
        
    cursor.execute("SELECT pracownik, time, action, komentarz FROM obecnosc WHERE pracownik = " + str(id) + " AND TIME LIKE '" + month_year + "%' ORDER BY pracownik, time, action")
    sql_query_2 = cursor.fetchall()
    row = 4
    for (pracownik, time, action, komentarz) in sql_query_2:
        worksheet = workbook.get_worksheet_by_name(nazwisko + " " + imie)
        col = action
        time_string = str(time)
        row = int(time_string[8:10])
        if int((time_string[14:16])) > 0 and action == 1 and int((time_string[14:16])) < 30:
            cell_type = orange_cell
            if int_total_time < 28800:
                cell_type = red_cell
        elif int((time_string[14:16])) > 55 and action ==2:
            cell_type = orange_cell
            if int_total_time < 28800:
                cell_type = red_cell
        else:
            cell_type = black_cell
        if int(time_string[14:16]) >= 45 and action == 1:
            entry_hour = int(time_string[11:13]) + 1
            entry_type = black_cell
        elif int(time_string[14:16]) <= 20 and action == 1:
            entry_hour = int(time_string[11:13])
            entry_type = black_cell
        elif int(time_string[14:16]) > 20 and int(time_string[14:16]) < 45 and action == 1:
            entry_hour = "Wymaga uwagi"
            if (pracownik == 7 or pracownik == 128 or pracownik == 21 or pracownik == 112):
                entry_hour = time_string[11:16]
            entry_type = red_cell

        if int(time_string[14:16]) >= 45 and action == 2:
            exit_hour = int(time_string[11:13]) + 1
            exit_type = black_cell
        elif int(time_string[14:16]) <= 15 and action == 2:
            exit_hour = int(time_string[11:13])
            exit_type = black_cell
        elif int(time_string[14:16]) > 15 and int(time_string[14:16]) < 45 and action == 2:
            exit_hour = "Wymaga uwagi"
            if (pracownik == 7 or pracownik == 128 or pracownik == 21 or pracownik == 112):
                exit_hour = time_string[11:16]
            exit_type = red_cell

#Wyjatek dla : 7 
        if (pracownik == 7 or pracownik == 128 or pracownik == 21 or pracownik == 112):
            cell_type = black_cell
            entry_type = black_cell
            exit_type = black_cell

#GODZINA WEJSCIA/WYJSCIA
        if action == 1 or action == 2:
            worksheet.write(row + 3, col, time_string[10:], cell_type)
            if komentarz != None and komentarz != "":
                worksheet.write(row + 3, 6, komentarz, green_cell)
        elif action == 3:
            worksheet.write(row + 3, col + 10, "Start przerwy: " + time_string[10:], cell_type)
            if komentarz != None and komentarz != "":
                worksheet.write(row + 3, 6, komentarz, green_cell)
        elif action == 4:
            worksheet.write(row + 3, col + 10, "Koniec przerwy: " + time_string[10:], cell_type)
            if komentarz != None and komentarz != "":
                worksheet.write(row + 3, 6, komentarz, green_cell)
        else:
            holiday_type = Get_SQL_Data("_action", "action", "id", action)
            worksheet.write(row + 3, 3, holiday_type, cell_type)
            if action == 12:
                worksheet.write(row + 3, 8, 8)
                worksheet.write(row + 3, 9, "08:00:00")
            if komentarz != None and komentarz != "":
                worksheet.write(row + 3, 6, komentarz, green_cell)

        if 'entry_hour' in locals():
            worksheet.write(row + 3, 4, entry_hour, entry_type)
            del entry_hour
        if 'exit_hour' in locals():
            worksheet.write(row + 3, 5, exit_hour, exit_type)
            del exit_hour


workbook.close()
conn.close()
