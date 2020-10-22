(function () {
    let clipboard = new ClipboardJS('.js-autocopy');

    clipboard.on('success', function(e) {
        $(e.trigger).tooltip('show');

        setTimeout(function () {
            $(e.trigger).tooltip('dispose');
        }, 1000);
    });
})();