Formulare (subforms)
====================

Subforms ist eine Sammelstelle für Formulare, die mit Standardextensions wie powermail oder form nicht erstellt werden können.
Variable Daten wie Mailempfänger werden über TypoScript flexibel gesetzt.

Installation
------------

Installation der Extension, dabei Anlage der Datenbankfelder und anschließend Einbinden des TypoScripts. Die Absender- und Empfängere-mailadressen müssen im TypoScript definiert werden.

Integrierte Formulare
---------------------

Die Formulare sind jeweils als eigenständiges Plugin integriert.

Bücherwunschformular
~~~~~~~~~~~~~~~~~~~~

Plugin Name: buecherwunsch

Das Bücherwunschformular bietet eine integrierte Zählung der bereits verschickten Mails und stellt diese im Subject dar.

Wird das Feld ISBN ausgefüllt, so wird über einen Ajax Call im Hintergrund eine Datenbank nach Metadaten für den Titel abgefragt und die Felder im Frontend bei Erfolgt damit gefüllt.
Sobald ein Titel gefunden wurde werden diese Metadaten in eine lokale Redis-Datenbank eingefügt und beim nächsten Abruf der ISBN stehen diese dann sofort lokal ohne API Anfrage direkt zur Verfügung

Feedbackformular
~~~~~~~~~~~~~~~~

Pluginname: feedback

Ablösung der Extension nkwuserfeedback.

Die Empfänger des abegsendeten Formulars müssen über TypoScript definiert werden. Der Standardabsender (für den Fall dass keine E-Mail Adresse beim Absenden angegeben wurde sollte ebenfalls über TypoScript definiert werden.

Das Formular sendet an den vordefinierten Empfänger eine E-Mail mit Informationen aus dem Feedbackformular. Das Formular weiß, von welcher Seite es aufgerufen wurde und liefert entsprechend die SeitenID und den Link mit, damit für den Empfänger nachvollzogen werden kann auf welche Seite sich das Feedback bezieht.