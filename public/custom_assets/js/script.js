Noty.overrideDefaults({
    theme: 'limitless',
    layout: 'topRight',
    type: 'alert',
    timeout: 2500
});

Livewire.on('show-message', function(event) {
    new Noty({
        text: event.message,
        type: event.type,
    }).show();
})

function numberSeparator(input) {
    let inputValue = input.value

    let striped = Number(inputValue.replace(/\D/g,''))

    input.value = striped.toLocaleString('en-US')
}