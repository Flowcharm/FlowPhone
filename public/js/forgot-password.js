import vanillaToast from "https://esm.sh/vanilla-toast@0.5.0";

const form = document.querySelector("#forgot-password-form");
const submit = document.querySelector("#forgot-password-form-submit");

const REDIRECT_TIMEOUT = 2000; // ms

form.addEventListener("submit", async (e) => {
  e.preventDefault();

  submit.disabled = true;

  const formData = new FormData(form);

  const email = formData.get("email");

  try {
    const resp = await fetch("/src/app/api/forgot-password.php", {
      method: "POST",
      body: JSON.stringify({ email }),
      headers: { "Content-Type": "application/json" }
    });

    const json = await resp.json();

    if (json.error) {
      vanillaToast.error(json.error);
    } else {
      vanillaToast.success("Password reset link sent to your email.");

      setTimeout(() => {
        window.location = "/src/app/login.php";
      }, REDIRECT_TIMEOUT);
    }
  } catch (error) {
    vanillaToast.error("Something went wrong. Please try again later.");
  } finally {
    submit.disabled = false;
  }
});
