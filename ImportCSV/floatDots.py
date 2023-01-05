CSV = "C:/Users/alexa/Documents/GitHub/FootBallStats/ImportCSV/CDM2014StatCroise.csv"
file = open(CSV, "r",encoding="utf-8")
reader = file.read()
file.close()
reader = list(reader)
counter = 0
for c in range(len(reader)):
    if reader[c] == '"':
        counter+=1
    try:
        int(reader[c+1])
        int(reader[c-1])
        if reader[c] == "," and counter == 1:
            reader[c] = "."
    except:
        pass
    if counter >= 2: counter = 0
nreader = ""
for c in reader: nreader+=c
nreader = nreader.replace('"','')
file = open(CSV, "w",encoding="utf-8")
file.write(nreader)