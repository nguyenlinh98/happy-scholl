import { Controller } from 'stimulus';

class Select2Controller extends Controller {
    connect() {
        window.$(this.element).select2({
            theme: 'bootstrap4'
        });
    }
}

export default Select2Controller;
