export async function addToCart(phone_id, quantity = 1) {
  try {
    await fetch(`/src/app/api/cart.php`, {
      method: "PUT",
      body: JSON.stringify({
        phone_id,
        quantity
      })
    });
  } catch (error) {
    console.log(error);
  }
}

export async function getUserCart() {
  try {
    const resp = await fetch("/src/app/api/cart.php");
    const data = await resp.json();
    return data;
  } catch (error) {
    console.log(error);
  }
}
