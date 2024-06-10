export const API_PATH = '/src/app/api/review.php';

export const API_PARAMS = {
    phoneId: 'phone_id',
};

export const getReviews = async phoneId => {
    const API_URL = new URL(API_PATH, window.location.origin);
    API_URL.searchParams.set(API_PARAMS.phoneId, phoneId);

    const response = await fetch(API_URL);
    const reviews = await response.json();
    // Reviews doesn't have users data

    return reviews;
};
