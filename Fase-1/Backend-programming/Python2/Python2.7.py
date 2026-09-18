import os
import json
from datetime import datetime


boeken = []
huidig_bestand = ""
bestandstype = ""


def kies_bestand():
    global huidig_bestand, bestandstype, boeken

    while True:
        keuze = input("Kies bestandstype (1 = TXT, 2 = JSON): ")
        if keuze == "1":
            bestandstype = "txt"
            huidig_bestand = "boeken.txt"
            break
        elif keuze == "2":
            bestandstype = "json"
            huidig_bestand = "boeken.json"
            break
        else:
            print("Ongeldige keuze.")
            continue

    if not os.path.exists(huidig_bestand):
        open(huidig_bestand, "w").close()
        boeken = []
        return

    try:
        if bestandstype == "json":
            with open(huidig_bestand, "r", encoding="utf-8") as f:
                boeken = json.load(f)
        else:
            boeken = []
            with open(huidig_bestand, "r", encoding="utf-8") as f:
                for regel in f:
                    delen = regel.strip().split("|")
                    if len(delen) != 4:
                        pass
                    else:
                        boeken.append({
                            "titel": delen[0],
                            "auteur": delen[1],
                            "jaar": delen[2],
                            "toegevoegd": delen[3]
                        })
    except Exception as e:
        print("Fout bij inladen:", e)
        boeken = []


def opslaan(keuze=None):
    keuze = keuze or bestandstype

    try:
        if keuze == "json":
            with open("boeken.json", "w", encoding="utf-8") as f:
                json.dump(boeken, f, indent=4, ensure_ascii=False)
        elif keuze == "txt":
            with open("boeken.txt", "w", encoding="utf-8") as f:
                for boek in boeken:
                    f.write(f"{boek['titel']}|{boek['auteur']}|{boek['jaar']}|{boek['toegevoegd']}\n")
        else:
            raise ValueError("Ongeldig bestandstype")
    except Exception as e:
        print("Opslaan mislukt:", e)
    finally:
        pass


def boek_toevoegen():
    titel = input("Titel: ")
    auteur = input("Auteur: ")
    jaar = input("Jaar: ")

    boek = {
        "titel": titel,
        "auteur": auteur,
        "jaar": jaar,
        "toegevoegd": datetime.now().strftime("%Y-%m-%d %H:%M:%S")
    }
    boeken.append(boek)
    print("Boek succesvol toegevoegd.")


def boek_zoeken():
    zoekterm = input("Zoek op titel of auteur: ").lower()
    gevonden = False

    for boek in boeken:
        if zoekterm in boek["titel"].lower() or zoekterm in boek["auteur"].lower():
            print(boek)
            gevonden = True

    if not gevonden:
        print("Geen boeken gevonden.")


def boek_verwijderen():
    titel = input("Titel van het boek om te verwijderen: ").lower()
    global boeken

    originele_lengte = len(boeken)
    boeken = [boek for boek in boeken if boek["titel"].lower() != titel]

    if len(boeken) < originele_lengte:
        print("Boek verwijderd.")
    else:
        print("Boek niet gevonden.")


def toon_boeken():
    if not boeken:
        print("Geen boeken beschikbaar.")
        return

    for boek in boeken:
        print(boek)


def statistieken():
    if not boeken:
        print("Geen statistieken beschikbaar.")
        return

    totaal = len(boeken)
    unieke_auteurs = len(set(boek["auteur"] for boek in boeken))
    laatste_toevoeging = max(boek["toegevoegd"] for boek in boeken)

    boeken_per_jaar = {}
    for boek in boeken:
        jaar = boek["jaar"]
        boeken_per_jaar[jaar] = boeken_per_jaar.get(jaar, 0) + 1

    print(f"Totaal aantal boeken: {totaal}")
    print(f"Aantal unieke auteurs: {unieke_auteurs}")
    print(f"Laatst toegevoegd: {laatste_toevoeging}")
    print("Aantal boeken per jaar:")
    for jaar, aantal in boeken_per_jaar.items():
        print(f"  {jaar}: {aantal}")


def menu():
    while True:
        print("""
1. Boek toevoegen
2. Boek zoeken
3. Boek verwijderen
4. Toon alle boeken
5. Opslaan naar bestand (TXT of JSON)
6. Statistieken weergeven
7. Afsluiten
""")
        keuze = input("Maak een keuze: ")

        if keuze == "1":
            boek_toevoegen()
        elif keuze == "2":
            boek_zoeken()
        elif keuze == "3":
            boek_verwijderen()
        elif keuze == "4":
            toon_boeken()
        elif keuze == "5":
            formaat = input("Opslaan als (txt/json): ").lower()
            opslaan(formaat)
        elif keuze == "6":
            statistieken()
        elif keuze == "7":
            opslaan()
            print("Programma afgesloten.")
            break
        else:
            print("Ongeldige keuze.")
            continue


kies_bestand()
menu()
