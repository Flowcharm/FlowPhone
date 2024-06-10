import vanillaToast from "https://esm.sh/vanilla-toast@0.5.0";
import { getPhone } from "./modules/api/phone.js";
import { isUserAuthenticated } from "./modules/helpers/isUserAuthenticated.js";
import { getCartFromLocalStorage } from "./modules/helpers/localCart.js";
import { getUserCart } from "./modules/api/cart.js";

const isUserAuth = await isUserAuthenticated();

if (!isUserAuth) {
  loadLocalCart();
}

const btnRemove = document.querySelectorAll(".btn-remove");
const btnDecrease = document.querySelectorAll(".btn-decrease");
const payment = document.querySelector("#payment");
const total = document.querySelector("#total");

btnRemove.forEach((btn) => {
  btn.addEventListener("click", async (ev) => {
    const id = btn.dataset.id;
    const quantity = btn.dataset.quantity;
    const price = btn.dataset.price;

    ev.target.closest("li").remove();
    total.textContent = (+total.textContent - +price * +quantity).toFixed(2);

    if (+total.textContent < 0.01) {
      total.textContent = 0;
    }

    await removeItemFromCart(id, quantity);
  });
});

btnDecrease.forEach((btn) => {
  btn.addEventListener("click", async (ev) => {
    const id = btn.dataset.id;
    const quantity = +btn.dataset.quantity;
    const price = btn.dataset.price;

    total.textContent = +total.textContent - +price;

    if (+total.textContent < 0.01) {
      total.textContent = 0;
    }

    if (quantity === 1) {
      ev.target.closest("li").remove();
    } else {
      const phoneQuantitySpan = document.querySelector(`#phone-quantity-${id}`);

      phoneQuantitySpan.textContent = quantity - 1;
      btn.dataset.quantity = quantity - 1;
      btn.dataset.quantity = quantity - 1;
    }

    await removeItemFromCart(id, 1);
  });
});

payment.addEventListener("click", async () => {
  await proceedCheckout();
});

async function proceedCheckout() {
  payment.textContent = "Processing...";
  const userCart = await getUserCart();
  try {
    const resp = await fetch("/src/app/api/checkout.php", {
      method: "POST",
      body: JSON.stringify({
        items: userCart.map((el) => ({
          id: el.phone.id,
          quantity: el.quantity
        }))
      })
    });
    const data = await resp.json();
    window.location.href = data.url;
  } catch (error) {
    console.log(error);
  }
}

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
    console.log(phones);
    // cartList.innerHTML = phones.map(({id, price_eur, brand, img_url})=>cartItemTemplate({id, price: price_eur, brand, img: img_url })).join("");
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
