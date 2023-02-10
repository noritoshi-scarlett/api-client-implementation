### ApiCLient

Api Client stworzony na potrzeby zadania rekrutacyjnego dla firmy 'merce.

## Changelog

1. init, PSR-7

- composer init
- Dodanie do projektu gotowej implementacji PSR-7: `nyholm/psr7`


2. PSR-18, struktura projektu, inne biblioteki

- implementacja PHPUnit: `phpunit/phpunit`
- własna implementacja PSR18 (PSR opisujący klasy typu ApiClient oraz Exceptiony przez nie wywoływane)
- utworzenie podstawowej struktury katalogów i plików:
  - Request implementujący Request z biblioteki od `nyholm`
  - Response implementujący Response z biblioteki od `nyholm`
  - ApiClient implementujący ClientInterface z oficjalnego psr-18
  - Exceptiony implementujące Interfejsy z oficjalnego psr-18

3. rozbudowa implementacji PSR-18

4. Walidacja basic i JWT

5. dodanie killku testów

6. przykładowe zapytania