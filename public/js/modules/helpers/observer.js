
export const observeNewElement = ({root, toObserve, rootMargin = "0px", threshold = 0.5,callback = () => {}}) => {
    const observer = new IntersectionObserver(entries => {
        const entry = entries[0];
        if (entry.isIntersecting) {
            observer.unobserve(entry.target);
            callback();
        }
    }, { root, rootMargin, threshold });

    observer.observe(toObserve);
}