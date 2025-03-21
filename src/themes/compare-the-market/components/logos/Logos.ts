import {Component} from "@/component";

export default class Logos extends Component {

  private element: HTMLElement;

  constructor(element: HTMLElement) {
    super(element);

    this.element = element;

    if (element.dataset.randomize === "1") {
      this.randomize();
    } else {
      this.element.dataset.loaded = String(true);
    }

    this.element.querySelectorAll('.show-all-mobile').forEach((element) => {


      element.addEventListener('click', (e) => {

        e.preventDefault();
        let expanded = this.element.ariaExpanded === 'true';

        if(expanded) {
          this.element.ariaExpanded = 'false';

          this.element.querySelectorAll('.logo-container').forEach((logo, index) => {
            if(index > 8) {
              logo.classList.add('d-none')
            }
          })
          this.element.ariaExpanded = 'false';

          element.querySelector('span').innerText = this.element.dataset.viewAll;


          if(window.dataLayer) {
            window.dataLayer.push({
              'event': 'INTERACTION_EVENT',
              'ixn_action': 'minimise'
            })
          }

        } else {
          this.element.ariaExpanded = 'true';

          this.element.querySelectorAll('.logo-container').forEach((logo) => {
            logo.classList.remove('d-none')
          })

          element.querySelector('span').innerText = this.element.dataset.viewLess;

          if(window.dataLayer) {
            window.dataLayer.push({
              'event': 'INTERACTION_EVENT',
              'ixn_action': 'expand'
            })
          }
        }
      })
    })
  }

  private randomize() {
    // randomize the order of logos within .logo-container
    const logoContainers = Array.from(this.element.querySelectorAll(".logo-container"));

    if (logoContainers.length === 0) {
      return;
    }

    this.shuffle(logoContainers);

    const parent = logoContainers[0].parentElement;

    if (parent === null) {
      return;
    }

    parent.innerHTML = logoContainers.map((element) => element.outerHTML).join('');

    this.element.dataset.loaded = String(true);
  }

  // randomize array
  private shuffle(array: Element[]) {
    for (let currentIndex = array.length - 1; currentIndex > 0; currentIndex--) {
      const randomIndex = Math.floor(Math.random() * (currentIndex + 1));
      [array[currentIndex], array[randomIndex]] = [array[randomIndex], array[currentIndex]];
    }
  }
}
