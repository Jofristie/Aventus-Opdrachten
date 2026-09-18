print("Gegroet gebruiker")
naam = input("Wat is je naam?")

# Functies


def begroeting():
    print("Hallo", naam)


def rekenen():
    x = float(input("Geef een getal!"))
    y = float(input("Geef nog een getal!"))
    som = x + y
    verschil = x - y
    product = x * y
    quotiënt = x / y
    print("De som is", som)
    print("Het verschil is", verschil)
    print("Het product is", product)
    print("Het quotiënt is", quotiënt)


def info_opslaan():
    global info_lijst
    leeftijd = int(input("Hoe oud ben je?"))
    hobby = input("Wat is je hobby?")
    info_lijst = [leeftijd, hobby]
    print("Je informatie is opgeslagen!")


def info():
    if info_lijst:
        print("Je leeftijd is", info_lijst[0], "en je hobby is", info_lijst[1])
    else:
        print("Er is nog geen informatie opgeslagen.")


def afsluiten():
    print("Het programma wordt afgesloten")


while True:
    print("Wat wil je doen?")
    print("1. Begroeting")
    print("2. Rekenkundige bewerkingen")
    print("3. Persoonlijke informatie invoeren")
    print("4. Persoonlijke informatie bekijken")
    print("5. Afsluiten")
    keuze = input("Kies een optie (1-5)")

    if keuze == "1":
        begroeting()
    elif keuze == "2":
        rekenen()
    elif keuze == "3":
        info_opslaan()
    elif keuze == "4":
        info()
    elif keuze == "5":
        afsluiten()
        break
    else:
        print("De keuze was ongeldig")
