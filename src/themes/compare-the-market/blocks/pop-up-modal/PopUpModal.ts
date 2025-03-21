import { Component } from "@/component";

export default class PopUpModal extends Component {
  private choice: string;
  private cookiesEnabled: boolean;
  private modalId: string;
  private modal: HTMLElement | null;
  private pageTitle: string;
  private originalTitle: string;
  private selectedFavicon: string;
  private originalFavicon: string;
  private popupId: string;
  private emojiFavicon: string;
  private slideTitleInterval: number;
  private faviconInterval: number;

  constructor(element: HTMLElement) {
    super(element);

    this.choice = element.dataset.popupmodalChoice ?? "";
    this.cookiesEnabled = element.dataset.popupmodalCookies === "1";
    this.modalId = element.dataset.popupmodalModalId ?? "";
    this.pageTitle = element.dataset.popupmodalPageTitle ?? "";
    this.selectedFavicon = element.dataset.popupmodalSelectedFavicon ?? "";
    this.popupId = element.dataset.popupmodalPopupClass ?? "";
    this.emojiFavicon = element.dataset.popupmodalEmojiFavicon ?? "";

    this.initPopupModalMonitor();
  }

  private getCookie = (name: string) => {
    const match = document.cookie
      .split("; ")
      .find((row) => row.startsWith(name));
    return match ? match.split("=")[1] : null;
  };

  private setCookie = (name: string, value: string, days: number) => {
    const date = new Date();
    date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
    document.cookie = `${name}=${value};expires=${date.toUTCString()};path=/`;
  };

  private setTemporaryCookie = (
    name: string,
    value: string,
    minutes: number
  ) => {
    const date = new Date();
    date.setTime(date.getTime() + minutes * 60 * 1000);
    document.cookie = `${name}=${value};expires=${date.toUTCString()};path=/`;
  };

  private changeFavicon = (url: string) => {
    document
      .querySelectorAll("link[rel='icon']")
      .forEach((link) => link.remove());
    const newLink = document.createElement("link");
    newLink.type = "image/x-icon";
    newLink.rel = "icon";
    newLink.href = url;
    document.head.appendChild(newLink);
  };

  private slideTitle = (newTitle: string) => {
    clearInterval(this.slideTitleInterval);
    const titleChars = Array.from(decodeURIComponent(newTitle));
    let currentIndex = 0;
    this.slideTitleInterval = setInterval(() => {
      currentIndex = (currentIndex + 1) % titleChars.length;
      document.title = titleChars
        .slice(currentIndex)
        .concat(titleChars.slice(0, currentIndex))
        .join("");
    }, 300);
  };

  private stopSlidingTitle = () => {
    clearInterval(this.slideTitleInterval);
    document.title = this.originalTitle;
  };

  private rotateFavicon = (emojis: string) => {
    clearInterval(this.faviconInterval);
    if (emojis) {
      const emojiArray = Array.from(emojis);
      let currentEmojiIndex = 0;
      this.faviconInterval = setInterval(() => {
        this.changeFavicon(
          `data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 32 32%22><text y=%2224%22 font-size=%2232%22>${emojiArray[currentEmojiIndex]}</text></svg>`
        );
        currentEmojiIndex = (currentEmojiIndex + 1) % emojiArray.length;
      }, 1000);
    } else {
      this.changeFavicon(this.selectedFavicon);
    }
  };

  private stopRotateFavicon = () => {
    clearInterval(this.faviconInterval);
    this.changeFavicon(this.originalFavicon);
  };

  private openModal = () => {
    this.modal?.classList.add("show");
    this.modal?.classList.remove("d-none");
    document.body.classList.add("modal-open");
  };

  private closeModal = () => {
    this.modal?.classList.remove("show");
    this.modal?.classList.add("d-none");
    document.body.classList.remove("modal-open");
    history.pushState(
      "",
      document.title,
      window.location.pathname + window.location.search
    );
  };

  private handleExitIntent = () => {
    if (
      this.cookiesEnabled &&
      (this.getCookie("popupShown") === "true" ||
        this.getCookie("sessionPopupShown") === "true")
    )
      return;
    document.addEventListener("mouseout", (event) => {
      if (!event.relatedTarget && event.clientY <= 0) {
        if (this.getCookie("sessionPopupShown") !== "true") {
          this.openModal();
          this.setTemporaryCookie("sessionPopupShown", "true", 2);
        }
      }
    });
  };

  private handleElementClick = () => {
    const element = document.getElementById(this.popupId);
    if (element)
      element.addEventListener("click", (event) => {
        event.stopPropagation();
        this.openModal();
      });
    if (window.location.hash === `#${this.popupId}`) this.openModal();
    window.addEventListener("hashchange", () => {
      if (window.location.hash === `#${this.popupId}`) this.openModal();
    });
  };

  private handleTabSwitch = () => {
    document.addEventListener("visibilitychange", () => {
      if (document.visibilityState === "hidden") {
        if (this.pageTitle) {
          this.slideTitle(this.pageTitle);
        }
        this.rotateFavicon(this.emojiFavicon);
      } else if (document.visibilityState === "visible") {
        this.openModal();
        this.stopSlidingTitle();
        this.stopRotateFavicon();
      }
    });
  };

  private initPopupModalMonitor(): void {
    this.modal = document.getElementById(this.modalId);
    this.originalTitle = document.title;
    this.originalFavicon =
      document.querySelector("link[rel='icon']")?.getAttribute("href") ?? "";

    switch (this.choice) {
      case "Exit intent":
        this.handleExitIntent();
        break;
      case "Pop up on element click":
        this.handleElementClick();
        break;
      case "Pop up on tab switch":
        this.handleTabSwitch();
        break;
    }

    if (null !== this.modal) {
      document
        .querySelectorAll(`#${this.modalId} .close-modal`)
        .forEach((button) => {
          button.addEventListener("click", (event) => {
            event.stopPropagation();
            this.closeModal();
            if (this.cookiesEnabled && this.choice === "Exit intent")
              this.setCookie("popupShown", "true", 7);
            this.setTemporaryCookie("sessionPopupShown", "true", 2);
          });
        });

      this.modal.addEventListener("click", (event) => event.stopPropagation());
      document.querySelector(".modal")?.addEventListener("click", (event) => {
        if (event.target === this.modal) {
          this.closeModal();
        }
      });
    }
  }
}
