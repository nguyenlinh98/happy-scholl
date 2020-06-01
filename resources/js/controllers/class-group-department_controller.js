import { Controller } from 'stimulus';

class ClassGroupDepartmentController extends Controller {
    static targets = ['choice', 'select', 'selectAll'];

    get currentSelect() {
        return this.data.has('currentSelect') ? this.data.get('currentSelect') : '';
    }

    set currentSelect(value) {
        this.data.set('currentSelect', value);
    }

    connect() {
        if (this.hasSelectTarget) {
            this.selector = this.selectTarget.getAttribute('name');
            this.change();
        }
    }

    change() {
        const identifier = this.selectTarget.value;
        this.selectAllTargets.forEach($selectAllContainer => {
            if (`${this.selector}--${identifier}` !== $selectAllContainer.getAttribute('for')) {
                $selectAllContainer.setAttribute('style', 'display: none;');
            } else {
                $selectAllContainer.setAttribute('style', 'display: block;');
                // eslint-disable-next-line no-param-reassign
                // $selectAllContainer.querySelector('input').checked = false;
            }
        });
        this.choiceTargets.forEach($choiceContainer => {
            if (`${this.selector}--${identifier}` !== $choiceContainer.getAttribute('for')) {
                $choiceContainer.setAttribute('style', 'display: none;');
                // ClassGroupDepartmentController.clearChoices($choiceContainer);
            } else {
                $choiceContainer.setAttribute('style', 'display: block;');
            }
        });
    }

    static clearChoices($element) {
        Array.from($element.getElementsByTagName('input')).forEach($checkbox => {
            if ($checkbox.type === 'checkbox') {
                // eslint-disable-next-line no-param-reassign
                $checkbox.checked = false;
            }
        });
    }
}

export default ClassGroupDepartmentController;
