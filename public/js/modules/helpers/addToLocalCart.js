function addToLocalCart(id, quantity) {
  let cart = JSON.parse(localStorage.getItem("cart"));
  if (cart == null) {
    cart = [];
  }
  cart.push({ id, quantity });
  localStorage.setItem("cart", JSON.stringify(cart));
}
