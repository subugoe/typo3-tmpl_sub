Buchpatenschaften (patenschaften)
=================================

Technische Dokumentation
-------------------------

Anzeige von Buchpatenschaften und Kategorien im Frontend.

Installation
~~~~~~~~~~~~

* Bilddateien inklusive Unterverzeichnisse in ``/fileadmin/media/bilder/patenschaften/`` kopieren
* Erstellen der Seiten.
* Installation der ``patenschaften`` Extension
* Hinzufügen des Frontend-Plugins auf die entsprechenden Seiten und dabei Auswahl der gewünschten Funktion im Flexform
* Unten angeführtes Typoscript auf der Zielseite, in der Buchpatenschaften genutzt werden sollen, lokalem Template einbinden
* Anlegen des SysFolder für die Patenschaften und Eingabe der ID in ``plugin.tx_patenschaften_pi1.pidList = 1184`` (z.B.)
* Anlegen der Formularseite und im TypoScript ``plugin.tx_patenschaften_pi1.pidList.formPage = 1191`` (z.B.) setzen
* Im TypoScript den *devMode* auf 1 setzen. Damit werden die vorhandenen Daten migriert.

TypoScript
~~~~~~~~~~
::

  #Angenommen die UID des Powermailfeldes ist {$selectID}:
  lib.uebergabe = TEXT
  lib.uebergabe.data = GPvar:tx_powermail_pi1|uid{$selectID}
  lib.uebergabe.intval = 1
  lib.uebergabe.required = 1
  lib.uebergabe.wrap = uid = |

  # lib.uebergabeNo = TEXT
  # lib.uebergabeNo.data = GPvar:tx_powermail_pi1|uid{$selectID}
  # lib.uebergabeNo.intval = 1
  # lib.uebergabeNo.required = 1
  # lib.uebergabeNo.wrap = uid != |

  #alle buecher aus der DB auslesen
  lib.buecher = COA_INT
  lib.buecher {
    10 = TEXT
    10.value = <div class="tx_powermail_pi1_fieldwrap_html tx_powermail_pi1_fieldwrap_html_text tx_powermail_pi1_fieldwrap_html_{$selectID} even" id="powermaildiv_uid{$selectID}"><label for="uid{$selectID}">Ihre Patenschaft:</label>

    15 = COA
    15.wrap = <select id="uid{$selectID}" class="powermail_ihrebuchpatenschaft powermail_text powermail_uid{$selectID}" tabindex="9" name="tx_powermail_pi1[uid{$selectID}]" size="1">|</select></div>

    15 {
      5 = TEXT
      5.data < lib.uebergabe
      10 = CONTENT
      10 {
        table = tx_patenschaften_buecher
        select {
          pidInList = {$pidInList}
          where = sponsorship = ""
          andWhere  < lib.uebergabe
          max = 1
        }
        renderObj = COA
        renderObj {
          10 = COA
          10 {
            10 = TEXT
            10 {
              field = titel
              wrap = <option selected="selected" value="|">
              stdWrap.htmlSpecialChars = 1
            }
            20 = TEXT
            20 {
              field = titel
              wrap = |</option>
            }
          }
        }
      }
      20 = CONTENT
      20 {
        table = tx_patenschaften_buecher
        select {
          pidInList = {$pidInList}
          orderBy = titel
          where = sponsorship = ""
        }
        renderObj = COA
        renderObj {
          10 = COA
          10 {
            10 = TEXT
            10 {
              field = titel
              wrap = <option value="|">
              stdWrap.htmlSpecialChars = 1
            }
            20 = TEXT
            20 {
              field = titel
              wrap = |</option>
            }
          }
        }
      }
    }
  }

TODO
----
* Autoren *alphabetisch* auflisten
* Hochkant- und Querformatbilder in gleicher Größe
* Head nur einmal in der Buecherliste

Redakteurs-Dokumentation
------------------------

Dieser Abschnitt beschreibt kurz was aus Sicht der Redakteure bei der Nutzung der Extension 'patenschaften' zu beachten ist.

Anlegen neuer Bücher und Kategorien
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Zum Anlegen neuer Kategorien und Bücher muss in der List-Ansicht im Backend der Systemordner *Patenschaften* ausgewählt werden. Der Inhalt des Ordners gliedert sich in zwei Elementgruppen, die Kategorien und Bücher. Die Schritte zum Anlegen eines neuen Elements sind in beiden Fällen gleich, daher wird an dieser Stelle nur das Anlegen eines neuen Buches beschrieben:

1. Zunächst klickt man im Abschnitt *Bücher* auf das Icon "Datensatz erstellen", um einen neuen Datensatz anzulegen.
2. Ein Buch im System verfügt über die folgenden Attribute:

	- Titel
	- Autor
	- Langtitel
	- Signatur
	- Beschreibung (Freitext)
	- Preis
	- Schadensbeschreibung (Freitext)
	- Mit ihrer Hilfe ... (Freitext)
	- Bilder (Select-Box)
	- Sponsor
	- Kategorie (Select-Box)

 Diese Felder müssen nicht zwingend alle ausgefüllt werden.

3. Beim Einbinden der Bilder ist zu beachten, dass diese aus dem Ordner ``fileadmin/media/bilder/patenschaften`` ausgewählt werden müssen. Der Einheitlichkeit halber sollten neue Bilder beim Upload auch immer in diesem Ordner abgelegt werden.
4. Wenn alle Felder ausgefüllt sind, muss der neue Datensatz gespeichert und geschlossen werden.

Verschieben eines Buches in übernommene Buchpatenschaften
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Wenn ein Buch einen Paten erhalten soll, muss nur das Feld *Sponsor* ausgefüllt und gespeichert werden. Dann verschiebt sich das Buch im Frontend automatisch in den Bereich *Bereits übernommene Buchpatenschaften*. Bei den Werten für das Feld kann zwischen zwei Typen gewählt werden, *anonyme* oder *öffentliche* Buchpatenschaft.

Um die anonyme Buchpatenschaft zu setzen, muss "Nicht genannt" als Sponsor eingetragen werden, dann wird das Buch mit anoymen Spender angezeigt. Ansonsten sollte der Spender in dem Stil *Name, Vorname; Stadt* angegeben werden.

