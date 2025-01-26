# Zentralisiertes Autorisierungsmanagement

Stelle sicher, dass Autorisierungslogik immer zentralisiert ist, z. B. durch **Event Listener** oder **Middleware**.

```PHP
public function onKernelRequest(GetResponseEvent $event)
{
    $request = $event->getRequest();

    // Globaler Check vor Zugriff auf Ressourcen
    // Beispiel: Prüfe auf den Besitzer der Ressource
}
```