import { Controller } from 'stimulus';
import Pikaday from 'pikaday';
import Cleave from 'cleave.js';

const toDigits = number => (number > 9 ? number : `0${number}`);
const toJapaneseDate = date => `${date.getFullYear()}年${toDigits(date.getMonth() + 1)}月${toDigits(date.getDate())}日`;
const fromJapaneseDate = dateString => {
    const regex = /^(\d+)年(\d+)月(\d+)日/gm;
    let m;
    // eslint-disable-next-line no-cond-assign
    while ((m = regex.exec(dateString)) !== null) {
        // This is necessary to avoid infinite loops with zero-width matches
        if (m.index === regex.lastIndex) {
            regex.lastIndex += 1;
        }
    }
    const [year, month, day] = m.map(item => parseInt(item, 10));

    return new Date(year, month - 1, day);
};
class Datepicker extends Controller {
    connect() {
        this.Datepicker = new Pikaday({
            field: this.element,
            toString(date) {
                return toJapaneseDate(date);
            },
            parse(dateString) {
                const lastCharacter = dateString.slice(-1);
                if (lastCharacter !== '日') {
                    return false;
                }
                return fromJapaneseDate(dateString);
            },
            i18n: {
                previousMonth: '前月',
                nextMonth: '翌月',
                months: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'],
                weekdays: ['日曜日', '月曜日', '火曜日', '水曜日', '木曜日', '金曜日', '土曜日'],
                weekdaysShort: ['日', '月', '火', '水', '木', '金', '土']
            }
        });

        this.cleaveInput = new Cleave(this.element, {
            delimiters: ['年', '月', '日'],
            numericOnly: true,
            blocks: [4, 2, 2, 0]
        });
    }
}

export default Datepicker;
