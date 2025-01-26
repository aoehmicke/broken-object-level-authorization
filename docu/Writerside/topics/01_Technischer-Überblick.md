# Technischer Überblick

<tip>
    APIs arbeiten mit Ressourcen-IDs, die oft in den Requests übermittelt werden, z. B. in der URL oder als Parameter.
    <code-block lang="Markdown">/api/orders/{orderId}</code-block>
</tip>

<warning>
    Schwachstellen entstehen, wenn der Benutzer die Ressourcen-ID manipulieren kann, 
    ohne dass eine zusätzliche Berechtigungsprüfung erfolgt.
</warning>