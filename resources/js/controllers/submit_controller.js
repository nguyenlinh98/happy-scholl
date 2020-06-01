import { Controller } from 'stimulus';

class SubmitController extends Controller {
    preventDouble() {
        if ((this.element.nodeName === 'INPUT' && (this.element.type === 'submit' || this.element.type === 'image')) || (this.element.nodeName === 'BUTTON' && this.element.type === 'submit')) {
            this.element.classList.add('form-element-disable-click');
        }
    }
}

export default SubmitController;
