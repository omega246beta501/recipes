customElements.define('card-component',
  class extends HTMLElement {
    constructor() {
      super();
      let template = document.getElementById('card-component');
      let templateContent = template.content;

      const shadowRoot = this.attachShadow({mode: 'open'})
        .appendChild(templateContent.cloneNode(true));
  }
})