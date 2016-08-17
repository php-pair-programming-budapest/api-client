# Simple API Client

Egyszerű HTTP API kliens implementáció.

A mai meetupon megnéztük, hogy hogyan lehet egy HTTP protokollon keresztül működő egyszerű (@kocsismate szerint) RESTful APIval. Elkezdtük sima `file_get_contents` és `json_decode` módszerrel, majd egy kliens osztályba átraktuk a transzport réteget (HTTP kliens absztrakció: https://github.com/php-http/httplug), a hibakezelést, valamint a szerializációs réteget is.

Végezetül absztraháltuk magát az API klienst is, hogy az azt használó kód könnyen tesztelhető legyen.

Ezekután megnéztünk egy JSON-API szerver és kliens implementációt (https://github.com/woohoolabs/yin, https://github.com/woohoolabs/yang), amik a fenti HTTP kliens absztrakciót használják, majd belenéztünk két való életben használt API kliens kódjába is.
