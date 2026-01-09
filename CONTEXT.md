# Sistema di Gestione Corsi

## Scopo del Progetto
Questo progetto implementa un sistema CRUD completo per la gestione di corsi utilizzando PHP, HTML, JavaScript e JSON. Il sistema permette agli utenti di creare, leggere, aggiornare ed eliminare corsi, con persistenza dei dati in file JSON.

## Caratteristiche Principali
- **Creazione Corsi**: Aggiunta di nuovi corsi con ID auto-generato, titolo obbligatorio, caricamento multimedia e 4 parole chiave obbligatorie con prevenzione duplicati.
- **Elenco Corsi**: Visualizzazione dell'elenco dei corsi con collegamenti ai dettagli.
- **Aggiornamento Corsi**: Modifica dei dettagli esistenti, inclusa l'aggiunta di lingue aggiuntive (default italiano).
- **Eliminazione Corsi**: Rimozione sicura dei corsi dal sistema.
- **Esportazione JSON**: Tutti i dati sono memorizzati ed esportati in formato JSON.
- **Dettagli Corsi**: Pagine individuali per informazioni complete sui corsi.
- **Internazionalizzazione**: Supporto per più lingue, con italiano come default per la creazione e possibilità di aggiungere altre lingue durante la modifica.

## Architettura
- **Frontend**: Form HTML con JavaScript per gestione dinamica dei form.
- **Backend**: PHP per logica server-side e processamento dati.
- **Persistenza Dati**: File JSON per archiviazione.
- **Classi**: Classi PHP separate per Course e CourseManager (singleton).

## Struttura dei Dati
Ogni corso contiene:
- ID (auto-generato, formato a 3 cifre con zeri iniziali)
- Titolo (array associativo per lingue)
- Descrizione (array associativo per lingue)
- Galleria Multimedia (array di elementi con tipo e percorso locale)
- Parole Chiave (esattamente 4, ciascuna con ID e peso 0-1)

Le parole chiave sono memorizzate separatamente in keywords.json, tracciando quali corsi le utilizzano e i relativi pesi.

## Decisioni Architetturali
- Utilizzo di PHP per processamento server-side come richiesto.
- JSON per persistenza dati per soddisfare il requisito di esportazione.
- Separazione delle responsabilità: PHP per logica, HTML per struttura, JS per interattività.
- ID auto-incrementali con formattazione a zero-padded.
- Campi form dinamici per input flessibili di media e parole chiave.

## Struttura del Progetto
- `html/index.html`: Punto di ingresso con collegamento al menu.
- `php/menu.php`: Menu di navigazione principale.
- `php/createCourse.php`: Form per creazione corsi.
- `php/editCourse.php`: Interfaccia modifica corsi.
- `php/deleteCourse.php`: Interfaccia eliminazione corsi.
- `php/listCourses.php`: Elenco corsi con collegamenti.
- `php/courseDetails.php`: Pagine dettagli individuali.
- `php/Course.php`: Classe modello Course.
- `php/CourseManager.php`: Classe singleton per gestione dati.
- `json/courses.json`: Archiviazione dati corsi.
- `json/keywords.json`: Archiviazione relazioni parole chiave.
- `js/formHandler.js`: JavaScript per elementi form dinamici e filtro file.
- `css/styles.css`: Stili CSS per l'interfaccia.
- `uploads/`: Directory per file caricati.

## Convenzioni del Progetto
- Interfaccia utente completamente in italiano.
- Separazione rigorosa tra codice PHP, HTML e JavaScript.
- Utilizzo di pattern Singleton per la gestione dati.
- Gestione errori basilare con messaggi in italiano.
- Stili CSS responsive e accessibili.

## Dipendenze
- PHP 7.0+ con supporto file e JSON.
- Server web per esecuzione PHP (es. Apache, Nginx).
- Browser moderno per supporto JavaScript e CSS.

## Note di Sviluppo
- Il sistema è progettato per ambienti sandboxed.
- I file multimedia sono caricati nella directory `uploads/`.
- Le parole chiave esistenti sono caricate dinamicamente nei form.
- Prevenzione duplicati implementata lato client con JavaScript.
