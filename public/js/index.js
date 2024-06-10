import { getPhones } from './modules/api/phone.js';
import { observeNewElement } from './modules/helpers/observer.js';
import { debounce } from './modules/helpers/debounce.js';
import { createPreviewPhoneCard, createPreviewPhoneCardSkeleton } from './modules/ui/previewPhoneCard.js';

let isSearch = false;

const listPhonesMain = document.getElementById('list-phones-main');

const limit = listPhonesMain.children.length - 1 || 10;
let offset = 0;

const phones = [];

let firstLoad = true;

const listPhonesSearch = document.getElementById('list-phones-search');
const searchForm = document.getElementById('search-form');
const searchInput = document.getElementById('search-input');
const phonesContainer = document.getElementById('phones-container');
const searchResultsContainer = document.getElementById('search-results-container');

searchForm.addEventListener('submit', (event) => {
    event.preventDefault();
    handleForm();
});
searchInput.addEventListener('input', handleSearchChange);
searchForm.addEventListener('reset', () => {
    setIsSearch(false);
});

loadMorePhones();

function handleForm() {
    const formData = new FormData(searchForm);
    const formValues = Object.fromEntries(formData.entries());

    if (Object.values(formValues).every(value => value === '')) {
        setIsSearch(false);
        return;
    }

    setIsSearch(true);

    listPhonesSearch.innerHTML = '';
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
            ...formValues, 
        });

        populatePhones(phones, listPhonesSearch);

        listPhonesSearch.removeChild(
            listPhonesSearch.children[listPhonesSearch.children.length - 1]
        );
    } catch (error) {
        console.error('Error searching phones:', error);
    }
}

function populatePhones(phonesToCreate, container) {
    phonesToCreate.forEach((phone, index) => {
        const card = createPreviewPhoneCard({ phone });

        const lastChild = container.children[container.children.length - 1];

        container.insertBefore(card, lastChild);

        if (index === phonesToCreate.length - 1) {
            const root = document;
            observeNewElement({
                root: root,
                toObserve: card,
                callback: loadMorePhones,
            });
        }
    });
}

async function loadMorePhones() {
    try {
        const newPhones = await getPhones({ limit, offset });
        console.log(newPhones);

        if (newPhones.length === 0) {
            listPhonesMain.removeChild(
                listPhonesMain.children[listPhonesMain.children.length - 1]
            );
        }

        if (firstLoad) {
            firstLoad = false;
            observeNewElement({
                root: document,
                toObserve: listPhonesMain.children[listPhonesMain.children.length - 1],
                callback: loadMorePhones,
            });
        } else {
            populatePhones(newPhones, listPhonesMain);
        }

        offset += limit;
    } catch (error) {
        console.error('Error loading more phones:', error);
    }
}

function setIsSearch(value) {
    if (isSearch === value) return;
    if (value) {
        searchResultsContainer.classList.remove('hidden');
    } else {
        if (!searchResultsContainer.classList.contains('hidden')) 
            searchResultsContainer.classList.add('hidden');
    }
    isSearch = value;
}
