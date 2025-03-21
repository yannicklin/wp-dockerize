import ReadMore from "./global-components/readMore";

export default class GlobalComponents {

  constructor() {
   this.loadReadMore();
  }


  loadReadMore() {
    const readMore = document.querySelectorAll('.read-more-link');
    readMore.forEach((el) => {
      let element = el as HTMLElement;
      new ReadMore(element);
    });
  }
}

