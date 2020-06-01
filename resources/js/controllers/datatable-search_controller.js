import { Controller } from 'stimulus';

class DatatableSearchController extends Controller {
    static targets = ['input'];

    connect() {
        this.dataTableIdentifier = this.data.has('identifier') ? this.data.get('identifier') : '';

        this.dataTableColumns = this.data.has('columns') ? this.data.get('columns') : '';
    }

    search() {
        const searchString = this.inputTarget.value;

        window.dispatchEvent(
            new CustomEvent('datatableSearch', {
                detail: {
                    identifier: this.dataTableIdentifier,
                    columns: this.dataTableColumns,
                    input: this.inputTarget.name,
                    searchString
                }
            })
        );
    }
}

export default DatatableSearchController;
