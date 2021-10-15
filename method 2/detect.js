var external = 'https://burp';

if (window.fetch) {
    fetch(external, {'mode':'no-cors'})
        .then(function () {
            console.log('burp detected');
        })
        .catch(function () {
            console.log('burp not detected');
        });
} else {
    console.log('[!] Error');
}
