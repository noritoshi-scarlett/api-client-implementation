### ApiCLient

Api Client stworzony na potrzeby zadania rekrutacyjnego dla firmy X.
Wytyczne: użycie gotowej implementacji PSR-7, implementacja PSR-18,

## Opis wykonanego zadania

Ogółem odczułem, że jestem mocno ograniczony ze względu na PSR-7 w planowaniu architektury Api Clienta.
Moja cała dowolność działania znajduje się właściwie tylko na polu obsługi samego curla i opakowaniu go middlewerami.
Zwłasza, że zdecydowałem się użyć ClientInterface, który sprawia, że klasa ApiClient musi udostepniać metodę 'sendRequest'.
Dodałem jednak dodatkowe metody, które pozwalają obyć sie z Api bez tworzenia requesta, a bazują tylko na uri jako jedynym parametrze sterującym pracą instancji ApiClienta.
Uzywam też własnych klas Requesti i Response, wymagam wręcz ich używania. Dzięki temu można mocno rozbudowac obsługę żądań i odpowiedzi, dopasować pod konkretny sposób użycia. Np. w Responsie utworzyć metody tworzące obiekty z body JSONowego.


## Struktura projektu:

- `/tests` -> testy napisane w PHPUnit
- `/src` -> moje wlasne klasy: ApiClient, Request, Response, Middlewewry i Exceptiony
- `/files` -> logi, ciasteczka
- `/example` -> przykłady uzycia


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

3. Walidacja basic i JWT

- dodanie własnego interfejsu Middleware.
- Utworzenie dwóch Middleware: Basic i JWT.

4. rozbudowa implementacji PSR-18

- dodanie prostej implementacji curla do ApiClienta

5. dodanie killku testów

- dodanie 2 testów do API w PHPUnit
- dodanie exampla w examples

6. Solidna rozbudowa middlewarow w ApiCliencie

7. Drobne poprawki

8. Dodanie plików na ciasteczka i logi.
