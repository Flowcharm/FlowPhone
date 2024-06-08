import vanillaToast from "https://esm.sh/vanilla-toast@0.5.0";

const REDIRECT_TIMEOUT = 2000; // ms

const form = document.querySelector("#register-form");
const submit = document.querySelector("#register-form-submit");

form.addEventListener("submit", async (event) => {
  event.preventDefault();

  submit.disabled = true;

  const formData = new FormData(form);

  const name = formData.get("name");
  const email = formData.get("email");
  const password = formData.get("password");

  try {
    const resp = await fetch("/src/app/api/register.php", {
      method: "POST",
      body: JSON.stringify({ name, email, password }),
      headers: { "Content-Type": "application/json" }
    });

    const json = await resp.json();

    if (json.error) {
      vanillaToast.error(json.error);
    } else {
      vanillaToast.success("Account created!");

      form.reset();
      setTimeout(() => {
        window.location = "/src/app/login.php";
      }, REDIRECT_TIMEOUT);
    }
  } catch (error) {
    console.log(error);
    vanillaToast.error("Something went wrong...");
  }

  submit.disabled = false;
});
