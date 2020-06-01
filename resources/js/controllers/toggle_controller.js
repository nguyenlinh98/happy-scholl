import { Controller } from 'stimulus';

class ToggleController extends Controller {
    toggle(event) {
        try {
            if (!event.currentTarget.dataset.toggleClass) {
                throw new Error('Trigger Element does not have toggle class setting');
            }
            if (event.currentTarget.dataset.toggleId) {
                if (this.element.id === event.currentTarget.dataset.toggleId) {
                    this.element.classList.toggle(event.currentTarget.dataset.toggleClass);
                } else {
                    document.getElementById(event.currentTarget.dataset.toggleId).classList.toggle(event.currentTarget.dataset.toggleClass);
                }
            } else {
                this.element.classList.toggle(event.currentTarget.dataset.toggleClass);
            }
        } catch (e) {
            console.error(e);
        }
    }
}

export default ToggleController;
