import {Component} from "@/component";
import throttle from 'lodash.throttle'

export default class CustomerFeedback extends Component {

  private el: HTMLElement;
  private armContainer: HTMLElement;
  private titleBlock: HTMLElement;

  constructor(element: HTMLElement) {
    super(element);
    this.el = element;
    this.armContainer  = element.querySelector('.animation-container');
    this.titleBlock  = element.querySelector('.component-title-block');

    window.addEventListener('resize', throttle(this.handleResize.bind(this),500));
    this.armScrollIntoView();

  }

   handleResize() {
    const titleOffset = this.titleBlock.offsetLeft;
    this.armContainer.style.width = titleOffset + 'px';
  }


  armScrollIntoView(){
    let options = {
      rootMargin: "0px",
      threshold: 0.8,
    };
    const observer = new IntersectionObserver(entries => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          this.handleResize();
          this.armContainer.classList.add('animated');
        }
      });
    }, options);
    observer.observe(this.el);
  }
}
