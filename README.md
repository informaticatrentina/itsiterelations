# itsiterelations

Questa estensione visualizza quali estensioni sono richieste da ogni siteaccess
installato su server eZ-Publish e le dipendenze tra le estensioni.

Le funzionalità sono realizzate per  eZ-Publish Community Project 2014.11 e
vengono fatte le seguenti assunzioni.
    - Il Front End di ogni sito è rappresentato da un codice numerico
    di 3 cifre che va da 000 a 999
    - Il Back End del sito XXX è rappresentato con XXXadmin
    - Il Debug del sito XXX è rasspresentato con XXXdebug
    - Il sito tradotto in tedesco è rappresentato con XXXdeu
    - Il sito tradotto in inclese è rappresentato con XXXeng

Le dipendenze tra siteaccess ed estensioni sono estratte dai file site.ini.apppend.php.
(modulo relations/siteextensions)

Le dipendenze tra le estensioni sono estratte dal file composer.json.
(modulo relations/extensions)
