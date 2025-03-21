import {Component} from "@/component";
import { Swiper} from "swiper";
import {Navigation, Pagination, EffectFade, Thumbs, Autoplay} from "swiper/modules"

export default class VideoReel extends Component {

  private sliderContainer: HTMLElement;

  private slides: number;

  constructor(element: HTMLElement) {
    super(element);

    this.element = element;

    this.sliderContainer = element.querySelector('.swiper-container') as HTMLElement;

    this.initSlider();

    this.bindModalListeners();

    this.modalReel();
  }

  private checkWistiaJSLoaded() {
    let url = "//fast.wistia.com/assets/external/E-v1.js";
    let scripts = document.getElementsByTagName('script');
    for (let i = scripts.length; i--;) {
      if (scripts[i].src == url) return true;
    }
    return false;
  }

  private bindModalListeners()
  {
    this.element.querySelectorAll('.video-reel-play-button').forEach(element => {
      element.addEventListener('click', () => {

        if (!this.checkWistiaJSLoaded()) {
              let WStag = document.createElement('script');
              WStag.type = 'text/javascript';
              WStag.id = 'wistia-E-v1';
              WStag.src = '//fast.wistia.com/assets/external/E-v1.js';
              WStag.async = true;
              document.head.appendChild(WStag);

              // Setup default
              window._wq = window._wq || [];
              _wq.push( {
                  id: '_all',
                  options: {
                      doNotTrack: false,
                      playbackRateControl: false,
                      seo: false,
                      settingsControl: true,
                      videoFoam: true,
                      wmode: 'transparent'
                  }
              } );
            }
        this.openModal(element);
      })
    })
  }

  private openModal(element: Element)
  {
    document.getElementById(
      element.dataset.modalTarget
    )?.dispatchEvent(new CustomEvent('open'));

    this.element.dispatchEvent(new CustomEvent('slideTo', {
      detail: {
        index: element.dataset.modalIndex
      }
    }))
  }

  private initSlider()
  {
    Swiper.use([Pagination, Navigation, Thumbs]);

    const slidePagination = this.sliderContainer.querySelector(
      ".swiper-pagination"
    ) as HTMLElement;

    this.slides = this.sliderContainer.querySelectorAll('.swiper-slide').length;

    if(this.slides <= 1) {
      return;
    }

    const swiper = new Swiper(this.sliderContainer, {
      modules: [Pagination, EffectFade, Autoplay],
      effect: 'fade',
      crossFade: true,
      slidesPerView: 1,
      loop: this.slides > 1,
      autoplay: {
        delay: parseInt(this.element.dataset.sliderTiming),
      }
    })

    window.slider = swiper;

    window.slider.on('slideChangeTransitionStart', () => {
      if(window.dataLayer) {
        window.dataLayer.push({
          'event': 'INTERACTION_EVENT',
          'ixn_action': 'slide'
        })
      }
    })

    this.element.querySelectorAll('.swiper-internal-pagination button').forEach((element, index) => {
      element.addEventListener('click', () => {
        swiper.slideTo(element.dataset.reelTarget);
      })
    });

    this.element.querySelectorAll('button.swiper-internal-navigation-prev').forEach((element, index) => {
      element.addEventListener('click', () => {
        swiper.slidePrev();
      })
    })

    this.element.querySelectorAll('button.swiper-internal-navigation-next').forEach((element, index) => {
      element.addEventListener('click', () => {
        swiper.slideNext();

      })
    })
  }

  private modalReel()
  {
    if(this.slides <= 1) {
      return;
    }

    let video = document.querySelector(".modal-reel") as HTMLElement;
    let modalThumbnails = document.querySelector('.modal-thumbnails') as HTMLElement;

    const swiper = new Swiper(modalThumbnails, {
      slidesPerView: 10,
      spaceBetween: 10,
      breakpoints: {
        200: {
          slidesPerView: 3,
        },
        480: {
          slidesPerView: 4,
        },
        640: {
          slidesPerView: 5,
        },
        768: {
          slidesPerView: 6,
        },
        1024: {
          slidesPerView: 8,
        },
        1366: {
          slidesPerView: 10,
        }
      },
      freeMode: true,
      watchSlidesProgress: true,
    });

    const videoSwiper = new Swiper(video, {
      slidesPerView: 1,
      allowTouchMove: false,
      loop: this.slides > 1,
      thumbs: {
        swiper: swiper,
      },
      navigation: {
        nextEl: this.element.querySelector(this.element.dataset.modalId + ' .swiper-button-next'),
        prevEl: this.element.querySelector(this.element.dataset.modalId + ' .swiper-button-prev'),
      },
    });

    videoSwiper.on('slideChangeTransitionStart', () => {
      if(window.dataLayer) {
        window.dataLayer.push({
          'event': 'INTERACTION_EVENT',
          'ixn_action': 'slide'
        })
      }
    })

    this.element.addEventListener('slideTo', (event: CustomEvent) => {
      videoSwiper.slideTo(event.detail.index);
    });
  }
}
