import vanillaToast from "https://esm.sh/vanilla-toast@0.5.0";

const form = document.querySelector("#account-form");
const title = document.querySelector("#account-title");
const nameField = document.querySelector("#account-form-name");
const emailField = document.querySelector("#account-form-email");
const submit = document.querySelector("#account-form-submit");

form.addEventListener("submit", async (event) => {
  event.preventDefault();

  submit.disabled = true;

  const formData = new FormData(form);

  const name = formData.get("name");
  const email = formData.get("email") ?? null;
  const currentPassword = formData.get("current-password") ?? null;
  const newPassword = formData.get("new-password") ?? null;
  const confirmPassword = formData.get("confirm-password") ?? null;

  if ((!currentPassword && newPassword) || confirmPassword) {
    vanillaToast.error("Please enter your current password.");
    submit.disabled = false;
    return;
  }

  if (newPassword !== confirmPassword) {
    vanillaToast.error("New passwords do not match.");
    submit.disabled = false;
    return;
  }

  try {
    const resp = await fetch("/src/app/api/account.php", {
      method: "PATCH",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
        name,
        email,
        currentPassword,
        newPassword
      })
    });

    const json = await resp.json();

    if (json.error) {
      vanillaToast.error(json.error);
    } else {
      form.reset();
      vanillaToast.success("Account updated successfully.");

      nameField.value = name ?? nameField.value;
      title.textContent = name ?? nameField.value;

      if (emailField) {
        emailField.value = email ?? emailField.value;
      }
    }
  } catch (error) {
    vanillaToast.error("An error occurred while updating your account.");
    console.error(error);
  } finally {
    submit.disabled = false;
  }
});
