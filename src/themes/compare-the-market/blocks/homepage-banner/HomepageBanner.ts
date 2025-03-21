import {Component} from "@/component";
import throttle from 'lodash.throttle';;

export default class HomepageBanner extends Component {

  private scrollBanner: HTMLElement;
  private el: HTMLElement;

  constructor(element: HTMLElement) {
    super(element);
    this.el = element;
    this.scrollBanner = element.querySelector('.homepage-banner-scroll');

    if (!this.scrollBanner) return;

    this.initScrollClick();
    window.addEventListener('scroll', throttle(()=>this.initScroll(), 200));
  }

  initScrollClick() {
    const header = document.querySelector('header');
    const headerHeight = document.querySelector('#wpadminbar') ?
      header.clientHeight + document.querySelector('#wpadminbar').clientHeight :
      header.clientHeight;

    const nextBlock = this.el.nextElementSibling as HTMLElement;
    this.scrollBanner.addEventListener('click', ()=>{

      window.scrollTo({
        top: window.scrollY + nextBlock.getBoundingClientRect().top - headerHeight,
        behavior: 'smooth',
      });
    });


  }

  initScroll(){
   if(window.scrollY > 150) {
     this.scrollBanner.classList.add('opacity-0');
   } else {
     this.scrollBanner.classList.remove('opacity-0');
   }

  }
}
