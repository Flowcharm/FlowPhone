
export const observeNewElement = ({root, toObserve, callback = () => {}}) => {
    const observer = new IntersectionObserver(entries => {
        const entry = entries[0];
        if (entry.isIntersecting) {
            observer.unobserve(entry.target);
            callback();
        }
    }, { root, rootMargin: "0px", threshold: 0.5 });

    observer.observe(toObserve);
}