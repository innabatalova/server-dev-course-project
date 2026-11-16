@props(['active' => 'index'])
<nav class="notebook-menu">
    <a href="/labs/2" @class(['menu-btn', 'active' => $active === 'index'])>Просмотр</a>
    <a href="/labs/2/create" @class(['menu-btn', 'active' => $active === 'create'])>Добавление записи</a>
    <a href="/labs/2/edit" @class(['menu-btn', 'active' => $active === 'edit'])>Редактирование записи</a>
    <a href="/labs/2/delete" @class(['menu-btn', 'active' => $active === 'delete'])>Удаление записи</a>
</nav>
