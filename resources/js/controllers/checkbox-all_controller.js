import { Controller } from 'stimulus';

class CheckboxAllController extends Controller {
    get identifier() {
        if (this.data.has('identifier')) {
            return this.data.get('identifier');
        }
        return false;
    }

    initialize() {
        try {
            if (this.element.nodeName !== 'INPUT' || this.element.getAttribute('type') !== 'checkbox') {
                throw new Error('Checkbox-all Controller require host element to be checkbox');
            }
        } catch (e) {
            console.error('Error in element', this.element, e);
        }
    }

    trigger() {
        try {
            if (this.identifier === false) {
                throw new Error('Setup failed, no identifier found');
            }
            const CURRENT_CHECKBOX_CHECKED = this.element.checked === true;
            document.querySelectorAll(this.identifier).forEach(element => {
                if (element.nodeName === 'INPUT' && element.getAttribute('type') === 'checkbox') {
                    if (CURRENT_CHECKBOX_CHECKED) {
                        // eslint-disable-next-line no-param-reassign
                        element.checked = true;
                        if (!element.dataset.checkboxAllCallbackRegistered) {
                            element.addEventListener('change', this.callbackTrigger.bind(this), true);
                            // eslint-disable-next-line no-param-reassign
                            element.dataset.checkboxAllCallbackRegistered = true;
                        }
                    } else {
                        // eslint-disable-next-line no-param-reassign
                        element.checked = false;
                    }
                }
            });
        } catch (e) {
            console.error(e);
        }
    }

    callbackTrigger() {
        this.element.checked = false;
    }
}
export default CheckboxAllController;
