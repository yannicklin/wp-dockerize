import { Component } from "@/component";
import Swiper from "swiper";
import throttle from 'lodash.throttle';

export default class ProductComparison extends Component {
  private tabs: NodeListOf<HTMLAnchorElement>;
  private tabContents: NodeListOf<HTMLElement>;
  private swiper: Swiper | null = null;
  private mediaQuery: MediaQueryList;
  private images: NodeListOf<HTMLImageElement>;

  constructor(element: HTMLElement) {
    super(element);
    this.tabs = this.element.querySelectorAll<HTMLAnchorElement>('.nav-link');
    this.tabContents = this.element.querySelectorAll<HTMLElement>('.tab-pane');
    this.mediaQuery = window.matchMedia('(max-width: 1199px)');
    this.images = this.element.querySelectorAll<HTMLImageElement>('.component-image img');

    this.initTabs();
    this.handleScreenSizeChange();
    this.mediaQuery.addEventListener('change', this.handleScreenSizeChange.bind(this));

    this.equalizeListHeights(); 
    window.addEventListener('resize', throttle(this.equalizeListHeights.bind(this), 200));

    this.images.forEach((img) => {
      if (img.complete) {
        this.equalizeListHeights();
      } else {
        img.addEventListener('load', this.equalizeListHeights.bind(this));
      }
    });
  }

  private initTabs(): void {
    this.tabs.forEach((tab, index) => {
      tab.addEventListener('click', (event) => {
        event.preventDefault();
        this.changeTab(index);
      });
    });
  }

  private changeTab(activeIndex: number): void {
    this.tabs.forEach((tab, index) => {
      const isActive = index === activeIndex;
      tab.classList.toggle('active', isActive);
      tab.classList.toggle('bg-blue-300', isActive);
      tab.classList.toggle('text-blue-500', isActive);
      tab.classList.toggle('bg-white', !isActive);
      tab.setAttribute('aria-selected', isActive.toString());
      this.tabContents[index].classList.toggle('show', isActive);
      this.tabContents[index].classList.toggle('active', isActive);
    });
    
    this.equalizeListHeights();
  }

  private initSwiper(): void {
    if (this.element.querySelector('.swipercomparison') && !this.swiper) {
        this.swiper = new Swiper('.swipercomparison', {
            direction: 'horizontal',
            loop: false,
            on: {
                init: () => this.equalizeListHeights()
            },
            breakpoints: {
                0: {
                    slidesPerView: 1.3,
                    spaceBetween: 10,
                },
                768: {
                    slidesPerView: 2.2,
                    spaceBetween: 10,
                },
            },
        });
    }
  }

  private destroySwiper(): void {
    if (this.swiper) {
      if (Array.isArray(this.swiper)) {
        this.swiper.forEach((swiperInstance) => {
          swiperInstance.destroy(true, true);
        });
      } else {
        this.swiper.destroy(true, true);
      }
      this.swiper = null;
    }
  }

  private handleScreenSizeChange(): void {
    if (this.mediaQuery.matches) {
      this.initSwiper();
    } else {
      this.destroySwiper();
    }
  }

  private equalizeListHeights(): void {
    const cards = this.element.querySelectorAll<HTMLElement>('.card-item');
    let maxHeight = 0;
  
    cards.forEach((card) => {
      card.style.height = 'auto';
    });
  
    cards.forEach((card) => {
      maxHeight = Math.max(maxHeight, card.offsetHeight);
    });
  
    const clampedHeight = 2 * Math.round(maxHeight / 2);
    cards.forEach((card) => {
      card.style.height = `${clampedHeight}px`;
    });
  }
}