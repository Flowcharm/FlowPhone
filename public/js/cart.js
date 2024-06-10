import vanillaToast from "https://esm.sh/vanilla-toast@0.5.0";
import { getUserCart } from "./modules/api/cart.js";

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
