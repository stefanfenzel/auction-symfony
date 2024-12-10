# Auktionssystem - Symfony Anwendung

## Projektbeschreibung

Dieses Projekt ist Teil meiner Bachelorarbeit mit dem Thema: "Integration des Domain-Driven-Designs in PHP-Frameworks:
Ein Vergleich von Laravel, Symfony und Laminas". In meiner Bachelorarbeit untersuche ich die Unterschiede in der
Implementierung des Domain-Driven Designs in diesen drei Frameworks und zeige die Stärken und Schwächen der jeweiligen
Ansätze auf.

Dieses Projekt ist eine einfache Auktionsanwendung, die mit dem Symfony Framework entwickelt wurde. Das System
ermöglicht es Benutzern, Auktionen zu erstellen und daran teilzunehmen. Die Anwendung unterstützt grundlegende
CRUD-Operationen für Auktionen und Gebote sowie die Benutzerauthentifizierung. Es gibt zwei Benutzerarten: Gäste und
eingeloggte Benutzer.

### Funktionalitäten

- **Nicht angemeldeter Benutzer**:
    - Registrierung im System
    - Anmeldung im System
    - Anzeigen der Liste der Auktionen
    - Ansehen von Auktionsdetails

- **Eingeloggter Benutzer**:
    - Erstellen, Bearbeiten und Löschen eigener Auktionen
    - Abgabe von Geboten auf Auktionen
    - Abmeldung aus dem System

### Installation

1. **Repository klonen**:
   ```bash
   git clone <repository-url>
   ```

2. **Abhängigkeiten installieren**:
   ```bash
   cd auction-symfony
   composer install
   ```

3. **Umgebungsvariablen konfigurieren**:
   Kopiere die `.env.test` Datei und benenne sie in `.env.local` um:
   ```bash
   cp .env.example .env.local
   ```
   Aktualisiere die Umgebungsvariablen entsprechend deiner Datenbank- und Anwendungskonfiguration.

4. **Datenbankmigrationen ausführen**:
   ```bash
    php bin/console doctrine:migrations:migrate
   ```

5. **Entwicklungserver starten**:
   ```bash
   symfony server:start
   ```

### Technologien

- Symfony Framework
- MySQL (oder eine andere relationale Datenbank)
- Twig Templates für die Benutzeroberfläche
