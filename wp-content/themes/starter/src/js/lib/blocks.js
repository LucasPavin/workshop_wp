import gk_timeline from "../../../blocks/Timeline/script";
import gk_highlights from "../../../blocks/Highlights/script";
import gk_accordions from "../../../blocks/AccordionTabs/script";
import gk_downloads from "../../../blocks/Download/script";
import gk_eco_video from "../../../blocks/EcoVideo/script";
import gk_links from "../../../blocks/Link/script";

let gk_blocks = {
    load(){
        gk_timeline.load()
        gk_highlights.load()
        gk_accordions.load()
        gk_downloads.load()
        gk_eco_video.load()
        gk_links.load()
    }
}

export default gk_blocks;
