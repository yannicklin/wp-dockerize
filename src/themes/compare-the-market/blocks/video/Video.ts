import {Component} from "@/component";

export default class Video extends Component {

  constructor(element: HTMLElement) {
    super(element);

    this.element = element;

    this.bindVideoPlayer();
  }


  private bindVideoPlayer()
  {
    this.element.querySelectorAll('.play-button-overlay').forEach(element => {
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
        let thumbnail = element.closest('.video-container').querySelector('.wistia-thumbnail');
        let wistiaVideoId = thumbnail.dataset.wistiaId;
        let videoPlayer = element.parentNode.querySelector('div.wistia_embed');

        element.classList.add('d-none');
        thumbnail.classList.add('fadeOut','d-none');
        videoPlayer.classList.remove('d-none');
        videoPlayer.classList.add('fadeIn');

        _wq.push({
          id: wistiaVideoId, onReady: function(video) {
            video.play();
          }
        });
      })
    })
  }

  private checkWistiaJSLoaded() {
    let url = "//fast.wistia.com/assets/external/E-v1.js";
    let scripts = document.getElementsByTagName('script');
    for (let i = scripts.length; i--;) {
      if (scripts[i].src == url) return true;
    }
    return false;
  }

}