import { Controller } from 'stimulus';
import jQuery from 'jquery';

export default class extends Controller {
    static targets = ['title', 'time', 'location', 'detail', 'deleteForm', 'editLink', 'footer'];

    initialize() {
        jQuery(this.element).on('show.bs.modal', event => {
            if (event.target.id === 'viewCalendarEvent') {
                const eventData = JSON.parse(event.relatedTarget.dataset.event);
                this.populateViewEventModel(eventData);
            }
            return true;
        });
    }

    populateViewEventModel(eventData) {
        this.titleTarget.innerHTML = eventData.title;
        this.timeTarget.innerHTML = eventData.time;
        this.locationTarget.innerHTML = eventData.location;
        this.detailTarget.innerHTML = eventData.detail;
        if (eventData.calendar_type === 'hsp') {
            this.footerTarget.classList.add('d-none');
        } else {
            this.editLinkTarget.href = `admin/event/${eventData.id}/edit`;
            // this.eventIdTarget.value = eventData.id;
            this.deleteFormTarget.action = `admin/event/${eventData.id}`;
            this.footerTarget.classList.remove('d-none');
        }
    }
}
