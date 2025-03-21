import {Component} from "@/component";

export default class HybridAccordion extends Component {

  constructor(element: HTMLElement) {
    super(element);

    this.calculateHeights(element);
    window.addEventListener('resize', () => this.calculateHeights(element));
  }


  private calculateHeights(element: HTMLElement): void {
    element.querySelectorAll('.component-ctm-accordion').forEach((accordionContent) => {
      const innerContent = accordionContent.querySelector('.ctm-accordion-content') as Element;

      // unset the overflow behavior to get a true height
      innerContent.style.overflow = 'unset';
      const height = accordionContent.scrollHeight;

      // set the max height and the correct overflow behavior
      innerContent.style.maxHeight = height + 'px';
      innerContent.style.overflow = 'hidden';

      const button = document.getElementById(accordionContent.dataset.toggle);
      button.classList.toggle('d-none', this.shouldRemoveExpander(innerContent.scrollHeight));
    });
  }

  // if the screen is mobile, we want to remove the expander if the height
  // is less than 256px otherwise we want to remove it if the height is less than 360px
  private shouldRemoveExpander(height: number)
  {
    const desktopMaxHeight = 256 + 32;
    const mobileMaxHeight = 360 + 32;

    if(window.innerWidth > 568) {
      return height < desktopMaxHeight
    }
    return height < mobileMaxHeight;
  }
}
