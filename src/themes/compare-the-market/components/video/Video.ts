import {Component} from "@/component";

export default class Video extends Component {

  constructor(element: HTMLElement) {
    super(element);

    const placeholder = this.element.querySelector('.component-image') as HTMLElement;
    if (!placeholder) return;

    //placeholder.addEventListener('click', this.loadMedia.bind(this));
    placeholder.addEventListener('click', () => this.loadMedia());

  }

  loadMedia(): void {

    // If already loaded, skip
    if (this.element.getAttribute('loaded')) {
      return;
    }
    // Create new dom element for the deferred media
    const content = document.createElement('div') as HTMLElement;
    const template = this.element.querySelector('template') as HTMLTemplateElement;
    content.appendChild(template?.content?.firstElementChild.cloneNode(true));

    // Append template contents to component
    const video = content.querySelector('video, iframe') as HTMLVideoElement || HTMLIFrameElement;
    this.element.appendChild(video);

    // Play video
    video.tagName.toLowerCase() == 'video' ? video.play() : video.src = video.src + '&autoplay=1';

    // Set element ad loaded
    this.element.setAttribute('loaded', true);

  }
}
