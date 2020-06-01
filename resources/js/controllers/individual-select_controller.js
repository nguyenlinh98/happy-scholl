import { Controller } from 'stimulus';
import Tagify from '@yaireo/tagify';

class IndividualSelectController extends Controller {
    static targets = ['selectClass', 'selectStudent', 'selectStudentBody', 'modal', 'tag', 'student'];

    selectClass(event) {
        event.preventDefault();
        event.stopPropagation();
        this.element.classList.add('step--select-student');
        window.axios.get(`${this.data.get('students-api')}?class_id=${event.currentTarget.dataset.classId}`).then(response => {
            this.selectStudentBodyTarget.innerHTML = response.data;
        });
    }

    connect() {
        this.tagify = new Tagify(this.tagTarget, {
            editTags: false,
            backspace: false,
            addTagOnBlur: false,
            enforceWhitelist: true,
            dropdown: {
                enabled: false
            }
        });
        if (this.data.has('defaults')) {
            const defaultStudents = JSON.parse(this.data.get('defaults'));
            this.tagify.settings.whitelist = defaultStudents;
            this.tagify.addTags(defaultStudents);
        }
        window.$(this.modalTarget).on('hide.bs.modal', () => {
            this.element.classList.remove('step--select-student');
            this.selectStudentBodyTarget.innerHTML = '';
        });
    }

    selectStudent() {
        const selectedStudents = this.studentTargets.filter(item => item.checked === true).map(item => JSON.parse(item.value));
        this.tagify.removeAllTags();
        this.tagify.settings.whitelist = selectedStudents;
        this.tagify.addTags(selectedStudents);
        window.$(this.modalTarget).modal('hide');
    }
}

export default IndividualSelectController;
