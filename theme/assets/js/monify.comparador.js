(() => {
    const form = document.getElementById('monify-change-pair');
    if (!form) return;

    const first = form.elements.primeiro;
    const second = form.elements.segundo;
    const button = document.querySelector('button[form="monify-change-pair"]');
    const status = document.querySelector('[data-monify-pair-status]');
    const initial = [first.value, second.value];

    function update() {
        const duplicate = first.value === second.value;
        second.setCustomValidity(duplicate ? 'Selecione dois cartões diferentes.' : '');
        const changed = first.value !== initial[0] || second.value !== initial[1];
        button.disabled = duplicate || !first.value || !second.value || !changed;
        status.textContent = duplicate
            ? 'Selecione dois cartões diferentes.'
            : changed ? 'Seleção alterada. Atualize para ver as novas condições.' : '';
    }

    first.addEventListener('change', update);
    second.addEventListener('change', update);
    update();
})();
