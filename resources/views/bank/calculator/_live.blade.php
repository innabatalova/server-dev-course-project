{{-- Ползунки только меняют значения в полях. Расчёт выполняется по кнопке «Рассчитать»
     без перезагрузки страницы (считает по-прежнему сервер). Если параметры изменили
     после расчёта, результат заменяется скелетоном до нового нажатия на кнопку. --}}
<script>
(function () {
    var form = document.querySelector('[data-live-form]');
    if (!form || !window.fetch || !window.DOMParser || !window.URLSearchParams) return;

    var url = form.getAttribute('action');
    var controller = null;
    var pairs = [];

    form.querySelectorAll('input[type="range"][data-sync]').forEach(function (range) {
        var field = form.elements[range.getAttribute('data-sync')];
        if (field) pairs.push({ range: range, field: field });
        paint(range);
    });

    // Закрашиваем часть дорожки до бегунка (для Chrome/Safari; Firefox делает это сам).
    function paint(range) {
        var share = (range.value - range.min) / (range.max - range.min) * 100;
        range.style.setProperty('--fill', share + '%');
    }

    function block(name) { return document.querySelector('[data-live="' + name + '"]'); }

    function toNumber(text) {
        return parseFloat(String(text).replace(/[\s ]/g, '').replace(',', '.'));
    }

    // Приводим значение к допустимому диапазону ползунка.
    function clamp(pair) {
        var value = toNumber(pair.field.value);
        var min = Number(pair.range.min);
        var max = Number(pair.range.max);
        if (isNaN(value)) value = min;
        if (pair.range.step === '1') value = Math.round(value);
        value = Math.min(Math.max(value, min), max);
        pair.field.value = value;
        pair.range.value = value;
        paint(pair.range);
    }

    // Скелетон показываем, только если на экране есть готовый результат.
    function showSkeleton() {
        var side = block('side');
        var table = block('table');
        if (!side || !side.querySelector('.bank-result-card:not(.bank-result-empty)')) return;

        side.innerHTML =
            '<div class="bank-result-card bank-skeleton" role="status">' +
            '<span class="bank-skeleton-line" style="width:45%"></span>' +
            '<span class="bank-skeleton-line bank-skeleton-big" style="width:70%"></span>' +
            '<span class="bank-skeleton-line" style="width:100%"></span>' +
            '<span class="bank-skeleton-line" style="width:100%"></span>' +
            '<span class="bank-skeleton-line" style="width:100%"></span>' +
            '<p class="bank-skeleton-note">Параметры изменены. Нажмите «Рассчитать», чтобы обновить результат.</p>' +
            '</div>';

        if (table) {
            var rows = '';
            for (var i = 0; i < 6; i++) rows += '<span class="bank-skeleton-line bank-skeleton-row"></span>';
            table.innerHTML = '<div class="bank-skeleton-table" aria-hidden="true">' + rows + '</div>';
        }
    }

    function calculate() {
        var query = new URLSearchParams(new FormData(form)).toString();
        var target = url + '?' + query;
        var side = block('side');

        if (controller) controller.abort();
        controller = new AbortController();
        if (side) side.classList.add('is-loading');

        fetch(target, { headers: { 'X-Requested-With': 'XMLHttpRequest' }, signal: controller.signal })
            .then(function (response) { return response.text(); })
            .then(function (html) {
                var doc = new DOMParser().parseFromString(html, 'text/html');
                ['side', 'table'].forEach(function (name) {
                    var current = block(name);
                    var fresh = doc.querySelector('[data-live="' + name + '"]');
                    if (current && fresh) current.innerHTML = fresh.innerHTML;
                });
                // Значения уже в допустимых пределах, поэтому старые сообщения об ошибках убираем.
                if (!doc.querySelector('[data-live="side"] .bank-result-empty')) {
                    form.querySelectorAll('.bank-alert, .bank-error').forEach(function (el) { el.remove(); });
                }
                history.replaceState(null, '', target);
            })
            .catch(function (error) {
                if (error.name !== 'AbortError') window.location.href = target; // запасной путь: обычная перезагрузка
            })
            .then(function () { if (side) side.classList.remove('is-loading'); });
    }

    pairs.forEach(function (pair) {
        // Ползунок двигают: число в поле меняется, результат прячется под скелетон.
        pair.range.addEventListener('input', function () {
            pair.field.value = pair.range.value;
            paint(pair.range);
            showSkeleton();
        });
        // Число ввели руками: следим за каждым нажатием и проверяем границы, когда поле потеряло фокус.
        pair.field.addEventListener('input', showSkeleton);
        pair.field.addEventListener('change', function () { clamp(pair); });
    });

    var select = form.querySelector('select');
    if (select) select.addEventListener('change', showSkeleton);

    // Расчёт только по кнопке.
    form.addEventListener('submit', function (event) {
        event.preventDefault();
        pairs.forEach(clamp);
        calculate();
    });
})();
</script>
