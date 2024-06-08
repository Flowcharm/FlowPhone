import vanillaToast from "https://esm.sh/vanilla-toast@0.5.0";

const REDIRECT_TIMEOUT = 2000; // ms
const form = document.querySelector("#reset-password-form");
const submit = document.querySelector("#reset-password-form-submit");

form.addEventListener("submit", async (e) => {
  e.preventDefault();

  const url = new URL(window.location);
  const token = url.searchParams.get("token");

  submit.disabled = true;

  const formData = new FormData(form);

  const password = formData.get("password");
  const confirmPassword = formData.get("confirm-password");

  if (password !== confirmPassword) {
    vanillaToast.error("Passwords do not match");
    submit.disabled = false;
    return;
  }

  try {
    const resp = await fetch("/src/app/api/reset-password.php", {
      method: "POST",
      body: JSON.stringify({ token, password }),
      headers: { "Content-Type": "application/json" }
    });

    const json = await resp.json();

    if (json.error) {
      vanillaToast.error(json.error);
    } else {
      vanillaToast.success(
        "Password reset successfully. You can now log in with your new password."
      );
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
