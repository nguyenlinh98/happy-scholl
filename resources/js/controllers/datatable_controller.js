import { Controller } from 'stimulus';
import debounce from 'lodash.debounce';

class DatatableController extends Controller {
    initialize() {
        this.search = debounce(this.search, 100);
    }

    connect() {
        if (!this.element.classList.contains('dataTable')) {
            this.columns = this.getColumns();
            this.datatableInstance = window.$(this.element).DataTable({
                searching: true,
                pageLength: 50,
                language: {
                    sEmptyTable: 'テーブルにデータがありません',
                    sInfo: ' _TOTAL_ 件中 _START_ から _END_ まで表示',
                    sInfoEmpty: ' 0 件中 0 から 0 まで表示',
                    sInfoFiltered: '（全 _MAX_ 件より抽出）',
                    sInfoPostFix: '',
                    sInfoThousands: ',',
                    sLengthMenu: '_MENU_ 件表示',
                    sLoadingRecords: '読み込み中...',
                    sProcessing: '処理中...',
                    sSearch: '検索:',
                    sZeroRecords: '一致するレコードがありません',
                    oPaginate: {
                        sFirst: '先頭',
                        sLast: '最終',
                        sNext: '次',
                        sPrevious: '前'
                    },
                    oAria: {
                        sSortAscending: ': 列を昇順に並べ替えるにはアクティブにする',
                        sSortDescending: ': 列を降順に並べ替えるにはアクティブにする'
                    },
                    dom: '<lf<t>ip>'
                },
                columns: this.columns
            });

            this.registerSearchEvents();
        }
    }

    getColumns() {
        const $header = this.element.querySelector('thead > tr:first-child');
        if (!$header) {
            console.error(`Table ${this.element} has no header`);
            return [];
        }
        const columns = [];

        $header.querySelectorAll('th').forEach(($column, index) => {
            const setting = {};

            setting.data = 'column' in $column.dataset ? $column.dataset.column : index;
            setting.searchable = 'searchable' in $column.dataset ? $column.dataset.searchable === 'true' : true;
            setting.visible = 'visible' in $column.dataset ? $column.dataset.visible === 'true' : true;
            setting.sortable = 'sortable' in $column.dataset ? $column.dataset.sortable === 'true' : true;
            columns.push(setting);
        });
        return columns;
    }

    registerSearchEvents() {
        const action = 'datatableSearch@window->datatable#search';
        if ('action' in this.element.dataset) {
            if (this.element.dataset.action.indexOf(action) !== -1) {
                this.element.dataset.action = `${this.element.dataset.action} ${action}`;
            }
        } else {
            this.element.dataset.action = action;
        }
    }

    getColumnsIndex(columnArray) {
        const columnsIndex = [];
        this.columns.forEach((column, index) => {
            if (columnArray.includes(column.data)) {
                columnsIndex.push(index);
            }
        });
        return columnsIndex;
    }

    search(event) {
        const { identifier, columns, searchString } = event.detail;

        if (identifier !== '') {
            if (this.element.id !== identifier) {
                return false;
            }
        }
        const columnsIndex = this.getColumnsIndex(columns.split(','));
        if (columnsIndex.length === 0) {
            this.datatableInstance.search(searchString).draw();
        }
        if (columnsIndex.length === 1) {
            this.datatableInstance
                .column(columnsIndex[0])
                .search(searchString)
                .draw();
        } else {
            // TODO: Multi column search improvement
            this.datatableInstance
                .columns(columnsIndex)
                .search(searchString)
                .draw();
        }
        return true;
    }
}

export default DatatableController;
