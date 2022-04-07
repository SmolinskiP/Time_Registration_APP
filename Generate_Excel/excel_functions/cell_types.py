import xlsxwriter
import excel_functions.Get_Path as Get_Path

dirpath = Get_Path.Get_Local_Path()
workbook = xlsxwriter.Workbook(dirpath + 'Obecnosc.xlsx')

red_cell = workbook.add_format({'font_color': 'white', 'bg_color': 'red', 'bold': True})
orange_cell = workbook.add_format({'font_color': 'white', 'bg_color': 'orange', 'bold': True})
green_cell = workbook.add_format({'font_color': 'white', 'bg_color': 'green', 'bold': True})
black_cell = workbook.add_format({'font_color': 'black'})
time_cell = workbook.add_format({'num_format': 'hh:mm:ss'})
white_cell = workbook.add_format({'font_color': 'white'})
