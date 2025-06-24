# 📬 JSONPlaceholder Post App – Symfony 6

Aplikacja napisana w Symfony 6.  
Pobiera dane z API `https://jsonplaceholder.typicode.com` i zapisuje je lokalnie w bazie PostgreSQL.

## 🌐 Dostęp do aplikacji

Aplikacja jest dostępna pod adresem:  
🔗 [http://57.128.221.233/](http://57.128.221.233/)

### 🔐 Dostępne ścieżki

- `/login` – logowanie do aplikacji
- `/api/posts` – API do listy postów

### 👤 Dane testowego użytkownika

- **E-mail:** `test@test.pl`
- **Hasło:** `test123`

## 🔧 Technologie

- PHP 8.3
- Symfony 6.4
- Doctrine ORM
- PostgreSQL
- API Platform
- Twig (UI)
- Bootstrap (lekki styl)
- Symfony Security (logowanie)
- Maker Bundle, Migrations

---

## ✨ Funkcje aplikacji

### 1. Konsolowe pobieranie danych z API

Dane z serwisu `https://jsonplaceholder.typicode.com` pobierzesz komendą:

```bash
php bin/console app:fetch-posts
```

Co robi ta komenda?

- Pobiera użytkowników z `/users` i zapisuje ich do bazy danych.
- Pobiera posty z `/posts` i zapisuje je do bazy z przypisanym autorem (`userId`).
- Każdy post zawiera tytuł, treść i autora.

---

### 2. Zabezpieczona strona z listą postów

- Dostępna pod `/lista`
- Wymaga logowania (`/login`)
- Pozwala na usuwanie postów z lokalnej bazy danych

---

### 3. Publiczne API z API Platform

- Endpoint: `GET /api/posts`
- Zwraca dane z lokalnej bazy w formacie JSON
- Zawiera autora (`author.name`)

---

## 🔐 Logowanie

- Formularz logowania: `/login`
- Sesja z opcją zapamiętania (`remember_me`)
- Użytkownik `AppUser` przechowuje dane logowania

---

## 👤 Tworzenie użytkownika z poziomu konsoli

Utworzenie nowego użytkownika (np. do logowania):

```bash
php bin/console app:create-user jan.kowalski@gmail.com haslo123
```

Przykład:

```bash
php bin/console app:create-user admin@wp.pl admin123
```

---

## ⚙️ Instalacja lokalna

1. Sklonuj repozytorium:
   ```bash
   git clone https://github.com/damian-kurowski/jsonplaceholder-post-app.git
   cd jsonplaceholder-post-app
   ```

2. Zainstaluj zależności:
   ```bash
   composer install
   ```

3. Skonfiguruj połączenie z bazą:
   ```dotenv
   DATABASE_URL="postgresql://username:password@localhost:5432/jsonplaceholder"
   ```

4. Utwórz bazę i uruchom migracje:
   ```bash
   php bin/console doctrine:database:create
   php bin/console doctrine:migrations:migrate
   ```

5. (Opcjonalnie) Dodaj użytkownika:
   ```bash
   php bin/console app:create-user admin@wp.pl admin123
   ```

6. Uruchom serwer:
   ```bash
   symfony server:start
   ```


---

## 📁 Struktura projektu

- `src/Entity/Post.php` – encja posta
- `src/Entity/User.php` – encja użytkownika zewnętrznego
- `src/Entity/AppUser.php` – encja użytkownika logującego się
- `src/Command/FetchPostsCommand.php` – pobieranie danych z API
- `src/Command/CreateUserCommand.php` – dodawanie użytkownika przez CLI
- `src/Controller/PostListController.php` – wyświetlanie i usuwanie postów
- `src/Security/LoginFormAuthenticator.php` – obsługa logowania

---

## ✅ Wymagania

- PHP >= 8.2
- Composer
- PostgreSQL
- Symfony CLI

---

## 📬 Autor

>  *Damian Kurowski*  
