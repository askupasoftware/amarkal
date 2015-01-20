# Contributing to Amarkal
### Creating a new widget UI component

- Create a new directory under `Widget/UI/`. The name of the new directory will be used as the component's class name. for example, the directory `Widget/UI/ComponentName/` represents the UI component `ComponentName`. The new component can be instantiated in PHP with the code `new \Amarkal\Extensions\WordPress\Widget\UI\ComponentName()`.
- Each component directory contains the files required for the component:
 - `controller.php` is the php class of the component. The class should have the same name as the directory name (`ComponentName`).
 - `template.php` is the component's template file.
 - `style.scss` is the component's sass file. This file is compiled into `Assets/css/widget.min.css`. 
 - `script.js` is the component's script file. This file is compiled into `Assets/js/widget.min.js`. 
- At the very least, the directory should have the `controller.php` and `template.php` files. Otherwise, an error will occur.
- The script should be wrapped inside a function that is binded to the 'widget_init' event. This will ensure that the script is called by the widget's admin panel after it is saved/dragged/refreshed.
- Take a look at the existing UI components under `Widget/UI` to learn how they should be created.

### Creating a new options page UI component
- To be written.
