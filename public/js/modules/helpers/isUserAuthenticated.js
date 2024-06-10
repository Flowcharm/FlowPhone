export const isUserAuthenticated = async () => {
  let isAuthenticated = false;

  try {
    const account = await fetch("/src/app/api/account.php");
    const json = await account.json();

    isAuthenticated = !json.error;
  } catch (error) {
    isAuthenticated = false;
  }

  return isAuthenticated;
};
