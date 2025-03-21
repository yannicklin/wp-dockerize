import {Component} from "../../resources/scripts/component";
import throttle from 'lodash.throttle';

export default class Header extends Component {

  static sticky = true;
  private body: HTMLElement;
  private header: HTMLElement;
  private desktopMenuToggle: HTMLElement;
  private mobileMenuToggles: NodeList;
  private minBaseScroll: number;
  private minScroll: number;
  private lastScroll: number;
  private timeout: any;

  constructor(element: HTMLElement) {
    super(element);

    this.body = document.querySelector("body");
    this.header = this.element;
    this.desktopMenuToggle = this.header.querySelector(".desktop-menu-toggle") as HTMLElement;
    this.mobileMenuToggles = this.header.querySelectorAll(".mobile-menu-toggle") as NodeList;
    this.minBaseScroll = 0;
    this.minScroll = 50;
    this.lastScroll = 0;

    this.mobileMenuToggles.forEach((element) => {
      element.addEventListener("click", ()=>{
        element.classList.toggle('active');
        const desktopMenu = this.header.querySelector('.desktop-menu') as HTMLElement;
        desktopMenu.classList.toggle('d-none');

        if(window.dataLayer) {
          window.dataLayer.push({
            'event': 'INTERACTION_EVENT',
            'ixn_action': desktopMenu.classList.contains('d-none') ? 'minimise' : 'expand'
          })
        }
      });
    });


    if (Header.sticky) {
      window.addEventListener('scroll', throttle(()=>{
        const scrollTopNew = window.pageYOffset;
        if (scrollTopNew > this.minBaseScroll + this.minScroll) {
          this.header.classList.add("compact");
          this.body.classList.add("compact-header");

        } else {
          this.header.classList.remove("compact");
          this.body.classList.remove("compact-header");
        }

        if (scrollTopNew > 500 && scrollTopNew > this.lastScroll ){
          this.body.classList.add("show-cta");
        } else {
          this.body.classList.remove("show-cta");
        }

        this.lastScroll = scrollTopNew;


      }, 20));

      this.addToggleListeners()

    }

  }

  private toggleDesktopMenu(){
    const navWrapper = this.header.querySelector(".navbar-wrapper") as HTMLElement;
    const desktopMenu = this.header.querySelector('.desktop-menu') as HTMLElement;

    const desktopToggleExpanded : Boolean = this.desktopMenuToggle.getAttribute('aria-expanded') == "true";
    const navWrapperExpanded : Boolean = navWrapper.getAttribute('aria-hidden') === 'true';
    this.desktopMenuToggle.setAttribute('aria-expanded', !desktopToggleExpanded);
    navWrapper.setAttribute('aria-hidden', !navWrapperExpanded);
    this.body.classList.toggle('nav-open')
    clearTimeout(this.timeout);

    if(window.dataLayer) {
      window.dataLayer.push({
        'event': 'INTERACTION_EVENT',
        'ixn_action': !navWrapperExpanded ? 'minimise' : 'expand'
      })
    }


    this.timeout = setTimeout(()=>{
      desktopMenu.classList.toggle('d-none', !navWrapperExpanded);
    }, navWrapperExpanded ? 0 : 300);
  }

  private addToggleListeners() {
    const navbarOverlay = this.header.querySelector(".navbar-overlay") as HTMLElement;
    this.desktopMenuToggle.addEventListener('click',()=>{
      this.toggleDesktopMenu();
    });
    navbarOverlay.addEventListener('click',()=>{
      this.toggleDesktopMenu();
    })
  }

}
