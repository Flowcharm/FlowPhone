export const createDropdownOption = (phone, handleClick) => {
    const liOption = document.createElement("li");
    liOption.textContent = `${phone.brand} ${phone.model}`;
    liOption.classList.add("dropdown__option");
    liOption.addEventListener("click", handleClick);
    return liOption;
}
