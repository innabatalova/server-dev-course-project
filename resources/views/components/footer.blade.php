<footer class="site-footer">
    <div class="container footer-cols">
        <div>
            <h3>О проекте</h3>
            <p><strong>Серверная веб-разработка</strong></p>
            <p>Учебный сайт: лабораторные работы и курсовой проект на Laravel</p>
        </div>
        <div>
            <h3>Разделы</h3>
            <ul>
                <li><a href="/">Главная</a></li>
                <li><a href="/labs">Лабораторные</a></li>
                <li><a href="/course">Курсовой проект</a></li>
            </ul>
        </div>
        <div>
            <h3>Лабораторные</h3>
            <ul>
                <li><a href="/labs/1">Лаба 1 — Feedback form</a></li>
                <li><a href="/labs/2">Лаба 2 — Notebook</a></li>
                <li><a href="/labs/3">Лаба 3 — Роутинг</a></li>
                @foreach (range(4, 5) as $n)
                    <li><a href="/labs/{{ $n }}">Лаба {{ $n }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="container footer-bottom">
        <span>© {{ date('Y') }} Баталова И. А., группа 253-325</span>
        <span>Московский политехнический университет</span>
    </div>
</footer>
