export const API_PATH = '/src/app/api/phones/';
export const API_GET_PATH = API_PATH;
export const API_DELETE_PATH = `${API_PATH}delete.php`;
export const API_UPDATE_PATH = `${API_PATH}update.php`;
export const API_CREATE_PATH = `${API_PATH}create.php`;

export const API_PARAMS = {
    id: 'id',
    limit: 'limit',
    offset: 'offset',
    basic: 'basic',
    similar: 'similar',
    search: 'search',
    brand: 'brand',
    minPrice: 'min_price',
    maxPrice: 'max_price',
};

export const getPhone = async id => {
    const API_URL = new URL(API_GET_PATH, window.location.origin);
    API_URL.searchParams.set(API_PARAMS.id, id);

    const response = await fetch(API_URL);
    const data = await response.json();

    return data.data;
};

export const getPhones = async ({
    limit,
    offset,
    basic,
    similar,
    search,
    brand,
    minPrice,
    maxPrice,
} = {}) => {
    const API_URL = new URL(API_GET_PATH, window.location.origin);
    if (offset) API_URL.searchParams.set(API_PARAMS.offset, offset);
    if (limit) API_URL.searchParams.set(API_PARAMS.limit, limit);
    if (basic) API_URL.searchParams.set(API_PARAMS.basic, basic);
    if (similar) API_URL.searchParams.set(API_PARAMS.similar, similar);
    if (search) API_URL.searchParams.set(API_PARAMS.search, search);
    if (brand) API_URL.searchParams.set(API_PARAMS.brand, brand);
    if (minPrice) API_URL.searchParams.set(API_PARAMS.minPrice, minPrice);
    if (maxPrice) API_URL.searchParams.set(API_PARAMS.maxPrice, maxPrice);

    const response = await fetch(API_URL);
    const data = await response.json();

    return data.data;
};

export const getBasicPhonesInfo = async ({ offset, limit } = {}) => {
    return getPhones({ offset, limit, basic: true });
};
