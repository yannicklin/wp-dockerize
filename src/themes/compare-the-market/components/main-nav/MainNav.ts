import {Component} from "@/component";
import Dropdown from 'bootstrap.native/src/components/dropdown-native';
import Offcanvas from 'bootstrap.native/src/components/offcanvas-native';

export default class MainNav extends Component {

  constructor(element: HTMLElement) {
    super(element);

    // Parent Toggle
    const dropdownElements = element.querySelectorAll('.desktop-menu .dropdown-toggle'); // e.g. Insurance
    const mobileDropdowns = element.querySelectorAll('.mobile-menu .dropdown-toggle');
    const subMenuDropdowns = element.querySelectorAll('.desktop-menu .menu-item-has-children .dropdown-item'); // E.g. Car Insurance
    const mobileSubMenuDropdowns = element.querySelectorAll('.mobile-menu .menu-item-has-children .dropdown');

    let currentTarget:any;

    // Instantiate mobile menu as bootstrap Offcanvas
    const offcanvas = new Offcanvas(
      '.desktop-menu',
      {
        scroll: false
      }
    );
    offcanvas.hide();


    // Instantiate mobile dropdowns
    dropdownElements.forEach( x => {
      const drop = new Dropdown(x);
      x.addEventListener( "click", (e:Event) => {
        if (!x.parentElement?.classList.contains('show')) {
          this.hideMenu(x);
        }
      })
    })

    mobileSubMenuDropdowns.forEach( x => {
      x.addEventListener( "click", (e:Event) => {
        x.querySelector('.dropdown-menu')?.parentElement?.classList.toggle('show');
        x.querySelector('.dropdown-menu')?.classList.toggle('show');
        e.stopPropagation();
      })
    })

    // Handle nested dropdown keyboard interactions
    subMenuDropdowns.forEach( x => {

      x.addEventListener( "focus", (e:Event) => {
        this.hideMenu(x);
      })

      // Attach an event listener for keyboardRight
      x.addEventListener( "keydown", (e:Event)=> {
        const keyboardEvent = <KeyboardEvent> e;
        currentTarget = e.target as Element;

        // Open child menu with right arrow
        if (keyboardEvent.key === 'ArrowRight') {
          let menu = currentTarget?.nextElementSibling!;
          // Find the elements sibling and if it exists add bootstrap show class, aria label and set focus
          menu.classList.add("show");
          menu.ariaExpanded="true";
          menu.querySelector('li').focus();
        }

        // Close child menu with left arrow
        if (keyboardEvent.key === 'ArrowLeft') {
          let menu = currentTarget.parentNode.parentNode
          this.hideMenu(menu)
          menu.parentNode?.querySelector('a').focus();
        }
      })
    })
  }

  // Get the elements container and hide all children
  hideMenu(x:Element) {
    const children = x.parentNode?.parentNode?.querySelectorAll('.show');
    if (children !== undefined && children?.length > 0) {
      children?.forEach( el => {
        el.classList.remove("show")
        el.ariaExpanded="false";
      })
    }
  }
}
