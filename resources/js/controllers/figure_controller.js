import { Controller } from 'stimulus';

class FigureController extends Controller {
    static targets = ['image', 'prevLink', 'nextLink'];

    get images() {
        if (this.data.has('images')) {
            return JSON.parse(this.data.get('images'));
        }
        return [];
    }

    set images(value) {
        this.data.set('images', JSON.stringify(value));
    }

    get currentIndex() {
        return this.data.has('currentIndex') ? parseInt(this.data.get('currentIndex'), 10) : 0;
    }

    set currentIndex(value) {
        this.data.set('currentIndex', value);
    }

    connect() {
        const images = [];
        this.imageTargets.forEach($image => {
            images.push($image.getAttribute('id'));
        });
        this.images = images;
    }

    next() {
        const targetIndex = this.currentIndex === this.images.length - 1 ? 0 : this.currentIndex + 1;
        this.selectTargetImage(targetIndex);
    }

    prev() {
        const targetIndex = this.currentIndex === 0 ? this.images.length - 1 : this.currentIndex - 1;
        this.selectTargetImage(targetIndex);
    }

    selectTargetImage(targetIndex) {
        const { images } = this;

        const currentImageId = images[this.currentIndex];
        const $currentImage = document.getElementById(currentImageId);
        $currentImage.classList.remove('is-active');

        const targetImageId = images[targetIndex];
        const $targetImage = document.getElementById(targetImageId);
        $targetImage.classList.add('is-active');

        this.currentIndex = targetIndex;
    }
}
export default FigureController;
