import { Controller } from 'stimulus';

class LinkController extends Controller {
    get href() {
        if (this.data.has('href')) {
            return this.data.get('href');
        }
        return false;
    }

    go() {
        if (this.href === false) {
            return false;
        }
        window.location.href = this.href;
        return true;
    }
}

export default LinkController;
