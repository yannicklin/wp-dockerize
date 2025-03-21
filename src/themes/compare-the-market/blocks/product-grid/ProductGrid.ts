import {Component} from "@/component";

export default class ProductGrid extends Component {

  private el: HTMLElement;

  constructor(element: HTMLElement) {
    super(element);

    this.el = element;

    this.calculateHeights(element);
    window.addEventListener('resize', () => this.calculateHeights(element));

    const button =  this.el.querySelector('button') as HTMLElement;
    button.addEventListener('click', () => this.toggleSecondaryVerticals(button));


  }

  private toggleSecondaryVerticals(button: HTMLElement): void {
    const secondaryVerticals =  this.el.querySelector('.product-grid-overflow-container');
    const isCollapsed = secondaryVerticals?.classList.contains('collapsed');

    if (secondaryVerticals) {
      secondaryVerticals.classList.toggle('collapsed', !isCollapsed);
      button.classList.toggle('collapsed', !isCollapsed);
      button.querySelector('span').innerText = isCollapsed ? 'Compare less' : 'Compare more';
      button.ariaExpanded = isCollapsed ? 'true' : 'false';
    }
  }


  private calculateHeights(element: HTMLElement): void {
    const secondaryVerticals =  this.el.querySelector('.product-grid-overflow-container');
      const height = secondaryVerticals.scrollHeight;
    secondaryVerticals.style.maxHeight = height + 'px';
      const button = this.el.querySelector('button');
      //button.classList.toggle('d-none', this.shouldRemoveExpander(height));

  }
}
