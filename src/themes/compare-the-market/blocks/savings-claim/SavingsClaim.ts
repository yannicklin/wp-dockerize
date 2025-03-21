import { Component } from "@/component";
import { Swiper } from "swiper";
import throttle from "lodash.throttle";

export default class SavingsClaim extends Component {
  private slide: Swiper;
  private slideActive: boolean;
  private slideContainer: HTMLElement;
  private cardsContainer: HTMLElement;

  constructor(element: HTMLElement) {
    super(element);

    this.slideActive = false;
    this.slideContainer = element.querySelector(".swiper") as HTMLElement;
    this.cardsContainer = element.querySelector(".claims-container") as HTMLElement;
    this.initObservation();
    this.initSlider();

    window.addEventListener(
      "resize",
      throttle(() => this.initSlider(), 200)
    );
  }

  private handleNumberJumping(elem: Element) {
    const savingAmountDOM = elem.querySelector(".saving-amount") as HTMLElement;
    const startValue = parseInt(savingAmountDOM.getAttribute("start")) || 0;
    const endValue = parseInt(savingAmountDOM.getAttribute("end")) || 10;
    const duration = parseInt(savingAmountDOM.getAttribute("duration")) || 10;
    const animated = "true" === savingAmountDOM.getAttribute("animated");

    const animateValue = (targetElem, start, end, duration) => {
      let startTimestamp = null;
      const step = (timestamp) => {
        if (!startTimestamp) startTimestamp = timestamp;
        const progress = Math.min((timestamp - startTimestamp) / duration, 1);
        targetElem.innerText = Math.floor(progress * (end - start) + start);
        if (progress < 1) {
          window.requestAnimationFrame(step);
        }
      };
      window.requestAnimationFrame(step);
    };

    if (!animated) {
      animateValue(savingAmountDOM, startValue, endValue, duration);
    }

    savingAmountDOM.setAttribute("animated", "true");
  }

  private initObservation() {
    let options = {
      root: null, // use the viewport as the root
      rootMargin: "0px",
      threshold: 0.5,
    };
    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.querySelectorAll(".claim")?.forEach((claim) => {
            this.handleNumberJumping(claim);
          });
        }
      });
    }, options);

    const claimCardsCount = this.cardsContainer.querySelectorAll('.claim .saving-amount').length;
    const animatedCount = this.cardsContainer.querySelectorAll('.claim .saving-amount[data-animated]').length;

    if (claimCardsCount > animatedCount) {
      observer.observe(this.cardsContainer);
    }
  }


  private initSlider() {
    if (window.innerWidth < 1200 && !this.slideActive) {
      this.slideActive = true;
      this.slide = new Swiper(this.slideContainer, {
        slidesPerView: 1.2,
        //spaceBetween: 30,
      });

      this.slide.on("slideChangeTransitionStart", () => {
        if (window.dataLayer) {
          window.dataLayer.push({
            event: "INTERACTION_EVENT",
            ixn_action: "slide",
          });
        }
      });
    } else if (
      window.innerWidth >= 1201 &&
      this.slideActive &&
      this.slide != null
    ) {
      this.slideActive = false;
      this.slide.destroy();
      this.slideActive = false;
    }

    this.cardsContainer.style.cssText = `--claim-card-min-height:0px`; //reset
    let tallestElement: HTMLElement | null = null;
    this.cardsContainer.querySelectorAll(".claim")?.forEach((element) => {
      if (
        !tallestElement ||
        element.clientHeight > tallestElement.clientHeight
      ) {
        tallestElement = element;
      }
    });
    if (tallestElement) {
      // without clamping to the nearest 2px a chrome bug triggers that adds white space to the bottom of the containing div
      const largestCardHeight = 2 * Math.round(tallestElement.clientHeight / 2);

      this.cardsContainer.style.cssText = `--claim-card-min-height:${largestCardHeight}px`;
    }
  }
}
