export const API_PATH = '/src/api/phones.php';

export const API_PARAMS = {
    id: 'id',
    offset: 'offset',
    limit: 'limit',
    basic: 'basic',
}

export const getPhone = async (id) => {
    const API_URL = new URL(API_PATH, window.location.origin);
    API_URL.searchParams.set(API_PARAMS.id, id);

    const response = await fetch(API_URL);
    const data = await response.json();

    return data.data;
}

export const getPhones = async ({ offset, limit, basic } = {}) => {
    const API_URL = new URL(API_PATH, window.location.origin);
    if (offset) API_URL.searchParams.set(API_PARAMS.offset, offset);
    if (limit) API_URL.searchParams.set(API_PARAMS.limit, limit);
    if (basic) API_URL.searchParams.set(API_PARAMS.basic, basic);

    const response = await fetch(API_URL);
    const data = await response.json();

    return data.data;
}

export const getBasicPhonesInfo = async ({ offset, limit } = {}) => {
    return getPhones({ offset, limit, basic: true });
}
