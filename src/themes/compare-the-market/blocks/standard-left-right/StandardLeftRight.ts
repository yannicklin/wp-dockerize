import { Component } from "@/component";

export default class StandardLeftRight extends Component {
  private static isScriptLoaded: boolean = false;

  constructor(element: HTMLElement) {
    super(element);
    this.initLottieObserver();
  }

  initLottieObserver(): void {
    const options: IntersectionObserverInit = {
      root: null,
      rootMargin: "0px",
      threshold: 0.5,
    };

    const loadScript = (entries: IntersectionObserverEntry[], observer: IntersectionObserver): void => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          if (!StandardLeftRight.isScriptLoaded) {
            this.injectLottieScript();
            StandardLeftRight.isScriptLoaded = true;
          }

          observer.unobserve(entry.target);
        }
      });
    };

    const observer = new IntersectionObserver(loadScript, options);

    const targetElement = this.element.querySelector("dotlottie-player");

    if (targetElement) {
      observer.observe(targetElement);
    }
  }

  injectLottieScript(): void {
    const script = document.createElement("script");
    script.type = "module";
    script.src = "https://unpkg.com/@dotlottie/player-component@2.3.0/dist/dotlottie-player.mjs";
    script.defer = true;
    document.body.appendChild(script);
  }
}