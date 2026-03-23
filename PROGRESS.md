# Trufel Bakery — Прогрес розробки

## Стек
- **Backend:** Laravel 12, PHP 8.4, MySQL
- **Frontend (клієнт):** Blade + Alpine.js + Tailwind CSS
- **Admin panel:** Vue.js 3 + Vuex + Headless UI (в директорії `/backend`)
- **Build:** Vite

---

## Що вже зроблено

### 1. Laravel 10 → 12 (upgrade)
- Оновлено `composer.json`: `framework ^12`, `sanctum ^4`, `phpunit ^11`, тощо
- Міграція на новий L11/L12 skeleton:
  - Переписано `bootstrap/app.php` (новий формат `Application::configure()`)
  - Створено `bootstrap/providers.php`
  - Кастомні middleware aliases (`admin`, `order.cart.empty`) → в `bootstrap/app.php`
  - Schedule (`app:image-optimize`) → перенесено в `routes/console.php`
  - Rate limiter → перенесено в `AppServiceProvider`
- Видалено: `app/Http/Kernel.php`, `app/Console/Kernel.php`, `RouteServiceProvider`, `AuthServiceProvider`
- Locale змінено з `en` → `uk` в `config/app.php`

---

### 2. Нова кольорова схема — пастельний мінімалізм

Додано в `tailwind.config.js` кастомну палітру `brand`:

| Змінна | HEX | Використання |
|---|---|---|
| `brand-cream` | `#FAFAF8` | фон body |
| `brand-blush` | `#F0DDD9` | акцент світлий, hover фони |
| `brand-rose` | `#C9847A` | кнопки, акценти, ціни |
| `brand-rose-dark` | `#A8635C` | hover кнопок, заголовки |
| `brand-text` | `#2D2D2D` | основний текст |
| `brand-muted` | `#8A8078` | другорядний текст |

Нові CSS-класи в `app.css`: `.button`, `.btn-outline`, `.section-title`, `.card`

---

### 3. Навігаційне меню (`layouts/nav-menu.blade.php`)

**До:** `Головна | Галерея▼ | Замовити▼ | Контакти | Відгуки | 🛒`
**Після:** `Головна | Каталог▼ | Відгуки | Контакти | 🛒`

- Прибрано дублювання (Галерея + Замовити → єдиний Каталог)
- Dropdown посилається на `/filling/{type}` (сторінка з замовленням)
- Overlay для мобільного меню при відкритті
- Нові hover ефекти в brand палітрі

---

### 4. Головна сторінка (`welcome.blade.php` + `SiteController`)

**Нова структура:**
1. **Hero** (`navigation-title.blade.php`) — 90vh, фонове фото, оновлені кольори, CTA кнопка "Переглянути каталог"
2. **"Наша продукція"** — 6 карток начинок прямо на головній з кнопкою "Обрати" (відкриває modal кошика)
3. **"Як зробити замовлення"** — 3 кроки з SVG іконками, пудровий фон на всю ширину
4. **"Відгуки клієнтів"** — 3 останніх відгуки в картках з аватаром-ініціалом і зірками

`SiteController::index()` тепер передає у view:
- `$featuredFillings` — 6 начинок з усіма даними для cart modal
- `$recentComments` — 3 останніх відгуки

---

### 5. Сторінка каталогу (`filling/index.blade.php`)

- **Фото-accordion** зверху сторінки:
  - Desktop: відкритий за замовчуванням
  - Mobile: **згорнутий** за замовчуванням (щоб начинки були одразу видні)
  - Кнопка toggle з лічильником фото
  - Grid 2×4 з `aspect-square` та hover-zoom
  - Посилання на повну галерею
- **Нові картки начинок:** `rounded-2xl`, `shadow-sm→shadow-md`, hover-zoom на фото
- **Фільтри категорій:** `rounded-full` в новій палітрі
- `FillingController` оновлено: передає `$previewProducts` для accordion

---

### 6. Оновлені стилі решти сторінок

- `components/title.blade.php` — підзаголовок `text-red-300` → `text-brand-muted`
- `contacts.blade.php` — іконки `bg-red-300` → `bg-brand-rose`
- `testimonials.blade.php` — зірки та кнопки `text-red-300` → `text-brand-rose`
- `cart/index.blade.php` — повністю перероблено: нові картки, кнопки +/−, порожній стан
- `order/index.blade.php` — форма в `card`, нові інпути `rounded-xl border-brand-blush`

---

### 7. Modal вікно кошика (`layouts/modal-order.blade.php`)

- Backdrop: `bg-pink-100/70` → `bg-black/50 backdrop-blur-sm`
- Анімація появи/зникнення (`scale + opacity transition`)
- Клік за межами закриває модалку
- Зображення: повна ширина `rounded-t-2xl`, `object-cover object-center max-h-72`
- Кнопка закриття: кругла `rounded-full` з hover
- Контроли +/−: `bg-brand-blush rounded-xl` з hover `bg-brand-rose`
- Ціна `text-brand-rose text-2xl font-medium`
- Кнопки дій розділені лінією `border-t border-brand-blush`

---

### 8. SEO (`MetaComposer` + `config/seo.php`)

Кожна сторінка отримує повний набір мета-тегів:

**Теги:** `title`, `description`, `keywords`, `robots`, `canonical`, `author`, `theme-color`
**Open Graph:** `og:title`, `og:description`, `og:image`, `og:url`, `og:type`, `og:locale`, `og:site_name`
**JSON-LD структуровані дані:**

| Сторінка | Схема |
|---|---|
| Головна | `Bakery` + `WebSite` + `AggregateRating` |
| `/filling/{type}` | `ItemList` (до 10 начинок з цінами) |
| `/contacts` | `Bakery` (адреса, телефон, соцмережі) |
| `/testimonials` | `AggregateRating` |
| Кошик / Замовлення | `robots: noindex, nofollow` |

**Динамічні дані на сторінках каталогу:**
- Назва типу у title
- Реальна кількість начинок з БД
- Мінімальна ціна з БД
- Правильні українські відмінки (маппінг у `config/seo.php`)

Файл `config/seo.php` — єдина точка для бізнес-даних (назва, телефон, адреса, соцмережі, відмінки типів).

---

### 9. Тестові дані (`FakeDataSeeder`)

Файл: `database/seeders/FakeDataSeeder.php`

Запуск: `php artisan db:seed --class=FakeDataSeeder`

Додає:
- **44 начинки** з реальними українськими назвами та описами:
  - Торт/Бісквітні: 10 шт (від 410 грн/кг)
  - Торт/Мусові: 10 шт (від 520 грн/кг)
  - Бенто/Класичні: 5 шт, Бенто/Фруктові: 5 шт
  - Капкейки (candybar): 5 категорій × 1-2 начинки
  - Кейпопси (candybar): 5 категорій × 1-2 начинки
- **41 продукт** (фото), рівномірно по всіх типах
- Всі використовують реальні завантажені зображення

---

## Що залишилось зробити

### Пріоритет 1 — Vue.js Admin Panel (`/backend`)
Адмін-панель ще не оновлювалась. Потрібно:
- [ ] Оновити стилі під нову палітру
- [ ] Адаптувати під зміни структури (новий пункт "Каталог" замість Gallery/Fillings)
- [ ] Перевірити CRUD для типів, категорій, начинок, продуктів
- [ ] Перевірити сторінку замовлень

### Пріоритет 2 — Дрібні покращення фронтенду
- [ ] `product/index.blade.php` — оновити стилі галереї в новій палітрі
- [ ] `filling/candybar.blade.php` — оновити стилі під нову палітру (сторінка candybar типів)
- [ ] `testimonials.blade.php` — можливо оновити layout карусельки
- [ ] Footer — можливо розширити (соцмережі, навігація)

### Пріоритет 3 — Функціонал
- [ ] Lazy loading зображень перевірити скрізь (`loading="lazy"` вже додано)
- [ ] OG image — покласти окремий файл `public/img/og-image.jpg` 1200×630px для соцмереж
- [ ] `APP_URL` в `.env` — поставити реальний домен (зараз `http://localhost`)

---

## Важливі файли

```
bootstrap/app.php              — L12 конфіг (middleware, routing)
bootstrap/providers.php        — провайдери (AppServiceProvider, EventServiceProvider)
config/seo.php                 — SEO налаштування та бізнес-дані
app/View/Composers/MetaComposer.php  — SEO мета для кожної сторінки
app/Http/Controllers/SiteController.php   — головна сторінка
app/Http/Controllers/FillingController.php — каталог + фото accordion
resources/views/welcome.blade.php          — головна сторінка
resources/views/filling/index.blade.php    — сторінка каталогу
resources/views/layouts/nav-menu.blade.php — навігація
resources/views/layouts/modal-order.blade.php — modal кошика
resources/views/components/app-layout.blade.php — layout + SEO теги
resources/css/app.css          — глобальні стилі + brand класи
tailwind.config.js             — brand кольори
database/seeders/FakeDataSeeder.php — тестові дані
```
