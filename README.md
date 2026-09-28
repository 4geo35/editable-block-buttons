### Установка

Добавить в `tailwind.admin.config.js`, созданный в пакете `tailwindcss-theme`.

    "./vendor/4geo35/editable-block-buttons/src/resources/views/livewire/admin/**/*.blade.php",
    "./vendor/4geo35/editable-block-buttons/src/resources/views/admin/**/*.blade.php",
    "./vendor/4geo35/editable-block-buttons/src/resources/views/components/**/*.blade.php",

Добавить в `tailwind.config.js`, созданный в пакете `tailwindcss-theme`.

    "./vendor/4geo35/editable-block-buttons/src/resources/views/web/**/*.blade.php",

Запустить миграции для создания таблиц `php artisan migrate`

#### Views

Сокращение для представлений: `ebtns`
Вывод кнопок на сайте, через представление: `@include('ebtns:web.render-buttons', ['blockItem' => $model])`

#### Livewire Components

Admin

- `ebtns-btn-list`: список кнопок, относящихся к модели `block-item`; `use-card-cover` - отображать с классом `card` или без.

#### Traits

- `ShouldButtons` - набор методов, необходимых для управления кнопками у модели.

#### Interfaces

- `ShouldButtonsInterface` - интерфейс, который необходим для модели с дополнительными кнопками.

#### Config

Название файла: `editable-block-buttons`

- `forms` => `[]`: список форм, вызов которых можно привязать к кнопке. Например `"call-request" => "Обратный звонок"`. Форма должна присутствовать на странице вывода, в шаблон не выводится сама форма, что бы исключить большое количество одинаковых форм.
