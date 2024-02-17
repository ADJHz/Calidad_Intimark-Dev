window._ = require('lodash');

try {
    require('bootstrap');
} catch (e) {}

window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Importa los scripts de Select2
window.$ = window.jQuery = require('jquery');
import 'select2';

// Resto del código

// Echo exposes an expressive API for subscribing to channels and listening
// for events that are broadcast by Laravel. Echo and event broadcasting
// allows your team to easily build robust real-time web applications.
// Comenta o elimina las siguientes líneas si no estás utilizando Echo

// import Echo from 'laravel-echo';
// window.Pusher = require('pusher-js');
// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });