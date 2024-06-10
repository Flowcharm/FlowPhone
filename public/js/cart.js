import vanillaToast from "https://esm.sh/vanilla-toast@0.5.0";
import { getPhone } from "./modules/api/phone.js";

try {
  const account = await fetch("/src/app/api/account.php");
  const json = await account.json();

  if (json.error) {
    loadLocalCart();
  }
} catch (error) {
  loadLocalCart();
}

const btnRemove = document.querySelectorAll(".btn-remove");
const btnDecrease = document.querySelectorAll(".btn-decrease");
const total = document.querySelector("#total");

btnRemove.forEach((btn) => {
  btn.addEventListener("click", (ev) => {
    const id = btn.dataset.id;
    const quantity = btn.dataset.quantity;
    const price = btn.dataset.price;

    ev.target.closest("li").remove();
    total.textContent = +total.textContent - +price * +quantity;

    removeItemFromCart(id, quantity);
  });
});

btnDecrease.forEach((btn) => {
  btn.addEventListener("click", (ev) => {
    const id = btn.dataset.id;
    const quantity = btn.dataset.quantity;
    const price = btn.dataset.price;

    total.textContent = +total.textContent - +price;

    if (quantity === 1) {
      ev.target.closest("li").remove();
    } else {
      const phoneQuantitySpan = document.querySelector(`#phone-quantity-${id}`);

      phoneQuantitySpan.textContent = quantity - 1;
      btn.dataset.quantity = quantity - 1;
      btnDecrease.dataset.quantity = quantity - 1;
      removeItemFromCart(id, 1);
    }
  });
});

function loadLocalCart() {
  const cart = getCartFromLocalStorage();

  Promise.all(
    cart.map(async ({ id, quantity }) => {
      const phone = await getPhone(id);
      return { ...phone, quantity };
    })
  ).then((phones) => {
    const total = phones.reduce(
      (acc, phone) => acc + phone.price * phone.quantity,
      0
    );
    document.querySelector("#total").textContent = total;

    const cartList = document.querySelector("#cart-list");
    cartList.innerHTML = phones.map(cartItemTemplate).join("");
  });
}

function cartItemTemplate({ id, img, brand, price, quantity }) {
  return `
    <li>
        <img src="${img}" alt="${brand}">
        <div class="phone">
            <div class="phone-details">
                <div class="phone-title">
                    <h2>${brand}</h2>
                    <span>price: ${price}€</span>
                </div>
                <span>
                    x<span id="phone-quantity-${id}">${quantity}</span>
                </span>
            </div>
            <div class="actions">
                <button class="minus" id="btn-decrease" data-quantity="${quantity}"
                    data-price="${price}">
                    <?php include_once "../includes/icons/minus.php" ?>
                </button>
                <button class="trash" id="btn-remove" data-id="${id}"
                    data-quantity="${quantity}" data-price="${price}>
                    <?php include_once "../includes/icons/trash.php" ?>
                </button>
            </div>
        </div>
    </li>
    `;
}

function getCartFromLocalStorage() {
  const cart = localStorage.getItem("cart");
  return cart ? JSON.parse(cart) : [];
}

async function removeItemFromCart(phone_id, quantity) {
  try {
    const resp = await fetch("/src/app/api/cart.php", {
      method: "DELETE",
      body: JSON.stringify({ phone_id, quantity }),
      headers: { "Content-Type": "application/json" }
    });

    const json = await resp.json();

    if (json.error) {
      vanillaToast.error(json.error);
    } else {
      vanillaToast.success("Item removed from cart");
    }
  } catch (error) {
    vanillaToast.error("Something went wrong...");
    console.log(error);
  }
}
