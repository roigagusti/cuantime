import os
import re

def extract_translations_from_php(folder_path):
    translations = {}

    # Iterar sobre todos los archivos en el directorio
    for root, dirs, files in os.walk(folder_path):
        data = []
        for file in files:
            if file.endswith(".php"):
                file_path = os.path.join(root, file)
                
                with open(file_path, "r", encoding="utf-8") as php_file:
                    php_code = php_file.read()

                    # Utilizar expresiones regulares para encontrar las traducciones
                    matches = re.findall(r'>(.*?)<', php_code)
                
            # añadir matches a data
            data.extend(matches)
        #eliminar duplicados en data
        data = list(set(data))
        #ordenar alfabeticamente
        data = sorted(data)
        
        for match in data:
            # if match is not a number and is not empty
            if match.isdigit() or match != "" or match != " " or match[0] != '"' or match[0] != "'":
            #eliminar match de la lista data
                data.remove(match)

    return data

def convert_to_php(input_list):
    text = '$text = array(\n'
    for index, value in enumerate(input_list):
        if index > 0:
            text += ",\n"
        text += f'"{value}" => ""'
    text += "\n);"
    return text

def obtenir_dades(path):
    data = extract_translations_from_php(path)
    data = convert_to_php(data)
    print(data)
    
# Obtenir tots els texts plans de cada PHP de la ruta
folder_path = "to_translate/"
#obtenir_dades(folder_path)

def revisar_duplicados(php_code):
    data = []
    for line in php_code:
        # remove spaces until first '"'
        line = line.lstrip()
        if line.startswith('"'):
            # get from line[1] to next '"' and print
            text = line[1:line.find('"', 1)]
            if text not in data:
                data.append(text)
            else:
                print(text)

# llegir arxiu php i fer print de cada linia
with open("languages/test_translate.php", "r", encoding="utf-8") as php_file:
    php_code = php_file.readlines()
    
    for line in php_code:
        # remove spaces until first '"'
        line = line.lstrip()
        if line.startswith('"'):
            # get from line[1] to next '"' and print
            text = line[1:line.find('"', 1)]
            print('"'+text+'" => "'+text+'",')
