import { getPhone, getBasicPhonesInfo } from "./modules/api/phone.js";
import { setupDropdownToggle, createDropdownOption, observeLastOption } from "./modules/ui/dropdown.js";
import { populateTable } from "./modules/ui/table.js";

export function main({ principalPhone }) {
    const phonesFetched = [principalPhone];
    let selectPage = 0;
    const selectLimit = 10;

    const dropdownSelect = document.getElementById("dropdown-select");
    const dropdownToggle = document.getElementById("dropdown-toggle");
    const dropdownMenu = document.getElementById("dropdown-menu");
    const dropdownText = document.getElementById("dropdown-text");
    const dropdownList = document.getElementById("dropdown-list");
    const dropdownLoadingElement = document.getElementById("dropdown-list-loading");

    setupDropdownToggle(dropdownToggle, dropdownMenu);
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
                observeLastOption(option, loadMoreOptions);
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
}