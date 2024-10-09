import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */


// app.js
import './styles/app.css';
// rajouter
// jquery
const $ = require ('jquery');
window.jQuery = $;
window.$ = $;

// Importer la partie js de Bootstrap
import 'bootstrap';

// Importer la partie css de Bootstrap
import 'bootstrap/dist/css/bootstrap.min.css';