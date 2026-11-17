{{-- Живой поиск и фильтр по рубрикам без перезагрузки страницы.
     Поиск, фильтрацию и разбивку на страницы делает сервер (FinArticleController@index):
     скрипт запрашивает тот же адрес с параметрами и подменяет блоки «рубрики» и «результаты». --}}
<script>
(function () {
    var form = document.querySelector('[data-article-filter]');
    if (!form || !window.fetch || !window.DOMParser || !window.URLSearchParams || !history.pushState) return;

    var base = form.getAttribute('action');
    var search = form.elements['q'];
    var timer = null;
    var controller = null;

    // Скрытое поле с рубрикой: создаём, если на странице оно ещё не нужно было.
    var category = form.elements['category'];
    if (!category) {
        category = document.createElement('input');
        category.type = 'hidden';
        category.name = 'category';
        category.value = '';
        form.insertBefore(category, form.firstChild);
    }

    function block(name) { return document.querySelector('[data-live="' + name + '"]'); }

    // Адрес запроса из текущих значений формы (пустые параметры не добавляем).
    function currentUrl() {
        var params = new URLSearchParams();
        if (search.value.trim() !== '') params.set('q', search.value.trim());
        if (category.value !== '') params.set('category', category.value);
        var query = params.toString();
        return base + (query ? '?' + query : '');
    }

    // mode: 'replace' — меняем текущую запись истории (набор текста),
    //       'push' — добавляем новую (рубрика, страница), 'none' — кнопка «Назад».
    function load(target, mode) {
        var results = block('results');

        if (controller) controller.abort();
        controller = new AbortController();
        if (results) results.classList.add('is-loading');

        fetch(target, { headers: { 'X-Requested-With': 'XMLHttpRequest' }, signal: controller.signal })
            .then(function (response) { return response.text(); })
            .then(function (html) {
                var doc = new DOMParser().parseFromString(html, 'text/html');
                ['chips', 'results'].forEach(function (name) {
                    var current = block(name);
                    var fresh = doc.querySelector('[data-live="' + name + '"]');
                    if (current && fresh) current.innerHTML = fresh.innerHTML;
                });
                if (mode === 'push') history.pushState(null, '', target);
                if (mode === 'replace') history.replaceState(null, '', target);
            })
            .catch(function (error) {
                if (error.name !== 'AbortError') window.location.href = target; // запасной путь: обычная перезагрузка
            })
            .then(function () { if (results) results.classList.remove('is-loading'); });
    }

    // Набор текста: ждём паузу в 300 мс, чтобы не слать запрос на каждую букву.
    var lastQuery = search.value.trim();
    search.addEventListener('input', function () {
        clearTimeout(timer);
        timer = setTimeout(function () {
            var value = search.value.trim();
            if (value === lastQuery) return;
            lastQuery = value;
            load(currentUrl(), 'replace');
        }, 300);
    });

    // Кнопка «Найти» и Enter: не перезагружаем страницу.
    form.addEventListener('submit', function (event) {
        event.preventDefault();
        clearTimeout(timer);
        lastQuery = search.value.trim();
        load(currentUrl(), 'push');
    });

    // Клики по рубрикам и по номерам страниц (блоки подменяются, поэтому слушаем документ).
    document.addEventListener('click', function (event) {
        if (event.metaKey || event.ctrlKey || event.shiftKey || event.button !== 0) return;

        var chip = event.target.closest('[data-live="chips"] a[data-category]');
        if (chip) {
            event.preventDefault();
            category.value = chip.getAttribute('data-category');
            load(currentUrl(), 'push');
            return;
        }

        var page = event.target.closest('[data-live="results"] a.page-link');
        if (page) {
            event.preventDefault();
            load(page.href, 'push');
            var results = block('results');
            if (results) results.scrollIntoView({ block: 'start' });
        }
    });

    // Кнопка «Назад»/«Вперёд»: возвращаем значения в форму и загружаем результаты.
    window.addEventListener('popstate', function () {
        var params = new URLSearchParams(window.location.search);
        search.value = params.get('q') || '';
        lastQuery = search.value.trim();
        category.value = params.get('category') || '';
        load(window.location.href, 'none');
    });
})();
</script>
