export default class Framework {

  public constructor() {
    // autoload blocks and components
    this.autoload('components', 'component');
    this.autoload('blocks', 'block');
  }

  private async autoload(folder: string = 'components', type: string = 'component') {
    // search the entire DOM for elements with data-autoload-component or data-autoload-block on them
    const modules = document.querySelectorAll(`[data-autoload-${type}]`);

    modules.forEach(moduleDOM => {

      // for each DOM element found, setup some variables to load the file
      const moduleName = moduleDOM.getAttribute(`data-autoload-${type}`);

      if(!moduleName) {
        return;
      }

      const deepFolder = this.kebabCase(moduleName);

      const name = `../../${folder}/${deepFolder}/${moduleName}.ts`;

      const modules = import.meta.glob([
        './../../components/**/**/*.ts',
        './../../blocks/**/**/*.ts'
      ])

      const match = modules[name];



      if(!match) {
        console.warn("Couldn't find module to autoload", moduleDOM);
        return;
      }

      match()
        .then(m => {
          new m.default(moduleDOM);
        })
        .catch(error => {
          console.error(error);
        });
    });
  }

  private kebabCase(string: string) {
    return string
      .replace(/([a-z])([A-Z])/g, "$1-$2")
      .replace(/[\s_]+/g, '-')
      .toLowerCase();
  }
}
