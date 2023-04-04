<?php

/**
 * ImmobilienScout24 PHP-SDK
 * Beispiele für die Nutzung des ImmobilienScout24 PHP-SDK.
 *
 * @package    ImmobilienScout24 PHP-SDK
 * @author     Norman Braun (medienopfer98.de)
 * @link       http://www.immobilienscout24.de
 */

/**
 * SDK laden.
 */
require_once('Immocaster/Sdk.php');

/**
 * Verbindung zum Service von ImmobilienScout24 aufbauen.
 * Die Daten (Key und Secret) erhält man auf
 * http://developer.immobilienscout24.de.
 */
$sImmobilienScout24Key    = 'Key für ImmobilienScout24';
$sImmobilienScout24Secret = 'Secret für ImmobilienScout24';
$oImmocaster              = Immocaster_Sdk::getInstance('is24', $sImmobilienScout24Key, $sImmobilienScout24Secret);

/**
 * Verbindung zur MySql-Datenbank (wird für einige Anfragen
 * an die API benötigt, wie z.B. nur Maklerobjekte anzeigen).
 *
 * @var array Infos zur Datenbank 'mysql','DB-Host','DB-User','DB-Password' und 'DB-Name'
 * @var string Optionaler Session-Namespace falls Session true ist
 * @var string Tabellenname in der Datenbank für Immocaster (Default ist Immocaster_Storage)
 * @var boolean Aktivieren (true) und deaktivieren (false) der Session (Wird nur für Zertifizierung benötigt!)
 */
// $oImmocaster->setDataStorage(array('mysql','DB-Host','DB-User','DB-Password','DB-Name'));

/**
 * HTTPS verwenden
 */
//$oImmocaster->useHttps(true);

/**
 * JSON verwenden
 */
// $oImmocaster->setContentResultType('json');

/**
 * Debug-Modus für Requests aktivieren
 * Zum deaktivieren: disableRequestDebug()
 */
//$oImmocaster->enableRequestDebug();

/**
 * Strict-Mode aktivieren
 */
// $oImmocaster->setStrictMode(true);

/**
 * Auf Live-System arbeiten.
 * Für die Arbeit mit Livedaten, muss man von
 * ImmobilienScout24 extra freigeschaltet werden.
 * Standardmäßig wird auf der Sandbox gearbeitet!
 */
// $oImmocaster->setRequestUrl('live');

/**
 * Authentifizierung mit oder ohne MySQL Eintrag durchspielen
 * default,false: MySQL
 * true: Session
 */
//$oImmocaster->authenticateWithoutDB(false);

?>

<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>Immocaster SDK</title>
  <style type="text/css">
    body {
      font-family: Verdana, Geneva, sans-serif;
      font-size: 11px;
    }

    h1 {
      font-family: Georgia, "Times New Roman", Times, serif;
      font-size: 16px;
      font-style: italic;
    }

    h2 {
      font-family: Georgia, "Times New Roman", Times, serif;
      font-size: 12px;
      font-style: italic;
    }

    p {
      width: 900px;
      display: inline-block;
    }

    textarea {
      width: 900px;
      height: 200px;
      margin: 10px 0;
    }

    #appVerifyButton {
      padding: 10px;
      background: #CCC;
      border: 1px solid #666;
      display: inline-block;
    }

    #appVerifyInfo {
      color: #F00;
      font-weight: bold;
      margin: 10px 0;
    }
  </style>
</head>

<body>
  <h1>
    <a href="http://www.immocaster.com">Immocaster SDK - Beispiele</a>
  </h1>
  <p>
    Das Immocaster SDK unterstützt Entwickler beim Erstellen von PHP-Applikationen mit der Schnittstelle von ImmobilienScout24. Eine
    ausführliche Dokumentation befindet sich unter <a href="http://immocaster.com/sdk-dokumentation">http://immocaster.com/sdk-dokumentation</a>. Au&szlig;erdem wird es auf der Website <a href="http://www.immocaster.com">www.immocaster.com</a> in Kürze fertige Plugins für verschiedene CMS (z.B. Wordpress, Drupal, Joomla, usw.) geben, um Projekte noch schneller umsetzen zu k&ouml;nnen.
  </p>
  <p>
    <strong>HINWEIS: Bei einigen Hostinganbietern wie z.B. 1und1, Strato, usw. kann es vorkommen, dass aus Sicherheitsgründen die Funktion file_get_contens nicht funktioniert. Diese wird aber vom SDK genutzt. Um das Problem zu beheben, öffnen Sie bitte die Datei "php.ini" im Ordner "Immocaster" und befolgen Sie die Anweisungen innerhalb der Datei.</strong>
  </p>
  <br />

  <?php

  /**
   * Geodaten (Suggestion) ermitteln.
   */
  echo '<h2>GIS - GeoAutoCompletion (GAC) v2 API Suggestion Ressource</h2><br>
      API Dokumentation: https://api.immobilienscout24.de/our-apis/gis/geoautocompletion-v2.html#suggestion';
  $aParameter = array(
    'country' => 'DEU', // DEU or AUT
    'i' => 'Berlin', // input search query
    'l' => '10', // optional, limit max. 50
    't' => 'ALL'
  );  // optional, entity types
  $res        = $oImmocaster->getGeoAutocompletionSuggestion($aParameter);
  echo '<div class="codebox"><textarea>' . $res . '</textarea></div>';

  /**
   * Geodaten (Entity) ermitteln.
   */
  echo '<h2>GIS - GeoAutocCmpletion (GAC) v2 API Entity Ressource</h2><br>
      API Dokumentation: https://api.immobilienscout24.de/our-apis/gis/geoautocompletion-v2.html#entity';
  $aParameter = array(
    'country' => 'DEU', // DEU or AUT
    'id' => '1276003001', // The ID of the entity. You get IDs in the result of the suggestion resource.
    'g' => 'WGS84'
  ); // optional, GeoCodingType: One of None, GeoId, Lambert, WGS84 (optional)
  $res        = $oImmocaster->getGeoAutocompletionEntity($aParameter);
  echo '<div class="codebox"><textarea>' . $res . '</textarea></div>';

  /**
   * Geodaten (Geohierarchy) ermitteln.
   */
  echo '<h2>GIS - Geohierarchy</h2><br>
      API Dokumentation: https://api.immobilienscout24.de/our-apis/gis/geohierarchy.html';
  $aParameter = array('country-id' => 276, 'region-id' => 2, 'list' => true);
  $res        = $oImmocaster->geoService($aParameter);
  echo '<div class="codebox"><textarea>' . $res . '</textarea></div>';

  /**
   * Ergebnisliste abfragen per Radius.
   */
  echo '<h2>Ergebnisliste abfragen per Radius</h2>';
  $aParameter = array('geocoordinates' => '52.52546480183439;13.369545936584473;2', 'realestatetype' => 'apartmentrent');
  $res        = $oImmocaster->radiusSearch($aParameter);
  echo '<div class="codebox"><textarea>' . $res . '</textarea></div>';

  /**
   * Ergebnisliste abfragen per Region.
   */
  echo '<h2>Ergebnisliste abfragen per Region</h2>';
  $aParameter = array('geocodes' => 1276003001, 'realestatetype' => 'apartmentrent');
  $res        = $oImmocaster->regionSearch($aParameter);
  echo '<div class="codebox"><textarea>' . $res . '</textarea></div>';

  /**
   * Ergebnisliste mit allen Objekten eines Maklers abfragen.
   */
  echo '<h2>Komplette Ergebnisliste eines Maklers</h2><br/>Diese Funktion wurde auskommentiert, da der Benutzer hierfür die Applikation zertifizieren muss und die Berechtigung von IS24 für diese Funktion benötigt.<br/><br/>';
  //$aParameter = array('username'=>'USERNAME');
  //$res = $oImmocaster->fullUserSearch($aParameter);
  //echo '<div class="codebox"><textarea>'.$res.'</textarea></div>';

  /**
   * Expose über die ID auslesen.
   */
  echo '<h2>Expose per ID auslesen</h2><br/>Diese Funktion wurde auskommentiert, da dafür eine aktuelle ExposeID benötigt wird.<br/><br/>';
  //$aParameter = array('exposeid'=>'ID'); // Expose-ID hinterlegen
  //$res        = $oImmocaster->getExpose($aParameter);
  //echo '<div class="codebox"><textarea>'.$res.'</textarea></div>';

  /**
   * Impressum eines Exposes auslesen.
   */
  echo '<h2>Impressum eines Exposes auslesen</h2><br/>Diese Funktion wurde auskommentiert, da dafür eine aktuelle ExposeID benötigt wird.<br/><br/>';
  //$aParameter = array('exposeid'=>'ID'); // Expose-ID hinterlegen
  //$res        = $oImmocaster->getExposeImprint($aParameter);
  //echo '<div class="codebox"><textarea>'.$res.'</textarea></div>';

  /**
   * Attachment auslesen.
   */
  echo '<h2>Attachment auslesen</h2><br/>Diese Funktion wurde auskommentiert, da dafür eine aktuelle ExposeID benötigt wird.<br/><br/>';
  //$aParameter = array('exposeid'=>'ID'); // Expose-ID hinterlegen
  //$res        = $oImmocaster->getAttachment($aParameter);
  //echo '<div class="codebox"><textarea>'.$res.'</textarea></div>';

  /**
   * Applikation zertifizieren.
   * Zum Beispiel für Applikationen, die nur Objekte des
   * Maklers anzeigen sollen.
   *
   * HINWEIS: Unter IE9 kann es zu Problemen mit der
   *          zertifizierung kommen. Darum sollte für
   *          die Zertifizierung möglichst ein anderer
   *          Browser (z.B. Firefox) genommen werden.
   *
   */
  echo '<h2>Zertifizierung einer Applikation durch den Makler</h2><br/>Diese Funktion wurde auskommentiert!<br/><br/>';
  /*
$sCertifyURL = 'http://MEINE-AKTUELLE-URL.DE'; // Komplette URL inkl. Parameter auf der das Script eingebunden wird
if(isset($_GET['main_registration'])||isset($_GET['state']))
{
    if(isset($_POST['user'])){ $sUser=$_POST['user']; }
    if(isset($_GET['user'])){ $sUser=$_GET['user']; }
    $aParameter = array('callback_url'=>$sCertifyURL.'?user='.$sUser,'verifyApplication'=>true);
    // Benutzer neu zertifizieren
    $returnAuthentication = $oImmocaster->getAccess($aParameter);
    if ($returnAuthentication === true)
    {
        echo '<div id="appVerifyInfo">Zertifizierung in der MySQL Datenbank war erfolgreich.</div>';
    }
    elseif (is_array($returnAuthentication) && count($returnAuthentication) > 1)
    {
        echo '<div id="appVerifyInfo">Zertifizierung war erfolgreich. Hier finden Sie Access Token und Token Secret kommasepariert und url enkodiert.</div>';
        echo '<div class="codebox"><textarea>'.implode(",", $returnAuthentication).'</textarea></div>';
    }
    else
    {
        echo '<div id="appVerifyInfo">Es ist etwas schief gelaufen. Troubleshooting: Benutzer ist bereits in der MySQL Datenbank zertifiziert oder es besteht keine Verbindung zur Datenbank.</div>';

    }
}
echo '<form action="'.$sCertifyURL.'?main_registration=1" method="post"><div id="appVerifyButton"><strong>Hinweis: Unter IE9 kann es zu Problemen mit der Zertifizierung kommen.</strong><br />Benutzername: <input type="text" name="user" /><br /><em>Der Benutzername sollte nach Möglichkeit gesetzt werden. Standardmäßig wird ansonsten "me" genommen. Somit können aber nicht mehrere User parallel in der Datenbank abgelegt werden. Der gewählte Benutzernamen muss der gleiche wie im Formular auf der nächsten Seite sein, damit der Token richtig zugewiesen werden kann.</em><br /><input type="submit" value="Jetzt zertifizieren" /></div></form>';
echo '<p>Registrierte Nutzer in der Datenbank: ';
// Anzeige welche Nutzer bereits in der MySQL Datenbank registriert sind
print_r($oImmocaster->getAllApplicationUsers(array('string'=>true)));
*/

  /**
   * Anbieter-Logo auslesen
   */
  echo '<h2>Logo eines Maklers auslesen</h2><br/>Diese Funktion wurde auskommentiert, da dafür eine Zertifizierung nötig ist.<br/><br/>';
  //$aParameter = array('username'=>'USERNAME'); // Username hinterlegen (standardmäßig ihr Nutzername, der beim Login verwendet wird)
  //$res        = $oImmocaster->getLogo($aParameter);
  //echo '<div class="codebox"><textarea>'.$res.'</textarea></div>';

  /**
   * Ergebnisliste abfragen per Radius (eines einzelnen Kunden/Maklers).
   */
  echo '<h2>Ergebnisliste eines einzelnen Maklers per Radius abfragen</h2><br/>Diese Funktion wurde auskommentiert, da dafür eine Zertifizierung nötig ist.<br/><br/>';
  //$aParameter = array('geocoordinates'=>'52.52546480183439;13.369545936584473;1000','realestatetype'=>'apartmentrent','username'=>'Benutzername','channel'=>'is24 oder hp');
  //$res        = $oImmocaster->radiusSearch($aParameter);
  //echo '<div class="codebox"><textarea>'.$res.'</textarea></div>';

  /**
   * Ergebnisliste abfragen per Region (eines einzelnen Kunden/Maklers).
   */
  echo '<h2>Ergebnisliste eines einzelnen Maklers per Region abfragen</h2><br/>Diese Funktion wurde auskommentiert, da dafür eine Zertifizierung nötig ist.<br/><br/>';
  //$aParameter = array('geocodes'=>1276003001017,'realestatetype'=>'apartmentrent','username'=>'Benutzername','channel'=>'is24 oder hp');
  //$res        = $oImmocaster->regionSearch($aParameter);
  //echo '<div class="codebox"><textarea>'.$res.'</textarea></div>';

  /**
   * Kontakt an Anbieter versenden.
   */
  echo '<h2>Anbieter kontaktieren</h2><br/>';
  echo 'Es kann zu Problemen kommen, wenn die Objekte die kontaktiert werden sollen nicht auf IS24 veröffentlicht sind.<br/>D.h. wenn die Objekte lediglich Homepage-Veröffentlicht sind wird ein Fehler erzeugt.<br/><br />';
  if ($_POST['formActionSendContact']) {
    $aParameter = array('exposeid' => $_POST['contactObjectId']);
    $res = $oImmocaster->getExpose($aParameter);
    if (substr_count($res, 'ERROR_RESOURCE_NOT_FOUND') < 1) {
      $sRequestBody = ''; // Infos zum Aufbau unter: http://developerwiki.immobilienscout24.de/wiki/Contact/POST
      $aContactParameter = array('exposeid' => $_POST['contactObjectId'], 'request_body' => $sRequestBody);
      $resContact = $oImmocaster->sendContact($aContactParameter);
      echo '<strong>' . $resContact . '</strong><br /><br />';
    } else {
      echo '<strong>' . $res . '</strong><br /><br />';
    }
  }
  echo '<form action="' . $SELFPHP . '" method="post" name="sendcontact">';
  echo 'Objekt-ID: <input type="text" name="contactObjectId"><br />';
  echo 'Nachricht: <input type="text" name="contactMsg"><br />';
  echo '<input type="hidden" name="formActionSendContact" value="do"><br />';
  echo '<input type="submit" name="submit" value="Anbieter kontaktieren">';
  echo '</form>';

  /**
   * Objekt weiter empfehlen (an Emailadresse).
   */
  echo '<h2>Objekt empfehlen:</h2><br/>';
  echo 'Es kann zu Problemen kommen, wenn das Objekt nicht auf IS24 veröffentlicht ist.<br/><br/>';
  if ($_POST['formActionSendFriend']) {
    $aParameter = array('exposeid' => $_POST['friendObjectId']);
    $res = $oImmocaster->getExpose($aParameter);
    if (substr_count($res, 'ERROR_RESOURCE_NOT_FOUND') < 1) {
      $sRequestBody = ''; // Infos zum Aufbau unter: http://developerwiki.immobilienscout24.de/wiki/SendAFriendForm/POST
      $aFriendParameter = array('exposeid' => $_POST['friendObjectId'], 'request_body' => $sRequestBody);
      $resFriend = $oImmocaster->sendAFriend($aFriendParameter);
      echo '<strong>' . $resFriend . '</strong><br /><br />';
    } else {
      echo '<strong>' . $res . '</strong><br /><br />';
    }
  }
  echo '<form action="' . $SELFPHP . '" method="post" name="sendafriend">';
  echo 'Objekt-ID: <input type="text" name="friendObjectId"><br />';
  echo 'Email-Adresse: <input type="text" name="friendEmail"><br />';
  echo '<input type="hidden" name="formActionSendFriend" value="do"><br />';
  echo '<input type="submit" name="submit" value="Objekt empfehlen">';
  echo '</form>';

  /**
   * Ermittelt die Kanäle (Channels) in die ein zertifizierter Benutzer Objekte exportieren darf
   */
  echo '<h2>Export-Channels für den User:</h2><br/>Diese Funktion wurde auskommentiert, da dafür eine Zertifizierung nötig ist.<br/><br/>';
  //$aParameter = array('username'=>'USERNAME'); // Benutzername ('me' ist hier nicht zulässig!)
  //$res        = $oImmocaster->getPublishChannel($aParameter);
  //echo '<div class="codebox"><textarea>'.$res.'</textarea></div>';

  /**
   * Objekt zu ImmobilienScout24 exportieren / Objekt ändern
   */
  echo '<h2>Objekt exportieren und &auml;ndern</h2><br/>Diese Funktion wurde auskommentiert, da dafür eine Zertifizierung nötig ist.<br/><br/>';
  /*
$aParameter = array(
	'username' => 'me',
	'service' => 'immobilienscout',
	'estate' => array(
	'xml' => '<?xml version="1.0" encoding="utf-8"?>
<realestates:apartmentRent xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:realestates="http://rest.immobilienscout24.de/schema/offer/realestates/1.0">
  <title>RestAPI - Immobilienscout24 Testobjekt! +++BITTE+++ NICHT kontaktieren - Wohnung Miete</title>
  <address>
    <street>Heuersdorfer Str</street>
    <houseNumber>26</houseNumber>
    <postcode>04574</postcode>
    <city>Heuersdorf</city>
  </address>
  <showAddress>false</showAddress>
  <baseRent>521.22</baseRent>
  <livingSpace>849.737</livingSpace>
  <numberOfRooms>8.4</numberOfRooms>
  <courtage>
    <hasCourtage>YES</hasCourtage>
    <courtage>7,14%</courtage>
  </courtage>
</realestates:apartmentRent>'
));
print_r($oImmocaster->exportObject($aParameter)); // Objekt exportieren
print_r($oImmocaster->changeObject($aParameter)); // Objekt &auml;ndern
*/

  /**
   * Ruft ein Objekte eines Maklers unabhängig von der Veröffentlichung ab
   * API Doku: http://api.immobilienscout24.de/our-apis/import-export/realestate/get-by-id.html
   */
  echo '<h2>Objekt eines Maklers per ID auslesen</h2><br/>Diese Funktion wurde auskommentiert, da dafür eine Zertifizierung nötig ist.<br/><br/>';
  //$aParameter = array('username'=>'**','exposeid'=>'**' /*ScoutID oder ext-ObjektNr*/);
  //$res        = $oImmocaster->getUserExpose($aParameter);
  //echo '<div class="codebox"><textarea>'.$res.'</textarea></div>';

  /**
   * Den Typ des Attachments gibt man mit 'type' an: 'Picture', 'PDFDocument' oder 'Link'
   * Attachment (Bild, PDF oder Link) zu einem Objekt hochladen
   * Wird ein Bild oder ein PDF hochgeladen, benötigt die Funktion den Parameter 'file' mit entsprechendem Dateipfad.
   * Beim Upload eines Links wird der Parameter 'url' übergeben.
   * Das Setzen der externalId ist freiwillig
   */
  echo '<h2>Attachment (Bild, PDF, Link) hochladen</h2><br/>Diese Funktion wurde auskommentiert, da dafür eine Zertifizierung nötig ist.<br/><br/>';
  /*
$aParameter = array(
  'username' => 'USERNAME',
  'estateid' => 'ESTATEID', //ID des Objektes
  'title' => 'TITLE',
  'type' => 'ATTACHMENTTYPE', // Picture, PDFDocument or Link
  'file' => 'LOCATION', // file path OR URL
  //'url' => 'URL',
  'externalId' => 'EXTERNALID', // optional
  'externalCheckSum' => 'CHECKSUM'); // optional
$res = $oImmocaster->exportObjectAttachment($aParameter);
echo '<div class="codebox"><textarea>'.$res.'</textarea></div>';
*/

  /**
   * Attachments eines Objektes abrufen
   * API Doku: http://api.immobilienscout24.de/our-apis/import-export/attachments/get-all.html
   */
  echo '<h2>Attachments eines Objektes abrufen.</h2><br/>Diese Funktion wurde auskommentiert, da dafür eine Zertifizierung nötig ist.<br/><br/>';
  //$aParameter = array('username'=>'USERNAME','estateid'=>'REALESTATEID' /*ScoutID oder ext-ObjektNr*/);
  //$res        = $oImmocaster->getObjectAttachments($aParameter);
  //echo '<div class="codebox"><textarea>'.$res.'</textarea></div>';

  /**
   * Objektbild entfernen
   */
  echo '<h2>Objektbild entfernen</h2><br/>Diese Funktion wurde auskommentiert, da dafür eine Zertifizierung nötig ist.<br/><br/>';
  //$aParameter = array('attachmentid' => 'ATTACHMENTID' /*ID des Bildes*/, 'estateid' => 'ESTATEID' /*ID des Objekts*/ );
  //$res = $oImmocaster->deleteObjectAttachment($aParameter);
  //echo '<div class="codebox"><textarea>'.$res.'</textarea></div>';

  /**
   * Objekt aktivieren
   */
  echo '<h2>Objekt aktivieren</h2><br/>Diese Funktion wurde auskommentiert, da dafür eine Zertifizierung nötig ist.<br/><br/>';
  /*
$aParameter = array(
	'exposeid' => 'ESTATEID', // Id des Objekts
	'channelid' => '10001' // 10000 = IS24, 10001 = Homepage
);
print_r($oImmocaster->enableObject($aParameter));
*/

  /**
   * Objekt deaktivieren
   */
  echo '<h2>Objekt deaktivieren</h2><br/>Diese Funktion wurde auskommentiert, da dafür eine Zertifizierung nötig ist.<br/><br/>';
  /*
$aParameter = array(
	'exposeid' => 'ESTATEID', // Id des Objekts
	'channelid' => '10001' // 10000 = IS24, 10001 = Homepage
);
print_r($oImmocaster->disableObject($aParameter));
*/

  /**
   * Objekt entfernen
   */
  echo '<h2>Objekt entfernen</h2><br/>Diese Funktion wurde auskommentiert, da dafür eine Zertifizierung nötig ist.<br/><br/>';
  //$aParameter = array('username' => 'USERNAME', 'estateid' => 'ESTATEID' /*ID des Objekts*/ );
  //$res = $oImmocaster->deleteObject($aParameter);
  //echo '<div class="codebox"><textarea>'.$res.'</textarea></div>';

  /**
   * Erstellt/Aktualisiert eine Kontaktadresse im Account des Maklers
   * API Doku: http://api.immobilienscout24.de/our-apis/import-export/contact/post.html
   */
  echo '<h2>Erstellen/Aktualisieren von Kontaktadresse im Makleraccount</h2><br/>Diese Funktion wurde auskommentiert, da dafür eine Zertifizierung nötig ist.<br/><br/>';
  /*$aParameter =
array(
    'username'=>'USERNAME',
  //'contactid'=>'CONTACTID', NUR FÜR AKTUALISIERUNG NOTWENDIG!!! id oder ext-externalId
    'contact' => array(
    'xml' =>
    '<?xml version="1.0" encoding="UTF-8"?>
    <common:realtorContactDetail xmlns:common="http://rest.immobilienscout24.de/schema/common/1.0" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:ns4="http://rest.immobilienscout24.de/schema/customer/1.0" xmlns:ns5="http://rest.immobilienscout24.de/schema/user/1.0" >
    <email>max.mustermann@immobilienscout24.de</email>
    <salutation>MALE</salutation>
    <firstname>Maxxxxxx</firstname>
    <lastname>Mustermann</lastname>
    <faxNumberCountryCode>+49</faxNumberCountryCode>
    <faxNumberAreaCode>30</faxNumberAreaCode>
    <faxNumberSubscriber>243010001</faxNumberSubscriber>
    <phoneNumberCountryCode>+49</phoneNumberCountryCode>
    <phoneNumberAreaCode>30</phoneNumberAreaCode>
    <phoneNumberSubscriber>243010001</phoneNumberSubscriber>
    <cellPhoneNumberCountryCode>+49</cellPhoneNumberCountryCode>
    <cellPhoneNumberAreaCode>179</cellPhoneNumberAreaCode>
    <cellPhoneNumberSubscriber>2430100078</cellPhoneNumberSubscriber>
    <address>
        <street>Andreasstr.</street>
        <houseNumber>10</houseNumber>
        <postcode>10243</postcode>
        <city>Berlin</city>
    </address>
    <countryCode>DEU</countryCode>
    <title>Master</title>
    <additionName>HuiBuh</additionName>
    <company>Immobilienscout24</company>
    <homepageUrl>http://www.immobilienscout24.de</homepageUrl>
    <officeHours>Von  11:30 bis 12:00, dabei eine halbe Stunde  Pause</officeHours>
    <defaultContact>false</defaultContact>
    <localPartnerContact>true</localPartnerContact>
    <businessCardContact>false</businessCardContact>
    <externalId>bestMan</externalId>
</common:realtorContactDetail>'
));*/
  //$res        = $oImmocaster->exportContact($aParameter);
  //$res        = $oImmocaster->changeContact($aParameter);
  //echo '<div class="codebox"><textarea>'.$res.'</textarea></div>';

  /**
   * Ruft eine Kontaktadresse (Contact) eines Maklers ab
   * API Doku: http://api.immobilienscout24.de/our-apis/import-export/contact/get-by-id.html
   */
  echo '<h2>Kontaktadresse eines Maklers per ID auslesen</h2><br/>Diese Funktion wurde auskommentiert, da dafür eine Zertifizierung nötig ist.<br/><br/>';
  //$aParameter = array('username'=>'USERNAME','contactid'=>'CONTACTID' /*id oder externalId*/);
  //$res        = $oImmocaster->getContact($aParameter);
  //echo '<div class="codebox"><textarea>'.$res.'</textarea></div>';

  /**
   * Löscht eine Kontaktadresse (Contact) eines Maklers
   * API Doku: http://api.immobilienscout24.de/our-apis/import-export/contact/delete.html
   */
  echo '<h2>Kontaktadresse eines Maklers löschen</h2><br/>Diese Funktion wurde auskommentiert, da dafür eine Zertifizierung nötig ist.<br/><br/>';
  //$aParameter = array('username'=>'USERNAME','contactid'=>'CONTACTID' /*id oder externalId*/);
  //$res        = $oImmocaster->deleteContact($aParameter);
  //echo '<div class="codebox"><textarea>'.$res.'</textarea></div>';

  /**
   * Liste von Objekten OnTop platzieren
   * API Doku: http://api.immobilienscout24.de/our-apis/import-export/ontop-placement/post-by-list.html
   */
  echo '<h2>Liste von Objekten OnTop platzieren</h2><br/>Diese Funktion wurde auskommentiert, da dafür eine Zertifizierung nötig ist.<br/><br/>';
  /*$aParameter =
array(
    'username'=>'USERNAME',
    'ontopplacementtype'=>'ONTOPPLACEMENTTYPE', //topplacement, premiumplacement oder showcaseplacement
    // Benutze "body" um den vollständigen Body mitzugeben or "realestateids" für eine komma separierte Liste
    // in der Rest.php wird aus der Liste ein Array, falls "realestateids" genutzt wird
    //'body'=>
    //  '<ONTOPPLACEMENTTYPE:ONTOPPLACEMENTTYPEs xmlns:ONTOPPLACEMENTTYPE="http://rest.immobilienscout24.de/schema/offer/ONTOPPLACEMENTTYPE/1.0" xmlns:xlink="http://www.w3.org/1999/xlink">
    //    <ONTOPPLACEMENTTYPE realestateid="ScoutID"/>
    //    <ONTOPPLACEMENTTYPE realestateid="ext-ObjektNr"/>
    //  </ONTOPPLACEMENTTYPE:ONTOPPLACEMENTTYPEs>'
    'realestateids'=>'REALESTATEID1,REALESTATEID2,...' // ScoutID oder ext-ObjektNr eingeben
);
$res        = $oImmocaster->postbylistOntopplacement($aParameter);
echo '<div class="codebox"><textarea>'.$res.'</textarea></div>';*/

  /**
   * Ein Objekt OnTop platzieren
   * API Doku: http://api.immobilienscout24.de/our-apis/import-export/ontop-placement/post-by-id.html
   */
  echo '<h2>Ein Objekt OnTop platzieren</h2><br/>Diese Funktion wurde auskommentiert, da dafür eine Zertifizierung nötig ist.<br/><br/>';
  //$aParameter = array('username'=>'USERNAME','realestateid'=>'REALESTATEID' /*ScoutID oder ext-ObjektNr*/,'ontopplacementtype'=>'ONTOPPLACEMENTTYPE' /*topplacement, premiumplacement oder showcaseplacement*/);
  //$res        = $oImmocaster->postbyidOntopplacement($aParameter);
  //echo '<div class="codebox"><textarea>'.$res.'</textarea></div>';

  /**
   * Alle OnTop Platzierungen abrufen
   * API Doku: http://api.immobilienscout24.de/our-apis/import-export/ontop-placement/get-all.html
   */
  echo '<h2>Alle OnTop Platzierungen abrufen</h2><br/>Diese Funktion wurde auskommentiert, da dafür eine Zertifizierung nötig ist.<br/><br/>';
  //$aParameter = array('username'=>'USERNAME','ontopplacementtype'=>'ONTOPPLACEMENTTYPE' /*topplacement, premiumplacement oder showcaseplacement*/);
  //$res        = $oImmocaster->getallOntopplacement($aParameter);
  //echo '<div class="codebox"><textarea>'.$res.'</textarea></div>';

  /**
   * OnTop Platzierung eines Objektes abrufen
   * API Doku: http://api.immobilienscout24.de/our-apis/import-export/ontop-placement/get-by-id.html
   */
  echo '<h2>OnTop Platzierung eines Objektes abrufen</h2><br/>Diese Funktion wurde auskommentiert, da dafür eine Zertifizierung nötig ist.<br/><br/>';
  //$aParameter = array('username'=>'USERNAME','realestateid'=>'REALESTATEID' /*ScoutID oder ext-ObjektNr*/,'ontopplacementtype'=>'ONTOPPLACEMENTTYPE' /*topplacement, premiumplacement oder showcaseplacement*/);
  //$res        = $oImmocaster->getbyidOntopplacement($aParameter);
  //echo '<div class="codebox"><textarea>'.$res.'</textarea></div>';

  /**
   * Alle OnTop Platzierungen löschen
   * http://api.immobilienscout24.de/our-apis/import-export/ontop-placement/delete-all.html
   */
  echo '<h2>Alle OnTop Platzierungen löschen</h2><br/>Diese Funktion wurde auskommentiert, da dafür eine Zertifizierung nötig ist.<br/><br/>';
  //$aParameter = array('username'=>'USERNAME','ontopplacementtype'=>'ONTOPPLACEMENTTYPE' /*topplacement, premiumplacement oder showcaseplacement*/);
  //$res        = $oImmocaster->deleteallOntopplacement($aParameter);
  //echo '<div class="codebox"><textarea>'.$res.'</textarea></div>';

  /**
   * Eine OnTop Platzierung löschen
   * http://api.immobilienscout24.de/our-apis/import-export/ontop-placement/delete-by-id.html
   */
  echo '<h2>Eine OnTop Platzierung löschen</h2><br/>Diese Funktion wurde auskommentiert, da dafür eine Zertifizierung nötig ist.<br/><br/>';
  //$aParameter = array('username'=>'USERNAME','realestateid'=>'REALESTATEID' /*ScoutID oder ext-ObjektNr*/,'ontopplacementtype'=>'ONTOPPLACEMENTTYPE' /*topplacement, premiumplacement oder showcaseplacement*/);
  //$res        = $oImmocaster->deletebyidOntopplacement($aParameter);
  //echo '<div class="codebox"><textarea>'.$res.'</textarea></div>';

  /**
   * Liste von OnTop Platzierungen löschen
   * http://api.immobilienscout24.de/our-apis/import-export/ontop-placement/delete-by-list.html
   */
  echo '<h2>Liste von OnTop Platzierungen löschen</h2><br/>Diese Funktion wurde auskommentiert, da dafür eine Zertifizierung nötig ist.<br/><br/>';
  //$aParameter = array('username'=>'USERNAME','realestateids'=>'REALESTATEID1,REALESTATEID2,..' /*ScoutID oder ext-ObjektNr*/,'ontopplacementtype'=>'ONTOPPLACEMENTTYPE' /*topplacement, premiumplacement oder showcaseplacement*/);
  //$res        = $oImmocaster->deletebylistOntopplacement($aParameter);
  //echo '<div class="codebox"><textarea>'.$res.'</textarea></div>';

  /**
   * Ein Video (Streaming) zu einem Objekt hochladen
   * 1. Video Upload Ticket von ImmobilienScout24 erhalten
   * 2. Video bei picesearch hochladen
   * 3. Video von picsearch zu Objekt von ImmobilienScout24 referenzieren
   * API Doku: http://api.immobilienscout24.de/our-apis/import-export/attachments/post.html
   *
   */
  echo '<h2>Ein Video zu einem Objekt hochladen (3 Schritte).<br/><br/>';
  /*$aParameter = array ('username'=>'USERNAME', 'file' => 'LOCATION', 'estateid' => 'ESTATEID', 'title' => 'TITLE');
$ticket        = $oImmocaster->getVideoUploadTicket($aParameter);
    $xml = new SimpleXMLElement($ticket);
    $auth   = (string) $xml->auth[0];
    $videoid  = (string) $xml->videoId[0];
    $uploadUrl   = (string) $xml->uploadUrl[0];
echo '<h5>1. Upload Ticket von ImmobilienScout24 holen (GET videouploadticket@IS24).<br/><br/>';
echo '<div class="codebox"><textarea>'.$ticket.'</textarea></div>';
    $aParameter['auth'] = $auth;
    $aParameter['uploadUrl'] = $uploadUrl;
$upload         = $oImmocaster->postVideoToPicsearch($aParameter);
echo '<h5>2. Video bei picsearch hochladen (POST videofile@picsearch).<br/><br/>';
echo '<div class="codebox"><textarea>'.$upload.'</textarea></div>';
    $aParameter['videoid'] = $videoid;
$postAttachment = $oImmocaster->exportObjectVideoAttachment($aParameter);
echo '<h5>3. Bei ImmobilienScout24 Video von picsearch verknüpfen (POST Attachment@IS24).<br/><br/>';
echo '<div class="codebox"><textarea>'.$postAttachment.'</textarea></div>';*/

  /**
   * Attachmentreihenfolge eines Objektes über die ObjektID auslesen.
   * Es werden nur Bilder und PDFs betrachtet.
   * API Doku: http://api.immobilienscout24.de/our-apis/import-export/attachments/attachmentsorder-get.html
   *
   */
  echo '<h2>Attachmentsreihenfolge eines Objektes über die ID auslesen.</h2><br/>Diese Funktion wurde auskommentiert, da dafür eine aktuelle ObjektNr benötigt wird.<br/><br/>';
  //$aParameter = array('username'=>'USERNAME','estateid'=>'ESTATEID' /*ScoutID oder ext-ObjektNr*/);
  //$res        = $oImmocaster->getObjectAttachmentsorder($aParameter);
  //echo '<div class="codebox"><textarea>'.$res.'</textarea></div>';

  /**
   * Attachmentreihenfolge eines Objektes ändern.
   * Es werden nur Bilder und PDFs betrachtet.
   * Es ist im SDK möglich den XML Part direkt weiterzugeben oder sortierte Liste von ESTATEIDs.
   * API Doku: http://api.immobilienscout24.de/our-apis/import-export/attachments/attachmentsorder-put.html
   */
  echo '<h2>Attachmentsreihenfolge eines Objektes über die ID ändern.</h2><br/>Diese Funktion wurde auskommentiert, da dafür eine Zertifizierung nötig ist.<br/><br/>';
  /*$aParameter =
array(
    'username'=>'USERNAME',
    'estateid'=>'ESTATEID',
     //Benutze "body" um den vollständigen Body mitzugeben or "attachmentids" für eine komma separierte Liste
     // in der Rest.php wird aus der Liste ein Array, falls "attachmentids" genutzt wird
     //'body'=>
     //   <attachmentsorder:attachmentsorder xmlns:attachmentsorder="http://rest.immobilienscout24.de/schema/attachmentsorder/1.0">
     //     <attachmentId>664055530</attachmentId>
     //     <attachmentId>664055529</attachmentId>
     //   </attachmentsorder:attachmentsorder>'
    'attachmentids'=>'ATTACHMENTID1,ATTACHMENTID2,...' // ScoutIDs, _nicht_ externalID des Objektes
);
$res        = $oImmocaster->changeObjectAttachmentsorder($aParameter);
echo '<div class="codebox"><textarea>'.$res.'</textarea></div>';*/

  /**
   * Aktualisierern eines Attachments (Bild, Video, PDF oder URL).
   * Bitte beachten, dass dabei nur die Metadaten verändert werden können, nicht das Bild an sich.
   * API Doku: http://api.immobilienscout24.de/our-apis/import-export/attachments/put-by-id.html
   */
  echo '<h2>Aktualisieren eines Attachments</h2><br/>Diese Funktion wurde auskommentiert, da dafür eine Zertifizierung nötig ist.<br/><br/>';
  /*$aParameter =
array(
    'username'=>'USERNAME',
    'estateid'=>'ESTATEID',
    'attachmentid'=>'ATTACHMENTID',
    'type'=>'ATTACHMENTTYPE', // "Picture", "PDFDocument", "StreamingVideo" oder "Link"
    'title'=>'TITLE',
    //'externalId'=>'EXTERNALID', // optional
    //'floorplan'=>'BOOLEAN', // Nur für Bilder und PDFs
    //'titlePicture'=>'BOOLEAN', // Nur für Bilder und PDFs
    //'url' =>'http://URL' // Nur für Links
);
$res        = $oImmocaster->changeObjectAttachment($aParameter);
echo '<div class="codebox"><textarea>'.$res.'</textarea></div>';*/

  /**
   * Ermittelt die Publishchannels eines Objektes
   * API Doku: http://api.immobilienscout24.de/our-apis/import-export/publish/get.html
   */
  echo '<h2>Publishchannels eines Objektes:</h2><br/>Diese Funktion wurde auskommentiert, da dafür eine Zertifizierung nötig ist.<br/><br/>';
  /*$aParameter = array(
  'username'=>'USERNAME',
  'realestate'=>'ESTATEID' // ScoutID
 // 'publishchannel'=>'10000' // optional: 10000=IS24, 10001=HP
  );
$res        = $oImmocaster->getPublish($aParameter);
echo '<div class="codebox"><textarea>'.$res.'</textarea></div>';*/

  ?>
</body>

</html>