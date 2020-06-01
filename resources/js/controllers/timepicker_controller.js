import { Controller } from 'stimulus';

const toDigits = number => (number > 9 ? number : `0${number}`);

const timeSelectOptions = (times, selectedTime) => {
    const html = [];
    for (const time of times) {
        html.push(`<option value="${time}" ${selectedTime === time ? 'selected="selected"' : ''}>${time}</option>`);
    }
    return html;
};

const timeBuilder = () => {
    const times = [];
    for (let hour = 0; hour < 24; hour += 1) {
        times.push(`${toDigits(hour)}:00`);
        times.push(`${toDigits(hour)}:30`);
    }
    return times;
};

const nonce = () =>
    Math.random()
        .toString(36)
        .substring(2, 15) +
    Math.random()
        .toString(36)
        .substring(2, 15);
class Timepicker extends Controller {
    connect() {
        this.element.classList.add('visually-hidden');
        this.nonceId = `timepicker-${nonce()}`;
        this.element.insertAdjacentHTML('afterend', this.buildTimeSelect(this.element.value));
        this.select2Element = window.$(document.getElementById(this.nonceId));
        this.select2Element.on('select2:select', event => {
            this.updateSelectedValue(event);
        });
    }

    updateSelectedValue(event) {
        this.element.value = event.params.data.id;
    }

    buildTimeSelect = selectedTime => {
        const times = timeBuilder();
        const optionsHTML = timeSelectOptions(times, selectedTime);
        return `
        <select data-controller="select2" id="${this.nonceId}">
        ${optionsHTML}
        </select>
    `;
    };
}
export default Timepicker;
