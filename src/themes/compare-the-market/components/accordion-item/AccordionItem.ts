import {Component} from "@/component";
import Collapse from 'bootstrap.native/src/components/collapse-native';

export default class AccordionItem extends Component {

  constructor(element: HTMLElement) {
    super(element);

    const collapseElement = element.querySelector('.collapse')
    const accordionItem = new Collapse(collapseElement)

  }
}
