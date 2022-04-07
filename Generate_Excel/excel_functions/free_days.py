from datetime import datetime, date, timedelta

def daterange(date1, date2):
    for n in range(int ((date2 - date1).days)+1):
        yield date1 + timedelta(n)
def Create_Free_days():
    weekdays = [5,6]
    weekends = []
    start_dt = date(2021,1,1)
    end_dt = date(2023,12,30)
    for dt in daterange(start_dt, end_dt):
        if dt.weekday() in weekdays:
            weekends.append(dt.strftime("%Y-%m-%d"))
    weekends.append("2022-01-06")
    weekends.append("2022-04-18")
    weekends.append("2022-05-03")
    weekends.append("2022-06-16")
    weekends.append("2022-08-15")
    weekends.append("2022-11-01")
    weekends.append("2022-11-11")
    weekends.append("2022-12-25")
    weekends.append("2022-12-26")
    weekends.append("2023-01-06")
    weekends.append("2023-04-10")
    weekends.append("2023-05-01")
    weekends.append("2023-05-03")
    weekends.append("2023-07-08")
    weekends.append("2023-08-15")
    weekends.append("2023-11-01")
    weekends.append("2023-12-25")
    weekends.append("2023-12-26")
    return weekends
