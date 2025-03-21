/**
 *  Base component class for all Block scripts
 *
 *  import this base class into your custom script and extend / inherit it to create a new block component.
 *
 *  All components must be 'installed' into the Burger framework for it to be active.
 *
 *  @see IComponent
 *  @see Framework
 */
export class Component  {

  public element: HTMLElement;

  /**
   * @param componentElement
   * The HTML element attached to the component; in most cases this will be the block's <section> element.
   */
  constructor(componentElement: HTMLElement) {
    this.element = componentElement;

    if(this.element.dataset.component) {
      throw new Error("Component is already attached to a HTML Element")
    }
    this.element.dataset.componentLoaded = "true"
  }
}
