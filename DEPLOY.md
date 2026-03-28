# Інструкція з розгортання та переходу на прод

## Зміст
- [Частина 1 — Розгортання на тестовий сервер (new.trufelbakery.com)](#частина-1--розгортання-на-тестовий-сервер)
- [Частина 2 — Перехід на прод (trufelbakery.com)](#частина-2--перехід-на-прод)

---

## Частина 1 — Розгортання на тестовий сервер

### Крок 1. Локально — збілдити проект перед пушем

```bash
# 1. Збілдити Laravel (CSS/JS фронтенд)
npm run build

# 2. Збілдити Vue адмін-панель (з правильним .env)
cd backend
cp .env.example .env
# Відкрий backend/.env і встанови:
# VITE_API_BASE_URL=https://new.trufelbakery.com
npm run build
cd ..

# 3. Закомітити і запушити
git add -A
git commit -m "build for deployment"
git push
```

> **Важливо:** `VITE_API_BASE_URL` вбудовується в JS під час білду.
> Після зміни домену треба перебілдити і перепушити.

---

### Крок 2. На сервері — клонувати репозиторій

```bash
cd /var/www
git clone https://github.com/YOUR_USERNAME/YOUR_REPO.git trufel-site
cd trufel-site
```

---

### Крок 3. Встановити PHP залежності

```bash
composer install --no-dev --optimize-autoloader
```
DB_USERNAME=laravel_user
DB_PASSWORD=aZas98&SWssw

---

### Крок 4. Налаштувати Laravel .env

```bash
cp .env.example .env
```

Відредагувати `.env` на сервері:

```env
APP_NAME="Trufel Bakery"
APP_ENV=production
APP_KEY=                        # заповниться командою нижче
APP_DEBUG=false
APP_URL=https://new.trufelbakery.com
APP_INDEXABLE=false             # ВАЖЛИВО: закрити від індексації поки тестовий

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=trufel_db           # назва вашої БД
DB_USERNAME=trufel_user         # ваш mysql юзер
DB_PASSWORD=your_password

TELEGRAM_BOT_ID=токен_вашого_бота
TELEGRAM_CHAT_ID=ваш_chat_id

LOG_LEVEL=error
```

```bash
# Згенерувати APP_KEY
php artisan key:generate
```

---

### Крок 5. Налаштувати storage та права

```bash
php artisan storage:link
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

---

### Крок 5.5. Створити БД і надати доступ MySQL юзеру

На сервері вже є MySQL юзер від іншого проекту — створювати нового не потрібно,
достатньо додати йому привілеї для нової бази:

```bash
mysql -u root -p
```

```sql
-- Створити нову базу для проекту
CREATE DATABASE trufel_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Дати існуючому юзеру доступ до нової БД
GRANT ALL PRIVILEGES ON trufel_db.* TO 'existing_user'@'localhost';
FLUSH PRIVILEGES;

EXIT;
```

> Замість `existing_user` — ім'я вашого поточного MySQL юзера.
> В `.env` вказати ті самі `DB_USERNAME` і `DB_PASSWORD` що й для іншого проекту,
> тільки `DB_DATABASE=trufel_db`.

---

### Крок 6. Запустити міграції та сідери

```bash
php artisan migrate

# Тільки ці сідери (без фейкових начинок)
php artisan db:seed --class=AdminUserSeeder
php artisan db:seed --class=CandybarGroupTypeSeeder
```

> `FakeDataSeeder` і `CandybarFakeDataSeeder` — **не запускати на прод/тест**.
> Реальні начинки і продукти додаються через адмін-панель.

---

### Крок 7. Закешувати конфіги

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

### Крок 8. Налаштувати Apache

Створити файл `/etc/apache2/sites-available/trufelbakery.conf`:

```apache
# ── Основний сайт ──────────────────────────────────────────────────
<VirtualHost *:80>
    ServerName new.trufelbakery.com

    DocumentRoot /var/www/trufel-site/public

    <Directory /var/www/trufel-site/public>
        AllowOverride All
        Require all granted
        Options -Indexes
    </Directory>

    ErrorLog  ${APACHE_LOG_DIR}/trufelbakery_error.log
    CustomLog ${APACHE_LOG_DIR}/trufelbakery_access.log combined
</VirtualHost>

# ── Адмін-панель (Vue SPA) ─────────────────────────────────────────
<VirtualHost *:80>
    ServerName manager.new.trufelbakery.com

    DocumentRoot /var/www/trufel-site/public/backend

    <Directory /var/www/trufel-site/public/backend>
        AllowOverride None
        Require all granted
        Options -Indexes
        FallbackResource /index.html
    </Directory>

    ErrorLog  ${APACHE_LOG_DIR}/trufelbakery_manager_error.log
    CustomLog ${APACHE_LOG_DIR}/trufelbakery_manager_access.log combined
</VirtualHost>
```

```bash
sudo a2ensite trufelbakery.conf
sudo a2enmod rewrite
sudo systemctl reload apache2
```

---

### Крок 9. SSL (HTTPS)

```bash
sudo apt install certbot python3-certbot-apache
sudo certbot --apache -d new.trufelbakery.com -d manager.new.trufelbakery.com
```

---

### Крок 10. Перевірити

- [ ] `https://new.trufelbakery.com` — сайт відкривається
- [ ] `https://manager.new.trufelbakery.com` — адмін-панель відкривається
- [ ] Можна залогінитись в адмін-панель
- [ ] Можна зробити тестове замовлення
- [ ] Telegram повідомлення приходить
- [ ] Завантаження зображень працює

---

## Частина 2 — Перехід на прод

### Крок 1. Локально — перебілдити з новим доменом

```bash
# Змінити в backend/.env:
# VITE_API_BASE_URL=https://trufelbakery.com
cd backend
npm run build
cd ..

npm run build

git add -A
git commit -m "build for production trufelbakery.com"
git push
```

---

### Крок 2. На сервері — оновити Laravel .env

```bash
nano /var/www/trufel-site/.env
```

Змінити:

```env
APP_URL=https://trufelbakery.com
APP_INDEXABLE=true              # Відкрити для індексації
```

---

### Крок 3. На сервері — оновити Apache конфіг

Замінити `ServerName` в `/etc/apache2/sites-available/trufelbakery.conf`:

```apache
# Було:                              # Стало:
new.trufelbakery.com          →      trufelbakery.com
manager.new.trufelbakery.com  →      manager.trufelbakery.com
```

```bash
sudo systemctl reload apache2
```

---

### Крок 4. Переключити DNS

В панелі управління доменом `trufelbakery.com`:
- `A` запис `@` → IP нового сервера
- `A` запис `manager` → IP нового сервера

Поширення DNS: до 24 годин.

---

### Крок 5. Оновити SSL сертифікати

```bash
sudo certbot --apache -d trufelbakery.com -d www.trufelbakery.com -d manager.trufelbakery.com
```

---

### Крок 6. Підтягнути зміни і перекешувати

```bash
cd /var/www/trufel-site
git pull
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

### Крок 7. На старому сервері — поставити 301 редірект

**Apache (.htaccess або VirtualHost):**
```apache
RewriteEngine On
RewriteRule ^(.*)$ https://trufelbakery.com/$1 [R=301,L]
```

**Nginx:**
```nginx
return 301 https://trufelbakery.com$request_uri;
```

> 301 передає SEO вагу сторінок на новий домен.

---

### Крок 8. Фінальна перевірка

- [ ] `https://trufelbakery.com` — відкривається новий сайт
- [ ] `https://manager.trufelbakery.com` — адмін-панель
- [ ] `https://new.trufelbakery.com` → редірект на `https://trufelbakery.com`
- [ ] Перевірити в Google Search Console що сайт індексується
- [ ] Перевірити meta robots в коді сторінки: `index, follow`

---

## Команди для рутинного оновлення (після git pull)

```bash
cd /var/www/trufel-site
git pull
php artisan config:cache
php artisan route:cache
php artisan view:cache
# Якщо були нові міграції:
php artisan migrate
```
