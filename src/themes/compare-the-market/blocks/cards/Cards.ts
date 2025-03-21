import {Component} from "@/component";
import {Swiper} from "swiper";
import throttle from 'lodash.throttle'

export default class Cards extends Component {

  private slide: Swiper;
  private slideActive: boolean;
  private slideContainer: HTMLElement;
  private cards: NodeList<HTMLElement>;
  private cardsContainer: HTMLElement;

  constructor(element: HTMLElement) {
    super(element);

    this.slideActive = false;
    this.slideContainer = element.querySelector('.swiper') as HTMLElement;
    this.cards = element.querySelectorAll('.card-item');
    this.cardsContainer = element.querySelector('.cards-container');

    this.initSlider();
    window.addEventListener('resize', throttle(()=>this.initSlider(), 200));
  }

  initSlider() {
    if (window.innerWidth < 1200 && !this.slideActive) {
      this.slideActive = true;
      this.slide = new Swiper(this.slideContainer, {
        slidesPerView: 1.2,
        //spaceBetween: 30,
      });

      this.slide.on('slideChangeTransitionStart', () => {
        if(window.dataLayer) {
          window.dataLayer.push({
            'event': 'INTERACTION_EVENT',
            'ixn_action': 'slide'
          })
        }
      })
    } else if (window.innerWidth >= 1201 && this.slideActive && this.slide != null) {
      this.slideActive = false;
      this.slide.destroy();
      this.slideActive = false;
    }

    this.cardsContainer.style.cssText  = `--min-height:0px`; //reset
    let tallestElement : HTMLElement | null = null;
    this.cards.forEach((element) => {
      if (!tallestElement || element.clientHeight > tallestElement.clientHeight) {
        tallestElement = element;
      }
    });
    if (tallestElement) {
      // without clamping to the nearest 2px a chrome bug triggers that adds white space to the bottom of the containing div
      const largestCardHeight = 2 * Math.round(tallestElement.clientHeight / 2);

      this.cardsContainer.style.cssText  = `--min-height:${largestCardHeight}px`;
    }


  }

}