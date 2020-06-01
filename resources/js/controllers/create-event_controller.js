import { Controller } from 'stimulus';

const toDigits = number => (number > 9 ? number : `0${number}`);

const toTime = date => `${toDigits(date.getHours())}:${toDigits(date.getMinutes())}`;

const toDate = date => `${date.getFullYear()}-${toDigits(date.getMonth() + 1)}-${toDigits(date.getDate())}`;

// const toDateTime = date => `${toDate(date)} ${toTime(date)}`;

const toJapaneseDate = date => `${date.getFullYear()}年${toDigits(date.getMonth() + 1)}月${toDigits(date.getDate())}日`;

const diffInDays = (first, second) => Math.floor((second - first) / (1000 * 60 * 60 * 24));

const datePickerElement = (elementId, elementName, elementValue) =>
    `<input type="text" class="form-control" id="${elementId}" name="${elementName}" data-controller="datepicker" value="${elementValue}"></input>`;
const timePickerElement = (elementId, elementName, elementValue) => `<input type="hidden" id="${elementId}" name="${elementName}" data-controller="timepicker" value="${elementValue}"></input>`;

const dateTimePickerElement = (type, dateValue, timeValue) =>
    `<div class="form-row">
        <div class="col-8">
            ${datePickerElement(`${type}Date`, `${type}_date`, dateValue)}
        </div>
        <div class="col-4">
            ${timePickerElement(`${type}Time`, `${type}_time`, timeValue)}
        </div>
    </div>
`;
class CreateEventController extends Controller {
    static targets = ['start', 'end', 'title', 'allDay', 'name'];

    connect() {
        this.allDayEvent = this.allDayTarget.checked;
    }

    reset() {
        this.allDayEvent = false;
        this.fromView = '';
        this.singleDate = '';
        this.oldStartTime = '';
        this.oldEndTime = '';
        this.allDayTarget.checked = false;
        if (this.hasNameTarget) {
            this.nameTarget.value = '';
        }
    }

    open(event) {
        this.reset();
        const details = event.detail;
        this.fromView = details.fromView;
        if (details.fromView === 'dayGridMonth') {
            if (diffInDays(details.start, details.end) === 1) {
                this.createSingleDayEvent(details);
            } else {
                this.createMultipleDaysEvent(details);
            }
        }
        if (details.fromView === 'timeGridWeek') {
            if (diffInDays(details.start, details.end) === 0) {
                this.createSingleDayEvent(details);
            } else {
                this.createMultipleDaysEvent(details);
            }
        }

        if (details.fromView === 'timeGridDay') {
            this.createSingleDayEvent(details);
        }

        window.$(this.element).modal('show');
    }

    createSingleDayEvent(data) {
        this.singleDay = true;
        this.singleDate = data.start;
        const now = new Date();
        let minTime;
        let maxTime;
        if (data.fromView === 'dayGridMonth') {
            minTime = new Date();
            maxTime = new Date();
            minTime.setHours(now.getMinutes() > 30 ? now.getHours() + 1 : now.getHours(), now.getMinutes() > 30 ? 0 : 30, 0);
            maxTime.setHours(now.getHours() + 1, now.getMinutes() > 30 ? 30 : 0, 0);
        } else {
            minTime = data.start;
            maxTime = data.end;
        }

        this.startTarget.innerHTML = `${timePickerElement('startTime', 'start_time', toTime(minTime))}<input type="hidden" name="single_date" value="${toDate(data.start)}">`;
        this.endTarget.innerHTML = timePickerElement('endTime', 'end_time', toTime(maxTime));
        this.titleTarget.innerHTML = `${toJapaneseDate(data.start)}のイベントを追加する`;
    }

    createMultipleDaysEvent(data) {
        this.singleDay = false;
        const now = new Date();

        const startTime = data.start;
        const endTime = data.end;

        if (data.fromView === 'dayGridMonth') {
            endTime.setHours(now.getHours() - 24, now.getMinutes());
            startTime.setHours(now.getHours(), now.getMinutes());
        }

        this.startTarget.innerHTML = dateTimePickerElement('start', toJapaneseDate(startTime), toTime(startTime));
        this.endTarget.innerHTML = dateTimePickerElement('end', toJapaneseDate(endTime), toTime(endTime));
        this.titleTarget.innerHTML = '予定の追加';
    }

    toggleAllDayEvent() {
        this.allDayEvent = !this.allDayEvent;
        if (this.singleDay) {
            this.toggleSingleDayEvent();
        } else {
            this.toggleMultipleDayEvent();
        }
    }

    toggleSingleDayEvent() {
        if (this.allDayEvent) {
            const startTime = this.startTarget.querySelector('#startTime').value;
            const endTime = this.endTarget.querySelector('#endTime').value;
            this.oldStartTime = startTime;
            this.oldEndTime = endTime;

            this.endTarget.innerHTML = '';
            this.startTarget.innerHTML = `<input type="hidden" name="single_date" value="${toDate(this.singleDate)}">`;
        } else {
            this.startTarget.innerHTML = `${timePickerElement('startTime', 'start_time', this.oldStartTime)}<input type="hidden" name="single_date" value="${toDate(this.singleDate)}">`;
            this.endTarget.innerHTML = timePickerElement('endTime', 'end_time', this.oldEndTime);
        }
    }

    toggleMultipleDayEvent() {
        if (this.allDayEvent) {
            const startDate = this.startTarget.querySelector('#startDate').value;
            const startTime = this.startTarget.querySelector('#startTime').value;
            this.startTarget.innerHTML = datePickerElement('startDate', 'start_date', startDate);
            this.oldStartTime = startTime;

            const endDate = this.endTarget.querySelector('#endDate').value;
            const endTime = this.endTarget.querySelector('#endTime').value;
            this.endTarget.innerHTML = datePickerElement('endDate', 'end_date', endDate);
            this.oldEndTime = endTime;
        } else {
            const startDate = this.startTarget.querySelector('#startDate').value;
            this.startTarget.innerHTML = dateTimePickerElement('start', startDate, this.oldStartTime);
            const endDate = this.endTarget.querySelector('#endDate').value;
            this.endTarget.innerHTML = dateTimePickerElement('end', endDate, this.oldEndTime);
        }
    }
}

export default CreateEventController;
