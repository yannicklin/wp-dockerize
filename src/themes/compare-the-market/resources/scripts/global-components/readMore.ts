import {Component} from "@/component";

export default class ReadMore extends Component {

  constructor(element: HTMLElement) {
    super(element);

    const content = element.previousElementSibling as HTMLElement | null;

    element.addEventListener('click', ()=> {
        if (content) {
          if (content.classList.contains('read-more-content')) {
            content.toggleAttribute('hidden');
            element.classList.toggle('show-less');
            element.querySelector('span.read-more-text').innerText = (element.classList.contains('show-less')) ? 'Show Less' : 'Read More';
          }
        }
      });

  }
}
