// require('../css/global.scss');

// require('underscore');
// require('backbone');
var $ = require('jquery');
// JS is equivalent to the normal "bootstrap" package
// no need to set this to a variable, just require it
// require('tether');
require('bootstrap');

// or you can include specific pieces
// require('bootstrap-sass/javascripts/bootstrap/tooltip');
// require('bootstrap-sass/javascripts/bootstrap/popover');

// $(document).ready(function() {
//     $('[data-toggle="popover"]').popover();
// });

import '@linkorb/brace-helper'; // auto initialize ace editors

// import any modes or themes you'd like to use in your app
import 'brace/mode/javascript';
import 'brace/mode/css';
import 'brace/mode/yaml';
import 'brace/theme/monokai';
