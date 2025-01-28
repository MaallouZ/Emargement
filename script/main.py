import sys
sys.path.insert(0,'c:\python312\lib\site-packages')

import xlsxwriter as xls
from xlsxwriter.utility import xl_rowcol_to_cell
import json
from datetime import datetime, timedelta
from dateutil import relativedelta

with open("data.json",'r') as file:
    jsondata = file.read()

data = json.loads(jsondata)["data"]
meta = json.loads(jsondata)["meta"]

def numOfDays(date1, date2):
    if date2 > date1:
        return (date2-date1).days
    else:
        return (date1-date2).days

workbook = xls.Workbook('statistique.xlsx', {'default_date_format': 'dd/mm/yyyy'})

cFormat_Title = workbook.add_format()
cFormat_Title.set_pattern(1)
cFormat_Title.set_bg_color("#32a852")
cFormat_Title.set_align("center")
cFormat_Title.set_align("vcenter")
cFormat_Title.set_border(1)
cFormat_Title.set_border_color("#000000")
cFormat_Title.set_bold()

cFormat_Date = workbook.add_format({'num_format': 'dd/mm/yyyy'})
cFormat_Date.set_pattern(1)
cFormat_Date.set_bg_color("#5694db")
cFormat_Date.set_align("center")
cFormat_Date.set_align("vcenter")
cFormat_Date.set_border(1)
cFormat_Date.set_border_color("#000000")

cFormat_Date_day = workbook.add_format({'num_format': 'dddd'})
cFormat_Date_day.set_pattern(1)
cFormat_Date_day.set_bg_color("#56b8db")
cFormat_Date_day.set_align("center")
cFormat_Date_day.set_align("vcenter")
cFormat_Date_day.set_border(1)
cFormat_Date_day.set_border_color("#000000")

cFormat_Present = workbook.add_format()
cFormat_Present.set_bg_color("#3ade42")
cFormat_Present.set_align("center")
cFormat_Present.set_align("vcenter")

cFormat_Sexe_F = workbook.add_format()
cFormat_Sexe_F.set_bg_color("#f78df3")
cFormat_Sexe_F.set_align("center")
cFormat_Sexe_F.set_align("vcenter")

cFormat_Sexe_M = workbook.add_format()
cFormat_Sexe_M.set_bg_color("#8da9f7")
cFormat_Sexe_M.set_align("center")
cFormat_Sexe_M.set_align("vcenter")

cFormat_True = workbook.add_format()
cFormat_True.set_bg_color("#32db3d")
cFormat_True.set_align("center")
cFormat_True.set_align("vcenter")

cFormat_False = workbook.add_format()
cFormat_False.set_bg_color("#db3232")
cFormat_False.set_align("center")
cFormat_False.set_align("vcenter")

cFormat_Primary = workbook.add_format()
cFormat_Primary.set_bg_color("#6ec9f0")
cFormat_Primary.set_align("center")
cFormat_Primary.set_align("vcenter")

date_format = '%Y-%m-%d'
dateStart = meta['dateDebut']
dateEnd = meta['dateFin']
daysCount = numOfDays(datetime.strptime(dateEnd, date_format),datetime.strptime(dateStart, date_format))

worksheets = {}

for k, v in data.items():
    worksheets[k] = workbook.add_worksheet(k)
    worksheets[k].write(0,0,"Nom", cFormat_Title)
    worksheets[k].write(0, 1, "Prénom", cFormat_Title)
    worksheets[k].write(0, 2, "Age", cFormat_Title)
    worksheets[k].write(0, 3, "Sexe", cFormat_Title)
    worksheets[k].write(0, 4, "Ville", cFormat_Title)
    worksheets[k].write(0, 5, "tel", cFormat_Title)
    worksheets[k].write(0, 6, "ADH", cFormat_Title)
    #worksheets[k].split_panes(0, 59)

    worksheets[k].set_column(2, 3 , 5)
    worksheets[k].tmp_days_column = {}

    for day in range(daysCount):
        worksheets[k].write_datetime(0, 7 + day, datetime.strptime(dateStart, date_format) + timedelta(days=day), cFormat_Date)
        worksheets[k].set_column(7, 7 + day, 12)
        worksheets[k].write_datetime(1, 7 + day, datetime.strptime(dateStart, date_format) + timedelta(days=day), cFormat_Date_day)

        worksheets[k].tmp_days_column[datetime.strptime(dateStart, date_format) + timedelta(days=day)] = day + 7

    tmp_visiteur = {}
    tmp_visiteur_mx_pos = 0

    for visiteur in v:
        if visiteur['libelleActivite'] == k:
            if visiteur['present'] == "1":
                print(visiteur['IDvisiteur'], visiteur['libelleActivite'], k)
                tmp_visiteur[int(visiteur['IDvisiteur'])] = True
                if tmp_visiteur_mx_pos < int(visiteur['IDvisiteur']):
                    tmp_visiteur_mx_pos = int(visiteur['IDvisiteur'])
                print(tmp_visiteur, tmp_visiteur_mx_pos)
                worksheets[k].write(int(visiteur['IDvisiteur']), 0, visiteur['nom'], cFormat_Primary)
                worksheets[k].write(int(visiteur['IDvisiteur']), 1, visiteur['prenom'], cFormat_Primary)
                worksheets[k].write(int(visiteur['IDvisiteur']), 2, visiteur['age'], cFormat_Primary)

                if visiteur['sexe'] == "F":
                    worksheets[k].write(int(visiteur['IDvisiteur']), 3, visiteur['sexe'], cFormat_Sexe_F)
                elif visiteur['sexe'] == "M":
                    worksheets[k].write(int(visiteur['IDvisiteur']), 3, visiteur['sexe'], cFormat_Sexe_M)
                else:
                    worksheets[k].write(int(visiteur['IDvisiteur']), 3, visiteur['sexe'])

                worksheets[k].write(int(visiteur['IDvisiteur']), 4, visiteur['ville'], cFormat_Primary)
                worksheets[k].write(int(visiteur['IDvisiteur']), 5, visiteur['tel'], cFormat_Primary)

                if visiteur['ADH'] == "1":
                    worksheets[k].write(int(visiteur['IDvisiteur']), 6, visiteur['ADH'], cFormat_True)
                elif visiteur['ADH'] == "0":
                    worksheets[k].write(int(visiteur['IDvisiteur']), 6, visiteur['ADH'], cFormat_False)

                worksheets[k].write(int(visiteur['IDvisiteur']), worksheets[k].tmp_days_column[datetime.strptime(visiteur['dateJournee'], date_format)], 1, cFormat_Present)
    for l in range(tmp_visiteur_mx_pos, 1,-1):
        try:
            tmp_visiteur[l]
            print("HELLO", l, k)
        except:
            worksheets[k].set_row(l, None, None, {'hidden': True})
            print("++", l, k)

    for day in range(daysCount):
        tmp_cell_x = xl_rowcol_to_cell(tmp_visiteur_mx_pos, 7 + day)
        print(tmp_cell_x)
        tmp_cell_y = xl_rowcol_to_cell(2, 7 + day)
        print(tmp_cell_y)

        worksheets[k].write_formula(tmp_visiteur_mx_pos + 2, 7 + day, "=SUM("+tmp_cell_y+","+tmp_cell_x+")", cFormat_Primary, ' ')
        #worksheets[k].set_column(7, 7 + day, 12)
        #worksheets[k].write_datetime(1, 7 + day, datetime.strptime(dateStart, date_format) + timedelta(days=day), cFormat_Date_day)

        #worksheets[k].tmp_days_column[datetime.strptime(dateStart, date_format) + timedelta(days=day)] = day + 7

workbook.close()