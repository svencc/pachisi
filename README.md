0. Das Programm liegt als zip gepackt unter https://github.com/svencc/pachisi/blob/master/pachisi_dist.zip bereit.

1. Die Dateien im Ordner \logs müssen schreibbar sein.

2. composer install muss ausgeführt werden.

3. Die Dateien im Ordner /logs müssen schreibbar sein.

4. Die /local_config.php.template muss nach /local_config.php kopiert werden.

5. Die /local_config.php muss angepasst werden. Insbesondere können/müssen hier 2 Variablen gesetzt werden:
$USE_RANDOMORG_API = true;
$RANDOMORG_API_KEY = '<dein_randomorg_api_schlüssel>';

Ansonsten wird die php Standard randomizer-Funktion verwendet (die dann auch ohne Internet Verbindung funktioniert).

Ein weiteres Gimick: die random.org API erlaubt es mir in einem request gleich mehrere Zahlen zu generieren und zu senden. 
Um das Spiel nicht unnötig zu verlangsamen hole ich mit einem Request gleich 99 solcher Zufallszahlen und halte sie in einem Cache vor. 
Sollten diese Zahlen alle verbraucht werden, dann holt die Klasse die nächsten 99 Zahlen. (Meistens ist das Spiel aber nach 75 -85 Runden vorbei).

Mit php run.php kann die Anwendung mittels CLI/Konsole gestartet werden.

Es gibt sogar eine textuelle Ausgabe über den Spielverlauf.
Dieser kann auch in der Log-Datei /logs/render.log gefunden werden. Hierüber lässt sich das Spielgeschehen am besten verfolgen

Alle Log-Dateien werden werden vor einem erneuten Spielstart gelöscht.

In dem entpackten Ordner ist in der Datei INSTALL eine genauere Beschreibung und Erklärung enthalten
