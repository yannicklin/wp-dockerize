import {Component} from "@/component";

export default class Modal extends Component {

  private element: HTMLElement;

  constructor(element: HTMLElement) {
    super(element);

    this.element = element;

    element.addEventListener('open', () => {
      this.open();
    });

    element.addEventListener('close', () => {
      this.close();
    });

    // When escape is pressed close any open modals
    document.addEventListener('keydown', (e) => {
      if (e.keyCode == 27) {
        this.close();
      }
    });

    const closeButton = element.querySelector('.ctm-modal-close-button') as HTMLButtonElement;

    closeButton.addEventListener('click', () => {
      this.close();
    })
  }

  private close()
  {
    this.element.classList.remove('d-block');
    document.body.classList.remove('overflow-hidden');
  }

  private open()
  {
    this.element.classList.add('d-block');
    document.body.classList.add('overflow-hidden');

    // https://github.com/gdkraus/accessible-modal-dialog/blob/master/modal-window.js#L38
    // Focus the first focusable element in the modal when it appears
    let focusableElementsString = "a[href], area[href], input:not([disabled]), select:not([disabled]), textarea:not([disabled]), button:not([disabled]), iframe, object, embed, *[tabindex], *[contenteditable]";

    this.element.querySelectorAll(focusableElementsString)[0]?.focus();
  }
}
