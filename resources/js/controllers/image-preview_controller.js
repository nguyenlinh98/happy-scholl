import { Controller } from 'stimulus';

const readAsDataURL = file => {
    return new Promise((resolve, reject) => {
        const fr = new FileReader();
        fr.onerror = reject;
        fr.onload = () => {
            resolve(fr.result);
        };
        fr.readAsDataURL(file);
    });
};
class ImagePreview extends Controller {
    connect() {
        this.previewSelector = 'previewSelector' in this.element.dataset ? this.element.dataset.previewSelector : false;
        this.previewElements = this.previewSelector ? document.querySelectorAll(this.previewSelector) : [];
    }

    async updatePreview() {
        if (!this.previewSelector) {
            return false;
        }
        const promised = [];
        try {
            for (let i = 0; i < this.element.files.length; i += 1) {
                const file = this.element.files[i];
                promised.push(
                    readAsDataURL(file).then(url => {
                        const $element = this.previewElements.item(i);
                        if ($element !== null) {
                            $element.style.backgroundImage = `url(${url})`;
                        }
                        return i;
                    })
                );
            }
        } catch (error) {
            console.error(error);
        }
        const result = await Promise.all(promised);
        if (result.length < this.previewElements.length) {
            // if user does not select all preview slot
            // process to clean up
            const lastIndex = Math.max(...result) + 1;
            for (let index = this.previewElements.length - 1; index >= lastIndex; index -= 1) {
                const $element = this.previewElements.item(index);
                $element.style.backgroundImage = '';
            }
        }
        return true;
    }
}

export default ImagePreview;
