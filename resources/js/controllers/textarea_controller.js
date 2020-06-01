import { Controller } from 'stimulus';

class TextareaController extends Controller {
    connect() {
        this.defaultHeight = this.element.getBoundingClientRect().height;
    }

    input() {
        this.element.style.height = '5px';
        this.element.style.height = `${Math.max(this.element.scrollHeight, this.defaultHeight)}px`;
    }
}

export default TextareaController;
