/* Main stylesheets, do not remove */
import "../scss/app.scss";
// import "../admin/scss/admin.scss";

/* Your own modules go here */
import options from './lib/options';
import main from './lib/main';
import navigation from './lib/navigation';
import contact from './lib/contact';
import forms from "./lib/forms";
import blocks from "./lib/blocks";
import show from "./lib/show-on-scroll";

const initJs = () => {
    options.load();
    navigation.load();
    main.load();
    forms.load();
    contact.load();
    blocks.load();
    show.load();
}

initJs();