@props(['active' => 'index', 'sort' => 'added'])
<nav class="notebook-menu">
    <div class="menu-main">
        <a href="/labs/2" @class(['menu-btn', 'active' => $active === 'index'])>Просмотр</a>
        <a href="/labs/2/create" @class(['menu-btn', 'active' => $active === 'create'])>Добавление записи</a>
        <a href="/labs/2/edit" @class(['menu-btn', 'active' => $active === 'edit'])>Редактирование записи</a>
        <a href="/labs/2/delete" @class(['menu-btn', 'active' => $active === 'delete'])>Удаление записи</a>
    </div>

    @if ($active === 'index')
        <div class="menu-sub">
            <a href="/labs/2?sort=added" @class(['menu-btn', 'small', 'active' => $sort === 'added'])>В порядке добавления</a>
            <a href="/labs/2?sort=surname" @class(['menu-btn', 'small', 'active' => $sort === 'surname'])>По фамилии</a>
            <a href="/labs/2?sort=birth" @class(['menu-btn', 'small', 'active' => $sort === 'birth'])>По дате рождения</a>
        </div>
    @endif
</nav>
