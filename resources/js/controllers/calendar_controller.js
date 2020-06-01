import { Controller } from 'stimulus';
import { Calendar, formatDate, formatRange } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';
import listPlugin from '@fullcalendar/list';
import timeGridPlugin from '@fullcalendar/timegrid';
import jaLocale from '@fullcalendar/core/locales/ja';

const DATE_FORMAT = {
    locale: 'ja',
    month: 'long',
    year: 'numeric',
    day: 'numeric',
    separator: ' ～ '
};

class CalendarController extends Controller {
    static targets = ['createModal'];

    get events() {
        if (!this.data.has('events')) {
            return [];
        }
        return JSON.parse(this.data.get('events')).map(item => {
            // eslint-disable-next-line no-param-reassign
            item.backgroundColor = item.bg_color ? item.bg_color : item.calendar.event_bgcolor;
            return item;
        });
    }

    triggerCreateEventModal(info) {
        const details = {
            fromView: info.view.type,
            start: info.start,
            end: info.end,
            allDay: info.allDay
        };
        this.createModalTarget.dispatchEvent(
            new CustomEvent('open', {
                detail: details
            })
        );
    }

    connect() {
        const calendar = new Calendar(this.element, {
            plugins: [dayGridPlugin, interactionPlugin, listPlugin, timeGridPlugin],
            locale: 'ja',
            locales: [jaLocale],
            header: {
                left: 'timeGridDay,timeGridWeek,dayGridMonth',
                center: 'title',
                right: 'prev,today,next'
            },
            navLinks: true,
            selectable: true,
            height: 'parent',
            views: {
                timeGridDay: {
                    buttonText: '日',
                    allDayText: '終日',
                    slotLabelFormat: {
                        hour: 'numeric',
                        minute: 'numeric',
                        omitZeroMinute: false
                    },
                    nowIndicator: true
                },
                timeGridWeek: {
                    titleFormat: date => {
                        return `${formatDate(new Date(date.start.marker), DATE_FORMAT)} ～ ${formatDate(new Date(date.end.marker), DATE_FORMAT)}`;
                    },
                    titleRangeSeparator: ' ～ ',
                    buttonText: '週',
                    allDayText: '終日',
                    slotLabelFormat: {
                        hour: 'numeric',
                        minute: 'numeric',
                        omitZeroMinute: false
                    },
                    nowIndicator: true
                },
                dayGridMonth: {
                    buttonText: '月'
                }
            },
            select: info => {
                this.triggerCreateEventModal(info);
            },
            events: this.events,
            eventRender: info => {
                const eventElement = info.el;
                eventElement.dataset.toggle = 'modal';
                eventElement.dataset.target = '#viewCalendarEvent';
                eventElement.dataset.event = JSON.stringify({
                    title: info.event.title,
                    time: info.event.end === null ? formatDate(info.event.start, DATE_FORMAT) : formatRange(info.event.start, info.event.end, DATE_FORMAT),
                    detail: info.event.extendedProps.detail,
                    location: info.event.extendedProps.location,
                    id: info.event.id,
                    calendar_type: info.event.extendedProps.calendar.type
                });
            }
        });

        calendar.render();
    }
}

export default CalendarController;
