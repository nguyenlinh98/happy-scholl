import { Controller } from 'stimulus';

class ModalController extends Controller {
    initialize() {
        window.$(this.element).modal();
    }
}

export default ModalController;
