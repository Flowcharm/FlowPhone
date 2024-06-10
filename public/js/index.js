import vanillaToast from "https://esm.sh/vanilla-toast@0.5.0";
import { getPhones } from "./modules/api/phone.js";
import { observeNewElement } from "./modules/helpers/observer.js";
import { debounce } from "./modules/helpers/debounce.js";
import {
  createPreviewPhoneCard,
  createPreviewPhoneCardSkeleton
} from "./modules/ui/previewPhoneCard.js";
import {
  addToLocalCart,
  getCartFromLocalStorage
} from "./modules/helpers/localCart.js";
import { isUserAuthenticated } from "./modules/helpers/isUserAuthenticated.js";
import { addToCart, getUserCart } from "./modules/api/cart.js";

const isUserAuth = await isUserAuthenticated();

let isSearch = false;

const listPhonesMain = document.getElementById("list-phones-main");

const limit = listPhonesMain.children.length - 1 || 10;
let offset = 0;

const phones = [];

const listPhonesSearch = document.getElementById("list-phones-search");
const searchForm = document.getElementById("search-form");
const searchInput = document.getElementById("search-input");
const searchResultsContainer = document.getElementById(
  "search-results-container"
);

const chargedPhonesCards = document.querySelectorAll(
  ".preview-phone-card:not(.skeleton)"
);

const buyBtns = document.querySelectorAll(".preview-phone-card__phone-btn-buy");

buyBtns.forEach((btn) => {
  btn.addEventListener("click", async (event) => {
    const phoneId = event.target.dataset.id;
    proceedCheckout(phoneId);
  });
});

async function proceedCheckout(phoneId) {
  try {
    const resp = await fetch("/src/app/api/checkout.php", {
      method: "POST",
      body: JSON.stringify({
        items: [
          {
            id: phoneId,
            quantity: 1
          }
        ]
      })
    });
    const data = await resp.json();
    window.location.href = data.url;
  } catch (error) {
    console.log(error);
  }
}

searchForm.addEventListener("submit", (event) => {
  event.preventDefault();
  handleForm();
});
searchInput.addEventListener("input", handleSearchChange);
searchForm.addEventListener("reset", () => {
  setIsSearch(false);
});

initPhones();

function handleAddCart(phone) {
  console.log("Adding to cart:", phone);

  if (isUserAuth) {
    addToCart(phone.id);
  } else {
    const localCart = getCartFromLocalStorage();
    const item = localCart.find((item) => item.id === phone.id);
    const quantity = item ? item.quantity + 1 : 1;
    addToLocalCart(phone.id, quantity);
  }
  vanillaToast.success("Added to cart!");
}

function handleForm() {
  const formData = new FormData(searchForm);
  const formValues = Object.fromEntries(formData.entries());

  if (Object.values(formValues).every((value) => value === "")) {
    setIsSearch(false);
    return;
  }

  setIsSearch(true);

  listPhonesSearch.innerHTML = "";
  listPhonesSearch.appendChild(createPreviewPhoneCardSkeleton());

  searchPhones(formValues);
}

const debouncedSearch = debounce(handleForm, 500);

function handleSearchChange(event) {
  if (event.target.value.length === 0) {
    setIsSearch(false);
    return;
  }

  setIsSearch(true);

  debouncedSearch();
}

async function searchPhones(formValues) {

  try {
    const phones = await getPhones({
      ...formValues
    });

    populatePhones(phones, listPhonesSearch);

    listPhonesSearch.removeChild(
      listPhonesSearch.children[listPhonesSearch.children.length - 1]
    );
  } catch (error) {
    console.error("Error searching phones:", error);
  }
}

function populatePhones(phonesToCreate, container) {
  phonesToCreate.forEach((phone, index) => {
    const card = createPreviewPhoneCard({ phone, handleAddCart });

    const lastChild = container.children[container.children.length - 1];

    container.insertBefore(card, lastChild);

        if (index === phonesToCreate.length - 1) {
            const root = document;
            observeNewElement({
                root: root,
                toObserve: card,
                callback: loadMorePhones,
                threshold: 0.1,
            });
        }
    });
}

async function initPhones() {
    try {
        const newPhones = await getPhones({ limit, offset });

        phones.push(...newPhones);

        chargedPhonesCards.forEach((card, index) => {
            const phone = phones[index];
            const button = card.querySelector(
                '.preview-phone-card__phone-btn-cart'
            );
            button.addEventListener('click', () => handleAddCart(phone));
        });

        observeNewElement({
            root: document,
            toObserve:
                listPhonesMain.children[listPhonesMain.children.length - 1],
            callback: loadMorePhones,
            threshold: 0.1,
        });

        offset += limit;
    } catch (error) {
        console.error('Error initializing phones:', error);
    }

}

async function loadMorePhones() {
  try {
    const newPhones = await getPhones({ limit, offset });

    phones.push(...newPhones);

    if (newPhones.length === 0) {
      listPhonesMain.removeChild(
        listPhonesMain.children[listPhonesMain.children.length - 1]
      );
    }

    populatePhones(newPhones, listPhonesMain);

    offset += limit;
  } catch (error) {
    console.error("Error loading more phones:", error);
  }
}

function setIsSearch(value) {
  if (isSearch === value) return;
  if (value) {
    searchResultsContainer.classList.remove("hidden");
  } else {
    if (!searchResultsContainer.classList.contains("hidden"))
      searchResultsContainer.classList.add("hidden");
  }
  isSearch = value;
}
