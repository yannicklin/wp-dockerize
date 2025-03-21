import {Component} from "@/component";

export default class CtmAccordion extends Component {

  private element: Element;

  constructor(element: HTMLElement) {
    super(element);

    this.element = element;

    element.querySelectorAll('button').forEach((button) => {
      button.addEventListener('click', () => this.toggleAccordion(button));
    });

  }

  private toggleAccordion(button: HTMLElement): void {
    const accordionContent = document.getElementById(button.dataset.toggleId);
    const isCollapsed = accordionContent?.classList.contains('collapsed');

    if(isCollapsed && window.dataLayer) {
        window.dataLayer.push({
          'event': 'INTERACTION_EVENT',
          'ixn_action': 'expand'
        })
    }

    if(!isCollapsed && window.dataLayer) {
      window.dataLayer.push({
        'event': 'INTERACTION_EVENT',
        'ixn_action': 'minimise'
      })
    }


    if (accordionContent) {
      accordionContent.classList.toggle('collapsed', !isCollapsed);
      button.classList.toggle('collapsed', !isCollapsed);
      button.querySelector('span').innerText = isCollapsed ? this.element.dataset.readLess : this.element.dataset.readMore;
      button.ariaExpanded = isCollapsed ? 'true' : 'false';

      if(!isCollapsed) {
        this.scrollIntoView()
      }
    }
  }

  private scrollIntoView()
  {
    const yOffset = -120;

    const y = this.element.getBoundingClientRect().top + window.pageYOffset + yOffset;

    window.scrollTo({top: y, behavior: 'smooth'});

  }
}
