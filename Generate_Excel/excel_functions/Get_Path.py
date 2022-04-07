import os
import sys

def Get_Local_Path():
    localpath = os.getcwd()
    if sys.platform.startswith("linux"):
        dirpath = localpath + "/"
    elif sys.platform == "darwin":
        print("Jestem maczkiem")
    elif sys.platform == "win32":
        dirpath = localpath + "\\"
    else:
        print("Error 112 - nie mozna zdefiniowac wersji systemu")
    return dirpath