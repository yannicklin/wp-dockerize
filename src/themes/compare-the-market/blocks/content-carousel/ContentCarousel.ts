import {Component} from "@/component";
import { Swiper} from "swiper";
import {Navigation, Pagination} from "swiper/modules"

export default class ContentCarousel extends Component {

  private sliderContainer: HTMLElement;

  public element: HTMLElement;

  constructor(element: HTMLElement) {
    super(element);

    this.element = element;

    this.sliderContainer = element.querySelector('.swiper-container') as HTMLElement;

    this.initSlider();
  }

  private initSlider()
  {
    Swiper.use([Pagination, Navigation]);

    const slidePagination = this.element.querySelector(
      ".swiper-pagination"
    ) as HTMLElement;

    const nextButton = this.element.querySelector(
      ".swiper-button-next"
    ) as HTMLElement;

    const prevButton = this.element.querySelector(
      ".swiper-button-prev"
    ) as HTMLElement;

    const swiper = new Swiper(this.sliderContainer, {
      modules: [Pagination],
      slidesPerView: this.sliderContainer.dataset.slides,
      slidesPerGroup: this.sliderContainer.dataset.slides,
      spaceBetween: 40,
      pagination: {
        el: slidePagination,
        type: "bullets",
        clickable: true,
      },
      navigation: {
        nextEl: nextButton,
        prevEl: prevButton,
      },
      breakpoints: {
        0: {
          slidesPerView: 1,
          slidesPerGroup: 1,
        },
        1200: {
          slidesPerView: this.sliderContainer.dataset.slides,
          slidesPerGroup: this.sliderContainer.dataset.slides,
        },
      }
    });
  }
}
