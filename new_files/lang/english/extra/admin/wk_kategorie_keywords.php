<?php   
/* -----------------------------------------------------------------------------------------
   Modul Kategorie-Keywords für modified eCommerce Shopsoftware 2.0.6.0     
   Autor: Daniel Lonn, Agentur Webknecht [webknecht.net | modified-multishop.de]
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/
   
define('MODULE_WK_KATEGORIE_KEYWORDS_TEXT_TITLE', 'Kategorie-Keywords');
define('MODULE_WK_KATEGORIE_KEYWORDS_TEXT_DESCRIPTION', '<br />Ist der Suchbegriff Bestandteil von Kategorie-Keywords werden zus&auml;tzlich zum regul&auml;ren Suchergebnis alle Artikel der betreffenden Kategorie gelistet. Optional werden ausserdem  die erfassten Kategorien oberhalb des Suchergebnisses platziert. <br />Bei bereits gew&auml;hlter Kategorie in der erweiterten Suche erfolgt kein Abgleich der Kategorie-Keywords.<br />');
define('MODULE_WK_KATEGORIE_KEYWORDS_TEXT_INFO', MODULE_WK_KATEGORIE_KEYWORDS_TEXT_DESCRIPTION);
define('MODULE_WK_KATEGORIE_KEYWORDS_INCLUDE_TPL_MOD', '<br /><strong>Hinweis - F&uuml;r folgende Funktionen sind unten genannte Template Anpassungen notwendig:</strong><br />- Anpassung der &Uuml;berschrift im Kategorie Listing Suchergebnis zu "gefunden in folgenden Kategorien:"<br />- Anzeige des Suchergebnisses in der Vorschau der Autocomplete Suche<br />');
define('MODULE_WK_KATEGORIE_KEYWORDS_INCLUDE_TPL_ORIG', '<br /><br />Die mit ** gekennzeichneten Dateien sind bereits passend modifiziert.<br />Die mit * gekennzeichneten Dateien liegen im Original vor und k&ouml;nnen mit dem Inhalt der modifizierten Versionen &uuml;berschrieben werden (alternativ: Umbenennen von Original und modifizierter Version). Anderenfalls sind die Anpassungen per Dateivergleich zu erg&auml;nzen:<br /> ');
define('MODULE_WK_KATEGORIE_KEYWORDS_INCLUDE_TPL_NONE', '(Die mit *** gekennzeichneten Dateien sind nicht vorhanden und m&uuml;ssten f&uuml;r diese Templae erg&auml;nzt werden)<br />');

define('MODULE_WK_KATEGORIE_KEYWORDS_STATUS_TITLE', 'Modul aktivieren?');
define('MODULE_WK_KATEGORIE_KEYWORDS_STATUS_DESC', MODULE_WK_KATEGORIE_KEYWORDS_TEXT_DESCRIPTION);
define('MODULE_WK_KATEGORIE_KEYWORDS_SHOW_TITLE', 'Kategorie-Listing anzeigen?');
define('MODULE_WK_KATEGORIE_KEYWORDS_SHOW_DESC', 'Listing der erfassten Kategorien &uuml;ber dem Suchergebnis<br />');
define('MODULE_WK_KATEGORIE_KEYWORDS_INCLUDE_CATEGORIES_TITLE', 'Kategorienamen als Keyword verwenden');
define('MODULE_WK_KATEGORIE_KEYWORDS_INCLUDE_CATEGORIES_DESC', ' ');

define('MODULE_WK_KATEGORIE_KEYWORDS_TEXT_CATEGORY_KEYWORDS', 'Keywords f&uuml;r die Suche (kommagetrennt):');


?>