import Echo from 'laravel-echo';

window.Echo.channel('all')
    .listen('HadithAdded', (e) => {
        console.log(e.order.name);
        alert(e.message);
    });
