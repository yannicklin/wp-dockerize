import { Component } from "@/component";

export default class Posts extends Component {
  private currentPage = 1;
  private pages: number;

  constructor(element: HTMLElement) {
    super(element);
    this.pages = parseInt(element.dataset.pages || "1", 10);
    this.initPagination();
  }

  private initPagination(): void {
    this.element.querySelectorAll<HTMLAnchorElement>('.pagination a').forEach(link => {
      link.addEventListener('click', event => {
        event.preventDefault();
        this.element.scrollIntoView({ block: 'start', behavior: 'smooth' });

        if (link.classList.contains('btn-next') && this.currentPage < this.pages) {
          this.updatePage(this.currentPage + 1);
        } else if (link.classList.contains('btn-previous') && this.currentPage > 1) {
          this.updatePage(this.currentPage - 1);
        } else if (link.dataset.page) {
          const page = parseInt(link.dataset.page, 10);
          this.updatePage(page);
        }
      });
    });

    this.updatePage(this.currentPage); 
  }

  private updatePage(page: number): void {
    this.currentPage = page;
    this.element.querySelectorAll<HTMLElement>('.post-page-container').forEach(container => {
      container.classList.toggle('d-none', container.dataset.page !== page.toString());
    });

    this.element.querySelectorAll<HTMLAnchorElement>('.pagination a').forEach(link => {
      const isActivePage = link.dataset.page === page.toString();
      link.classList.toggle('btn-primary', isActivePage);
      link.classList.toggle('btn-secondary', !isActivePage);
    });
  }
}
