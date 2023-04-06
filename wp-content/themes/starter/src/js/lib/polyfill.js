import objectFitImages from "object-fit-images";

let polyfill = {

    load() {
        // Polyfill for object-fit
        objectFitImages();
    },

};

export default polyfill;
