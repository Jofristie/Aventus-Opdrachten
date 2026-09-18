document.addEventListener("DOMContentLoaded", () => {

  let artiestenData = [];
  let nummerData = [];
  let genreData = [];
  fetch('../Json/data.json')
    .then(res => res.json())
    .then(data => {

      artiestenData = data.top_artiesten.sort((a, b) => b.populariteit - a.populariteit);
      nummerData = data.top_nummers.sort((a, b) => a.populariteit - b.populariteit);
      genreData = data.top_genres.sort((a, b) => b.populariteit - a.populariteit);  
      toonArtiesten(artiestenData.slice(0, 10));
      toonNummers(nummerData.slice(0, 10));
      toonGenres(genreData.slice(0, 10));
    });

  //Html objecten ophalen
  const artiestlijst = document.getElementById("artiestenLijst");
  const nummerlijst = document.getElementById("nummerLijst");
  const genrelijst = document.getElementById("genreLijst")
  const searchInput = document.getElementById("searchInput");

  //Toont Artiesten
  function toonArtiesten(data) {
    if (!artiestlijst) return;
    artiestlijst.innerHTML = "";

    data.forEach((artiest, index) => {
      artiestlijst.innerHTML += `
        <li class="list-group-item d-flex item-lijst align-items-center position-relative bg-dark text-white border-secondary">
          
          <div class="curtain" id="curtain">
            <p class="fw-bold card-text">Klik voor de reveal!</p>
          </div>

          <span class="me-3 fw-bold">#${index + 1}</span>

          <img src="${artiest.afbeelding}" 
               alt="Foto van ${artiest.naam}" 
               width="50" 
               height="50"
               class="me-3 rounded">

          <div>
            <div class="fw-bold">${artiest.naam}</div>
            <small>${artiest.genre}</small>
          </div>

          <span class="ms-auto">${artiest.populariteit}%</span>

        </li>
      `;
    });
    voegCurtainEventsToe();
  }
  //Toont Nummers
  function toonNummers(data){
    if (!nummerlijst) return;
    nummerlijst.innerHTML="";

    data.forEach((nummer, index) => {
      nummerlijst.innerHTML += `
        <li class="list-group-item d-flex item-lijst align-items-center position-relative bg-dark text-white border-secondary">

          <div class="curtain" id="curtain">
            <p class="fw-bold card-text">Klik voor de reveal!</p>
          </div>

          <span class="me-3 fw-bold">#${index + 1}</span>
          
          <img src="${nummer.cover}" 
              alt="Foto van ${nummer.artiest}" 
              width="50" 
              height="50"
              class="me-3 rounded">
          <div>
            <div class="fw-bold">${nummer.titel}</div>
            <small>${nummer.artiest}</small>
          </div>
            
          <span class="ms-auto">${nummer.populariteit}%</span>
          
        </li>
      `;
    });
    voegCurtainEventsToe();
  }
  
  //Toont Genres
  function toonGenres(data) {
    if (!genrelijst) return;
    genrelijst.innerHTML = "";

    data.forEach((genre, index) => {
      genrelijst.innerHTML += `
        <li class="list-group-item d-flex item-lijst align-items-center position-relative bg-dark text-white border-secondary">

          <div class="curtain" id="curtain">
            <p class="fw-bold card-text">Klik voor de reveal!</p>
          </div>

          <span class="me-3 fw-bold">#${index + 1}</span>

          <img src="${genre.afbeelding}" 
            width="50" height="50"
            class="me-3 rounded">        

          <div class="fw-bold">${genre.naam}</div>

          <span class="ms-auto">${genre.populariteit}%</span>

        </li>
      `;
    });
    voegCurtainEventsToe();
  }

  if (searchInput) {
    searchInput.addEventListener("input", () => {

      const zoekTerm = searchInput.value.toLowerCase();

      const artiestgefilterd = artiestenData.filter(artiest =>
        artiest.naam.toLowerCase().includes(zoekTerm)
      );

      const nummergefilterd = nummerData.filter(nummer =>
        nummer.titel.toLowerCase().includes(zoekTerm)
      );

      const genregefilterd = genreData.filter(genre =>
        genre.naam.toLowerCase().includes(zoekTerm)
      );

      toonArtiesten(artiestgefilterd.slice(0, 10));
      toonNummers(nummergefilterd.slice(0, 10));
      toonGenres(genregefilterd.slice(0, 10));
    });
  }
});