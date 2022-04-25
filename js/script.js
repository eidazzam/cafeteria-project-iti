let navbar = document.querySelector(".navbar");

document.querySelector("#menu-btn").onclick = () => {
  navbar.classList.toggle("active");
  searchForm.classList.remove("active");
  cartItem.classList.remove("active");
};

let searchForm = document.querySelector(".search-form");

document.querySelector("#search-btn").onclick = () => {
  searchForm.classList.toggle("active");
  navbar.classList.remove("active");
  cartItem.classList.remove("active");
};

let cartItem = document.querySelector(".cart-items-container");

document.querySelector("#cart-btn").onclick = () => {
  cartItem.classList.toggle("active");
  navbar.classList.remove("active");
  searchForm.classList.remove("active");
};

window.onscroll = () => {
  navbar.classList.remove("active");
  searchForm.classList.remove("active");
  cartItem.classList.remove("active");
};
var cardItems = [];
var help = [];

function addcard(product_id) {
  // console.log(product_id);
  console.log(cardItems);
  if (cardItems.find((item) => item == product_id)) {
    console.log("already added");
  } else {
    document.getElementById("cardItems").value += product_id + " ";
    cardItems.push(product_id);
    console.log("object" + product_id);
  }
  // var x = document.getElementById("name").value;

  // document.getElementById("demo").innerHTML = "Welcome to Geeks For Geeks " + x;
}
