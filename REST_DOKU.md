#REST Dokumentation
##Fahrzeugtypen:
###alle Datensätze abrufen
```
GET rest/TYP
```
###einzelnen Datensatz abrufen
```
GET rest/TYP/{ID}
```
###Bsp.: 
```
GET rest/TYP/32
```

##Fahrzeugdaten:
###alle Datensätze abrufen
```
GET rest/KFZ
```
###einzelnen Datensatz abrufen
```
GET rest/KFZ/{KENNZEICHEN}
```
###einzelnen Datensatz ändern
```
PUT rest/KFZ/{KENNZEICHEN}
json: obj
```
###einzelnen Datensatz löschen
```
DELETE rest/KFZ/{KENNZEICHEN}
```
###Bsp.: 
```
GET rest/KFZ/KA-MM218
DELETE rest/KFZ/KA-MM218
```
