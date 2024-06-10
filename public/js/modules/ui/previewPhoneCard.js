import { createStarRating } from "./icons/star.js";
import { createShopCart } from "./icons/shopCart.js";

export const createPreviewPhoneCard = ({ phone, classContainer = "", isSimple = false, handleAddCart = () => {} }) => {
    const classMain = classContainer || "preview-phone-card"; 

    const className = classContainer ? `${classMain}__preview-phone-card` : classMain;

    const cardContainer = document.createElement("div");
    cardContainer.href = `/src/app/phone.php?id=${phone.id}`;
    cardContainer.classList.add(className);
    if (isSimple) {
        cardContainer.classList.add(className + "--simple");
    }

    const cardLink = document.createElement("a");
    cardLink.href = `/src/app/phone.php?id=${phone.id}`;
    cardLink.classList.add(`${classMain}__phone-link`);

    const cardImage = document.createElement("img");
    cardImage.src = phone.image_url;
    cardImage.alt = `${phone.brand} ${phone.model}`;
    cardImage.classList.add(`${classMain}__phone-image`);
    
    cardLink.appendChild(cardImage);

    const cardInfo = document.createElement("div");
    cardInfo.classList.add(`${classMain}__phone-info`);

    const cardName = document.createElement("h3");
    cardName.textContent = `${phone.brand} ${phone.model}`;
    cardName.classList.add(`${classMain}__phone-name`);

    cardInfo.appendChild(cardName);

    const cardPrice = document.createElement("p");
    cardPrice.textContent = `$ ${phone.price_eur}`;
    cardPrice.classList.add(`${classMain}__phone-price`);

    const cardPriceSpan = document.createElement("span");
    cardPriceSpan.textContent = "Taxes Included";
    cardPriceSpan.classList.add(`${classMain}__phone-price-span`);

    cardPrice.appendChild(cardPriceSpan);
    cardInfo.appendChild(cardPrice);

    if (!isSimple) {
        const cardOtherInfo = document.createElement("div");
        cardOtherInfo.classList.add(`${classMain}__phone-other-info`);

        const cardScreenSize = document.createElement("p");
        cardScreenSize.textContent = `Screen: ${phone.screen_size_inch} in`;
        cardScreenSize.classList.add(`${classMain}__phone-screen-size`);
        cardOtherInfo.appendChild(cardScreenSize);

        const cardRam = document.createElement("p");
        cardRam.textContent = `RAM: ${phone.ram_gb}GB`;
        cardRam.classList.add(`${classMain}__phone-ram`);
        cardOtherInfo.appendChild(cardRam);

        cardInfo.appendChild(cardOtherInfo);
    }

    const cardRating = createStarRating({ classContainer: classMain, rating: phone.ratings, showRating: !isSimple });

    cardInfo.appendChild(cardRating);

    cardLink.appendChild(cardInfo);
    cardContainer.appendChild(cardLink);

    if (isSimple) {
        return cardContainer;
    }

    const cardButtons = document.createElement("div");
    cardButtons.classList.add(`${classMain}__phone-buttons`);

    const cardBtnBuy = document.createElement("a");
    cardBtnBuy.href = `/src/app/phone.php?id=${phone.id}`; // TODO
    cardBtnBuy.textContent = "Buy";
    cardBtnBuy.classList.add(`${classMain}__phone-btn-buy`);

    cardButtons.appendChild(cardBtnBuy);

    const cardBtnCart = document.createElement("button");
    cardBtnCart.classList.add(`${classMain}__phone-btn-cart`);

    const cartIcon = createShopCart({ classContainer: classMain });
    cardBtnCart.appendChild(cartIcon);

    const cardBtnCartText = document.createElement("span");
    cardBtnCartText.textContent = "Add to Cart";

    cardBtnCart.addEventListener("click", () => handleAddCart(phone));
    
    cardBtnCart.appendChild(cardBtnCartText);

    cardButtons.appendChild(cardBtnCart);

    cardContainer.appendChild(cardButtons);

    return cardContainer;
};

export const createPreviewPhoneCardSkeleton = ({ classContainer = "" } = {}) => {
    const classMain = classContainer || "preview-phone-card"; 

    const className = classContainer ? `${classMain}__preview-phone-card` : classMain;

    const cardContainer = document.createElement("div");
    cardContainer.href = "#";
    cardContainer.classList.add(className);
    cardContainer.classList.add("skeleton");

    const cardImage = document.createElement("div");
    cardImage.classList.add(`${classMain}__phone-image`);
    
    cardContainer.appendChild(cardImage);

    const cardInfo = document.createElement("div");
    cardInfo.classList.add(`${classMain}__phone-info`);

    const cardName = document.createElement("h3");
    cardName.classList.add(`${classMain}__phone-name`);

    cardInfo.appendChild(cardName);

    const cardPrice = document.createElement("p");
    cardPrice.classList.add(`${classMain}__phone-price`);

    const cardPriceSpan = document.createElement("span");
    cardPriceSpan.classList.add(`${classMain}__phone-price-span`);

    cardPrice.appendChild(cardPriceSpan);
    cardInfo.appendChild(cardPrice);

    const cardOtherInfo = document.createElement("div");
    cardOtherInfo.classList.add(`${classMain}__phone-other-info`);

    const cardScreenSize = document.createElement("p");
    cardScreenSize.classList.add(`${classMain}__phone-screen-size`);
    cardOtherInfo.appendChild(cardScreenSize);

    const cardRam = document.createElement("p");
    cardRam.classList.add(`${classMain}__phone-ram`);
    cardOtherInfo.appendChild(cardRam);

    cardInfo.appendChild(cardOtherInfo);

    const cardRating = document.createElement("div");
    cardRating.classList.add(`${classMain}__phone-rating`);

    cardInfo.appendChild(cardRating);

    cardContainer.appendChild(cardInfo);

    const cardButtons = document.createElement("div");
    cardButtons.classList.add(`${classMain}__phone-buttons`);

    const cardBtnBuy = document.createElement("button");
    cardBtnBuy.classList.add(`${classMain}__phone-btn-buy`);
    cardButtons.appendChild(cardBtnBuy);

    const cardBtnCart = document.createElement("button");
    cardBtnCart.classList.add(`${classMain}__phone-btn-cart`);

    const cartIcon = document.createElement("span");
    cartIcon.classList.add(`${classMain}__shop-cart`);
    cardBtnCart.appendChild(cartIcon);

    const cardBtnCartText = document.createElement("span");
    cardBtnCart.appendChild(cardBtnCartText);

    cardButtons.appendChild(cardBtnCart);

    cardContainer.appendChild(cardButtons);

    return cardContainer;
}
