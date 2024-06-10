import { getPhone, getBasicPhonesInfo } from "./modules/api/phone.js";
import { createDropdownOption } from "./modules/ui/dropdown.js";
import { observeNewElement } from "./modules/helpers/observer.js";
import { populateTable } from "./modules/ui/table.js";

const principalPhone = await getPhone(new URLSearchParams(window.location.search).get("id")); 

const phonesFetched = [principalPhone];
let selectPage = 0;
const selectLimit = 10;

const dropdownToggle = document.getElementById("dropdown-toggle");
const dropdownMenu = document.getElementById("dropdown-menu");
const dropdownText = document.getElementById("dropdown-text");
const dropdownList = document.getElementById("dropdown-list");
const dropdownLoadingElement = document.getElementById("dropdown-list-loading");
const btnBuy = document.getElementById("btn-buy");

btnBuy.addEventListener("click", () => {
    proceedCheckout(principalPhone.id);
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

dropdownToggle.addEventListener("click", () => {
    dropdownMenu.classList.toggle("show");
});

dropdownMenu.addEventListener("blur", () => {
    dropdownMenu.classList.remove("show");
});

loadMoreOptions();

async function loadMoreOptions() {
    try {
        const phones = await getBasicPhonesInfo({ offset: selectPage, limit: selectLimit });
        if (phones.length === 0) {
            dropdownList.removeChild(dropdownLoadingElement);
        } 

        const filteredPhones = phones.filter(phone => phone.id !== principalPhone.id);
        populateSelect(filteredPhones);
        selectPage += selectLimit;
    } catch (error) {
        console.error("Error loading more options:", error);
    }
}

function populateSelect(phones) {
    phones.forEach((phone, index) => {
        const option = createDropdownOption(phone, async () => {
            await handleOptionClick(phone);
        });
        dropdownList.appendChild(option);

        if (index === phones.length - 1) {
            observeNewElement({ root: option.parentNode.parentNode, toObserve: option, callback: loadMoreOptions });
        }
    });
}

async function handleOptionClick(phone) {
    const phoneData = phonesFetched.find(p => p.id === phone.id) || await getPhone(phone.id);
    populateTable(phoneData);
    dropdownMenu.classList.remove("show");
    dropdownText.textContent = `${phoneData.brand} ${phoneData.model}`;
    if (!phonesFetched.includes(phoneData)) {
        phonesFetched.push(phoneData);
    }
}
