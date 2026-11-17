(() => {
    const results = document.querySelector('.tax-cartoes-itens');
    const bar = document.querySelector('[data-monify-catalog-compare]');
    if (!results || !bar) return;

    const filters = document.querySelector('.shop__filters-left');
    const disclosure = filters.querySelector('.monify-catalog-filters');
    const narrow = window.matchMedia('(max-width: 880px)');
    const syncDisclosure = () => { disclosure.open = !narrow.matches; };
    syncDisclosure();
    narrow.addEventListener('change', syncDisclosure);

    const form = bar.querySelector('form');
    const summary = bar.querySelector('[data-monify-selected]');
    const submit = form.querySelector('[type="submit"]');
    const selected = new Map();
    const cardSelector = '.item-label[data-slug] input[name="comparar"]';
    let pending;
    let searchTimer;

    function syncSelection() {
        const [first = '', second = ''] = selected.keys();
        bar.hidden = selected.size === 0;
        document.body.classList.toggle('monify-compare-active', selected.size > 0);
        summary.textContent = [...selected.values()].join(' × ');
        form.elements.primeiro.value = first;
        form.elements.segundo.value = second;
        submit.disabled = selected.size !== 2;
        results.querySelectorAll(cardSelector).forEach((input) => {
            input.checked = selected.has(input.closest('[data-slug]').dataset.slug);
            input.disabled = selected.size === 2 && !input.checked;
        });
    }

    results.addEventListener('change', (event) => {
        const input = event.target;
        if (!input.matches(cardSelector)) return;
        const { slug, name } = input.closest('[data-slug]').dataset;
        if (!input.checked) selected.delete(slug);
        if (input.checked && selected.size < 2) selected.set(slug, name);
        syncSelection();
    });

    bar.querySelector('[data-monify-clear]').addEventListener('click', () => {
        selected.clear();
        syncSelection();
        const firstCard = results.querySelector(cardSelector);
        if (firstCard) firstCard.focus();
    });

    form.addEventListener('submit', (event) => {
        if (selected.size !== 2) event.preventDefault();
    });

    async function load(url) {
        pending?.abort();
        const request = new AbortController();
        pending = request;
        const overlay = document.querySelector('.overlay');
        results.setAttribute('aria-busy', 'true');
        if (overlay) overlay.style.display = 'flex';
        try {
            const response = await fetch(url, { signal: request.signal });
            if (!response.ok) throw new Error('Falha ao carregar os cartões.');
            const documentFromServer = new DOMParser().parseFromString(await response.text(), 'text/html');
            const updated = documentFromServer.querySelector('.tax-cartoes-itens');
            if (!updated) throw new Error('Lista de cartões indisponível.');
            if (request.signal.aborted) return;
            results.replaceChildren(...updated.childNodes);
            history.replaceState(history.state, '', url);
            syncSelection();
        } catch (error) {
            if (!request.signal.aborted) window.location.assign(url);
        } finally {
            if (pending === request) {
                results.removeAttribute('aria-busy');
                if (overlay) overlay.style.display = 'none';
            }
        }
    }

    function filter() {
        clearTimeout(searchTimer);
        const url = new URL(window.location.href);
        const search = filters.querySelector('.sf-input-text').value.trim();
        if (search) url.searchParams.set('search', search);
        else url.searchParams.delete('search');
        url.searchParams.delete('pagina');
        for (const taxonomy of ['stcode_bandeiras', 'stcode_categoria', 'stcode_beneficios']) {
            const values = [...filters.querySelectorAll(`input[name="${taxonomy}"]:checked`)].map((input) => input.value);
            if (values.length) url.searchParams.set(taxonomy, values.join(','));
            else url.searchParams.delete(taxonomy);
        }
        const low = filters.querySelector('.fromInput');
        const high = filters.querySelector('.toInput');
        if (low && high) {
            const min = Math.min(Number(low.value), Number(high.value));
            const max = Math.max(Number(low.value), Number(high.value));
            low.value = min;
            high.value = max;
            filters.querySelector('.fromSlider').value = min;
            filters.querySelector('.toSlider').value = max;
            if (min) url.searchParams.set('min_price', min);
            else url.searchParams.delete('min_price');
            if (max !== Number(high.max || 100000)) url.searchParams.set('max_price', max);
            else url.searchParams.delete('max_price');
        }
        load(url);
    }

    filters.querySelector('.sf-input-text').addEventListener('input', () => {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(filter, 250);
    });
    filters.addEventListener('change', (event) => {
        const input = event.target;
        if (input.matches('.fromSlider, .toSlider')) {
            filters.querySelector(input.matches('.fromSlider') ? '.fromInput' : '.toInput').value = input.value;
        }
        if (input.matches('.filter__rule-input, .fromInput, .toInput, .fromSlider, .toSlider')) filter();
    });
    filters.querySelector('.search-filter-reset').addEventListener('click', () => {
        clearTimeout(searchTimer);
        filters.querySelector('.sf-input-text').value = '';
        filters.querySelectorAll('.filter__rule-input').forEach((input) => { input.checked = false; });
        filters.querySelectorAll('.fromInput, .fromSlider').forEach((input) => { input.value = input.min || '0'; });
        filters.querySelectorAll('.toInput, .toSlider').forEach((input) => { input.value = input.max || '100000'; });
        load(new URL(window.location.pathname, window.location.origin));
    });

    results.addEventListener('click', (event) => {
        const page = event.target.closest('.monify-catalog-pages a');
        if (!page || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) return;
        event.preventDefault();
        load(new URL(page.href));
    });

    syncSelection();
})();
