export const setupDropdownToggle = (dropdownToggle, dropdownMenu) => {
    dropdownToggle.addEventListener("click", () => {
        dropdownMenu.classList.toggle("show");
    });
}

export const createDropdownOption = (phone, handleClick) => {
    const liOption = document.createElement("li");
    liOption.textContent = `${phone.brand} ${phone.model}`;
    liOption.classList.add("dropdown__option");
    liOption.addEventListener("click", handleClick);
    return liOption;
}

export const observeLastOption = (option, callback) => {
    const observer = new IntersectionObserver(entries => {
        const entry = entries[0];
        if (entry.isIntersecting) {
            console.log(entry)
            observer.unobserve(entry.target);
            callback();
        }
    }, { root: option.parentNode.parentNode, rootMargin: "0px", threshold: 0.5 });

    observer.observe(option);
}
