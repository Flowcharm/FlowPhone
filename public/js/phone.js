import { createDropdownOption } from './modules/ui/dropdown.js';
import { observeNewElement } from './modules/helpers/observer.js';
import { populateTable } from './modules/ui/table.js';
import { createPreviewPhoneCard } from './modules/ui/previewPhoneCard.js';
import {
    getPhone,
    getBasicPhonesInfo,
    getSimilarPhones,
} from './modules/api/phone.js';
import { getReviews } from './modules/api/reviews.js';

const principalPhone = await getPhone(
    new URLSearchParams(window.location.search).get('id')
);

const phonesFetched = [principalPhone];
let selectPage = 0;
const selectLimit = 10;

const dropdownSelect = document.getElementById('dropdown-select');
const dropdownToggle = document.getElementById('dropdown-toggle');
const dropdownMenu = document.getElementById('dropdown-menu');
const dropdownText = document.getElementById('dropdown-text');
const dropdownList = document.getElementById('dropdown-list');
const dropdownLoadingElement = document.getElementById('dropdown-list-loading');

const listSimilarPhones = document.getElementById('list-similar-phones');

const commentariesList = document.getElementById('commentaries');

const compareButton = document.getElementById('compare-button');
// const compareModal = document.getElementById('compare-modal');

const similarPhonesLimit = listSimilarPhones.childElementCount;
const similarPhonesMinimum = similarPhonesLimit;

dropdownToggle.addEventListener('click', () => {
    dropdownMenu.classList.toggle('show');
});

loadSimilarPhones();
loadMoreOptions();
loadCommentaries();

async function loadCommentaries() {
    try {
        const commentaries = await getReviews(principalPhone.id);
        commentariesList.innerHTML = '';
        commentaries.forEach(commentary => {
            const card = createCommentary({
                review: commentary,
            });

            commentariesList.appendChild(card);
        });

        if (commentaries.length === 0) {
            commentariesList.innerHTML = 'No commentaries yet';
        }
    } catch (error) {
        console.error('Error loading commentaries:', error);
    }
}

async function loadSimilarPhones() {
    try {
        const phones = await getSimilarPhones({
            id: principalPhone.id,
            limit: similarPhonesLimit,
            minimumResults: similarPhonesMinimum,
        });
        const filteredPhones = phones.filter(
            phone => phone.id !== principalPhone.id
        );

        populateSimilarPhones(filteredPhones);
    } catch (error) {
        console.error('Error loading similar phones:', error);
    }
}

async function loadMoreOptions() {
    try {
        const phones = await getBasicPhonesInfo({
            offset: selectPage,
            limit: selectLimit,
        });
        if (phones.length === 0) {
            dropdownList.removeChild(dropdownLoadingElement);
        }

        const filteredPhones = phones.filter(
            phone => phone.id !== principalPhone.id
        );

        populateSelect(filteredPhones);
        selectPage += selectLimit;
    } catch (error) {
        console.error('Error loading more options:', error);
    }
}

function populateSimilarPhones(phones) {
    listSimilarPhones.innerHTML = '';
    phones.forEach(phone => {
        const card = createPreviewPhoneCard({
            phone: phone,
            isSimple: true,
        });

        listSimilarPhones.appendChild(card);
    });
}

function populateSelect(phones) {
    phones.forEach((phone, index) => {
        const option = createDropdownOption(phone, async () => {
            const currentPhone = await handleOptionClick(phone);
            compareButton.addEventListener('click', () => {
                createChart(principalPhone, currentPhone);
            });
        });
        dropdownList.appendChild(option);

        if (index === phones.length - 1) {
            observeNewElement({
                root: option.parentNode.parentNode,
                toObserve: option,
                callback: loadMoreOptions,
            });
        }
    });
}

async function handleOptionClick(phone) {
    const phoneData =
        phonesFetched.find(p => p.id === phone.id) ||
        (await getPhone(phone.id));
    populateTable(phoneData);
    dropdownMenu.classList.remove('show');
    dropdownText.textContent = `${phoneData.brand} ${phoneData.model}`;
    if (!phonesFetched.includes(phoneData)) {
        phonesFetched.push(phoneData);
    }
    return phoneData;
}

function createChart(principalPhone, currentPhone) {
}
