let items = [...document.getElementsByClassName("product")]


for (const item of items) {

    item.addEventListener("click", function (e) {
        let orderList = document.getElementById("list")
        let { name, price, id } = e.target.dataset;
        price = parseInt(price);

        let elementExist = document.getElementById(`${name}_element`);
        let total = document.getElementById("total");

        if (elementExist) {
            return;
        }

        let div = document.createElement("div");
        div.setAttribute("class", "list_element");
        div.setAttribute("id", `${name}_element`);

        let span = document.createElement("div");
        span.innerText = `${name}`;
        span.setAttribute("class", "item-name");
        div.appendChild(span);
        let counterDiv = document.createElement("div");
        counterDiv.setAttribute("class", "item-input");
        let minusBtn = document.createElement("button");
        minusBtn.setAttribute("class", "minus");
        minusBtn.type = "button";
        minusBtn.innerText = "-";
        counterDiv.appendChild(minusBtn);
        let quantity = document.createElement("input");
        quantity.setAttribute("name", `quantity[${id}]`);
        quantity.setAttribute("type", "text");
        quantity.setAttribute("value", "1");
        quantity.setAttribute("data-price", `${price}`);
        counterDiv.appendChild(quantity);
        let plusBtn = document.createElement("button");
        plusBtn.type = "button";
        plusBtn.innerText = "+";
        plusBtn.setAttribute("class", "plus");
        counterDiv.appendChild(plusBtn)
        div.appendChild(counterDiv);

        let elementPrice = document.createElement("span");

        elementPrice.innerText = `${price} L.E`
        elementPrice.setAttribute("class", "elementPrice");
        div.appendChild(elementPrice);

        let deleteBtn = document.createElement("button");
        deleteBtn.innerText = "X";
        deleteBtn.type = "button"
        deleteBtn.setAttribute("class", "deleteBtn");
        deleteBtn.addEventListener("click", function () {
            orderList.removeChild(div);
            total.innerText = totalOrderPrice()+" L.E";
        })
        div.appendChild(deleteBtn);
        orderList.appendChild(div);

        minusBtn.addEventListener("click", () => {
            let count = parseInt(quantity.value) - 1;
            count = count < 1 ? 1 : count;
            quantity.value = count;
            let itemPrice = price * parseInt(quantity.value);
            elementPrice.innerText = itemPrice+" L.E";

            total.innerText = "Total: " + totalOrderPrice()+" L.E";
        })

        plusBtn.addEventListener("click", () => {
            let count = parseInt(quantity.value) + 1;
            quantity.value = count;
            let itemPrice = price * parseInt(quantity.value);
            elementPrice.innerText = itemPrice+" L.E";

            total.innerText = "Total: " + totalOrderPrice()+" L.E";

        })

        total.innerText = "Total: " + totalOrderPrice()+" L.E";
    })
}


const totalOrderPrice = function () {
    let eachElementPrice = [...document.getElementsByClassName("elementPrice")];
    let sum = 0;
    for (const item of eachElementPrice) {
        sum += parseInt(item.innerText);
    }

    return sum;
}

let searchfield = document.getElementById("search");

searchfield.addEventListener("keyup", (e) => {
    const searchText = e.target.value;

    [...document.body.getElementsByClassName("item")].forEach(item => {

        if (item.childNodes[1].dataset.name.includes(searchText)) {
            item.style.display = "block";
        } else {
            item.style.display = "none";
        }
    })

})

const form = document.getElementById("form");

form.addEventListener("submit", (event) => {
    event.preventDefault();
    let reqData = "";
    const formData = new FormData(form);
    for (const [name, value] of formData.entries()) {
        reqData += `${name}=${value}&`
    }
    fetch('/CafeteriaSystem/userPages/insertOrder.php', {
        method: 'POST',
        headers: {
            "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
        },
        body: reqData,
    })
        .then(res => res.json())
        .then((res) => {
            if (res == "success") {
                location.reload();
                alert("Order Added Successfuly");
                orderList.innerHTML = "<div>Order</div>";
            }
            else {
                alert("Order is empty");
            }
        })
        .catch((error) => {
            console.error('Error:', error);
        });
})