export const MAX_RATING = 5;

export const createStar = ({ classContainer, filled = false }) => {
    const starEl = document.createElement('span');

    starEl.classList.add('star');
    if (filled) {
        starEl.classList.add('filled');
    }
    if (classContainer) {
        starEl.classList.add(`${classContainer}__star`);
    }

    const svg = `
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
        stroke-width="1" stroke-linecap="round" stroke-linejoin="round"
        class="icon icon-tabler icons-tabler-outline icon-tabler-star">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" />
        </svg>
    `;
    starEl.innerHTML = svg;

    return starEl;
};

export const createStarRating = ({ classContainer, rating, showRating = true }) => {
    const starRatingEl = document.createElement('div');
    starRatingEl.classList.add('stars');
    if (classContainer) {
        starRatingEl.classList.add(`${classContainer}__stars`);
    }

    for (let i = 1; i <= MAX_RATING; i++) {
        const star = createStar({ classContainer, filled: i <= rating });
        starRatingEl.appendChild(star);
    }

    if (showRating) {
        const ratingEl = document.createElement('span');
        ratingEl.textContent = rating;
        ratingEl.classList.add('rating');
        if (classContainer) {
            ratingEl.classList.add(`${classContainer}__rating`);
        }

        starRatingEl.appendChild(ratingEl);
    }

    return starRatingEl;
};
