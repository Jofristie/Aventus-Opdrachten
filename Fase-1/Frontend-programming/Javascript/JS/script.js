function haalProductenMetVertragingOp() {


  return new Promise((resolve, reject) => {


    setTimeout(async () => {
      try {

        const response = await fetch("../Data/producten.json");

        // Zet de JSON om naar een JavaScript object
        const producten = await response.json();


        resolve(producten);

      } catch (error) {

        reject(error);
      }
    }, 2000);
  });
}



async function haalProductenOp() {

  
  const container = document.getElementById("Item-container");


  container.innerHTML = "<p>Producten worden geladen...</p>";

  try {

    const producten = await haalProductenMetVertragingOp();


    renderProducten(producten);

  } catch (error) {
    container.innerHTML = "<p>Fout bij laden van producten.</p>";
    console.error("Fout bij laden van producten:", error);
  }
}



let cart = [];



function renderProducten(producten) {

  const container = document.getElementById("Item-container");

  container.innerHTML = "";


  producten.forEach(product => {


    const kaart = document.createElement("div");
    kaart.classList.add("Product-kaart");


    kaart.innerHTML = `
      <h3>${product.naam}</h3>
      <p><strong>€ ${product.prijs.toFixed(2)}</strong></p>
      <img src="${product.image}" alt="${product.naam}">
      <button class="add-to-cart-btn">Voeg toe</button>
    `;

 
    kaart.querySelector(".add-to-cart-btn").addEventListener("click", () => {


      cart.push(product);


      updateCart();
    });


    container.appendChild(kaart);
  });
}



function updateCart() {


  const container2 = document.getElementById("Item-container2");
  const cartItems = document.getElementById("cart-items");
  const cartTotal = document.getElementById("cart-total");


  container2.innerHTML = "";


  let totaal = 0;


  cart.forEach((product, index) => {


    totaal += product.prijs;

    const item = document.createElement("li");

  
    item.innerHTML = `
      ${product.naam} – € ${product.prijs.toFixed(2)}
      <button class="remove-from-cart-btn">Verwijder</button>
    `;


    item.querySelector(".remove-from-cart-btn").addEventListener("click", () => {


      cart.splice(index, 1);


      updateCart();
    });





    container2.appendChild(item);
  });


  cartItems.textContent =
    cart.length === 0
      ? "Winkelwagen is leeg"
      : "In winkelwagen: " + cart.map(p => p.naam).join(", ");


  cartTotal.textContent = `Totaal: € ${totaal.toFixed(2)}`;
}


function afrekenen(){
  if (cart.length === 0) {
    alert("Je winkelwagen is leeg!");
    return;
  }

  alert("Bedankt voor je bestelling!");

  cart = [];


  updateCart();
}


document.getElementById("afrekenen").addEventListener("click", afrekenen)
haalProductenOp(); 