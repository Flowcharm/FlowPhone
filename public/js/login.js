import vanillaToast from "https://esm.sh/vanilla-toast@0.5.0";

const form = document.querySelector("#login-form");
const submit = document.querySelector("#login-form-submit");

form.addEventListener("submit", async (e) => {
  e.preventDefault();

  submit.disabled = true;

  const formData = new FormData(form);

  const email = formData.get("email");
  const password = formData.get("password");

  try {
    const resp = await fetch("/src/app/api/login.php", {
      method: "POST",
      body: JSON.stringify({ email, password }),
      headers: { "Content-Type": "application/json" }
    });

    const json = await resp.json();

    if (json.error) {
      vanillaToast.error(json.error);
    } else {
      window.location = "/src/app/";
    }
  } catch (error) {
    console.log(error);
    vanillaToast.error("Something went wrong...");
  }

  submit.disabled = false;
});
