# Sunny Travels - Code Uitleg

Dit document beschrijft alle belangrijke bestanden in het `Sunny Travels` React-project en legt uit wat elk onderdeel doet.

---

## Projectstructuur

Belangrijkste mappen en bestanden:

- `package.json` - beheert dependencies en scripts.
- `vite.config.js` - Vite-configuratie.
- `index.html` - HTML-sjabloon voor de app.
- `src/main.jsx` - entry point voor React.
- `src/App.jsx` - hoofdcomponent die routing instelt.
- `src/App.css` - styling voor de app.
- `src/index.css` - algemene basisstijl van Vite.
- `src/data/vacations.js` - statische vakantiedata.
- `src/components/Header.jsx` - site-header/navigation.
- `src/components/VacationCard.jsx` - kaartcomponent voor één vakantie.
- `src/pages/Home.jsx` - overzichtspagina met zoek/filter.
- `src/pages/Detail.jsx` - detailpagina voor een specifieke vakantie.
- `src/pages/Booking.jsx` - boekingsformulier en bevestiging.

---

## package.json

Dit bestand bevat de projectmetadata, dependencies en scripts die worden gebruikt om de app te starten of te bouwen.

Belangrike onderdelen:

- `dependencies`
  - `react`, `react-dom`: React bibliotheken.
  - `react-router-dom`: router voor pagina-navigatie.
- `devDependencies`
  - `vite`: snellere ontwikkelserver en bundler.
  - `@vitejs/plugin-react`: React plugin voor Vite.
  - extra Babel- en ESLint-packages voor build/linting.
- `scripts`
  - `dev`: start de Vite ontwikkelserver.
  - `build`: maakt een productiebuild.
  - `preview`: preview van de productiebuild.

---

## .gitignore

Dit bestand vertelt Git welke bestanden en mappen niet in versiebeheer moeten worden opgenomen.

Belangrijke regels:

- `node_modules`: de dependency-map wordt niet opgeslagen in Git omdat deze lokaal kan worden herbouwd met `npm install`.
- `dist` en `dist-ssr`: outputmappen van de productiebuild.
- `*.log`, `npm-debug.log*`, `yarn-debug.log*`: logbestanden die niet in Git thuishoren.
- IDE/editorbestanden zoals `.vscode/`, `.idea`, `.DS_Store`: lokale editorinstellingen en systeembestanden die geen onderdeel zijn van je projectcode.

Dit zorgt voor een schone repository zonder tijdelijke of gegenereerde bestanden.

---

## eslint.config.js

Dit bestand configureert ESLint, de statische code-analyse tool voor JavaScript/JSX.

Belangrijke onderdelen:

- `globalIgnores(['dist'])`: laat ESLint de `dist`-map overslaan.
- `files: ['**/*.{js,jsx}']`: activeert de regels voor alle JavaScript- en JSX-bestanden.
- `extends`
  - `js.configs.recommended`: standaard aanbevolen ESLint-regels.
  - `reactHooks.configs.flat.recommended`: regels voor React hooks, zoals `useEffect` en `useState`.
  - `reactRefresh.configs.vite`: regels om React Fast Refresh met Vite goed te laten werken.
- `languageOptions`
  - `globals: globals.browser`: maakt browserglobals zoals `window` en `document` beschikbaar.
  - `parserOptions: { ecmaFeatures: { jsx: true } }`: stelt in dat JSX-syntaxis wordt toegestaan.

Deze configuratie helpt je code consistent en foutvrij te houden tijdens ontwikkeling.

---

## vite.config.js

Vite-configuratie:

- `plugins`: bevat `react()` om React te ondersteunen.
- `babel({ presets: [reactCompilerPreset()] })`: activeert extra React compile-opties.

Dit bestand zorgt ervoor dat Vite de React-code correct bouwt.

---

## index.html

De HTML-sjabloon voor de app.

- `div id="root"`: hier wordt de React-app gemount.
- `script type="module" src="/src/main.jsx"`: laadt de entry point van de app.

---

## src/main.jsx

Entry point van de React-app.

- Importeert `StrictMode` uit React voor extra waarschuwingen tijdens ontwikkeling.
- Importeert `createRoot` uit `react-dom/client` om de app op te starten.
- Importeert globale CSS (`./index.css`).
- Laadt de hoofdcomponent `App`.
- Maakt een root en rendert `<App />` binnen de `#root` container.

---

## src/App.jsx

Dit is de hoofdcomponent van de app en bevat de router.

- Importeert `BrowserRouter`, `Routes`, en `Route` uit `react-router-dom`.
- Importeert `Header` en paginacomponenten `Home`, `Detail`, en `Booking`.
- Stelt router-routes in:
  - `/`: overzichtspagina (`Home`).
  - `/vacation/:id`: detailpagina.
  - `/vakantie/:id`: Nederlandse alias voor dezelfde detailpagina.
  - `/book/:id`: boekingspagina.
  - `/boeken/:id`: Nederlandse alias voor boeking.
- `Header` staat bovenaan op alle pagina's.

Dit bestand verbindt de pagina's samen in één applicatie.

---

## src/App.css

Stijlen voor de hele applicatie.

Belangrijke secties:

- `:root`: defineert kleuren en variabelen zoals `--accent`, `--border`, en `--shadow`.
- `body`: globale basisstijl voor lettertype, marges en kleur.
- `.site-header`: stijlt de header met een zomerse achtergrondgradient.
- `.search` en `.search input`: opmaak voor de zoekbalk op de homepage.
- `.grid`: grid-layout voor kaarten.
- `.card`: styling voor individuele vakantiekaarten.
- `.button`, `.button.primary`: stijlen voor de knoppen.
- `.detail` en `.detail-img`: lay-out van de detailpagina.
- `.form`: styling voor het boekingsformulier.
- `.confirmation`: stijl voor de bevestigingsmelding na een boeking.

Deze CSS geeft de app een frisse, vakantieachtige uitstraling en maakt de interface overzichtelijk.

---

## src/index.css

Basisstijl van Vite.

- Definieert globale CSS-variabelen zoals `--text`, `--bg`, `--accent`.
- Zet basistypografie en responsive fontgrootte.
- Stelt de `body` marge in op 0.
- Styleert `#root` zodat de app gecentreerd en breed genoeg is.
- Bepaalt basisvormgeving voor `h1`, `h2`, `p`, `code`.

Deze file bevat algemene styling en wordt door `src/main.jsx` geladen.

---

## src/data/vacations.js

Dit bestand bevat de vakantiedata die in de app worden gebruikt.

Elke vakantie heeft:

- `id`: unieke ID voor routing.
- `title`: naam van de vakantie.
- `shortDesc`: korte beschrijving.
- `price`: prijsinformatie.
- `image`: pad naar een afbeelding.
- `longDesc`: uitgebreide beschrijving.
- `highlights`: een lijst met belangrijke kenmerken.

De data zijn hardcoded als een JavaScript-array en worden geëxporteerd met `export default vacations`.

---

## src/components/Header.jsx

Header-component:

- Gebruikt `Link` uit `react-router-dom` om tussen pagina's te navigeren zonder de pagina te verversen.
- Laat de site-naam `Sunny Travels` zien.
- Bevat een eenvoudige navigatie met een `Home` link.

Deze component wordt in `App.jsx` gebruikt, zodat de header op elke route zichtbaar is.

---

## src/components/VacationCard.jsx

Kaartcomponent voor een vakantie.

- Ontvangt de vakantiegegevens als prop `v`.
- Toont afbeelding, titel, korte beschrijving en prijs.
- Voegt een `Details` link toe naar de detailpagina van die vakantie (`/vacation/:id`).

Dit component maakt de lijst op de homepage overzichtelijk en herbruikbaar.

---

## src/pages/Home.jsx

Home-pagina met het overzicht van vakanties.

- `useState` houdt de zoekopdracht in `query` bij.
- `vacations.filter(...)` filtert de lijst op titel of korte beschrijving.
- Toont een zoekveld dat direct filtert tijdens typen.
- Renderde de gefilterde vakanties met `VacationCard`.
- Als er geen resultaten zijn, verschijnt de tekst `Geen resultaten`.

Deze pagina is de startpagina voor de gebruiker om vakanties te bekijken.

---

## src/pages/Detail.jsx

Detailpagina voor één vakantie.

- `useParams()` haalt de routeparameter `id` op.
- Zoekt de overeenkomstige vakantie in `vacations`.
- Als niets wordt gevonden, toont het een foutmelding `Vakantie niet gevonden`.
- Toont de titel, prijs, uitgebreide omschrijving en highlights.
- Heeft een `Boek nu` knop die linkt naar `/book/:id`.

Deze pagina biedt de gebruiker uitgebreide informatie voor een gekozen vakantie.

---

## src/pages/Booking.jsx

Boekingspagina met formulier.

- `useParams()` leest de vakanties `id` uit de URL.
- Zoekt de bijbehorende vakantie op.
- Houdt formulierwaarden bij in `form`.
- Houdt `confirmed` bij om te tonen of de boeking is afgerond.
- Bij submit (`submit`) voorkomt het standaardformuliergedrag en zet het `confirmed` state.
- Als `confirmed` gevuld is, wordt een bevestigingstekst getoond met naam, vakantie, aantal personen en vertrekdatum.
- Als nog niet bevestigd, toont het een formulier met velden:
  - Naam
  - Email
  - Aantal personen
  - Vertrekdatum
- De knop `Boek` verstuurt het formulier.

Deze pagina simuleert een boekingsstroom en toont een fictieve bevestiging zonder echte betaling.

---

## Hoe de app werkt samen

1. De browser laadt `index.html`.
2. `src/main.jsx` start React en rendert `App` in de `#root` container.
3. `App.jsx` gebruikt `BrowserRouter` om routes te beheren.
4. `Header.jsx` blijft bovenaan staan op alle pagina's.
5. `Home.jsx` toont de vakantiekaarten met zoekfunctie.
6. `VacationCard.jsx` linkt naar de detailpagina.
7. `Detail.jsx` toont detailinformatie en linkt naar het boekingsformulier.
8. `Booking.jsx` toont een formulier en bevestiging.
9. `App.css` en `index.css` zorgen voor de zomerse look en globale basisstijl.

---

## Extra opmerkingen

- De app gebruikt statische data in `src/data/vacations.js`.
- Routing is ingesteld met React Router, zodat de app meerdere URL's ondersteunt.
- Alle code is geschreven met React-function components en hooks (`useState`, `useParams`).
- De styling gebruikt CSS-variabelen en eenvoudige klassennamen.

---

## Aanpassingen die je makkelijk kunt doen

- Een nieuwe vakantie toevoegen door een object toe te voegen in `src/data/vacations.js`.
- Een andere afbeelding gebruiken door `image` te wijzigen.
- Extra navigatie toevoegen in `Header.jsx`.
- Meer velden aan het boekingsformulier toevoegen in `src/pages/Booking.jsx`.
- De styling verder aanpassen in `src/App.css`.
