import { Controller } from 'stimulus';

class FileController extends Controller {
    static targets = ['label', 'trigger', 'delete', 'input'];

    change() {
        if (this.hasLabelTarget) {
            this.labelTarget.innerHTML = this.inputTarget.files[0].name;
        }
    }

    delete() {
        this.inputTarget.value = '';
        this.labelTarget.innerHTML = '';
        if (this.hasDeleteTarget) {
            this.deleteTargets.forEach($element => {
                if ($element.nodeName === 'INPUT') {
                    // eslint-disable-next-line no-param-reassign
                    $element.value = '';
                }
            });
        }
    }
}

export default FileController;
