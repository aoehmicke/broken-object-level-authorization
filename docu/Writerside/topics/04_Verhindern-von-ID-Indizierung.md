# Verhindern von ID-Indizierung

Nutze `UUID` anstelle von sequenziellen IDs, um "Rateversuche" (enumeration attacks) zu minimieren.

```PHP
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id;
```