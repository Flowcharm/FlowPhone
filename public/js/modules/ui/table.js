export function populateTable(phone) {
    const tableSecondPhone = document.getElementById("table-second-phone");
    tableSecondPhone.classList.remove("no-phone");
    tableSecondPhone.classList.add("loading");

    document.getElementById("second-phone-brand").textContent = phone.brand;
    document.getElementById("second-phone-model").textContent = phone.model;
    document.getElementById("second-phone-release-year").textContent = phone.release_year;
    document.getElementById("second-phone-screen-size").textContent = `${phone.screen_size_inch} inches`;
    document.getElementById("second-phone-battery-capacity").textContent = `${phone.battery_capacity_mah} mAh`;
    document.getElementById("second-phone-ram").textContent = `${phone.ram_gb} GB`;
    document.getElementById("second-phone-storage").textContent = `${phone.storage_gb} GB`;
    document.getElementById("second-phone-os").textContent = phone.os;
    document.getElementById("second-phone-rating").textContent = phone.ratings;
    document.getElementById("second-phone-price").textContent = `${phone.price_eur}€`;
}
