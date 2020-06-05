# System umożliwiający anonimowe ankiety/głosowanie.

Celem projektu było stworzenie aplikacji umożliwiającej tworzenie ankiet i oddawania w nich głosów. Aplikacja jest dostępna tylko dla zarejestrowanych użytkowników, którzy mogą oddać anonimowy głos w danej ankiecie tylko raz. Tworzenie ankiety również jest anonimowe, zarówno dla użytkowników, jak i administratora.

## Utworzone w:

- HTML5
- CSS
- PHP 
- MySQL

## Uruchamianie

W przypadku zainstalowanego pakietu XAMPP należy włączyć Apache, MySQL oraz przy użyciu phpMyAdmin stworzyć bazę danych MySQL przy użyciu gotowej procedury phppoll.sql.

## Autorzy:

- Filip Węklar
- Konrad Gorczyca

## Struktura plików:

-**[ankiety---projekt-](https://github.com/fweklar/ankiety---projekt-)**
--registration
-----errors.php
-----login.php
-----register.php
-----server.php 
-----style.css
--check.php
--create.php 
--delete.php
--functions.php
--index.php 
--phppoll.sql 
--result.php
--style.css
--vote.php


## Dokumentacja

-**[ankiety---projekt-](https://github.com/fweklar/ankiety---projekt-)**
--registration
-----errors.php - plik zawierający błędy w przypadku niepoprawnego logowania.
-----login.php - strona odpowiadająca za logowanie się użytkownika.
-----register.php - strona odpowiadająca za założenie konta.
-----server.php - plik zawiera funkcjonalność połączenia z baza danych.
-----style.css - arkusz stylów dla systemu logowania i rejestracji.
--check.php - plik zawierający kod który umożliwia sprawdzenie czy ankieta jest w systemie.
--create.php - strona zawierająca możliwość tworzenia ankiet.
--delete.php - plik zawierający możliwość kasowania ankiet.
--functions.php - plik zawierający funkcje połączenia z bazą danych.
--index.php  - główna strona zawierająca listę utworzonych ankiet.
--result.php - strona zawierająca wyniki dla określonej ankiety.
--style.css - arkusz stylów CSS dla naszego systemu ankiet i głosowania.
--vote.php - strona zawierająca funkcję anonimowego głosowania. 

## Baza danych

--phppoll.sql  - procedura SQL odpowiadająca za utworzenie bazy zawierającej tabele: polls, poll_answers, users, user_answers, hashes.

---polls - tabela zawierająca informacje o ankietach które tworzymy
----ID(int(11)) - unikalne ID ankiety, działa na zasadzie inkrementacji.
----title(text) - tytuł ankiety.
----desc(text) - opis ankiety, tekst opcjonalny.

---poll_answers - tabela zawierająca wszystkie odpowiedzi dla naszych utworzonych ankiet.
----ID(int(11)) - unikalne ID odpowiedzi, działa na zasadzie inkrementacji.
----poll_ID - unikalne ID ankiety, dzięki temu polu możemy powiązać tabele.
----title(text) - odpowiedź w danej ankiecie.
----votes(int(11)) - ilość głosów.

---users - tabela zawierająca wszystkie dane użytkownika.
----ID(int(11) - unikalne ID dla użytkownika.
----username(varchar(100))  - pole przechowujące login użytkownika.
----email(varchar(100)) - pole przechowujące e-mail użytkownika.
----password(varchar(100)) - pole przechowujące zahashowane hasło użytkownika.

---user_answers - tabela zawierające informacje jaki użytkownik wziął udział w jakiej ankiecie.
----ID(int(11) - unikalne ID użytkownika.
----username(varchar(100))  - pole przechowujące login użytkownika.
----poll_ID - unikalne ID ankiety.

---hashes - tabela zawierające informacje jaki użytkownik wziął udział w jakiej ankiecie.
----ID(int(11) - unikalne ID.
----userhash(text)  - pole przechowujące unikalny hash wygenerowany przy pomocy danych użytkownika.
