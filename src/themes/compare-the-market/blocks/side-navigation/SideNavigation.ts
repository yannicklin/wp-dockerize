import {Component} from "@/component";
import throttle from 'lodash.throttle';

export default class SideNavigation extends Component {
  private sections: NodeListOf<HTMLElement>;
  private navItems: HTMLElement;
  private header: HTMLElement;
  private maxHeight: number;
  private showMore: HTMLElement;
  private wpAdminBar: HTMLElement | null;

  constructor(element: HTMLElement) {
    super(element);
    this.sections = element.querySelectorAll('section.block');
    this.navItems = element.querySelector('.side-navigation-items')!;
    this.header = document.querySelector('header')!;
    this.maxHeight = parseInt(window.getComputedStyle(this.navItems).getPropertyValue('--max-height'), 10);
    this.showMore = element.querySelector('.show-more')!;
    this.wpAdminBar = document.querySelector('#wpadminbar');

    this.setupEventListeners();
  }

  private setupEventListeners() {
    this.showMore.addEventListener('click', this.toggleShowMore.bind(this));
    window.addEventListener('resize', throttle(this.resizeSideNav.bind(this), 200));
    window.addEventListener('scroll', throttle(this.onStickyScroll.bind(this), 50));
  }

  private toggleShowMore() {
    const showMoreText = this.showMore.querySelector('span')!;
    showMoreText.innerText = (showMoreText.innerText === 'Show more') ? 'Show less' : 'Show more';
    this.showMore.setAttribute('aria-expanded', this.showMore.getAttribute('aria-expanded') !== "true" ? "true" : "false");
    this.navItems.classList.toggle('open');
  }

  private resizeSideNav() {
    if (window.innerWidth < 991 && this.navItems.clientHeight >= this.maxHeight) {
      this.navItems.classList.add('overflow');
      this.showMore.setAttribute('aria-expanded', "false");
    }
  }

  private onStickyScroll() {
    const wpAdminBarHeight = this.wpAdminBar ? this.wpAdminBar.clientHeight : 0;
    const headerHeight = this.header.clientHeight + wpAdminBarHeight;
  
    this.sections.forEach(section => {
      const id = section.id;
      const navItem = this.navItems.querySelector(`a[href="#${id}"]`);
      const rect = section.getBoundingClientRect();
  
      if (navItem) { 
        if (rect.top <= headerHeight) {
          navItem.classList.add('active');
        } else {
          navItem.classList.remove('active');
        }
      }
    });
  }  
}