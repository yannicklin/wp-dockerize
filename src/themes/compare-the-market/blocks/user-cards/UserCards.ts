import { Component } from "@/component";
import throttle from 'lodash.throttle';

export default class UserCards extends Component {
  private cardRows: NodeListOf<HTMLElement>; 

  constructor(element: HTMLElement) {
    super(element);
    this.cardRows = element.querySelectorAll('.user-cards-row');
    this.initResizeCards();
    window.addEventListener('resize', throttle(this.initResizeCards.bind(this), 200));
  }

  initResizeCards() {
    this.cardRows.forEach(userCardRow => {
      const userCards = userCardRow.querySelectorAll<HTMLElement>('.user-card');
      const tallestElementHeight = Array.from(userCards).reduce((maxHeight, element) => {
        return Math.max(maxHeight, element.clientHeight);
      }, 0);

      userCards.forEach(element => {
        element.style.setProperty('--min-height', `${tallestElementHeight}px`);
      });
    });
  }
}
