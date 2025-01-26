# Typisches Angriffsszenario

<deflist>
    <def title="1. Angreifer analysiert die API">
        Durch Abfangen von API-Requests (z. B. mittels <b>Postman</b> oder <b>Burp Suite</b>).
    </def>
    <def title="2. Manipulation der Ressourcen-IDs">
        Angreifer ändert Daten (z. B. Benutzer-IDs, Auftragsnummern, Dokument-IDs).
    </def>
    <def title="3. Unzureichende Prüfungen">
        Die API überprüft nicht, ob der Benutzer die manipulierten Ressourcen tatsächlich aufrufen darf.
    </def>
</deflist>