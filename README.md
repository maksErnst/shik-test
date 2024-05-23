Установка на OpenServer
1. **Склонировать репозиторий.**
   git clone https://github.com/maksErnst/shik-test
2. **Установить зависимости.**
   cd your-project &&
   composer install
3. **Настройка OpenServer.**
   Откройте OpenServer и перейдите в раздел "Домены".
   Выберите режим "Ручной + Автоматический".
   Добавьте нужный домен, указав путь к директории domains/your-project/web.
4. **База данных.**
   PostgreSQL
